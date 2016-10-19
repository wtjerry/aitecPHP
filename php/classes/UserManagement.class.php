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
}


?>
