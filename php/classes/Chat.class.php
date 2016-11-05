<?php

/* The Chat class exploses public static methods, used by ajax.php */

class Chat{

	public static function register($name,$email,$password,$passwordReenter){

	    if(!$name || !$email){
            throw new Exception('Fill in all the required fields.');
        }

        if(!filter_input(INPUT_POST,'registerEmail',FILTER_VALIDATE_EMAIL)){
            throw new Exception('Your email is invalid.');
        }

        $passwordRegex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,100}$/";
        if(!filter_var($password, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>$passwordRegex)))){
            throw new Exception('Password must be 8 to 100 characters long and contain at least one lower case letter, one upper case letter and a digit.');
        }

        if($password != $passwordReenter){
            throw new Exception('The passwords you entered do not match.');
        }

        // Preparing the gravatar hash:
        $gravatar = md5(strtolower(trim($email)));

        $hashAndSalt = password_hash($password, PASSWORD_BCRYPT);

        $user = new ChatUser(array(
            'name'		=> $name,
            'hashAndSalt'  => $hashAndSalt,
            'gravatar'	=> $gravatar
        ));

        // The save method returns a MySQLi object
        if($user->save()->affected_rows != 1){
            throw new Exception('This nick is in use.');
        }

        return array('status' => 1);
	}

	public static function login($name,$password){
		if(!$name || !$password){
			throw new Exception('Fill in all the required fields.');
		}

        $user = UserDB::loginUserOrThrow($name,$password);

		$_SESSION['user']	= array(
			'name'		=> $user->getName(),
			'gravatar'	=> $user->getGravatar()
		);

		return array(
			'status'	=> 1,
			'name'		=> $user->getName(),
			'gravatar'	=> $user->getGravatarFromHash()
		);
	}
	
	public static function checkLogged(){
		$response = array('logged' => false);
			
		if($_SESSION['user']['name']){
			$response['logged'] = true;
			$response['loggedAs'] = array(
				'name'		=> $_SESSION['user']['name'],
				'gravatar'	=> Converter::convertHashToGravatar($_SESSION['user']['gravatar'])
			);
		}
		
		return $response;
	}
	
	public static function logout(){
        UserDB::logout(OldDB::esc($_SESSION['user']['name']));
		
		$_SESSION = array();
		unset($_SESSION);

		return array('status' => 1);
	}
	
	public static function submitChat($chatText){
		if(!$_SESSION['user']){
			throw new Exception('You are not logged in');
		}
		
		if(!$chatText){
			throw new Exception('You haven\' entered a chat message.');
		}
	
		$chat = new ChatLine(array(
			'author'	=> $_SESSION['user']['name'],
			'gravatar'	=> $_SESSION['user']['gravatar'],
			'text'		=> $chatText
		));
	
		// The save method returns a MySQLi object
		$insertID = $chat->save()->insert_id;
	
		return array(
			'status'	=> 1,
			'insertID'	=> $insertID
		);
	}

	public static function getUsers(){
		if($_SESSION['user']['name']){
			$user = new ChatUser(array('name' => $_SESSION['user']['name']));
			$user->update();
		}

		// Deleting chats older than 5 minutes and users inactive for 30 seconds
		OldDB::query("DELETE FROM webchat_lines WHERE ts < SUBTIME(NOW(),'0:5:0')");
		UserDB::logoutInactiveUsers();

		$usersDB = UserDB::getLoggedInUsers();

        $users = array();
        foreach($usersDB as $u){
            $user = array(
                'name' => $u->getName(),
                'gravatar' => $u->getGravatarFromHash()
            );
            $users[] = $user;
        }

		return array(
			'users' => $users,
			'total' => count($users)
		);
	}
	
	public static function getChats($lastID){
		$lastID = (int)$lastID;
	
		$result = OldDB::query('SELECT * FROM webchat_lines WHERE id > '.$lastID.' ORDER BY id ASC');
	
		$chats = array();
		if($result) {
			while($chat = $result->fetch_object()){
		
				// Returning the GMT (UTC) time of the chat creation:
		
				$chat->time = array(
					'hours'		=> gmdate('H',strtotime($chat->ts)),
					'minutes'	=> gmdate('i',strtotime($chat->ts))
				);
		
				$chat->gravatar = Converter::convertHashToGravatar($chat->gravatar);
		
				$chats[] = $chat;
			}
		}
	
		return array('chats' => $chats);
	}
}


?>
