<?php

//require_once __DIR__.'/../vendor/autoload.php';
//require_once __DIR__.'/../include/global_config.php';

//use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Component\Validator\Validation;
//use Symfony\Component\Validator\Constraints\NotBlank;

//mysql_query("use $db_name;");

//$validator = Validation::createValidator();

//get input

// $userName = "";
// if (isset($_POST['userName'])){
// 	$userName = strip_tags(trim($_POST["userName"]));
// 	$userName = mysql_real_escape_string($userName);
// }

// $pathName = "";
// if (isset($_POST['pathName'])){
// 	$pathName = strip_tags(trim($_POST["pathName"]));
// 	$pathName = mysql_real_escape_string($pathName);
// }
// echo $userName;exit();
//security input

//initial validator
//$violations = $validator->validate($userName, new Assert\NotBlank());

//Add app rule
//$sqlGetMemberByName = "select mem_id from flc_member where mem_user = '$userName';";
//$member = mysql_query($sqlGetMemberByName);

// $errorsArray = array(
// 	'status' => 1,
// );

// $errorsArray = array(
// 	"errorName" => array(
// 		"status" => 1
// 	)
// );
// if (mysql_num_rows($member) == 0) {
// 	$errorsArray = array(
// 		"errorName" => array(
// 			"status" => 0
// 		)
// 	);
// }


// Validate Path Name

//$sqlGetMemberByPath = "select mem_id from flc_member where mem_folder = '$pathName';";
//$memberByPath = mysql_query($sqlGetMemberByPath);

// header('Content-Type: application/json');
// echo json_encode($errorsArray);

//return

//var_dump(is_string("123abc_add-a"));exit();
//phpinfo();exit;
error_reporting(-1);
ini_set("display_errors", "On");

const PDO_USER = "factlink_db";
const PDO_PASS = "01354101";


try {

	// INITIAL PDO OPJECT
	$dbh = new PDO('mysql:host=localhost;dbname=factlink_beta', PDO_USER, PDO_PASS);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//BUILD QUERY
	$query = "SELECT mem_id FROM flc_member WHERE mem_user = :userName LIMIT 10";
	$sth =  $dbh->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	$dbh->execute(array("userName" => "thuando"));
} catch (Exception $e) {
	
}
die();

if (isset($_POST['userName'])){
	$userName = $_POST['userName'];

	$dbh = new PDO('mysql:host=localhost;dbname=factlink_beta', PDO_USER, PDO_PASS);
	var_dump($dbh);exit();

	// try {
	// 	$dbh = new PDO('mysql:host=localhost;dbname=factlink_beta', PDO_USER, PDO_PASS);
	// } catch (Exception $e) {
	// }
	// header('Content-Type: application/json');
	// echo json_encode($userName);
}
?>