<?php
session_start();
try {
    $client = new SoapClient(null, array(
 'uri' => "http://pascal.fis.agh.edu.pl/~5kumorek/moj_server",//"http://pascal.fis.agh.edu.pl/~5kumorek/kolokwium/dir_server/server.php",
 'location' => "http://pascal.fis.agh.edu.pl/~5kumorek/projekt2/dir_server/server.php",
 'soap_version' => SOAP_1_2));
    $r = $client->__soapCall("checkConnection",array(""));
	
	if(!empty($_POST['logowanie']) && $_POST['logowanie']==true){
		if(!empty($_POST['login']) && !empty($_POST['password'])){
			$values=array($_POST['login'],$_POST['password']);
			$_SESSION['is_authorized'] = $client->__soapCall("checkUser",array($values));
			header("Location: client.php");
			exit;
		}
		else {
			$_SESSION['is_authorized']=false;
			header("Location: client.php");
			exit;
		}
	}
	if(!empty($_POST['logout']) && $_POST['logout']==true){
		$_SESSION['is_authorized']=false;
		header("Location: client.php");
    exit;
	}
	
} catch (SoapFault $fault) {
	$_SESSION['message']='Server not response';
	$_SESSION['is_authorized']=false;
	header("Location: client.php");
    exit;
}
?>
