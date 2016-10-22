<?php

class UserManagement{

	public static function loadUsers(){
		$usersDB = UserDB::getUsers();

        $users = array();
        foreach($usersDB as $u){
            $user = array(
                'name' => $u->getName(),
                'isLocked' => $u->getIsLocked()
            );
            $users[] = $user;
        }

        return array('users' => $users);
	}

	public static function lockUsers($users){
	    Logger::info("lock called with:");
	    Logger::info(users);
	}

	public static function unlockUsers($users){
        Logger::info("unlock called with:");
        Logger::info(users);
    }
}


?>
