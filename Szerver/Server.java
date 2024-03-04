import java.net.ServerSocket;
import java.net.Socket;
import java.util.Map;
import java.util.TreeMap;

public class Server{
	
	private int Port;
	private static Map<Integer,Client> Clients = new TreeMap<Integer,Client>(); //Id-Socket
	
	public Server(int Port) {
		
		this.Port = Port;
		
		
		
		
	}
	
	public void start() throws Exception{

	
		ServerSocket server = new ServerSocket(8080);
		System.out.println("Server started on port:"+this.Port);
		
		
				
		System.out.println("Clients: "+Clients.size());
	
		
				
				
		
		
		
		while(true) {
			Socket socket = server.accept();
			//if(Clients.containsValue(client)) continue;
			System.out.println("New User Connecting.");
			Client client = new Client(socket);
			client.Welcome();
			while(client.getID()==-1);
			Clients.put(client.getID(), client);
			
			
			
		}
		
		
	}
	
		public void removeDisconnected(){
			
			Clients.forEach((key,client)->{
				
				try {
					
					int CheckupCode=(int)(Math.random()*10000);
					
				client.WriteMessage("CheckupCode_for_DisconnectDetection:"+CheckupCode);
				int counter = 0;
				while(client.CheckupCode != CheckupCode) {
					System.out.println(client.CheckupCode+"!="+CheckupCode);
					Thread.sleep(1000);
					counter++;
					if(counter >= 10) {
						System.out.println("Killing Client #"+client.getID());
						killClient(client.getID());
						break;
					}
				}
				
				
				}catch(Exception e){e.printStackTrace();}
				
			});
			
			
			
		}
	
		public static void Broadcast(String text) {
		
		Clients.forEach((key,client)->{
			try {
				
			client.WriteMessage(text);
			
			
			
			}catch(Exception e){e.printStackTrace();}
			
		});
		
			}
		
		public void killClient(int ID) throws Exception{
			Clients.get(ID).Goodbye();
			Clients.remove(ID);
			
		}
	
	
}