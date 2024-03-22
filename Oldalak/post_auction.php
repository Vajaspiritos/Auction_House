<?php
$time_window = 10; //10 perc
$break_time = 5;

include '../Resources/Scriptek/CheckForLoggedIn.php';
include '../Resources/Scriptek/ConnectToDB.php';
if(empty($_POST['selected_items_container'])||isset($_POST["submit"])) returnWithError("Didn'T recive data");
$array = json_decode($_POST['selected_items_container']);
UpdateGeneralInfos($conn);
unset( $_POST['selected_items_container']);

$inventory=json_decode(GetInventory($conn),TRUE);

$ids =[];
$tier = 0;
foreach($inventory as $item){	
	$ids[] = $item['ID'];	
	if($item['Rarity'] > $tier) $tier = $item["Rarity"];
}
foreach($array as $item){
	if(!in_array($item,$ids)) returnWithError("Rossz item");	
}

if(count($inventory) < 5) returnWithError("Nem jelöltél ki elég tárgyat");

$result = $conn -> query("SELECT Date FROM `auction`");

$date = strtotime(date("Y-m-d H:i:s", (time() + $time_window*60)));
$tmp_time = $time_window;
while(true){
	
foreach($result as $row){
	
	if( ($date-strtotime($row["Date"])) < ($time_window+$break_time)*60 ){
		
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

returnWithError("Sucessfull posting");


function returnWithError($text){
	
	$_SESSION["Error"] = $text;
	echo "return";
	echo "<script>window.top.location.href='sajat_aukcio.php'</script>";
	
	die();
	
}

?>