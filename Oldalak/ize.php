<?php

	$servername = "localhost";
	$username = "root";
	$password = "";
	$data_base = "auction_house";
	$csatlakozas = mysqli_connect($servername,$username,$password,$data_base);
if(!$csatlakozas)
	{
		die("Hibás csatlakozás");
	}
$name = "users";
$sql = "SELECT * FROM $name";
$data = mysqli_query($csatlakozas,$sql);
echo "csa";

while($sor = mysqli_fetch_array($data))
{
	echo $sor["Username"];
}


?>

