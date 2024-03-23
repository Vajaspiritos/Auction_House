<?php
$time_window = 10; //10 perc
$break_time = 5;
$time_per_item = 1;

include '../Resources/Scriptek/CheckForLoggedIn.php';
include '../Resources/Scriptek/ConnectToDB.php';
if(empty($_POST['selected_items_container'])||isset($_POST["submit"])) returnWithError("Didn'T recive data");
$array = json_decode($_POST['selected_items_container']);
UpdateGeneralInfos($conn);
unset( $_POST['selected_items_container']);

$inventory=json_decode(GetInventory($conn),TRUE);

$first = array_shift($array);


$ids =[];
$tier = 0;
$loadout = [];
foreach($inventory as $item){	
	$ids[] = $item['ID'];	
	if(in_array($item['ID'],$array)) $loadout[]=$item;
	if($item['Rarity'] > $tier) $tier = $item["Rarity"];
}
foreach($array as $item){
	if(!in_array($item,$ids)) returnWithError("Rossz item");	
}
if($first == "own"){
if(count($inventory) < 5) returnWithError("Nem jelöltél ki elég tárgyat");

$result = $conn -> query("SELECT Date,ID FROM `auction`");

$date = strtotime(date("Y-m-d H:i:s", (time() + $time_window*60)));
$tmp_time = $time_window;
while(true){
	
foreach($result as $row){
	$counter = mysqli_num_rows($conn->query("SELECT ID FROM `items` WHERE Auction_ID=".$row["ID"]));
	if( ($date-strtotime($row["Date"])) < ($time_window+$break_time+($time_per_item*$counter))*60 ){
			
			
		
		$date += rand(1,6) *10*60;
		continue;
	}
	
}

break;
}
$date= date("Y-m-d H:i:s",$date);
$manager = $_SESSION["Name"];

$conn->query("INSERT INTO `auction` (Date,Tier,Manager) VALUES ('$date',$tier,'$manager')");
$id = $conn->query("SELECT ID FROM `auction` WHERE Date='$date'")->fetch_assoc()["ID"];

foreach($array as $item){
	
	$conn->query("UPDATE `items` SET Auction_ID=$id WHERE ID=".$item.";");
	
}

}else{
	$missed = 0;
	foreach($loadout as $item){
	
	$result = $conn -> query("SELECT * FROM `auction` WHERE Date > '".date("Y-m-d H:i:s")."' AND Tier=".$item["Rarity"]." ORDER BY RAND() LIMIT 1");
	
		if(mysqli_num_rows($result) == 0){
			$missed++;
		}else{
			$id = $result->fetch_assoc()['ID'];
			$conn->query("UPDATE `items` SET Auction_ID=$id WHERE ID=".$item['ID'].";");
		}
		
		
	}
	if($missed >0) returnWithError("Missed: ".$missed);
}

returnWithError("Sucessfull posting");


function returnWithError($text){
	
	$_SESSION["Error"] = $text;
	echo "return";
	//echo $text;
	echo "<script>window.top.location.href='sajat_aukcio.php'</script>";
	
	die();
	
}

?>