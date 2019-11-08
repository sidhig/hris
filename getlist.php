<?php

function openConn()
{
    $servername = "172.17.5.201";
    $username = "communique";
    $password = "bh*Y67Qpl";
    $dbname = "communique";
    try 
    {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
    }
    catch(PDOException $e)
    {
        echo "MySql Connection Error: " . $e->getMessage() ;
    }
    return $conn;
}

function execQuery($typ, $str)
{
    $result;
	try
    {
        $conn = openConn();
        $stmt = $conn->prepare($str);
        if($typ == "oth")
        {
            $result = $stmt->execute();
            
        }
        else if($typ == "sel")
        {
            $stmt->execute();
            $result = $stmt->FetchAll(PDO::FETCH_ASSOC);
        }
        
    }
    catch(PDOException $e)
    {
        echo "MySql statement Error: " . $e->getMessage() . "<br/>SQL: " . $str ;
	}
    $conn = null;
	return $result;
}


function getList( $clmName,$tblName,$cond)
{
	$sql = "SELECT DISTINCT $clmName AS clm FROM $tblName $cond";
	
	$strOptn = '';
	$sqlOut = execQuery("sel", $sql);
	foreach ($sqlOut as $k1 => $e1)
	{
		$strOptn .= '<option value = "'.$e1['clm'].'">'.$e1['clm'].'</option>';
	} 
	return $strOptn ;
}

$clm =  $_GET['clm'];
$tbl =  $_GET['tbl'];
$condn =  $_GET['cond'];
$strList = '<option value="">select</option>';
$strList .= getList( $clm,$tbl,$condn);
echo $strList;
?>