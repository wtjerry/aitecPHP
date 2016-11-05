<?php

/* Database Configuration. Add your details below */

$dbOptions = array(
	'db_host' => 'localhost',
	'db_user' => 'aitec',
	'db_pass' => 'aitec',
	'db_name' => 'test'
);

/* Database Config End */

//report everything except notice
error_reporting(E_ALL ^ E_NOTICE);

require "classes/DB/OldDB.class.php";
require "classes/DB/NewDB.class.php";
require "classes/DB/UserDB.class.php";
require "classes/Logger.class.php";
require "classes/Converter.class.php";
require "classes/Chat.class.php";
require "classes/ChatBase.class.php";
require "classes/ChatLine.class.php";
require "classes/ChatUser.class.php";
require "classes/UserManagement.class.php";

session_name('webchat');
session_start();

try{
	
	// Connecting to the database
	OldDB::init($dbOptions);
	NewDB::init($dbOptions);

	$response = array();
	
	// Handling the supported actions:
	
	switch($_GET['action']){

		case 'register':
		    $response = Chat::register($_POST['registerName'],$_POST['registerEmail'],$_POST['registerPassword'],$_POST['registerPasswordReenter']);
		break;

		case 'login':
			$response = Chat::login($_POST['name'],$_POST['password']);
		break;

		case 'adminLogin':
            $response = Chat::login($_POST['adminName'],$_POST['adminPassword']);
        break;

		case 'loadUsersForUserManagement':
            $response = UserManagement::loadUsers();
        break;

		case 'checkLogged':
			$response = Chat::checkLogged();
		break;
		
		case 'logout':
			$response = Chat::logout();
		break;
		
		case 'submitChat':
			$response = Chat::submitChat($_POST['chatText']);
		break;
		
		case 'getUsers':
			$response = Chat::getUsers();
		break;
		
		case 'getChats':
			$response = Chat::getChats($_GET['lastID']);
		break;

        case 'unlockUsers':
            $response = UserManagement::unlockUsers($_POST['users']);
        break;

		case 'lockUsers':
            $response = UserManagement::lockUsers($_POST['users']);
        break;

		default:
			throw new Exception('Wrong action');
	}
	
	echo json_encode($response);
}
catch(Exception $e){
	die(json_encode(array('error' => $e->getMessage())));
}

?>
