<?php
include_once '../config/database.php';
include_once '../objects/product.php';

//*****************************************
function readAll() {
$columns = array('id', 'name', 'quantity');

$database = new MyDB();
$product = new Product($database,'product');

$result = $product->readAll($columns);
$database->close();
	
	return $result;
}

//*****************************************
function getRows() {

$columns = array('id', 'name', 'quantity');

$database = new MyDB();
$product = new Product($database,'product');

$result = $product->getRows($columns);
$database->close();
	
	return $result;
}
//*****************************************
function getData() {

$columns = array("name"=>'name', "quantity"=>'quantity');

$database = new MyDB();
$product = new Product($database,'product');

$result = $product->getData($columns);
$database->close();
	
	return $result;
}
//*****************************************
function insertRecord($values) {

$columns = array("name"=>'name', "quantity"=>'quantity');

if(count($columns)!=count($values))
	return false;

$database = new MyDB();
$product = new Product($database,'product');

	//return $product->insert($columns, $values);
$result = $product->insert($columns, $values);
$database->close();
	
	if($result==true)
		return '<span class="label label-success">SUCCESS!</span>';
	else
		return '<span class="label label-warning">Insert failed</span>';
}
//*****************************************
function checkConnection(){
	return TRUE;	
}
//*****************************************
function checkUser($values) {

	if($values[0]=='admin' && $values[1]=='admin')
		return true;
	else
		return false;
		
//$database = new MyDB();
//$product = new Product($database,'product');

//$result = $product->getRows($columns);
//$database->close();
	
	//return true;
}
//*****************************************
 $server = new SoapServer(null, array(
 'uri' => "http://pascal.fis.agh.edu.pl/~5kumorek/moj_server",//"http://pascal.fis.agh.edu.pl/~5kumorek/kolokwium/dir_server/server.php",
 'soap_version' => SOAP_1_2));
 $server->addFunction("getRows");
$server->addFunction("checkConnection");
 $server->addFunction("getData");
$server->addFunction("readAll");
$server->addFunction("insertRecord");
$server->addFunction("checkUser");
 $server->handle();
?>
