<?php

include '_res/inc_phpfunctions.php';
$pnm = $_GET['po'];

//$pnm = 'Analytics Group';
//echo $pnm;
$dt=date('Y-m-d');
$ctime = date('H:i:s');
$my =date('m');
$yr = date('Y');
$totalarray = array();
$res01=execQuery2("oth","CALL hope('$dt');");

$res02=execQuery2("oth","CALL hope2('$dt');");

$res03=execQuery2("sel","SELECT tdate,ROUND(AVG(utilization),2) as util FROM temp3 WHERE MONTH(tdate) = '$my' AND YEAR(tdate) = '$yr' AND uname IN (SELECT uid FROM empuid WHERE PROCESS = '$pnm') GROUP BY tdate ORDER BY tdate");
echo json_encode($res03);



?>	
