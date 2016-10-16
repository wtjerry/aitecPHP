<?php

class UserDB {

	public static function getUserOrThrow($name,$password){

	    $escapedName = DB::esc($name);
	    $queryResult = DB::query("SELECT * FROM webchat_users WHERE name = '$escapedName'");

	    if($queryResult->num_rows != 1){
	        throw new Exception('Username does not exist');
	    }

        $result = $queryResult->fetch_object();

        if(!password_verify($password, $result->password)){
            throw new Exception('Username or password incorrect.');
        }

        $user = new ChatUser(array(
            'name'		=> $result->name,
            'gravatar'	=> $result->gravatar
        ));

        return $user;
	}
}

?>