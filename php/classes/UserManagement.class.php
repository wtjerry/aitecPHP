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
        UserDB::lockUsers($users);
        return array('status' => 1);
	}

	public static function unlockUsers($users){
        UserDB::unlockUsers($users);
        return array('status' => 1);
    }
}


?>
