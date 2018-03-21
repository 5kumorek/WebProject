<?php
session_start();
try {
    $client = new SoapClient(null, array(
 'uri' => "http://pascal.fis.agh.edu.pl/~5kumorek/moj_server",//"http://pascal.fis.agh.edu.pl/~5kumorek/kolokwium/dir_server/server.php",
 'location' => "http://pascal.fis.agh.edu.pl/~5kumorek/projekt2/dir_server/server.php",
 'soap_version' => SOAP_1_2));
    $r = $client->__soapCall("checkConnection",array(""));
	if(isset($_SESSION['is_authorized']) && $_SESSION['is_authorized']==true) {
		if(!empty($_POST['get_table'])){
			$data = array();
			$data['status'] = true;
			$data['result'] = $client->__soapCall("getRows",array(""));
			echo json_encode($data);
		}
		if(!empty($_POST['name']) && !empty($_POST['quantity'])){
			$data = array();
			$data['status'] = true;
			$name = "'" . $_POST['name'] . "'";
			$quantity = $_POST['quantity'];
			$values=array($name,$quantity);
			$data['result'] = $client->__soapCall("insertRecord",array($values));
			//$data['result'] = 'jakies info';
			echo json_encode($data);
		}
	}else {
		$data['status'] = false;
		$data['result']='You are not logged in';
		echo json_encode($data);
	}
} catch (SoapFault $fault) {
	$data['status'] = false;
	$data['result'] = "Server not response";
	echo json_encode($data);
}
?>
