<?php

include '_res/inc_phpfunctions.php';
$pnm = $_GET['po'];
$dt=date('Y-m-d');
$res04=execQuery2("oth","CALL hope2('$dt');");
$res05=execQuery2("sel","SELECT uname,offtime FROM temp3 WHERE uname IN (SELECT uid FROM empuid WHERE PROCESS = '$pnm') and tdate='$dt' GROUP BY uname");

echo json_encode($res05);

?>	
