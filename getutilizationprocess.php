<?php
session_start();

include '_res/inc_phpfunctions.php';
$ecn=$_SESSION['mirror']['ecn'];
$dt=date('Y-m-d');
$pname="";
$resa=execQuery("sel","select pname1,pname2,pname3,pname4,pname5 from user where ecn='$ecn'");
foreach($resa as $k=>$e1)
{
			$pname = "'".$e1['pname1']."'";
			$pname .= empty($e1['pname2']) ? "" : ",'".$e1['pname2']."'";
			$pname .= empty($e1['pname3']) ? "" : ",'".$e1['pname3']."'";
			$pname .= empty($e1['pname4']) ? "" : ",'".$e1['pname4']."'";
			$pname .= empty($e1['pname5']) ? "" : ",'".$e1['pname5']."'";
}


		$resb=execQuery2("oth","CALL hope2('$dt');");
		$resc=execQuery2("sel","SELECT e.process AS pname,ROUND(AVG(utilization),2) AS itime FROM temp3 t,empuid e WHERE tdate='$dt' AND t.uname=e.uid AND e.process IN ($pname) GROUP BY e.process ORDER BY itime;");
		echo json_encode($resc);
	


?>	
