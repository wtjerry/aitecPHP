<?php

class UserDB {

	public static function loginUserOrThrow($name,$password){

        $escapedName = DB::esc($name);
	    $queryResult = DB::query("SELECT * FROM webchat_users WHERE name = '$escapedName'");

	    if($queryResult->num_rows != 1){
	        throw new Exception('Username does not exist');
	    }

        $result = $queryResult->fetch_object();

        if(!password_verify($password, $result->password)){
            throw new Exception('Username or password incorrect.');
        }

        DB::query("UPDATE webchat_users SET is_logged_in=1 WHERE name = '$escapedName'");

        $user = new ChatUser(array(
            'name'		=> $result->name,
            'gravatar'	=> $result->gravatar
        ));

        return $user;
	}

	public static function logout($name){
	    $escapedName = DB::esc($name);
        DB::query("UPDATE webchat_users SET is_logged_in=0 WHERE name = '$escapedName'");
	}

	public static function logoutInactiveUsers(){
        DB::query("UPDATE webchat_users SET is_logged_in=0 WHERE last_activity < SUBTIME(NOW(),'0:0:30')");
    }

    public static function getLoggedInUsers(){
        $queryResult = DB::query("SELECT * FROM webchat_users WHERE is_logged_in = true ORDER BY name ASC LIMIT 18");

        $users = array();
        if($queryResult) {
            while($result = $queryResult->fetch_object()){
                $user = new ChatUser(array(
                    'name'		=> $result->name,
                    'gravatar'	=> $result->gravatar
                ));
                $users[] = $user;
            }
        }

        return $users;
    }
}

?>