<?php


$array = array();

$array["Character"] = array();

$tmp = [];

$tmp[]= explode("|","Patches|1.5|0.8");
$tmp[]= explode("|","Dougles Dougles|0.9|1");
$tmp[]= explode("|","Reigen|1.2|2.1");
$tmp[]= explode("|","Ms. Tamás|1|1");
$tmp[]= explode("|","Gavlan a törp|0|0.5");
$tmp[]= explode("|","Morshu|0.7|1.3");
$tmp[]= explode("|","Kira Yoshikage.|1.2|0.8");
$tmp[]= explode("|","Dio Brando|0.7|1.7");
$tmp[]= explode("|","Jack|black|1.5|2");
$tmp[]= explode("|","Jaffar|1|1");
$tmp[]= explode("|","Orobors|1.3|1.2");

foreach($tmp as $c){
	$asd = array();
	$asd["name"]= $c[0];
	$asd["pitch"]= $c[1];
	$asd["speed"]= $c[2];
	$array["Character"][] = $asd;
	
	
}
var_dump($array);
echo json_encode($array);
?>