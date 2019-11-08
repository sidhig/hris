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

function setBlank($pStr)
{
    $rslt = (empty($pStr)) ? 'NULL' : $pStr;
	$rslt = str_replace("'", "\'", $rslt);
    return $rslt;
}
function setNull($pStr)
{
    $rslt = (empty($pStr)) ? 'NULL' : $pStr;
    return $rslt;
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

include 'mailfunction.php';

$Msg="";
if(isset($_POST['fbk']))
{
	$empid = $_POST['empid'];
	$uname = $_POST['name'];
	$doj = $_POST['doj'];
	$function = $_POST['function'];
	$subfunction = $_POST['subfunction'];
	$process = $_POST['process'];
	$role = $_POST['role'];
	$sup = $_POST['sup'];
	$cont = $_POST['cont'];
	$mailid = $_POST['mailid'];
	$fbk = $_POST['fbk'];
	
	$sqlout = execQuery("oth", "insert into ask_er(empid,name,doj,function,subfunction,process,role,sup,cont,mailid,fbk) values('".$_POST['empid']."','".$_POST['name']."','".$_POST['doj']."','".$_POST['function']."','".$_POST['subfunction']."','".$_POST['process']."','".$_POST['role']."','".$_POST['sup']."','".$_POST['cont']."','".$_POST['mailid']."','".$_POST['fbk']."');");
	if($sqlout == 1)
	{
		$Msg = "<div id='eMsg'>Feedback/Concern has been updated in the database..</div>";
		$body02 = "<div style='margin:5px auto;background:#da7;border:10px solid #da7'>Hi,<br/><br/>$uname has submitted a feedback/Concern through 'Ask ER' Form..<br/><br/><b>ECN:</b> $empid<br/><b>Name:</b> $uname<br/><b>DOJ:</b> $doj<br/><b>Function:</b> $function<br/><b>Subfunction:</b> $subfunction<br/><b>Process:</b> $process<br/><b>Designation:</b> $role<br/><b>Supervisor:</b> $sup<br/><b>Number:</b> $cont<br/><b>E-Mail Id:</b> $mailid<br/><b>Feedback/Concern:</b><br/>$fbk<br/><br/>Regards,<br/>Admin - Ask ER</div>";
		$emailAdd02 = "shashikant.bohat@hyperquality.com";
		fnMail($emailAdd02,"ask.er@communique.com","ASK ER","New Submission - Ask ER",$body02);

	}
	else
	{
		$Msg = "<div id='eMsg'> There was some ERROR..</div>";
	}
}





?>



<!doctype html>
<html>
<head>
<title>Ask ER /eER Helpdesk</title>
<meta content="">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type='text/javascript' src='http://172.17.5.156/_dep/js/jquery-1.9.1.min.js'></script>
<script type="text/javascript" src="http://172.17.5.156/_dep/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://172.17.5.156/_dep/bootstrap/js/bootstrap-multiselect.js"></script>
<script type="text/javascript" src="http://172.17.5.156/_dep/js/jquery-ui.js"></script>
<script type="text/javascript" src="http://172.17.5.156/_dep/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="http://172.17.5.156/_dep/js/asker.js"></script>
<script type="text/javascript" src="http://172.17.5.156/_dep/js/jquery.ui.datepicker.validation.js"></script>

<link rel="stylesheet" href="http://172.17.5.156/_dep/bootstrap/css/bootstrap.min.css" type="text/css"/>
<link rel="stylesheet" href="http://172.17.5.156/_dep/bootstrap/css/bootstrap-multiselect.css" type="text/css"/>
<link rel="stylesheet" href="http://172.17.5.156/_dep/css/jquery-ui.css"/>
<link rel="stylesheet" href="http://172.17.5.156/_dep/css/asker.css" type="text/css"/>


<script type="text/javascript">
$( document ).ready(function() 
{
    $('.clsHide').hide();
    $( ".monthpicker" ).datepicker();
    $( ".monthpicker" ).datepicker( "option", "dateFormat","M-y");
    $( ".datepicker" ).datepicker();
    $( ".datepicker" ).datepicker( "option", "dateFormat","yy-mm-dd");
	
	$('#function').on('change', function(){
		var cond = "WHERE function='"+$(this).val()+"'";
		$.ajax({
			url :'getlist.php',
			type :'GET',
			data : {'clm' : 'subfunction','tbl' : 'resignation','cond' : cond} 
		})
		.done(function(d){$('#subfunction').html(d);})
		.fail(function(xhr){alert(xhr.status);})
	});

	$('#subfunction').on('change', function(){
		var cond2 = "WHERE subfunction='"+$(this).val()+"' and function='"+$('#function').val()+"'";
		$.ajax({
			url :'getlist.php',
			type :'GET',
			data : {'clm' : 'process','tbl' : 'resignation','cond' : cond2} 
		})
		.done(function(d){$('#process').html(d);})
		.fail(function(xhr){alert(xhr.status);})
	});
	
	$('#process').on('change', function(){
		var cond2 = "WHERE process='"+$(this).val()+"' and subfunction='"+$('#subfunction').val()+"' and function='"+$('#function').val()+"'";
		$.ajax({
			url :'getlist.php',
			type :'GET',
			data : {'clm' : 'role','tbl' : 'resignation','cond' : cond2} 
		})
		.done(function(d){$('#role').html(d);})
		.fail(function(xhr){alert(xhr.status);})
	});
	$('#asker').validate({
		rules:{empid:{required:true,digits:true},
			   cont:{required:true,digits:true}},
		messages:{empid:{required:"*required",digits:"Only digits are allowed"},
				  cont:{required:"*required",digits:"Only digits are allowed"}}
	});

});
</script>
</head>
<body>
<div class="cContainer">
		<div class="cRow" style="color:#000; font-size:30px;text-align:center;font-weight:bold;padding:15px;">
			Ask ER
		</div>
		<div class="cRow"  style="border:0;">
			<div id="menu" style="background-image:url('_res/images/mbar.png');">	 <?php include $menu; ?> <div class="spacer"></div></div>
		</div>
		<div class="cRow" style="border:0;padding-top:7px;padding-bottom:7px;text-align:center;">
			<div style="margin:0px auto;"><?php echo $Msg;?></div>
		</div>

		
<div class="cRow" >
    <div style="width:500px;margin:10px auto;text-align:center;">
    		<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<h3 class="panel-title"><b>eER Helpdesk</b></h3>
			 	</div>
			  	<div class="panel-body" style="padding-left:60px;">
			    	<form accept-charset="UTF-8" role="form" action="" method="POST" name="asker" id="asker" >
					<fieldset style="text-align:left;">
			    		<div class="form-group">
			    		    <label>Employee Code</label>
							<input class="form-control" placeholder="ECN" name="empid" id="empid" type="text" style="width:220px;" required/>
			    		</div>
			    		<div class="form-group">
			    		    <label>Name</label>
							<input class="form-control" placeholder="Name" name="name" id="name" type="text" style="width:220px;" required/>
			    		</div>
			    		<div class="form-group">
			    		    <label>DOJ</label>
							<input class="form-control datepicker" placeholder="Date of Joining" name="doj" id="doj" type="text" style="width:220px;" required readonly />
			    		</div>
			    	  	<div class="form-group">
							<label>Function Name</label>
							<select class="form-control" placeholder="Function Name" name="function" id="function" style="width:220px;" required><option value="">select function</option><?php echo getList('function','resignation');?></select>
			    		</div>
			    	  	<div class="form-group">
							<label>Sub-Function Name</label>
							<select class="form-control" placeholder="Sub-Function Name" name="subfunction" id="subfunction" style="width:220px;" required><option value="">select</option></select>
			    		</div>
			    		<div class="form-group">
							<label>Process Name</label>
							<select class="form-control" placeholder="Process Name" name="process" id="process" style="width:220px;" required><option value="">select</option></select>
			    		</div>
			    		<div class="form-group">
							<label>Designation</label>
							<select class="form-control" placeholder="Role Name" name="role" id="role" style="width:220px;" required><option value="">select</option></select>
			    		</div>
			    		<div class="form-group">
			    		    <label>Supervisor</label>
							<input class="form-control" placeholder="Supervisor" name="sup" id="sup" type="text" style="width:220px;" required/>
			    		</div>
			    		<div class="form-group">
			    		    <label>Your Contact Number</label>
							<input class="form-control" placeholder="Your Contact Number" name="cont" id="cont" type="text" style="width:220px;" required/>
			    		</div>
			    		<div class="form-group">
			    		    <label>E-Mail</label>
							<input class="form-control" placeholder="Mail ID" name="mailid" id="mailid" type="text" style="width:220px;" required/>
			    		</div>
			    		<div class="form-group">
			    		    <label>Feedback/Concern</label>
							<textarea class="form-control" placeholder="Feedback/Concern" name="fbk" id="fbk" style="width:400px;height:150px;" required></textarea>
			    		</div>
			    		<br/><br/>
			    		<input class="btn btn-primary" type="submit" id="submit "value="Submit"/>
			    	</fieldset>
			      	</form>
					
			    </div>
			</div>
    </div>


	<div class="cRow" style="border:0px;padding:20px;text-align:center;">
			<div style="margin:0px auto;">Copyright &copy; HyperQuality <?php echo date("Y")?>. All Rights Reserved.</div>
		</div>
		
	</div>
</body>
</html>
