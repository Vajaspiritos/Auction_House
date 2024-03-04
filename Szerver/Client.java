import java.io.InputStream;
import java.io.OutputStream;
import java.net.Socket;
import java.nio.charset.StandardCharsets;
import java.security.MessageDigest;
import java.util.Base64;
import java.util.HashMap;
import java.util.Map;
import java.util.Random;
import java.util.Scanner;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class Client{
	
	private int ID=-1;
	private String Name;
	private String Color;
	private Socket Client;
	
	private InputStream in;
	private OutputStream out;
	public int CheckupCode=0;
	
	
	public Client(Socket newConnection) throws Exception{
	
		this.Client = newConnection;
		
		
		this.in  = this.Client.getInputStream();
		this.out = this.Client.getOutputStream();
		
		Random r = new Random();
		int red = 50+r.nextInt(200);
		int green =50+ r.nextInt(200);
		int blue =50+ r.nextInt(200);
		this.Color = String.format("#%02x%02x%02x", red,green,blue);
		
	}
	public void HandShake() throws Exception{
		Scanner s = new Scanner(in, "UTF-8");
		String data = s.useDelimiter("\\r\\n\\r\\n").next();
		Matcher get = Pattern.compile("^GET").matcher(data);
		
		if (get.find()) {
			  Matcher match = Pattern.compile("Sec-WebSocket-Key: (.*)").matcher(data);
			  match.find();
			  byte[] response = ("HTTP/1.1 101 Switching Protocols\r\n"
			    + "Connection: Upgrade\r\n"
			    + "Upgrade: websocket\r\n"
			    + "Sec-WebSocket-Accept: "
			    + Base64.getEncoder().encodeToString(MessageDigest.getInstance("SHA-1").digest((match.group(1) + "258EAFA5-E914-47DA-95CA-C5AB0DC85B11").getBytes("UTF-8")))
			    + "\r\n\r\n").getBytes("UTF-8");
			  out.write(response, 0, response.length);
		}
		System.out.println("Kezrazas megtortent");
	}
	public void ReceiveData() throws Exception{
		WriteMessage("id");
		  String respond ="";
		  while(true) {
				if(in.available() > 0) {
					
					try {
						respond = ReadMessage(); //ID|Name
					}catch(Exception e) {e.printStackTrace();}
						break;
					
				}
		
				
				Thread.sleep(1000);
			}
		  String[] data = respond.split("\\|");
		 
		  this.ID=Integer.parseInt(data[0]);
		  this.Name = data[1];
		
	}
	
	public void Goodbye() throws Exception{
		
		
		in.close(); //nem tudom hogy szükséges e ha ugyis bezárom de biztos ami tuti
		out.close();
		
		Client.close();
	}
	
	public int getID() {
		return this.ID;
	}
	public InputStream getInput() {
		return in;
	}
	
		public  String ReadMessage()throws Exception {
		int frame = in.read();
		int length = in.read()-128;
		if(length > 100) return "Túl hosszú üzenet";
		
		
		byte[] decode_key = new byte[] {(byte)in.read(),(byte)in.read(),(byte)in.read(),(byte)in.read()};
		byte[] array = new byte[length];
		int i =0;
		while(in.available()>0) {
			array[i]=(byte)(in.read() ^ decode_key[i&0x3]); 
		//System.out.println(array[i]);
		i++;			
		}
		//System.out.println("message: "+new String(array,StandardCharsets.UTF_8));
		return new String(array,StandardCharsets.UTF_8);
	}
	public  void WriteMessage(String text) throws Exception{
		
		  byte[] bytetext = text.getBytes(StandardCharsets.UTF_8);
		  byte Len = (byte)bytetext.length;
		  byte[] array= new  byte[bytetext.length+2];
		  
		  array[0] =((byte)0x81);
		  array[1]=(Len);
		  
		  System.arraycopy(bytetext, 0, array, 2, bytetext.length);
		
		  out.write(array, 0, array.length);
		
	}
	public String PrepareText(String msg) {
		msg = this.Color+"|"+this.Name+"|"+this.ID+"|"+msg;
		//System.out.println(msg);
		return msg;
	}
	
	public void handleMessages()throws Exception {
		System.out.println("Started Listening for "+this.Name+"'s messages");
		while(true&&!this.Client.isClosed()) {
			if(in.available() > 0) {
				
				String msg =ReadMessage();					
				System.out.println(this.Name+"@"+this.ID+": "+ msg );
				if(msg.split(":")[0].equals("CheckupCode_for_DisconnectDetection")) {
				this.CheckupCode = 	Integer.parseInt(msg.split(":")[1]);
				}else {
				Server.Broadcast(PrepareText(msg));
				}
			
				
			}
	
			
			Thread.sleep(1000);
		}
		System.out.println("Stopped Listening for "+this.Name+"'s messages");
		

		
		
	}
	
	
	public void Welcome(){
		
	try {
		HandShake();
		ReceiveData();
		new Thread(()->{
					try {handleMessages();}catch(Exception e) {e.printStackTrace();}
					
				}).start();
	}catch(Exception e) {
		
		e.printStackTrace();
	}
		
		
	};
	
	
}