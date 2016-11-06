<?php

class UserDB {

    public static function loginUserOrThrow($name,$password){

        $escapedName = OldDB::esc($name);
        $queryResult = NewDB::query("SELECT * FROM webchat_users WHERE name = ?", array($escapedName));

        
        if($queryResult->rowCount() != 1){
            throw new Exception('Username does not exist');
        }

        $result = $queryResult->fetch(PDO::FETCH_OBJ);

        if($result->is_locked){
            throw new Exception('User is locked');
        }

        if(!password_verify($password, $result->password)){
            throw new Exception('Username or password incorrect.');
        }

        NewDB::query("UPDATE webchat_users SET is_logged_in=1 WHERE name = ?", array($escapedName));

        $user = new ChatUser(array(
            'name'	=> $result->name,
            'gravatar'	=> $result->gravatar
        ));

        return $user;
    }

    public static function logout($name){
        $escapedName = OldDB::esc($name);
        NewDB::query("UPDATE webchat_users SET is_logged_in=0 WHERE name = ?", array($escapedName));
    }

    public static function logoutInactiveUsers(){
        NewDB::query("UPDATE webchat_users SET is_logged_in=0 WHERE last_activity < ? ", array(date("Y-m-d H:i:s")));
    }

    public static function getLoggedInUsers(){
        $queryResult = NewDB::query("SELECT * FROM webchat_users WHERE is_logged_in = true ORDER BY name ASC LIMIT 18");

        $users = array();
        if($queryResult->rowCount() > 0) {
            while($result = $queryResult->fetch(PDO::FETCH_OBJ)) {
                $user = new ChatUser(array(
                    'name'              => $result->name,
                    'gravatar'          => $result->gravatar
                ));
                $users[] = $user;
            }
        }

        return $users;
    }

    public static function updateLastActivity($name){
        $escapedName = OldDB::esc($name);
        NewDB::query("UPDATE webchat_users SET last_activity = ? WHERE name = ?", array(date("Y-m-d H:i:s"), $escapedName));
    }

    public static function getUsers(){
        $queryResult = NewDB::query("SELECT * FROM webchat_users ORDER BY name ASC LIMIT 20");

        $users = array();
        if($queryResult) {
            while($result = $queryResult->fetch(PDO::FETCH_OBJ)){
                $user = new ChatUser(array(
                    'name'		=> $result->name,
                    'isLocked' 	=> $result->is_locked
                ));
                $users[] = $user;
            }
        }

        return $users;
    }
    
    public static function isUsernameOccupied($name) {
        $queryResult = NewDB::query("SELECT 1 FROM webchat_users WHERE name = ? LIMIT 1", array($name));
        $isUsernameFree = $queryResult->rowCount() == 1;
        return $isUsernameFree;
    }

    public static function unlockUsers($users) {
        
        $questionMarks = array();
        $escapedUsers = array();
        foreach($users as $user) {
            $escapedUser = OldDB::esc($user);
            $escapedUsers[] = $escapedUser;
            $questionMarks[] = "?";
        }

        $placeholders = join(", ", $questionMarks);
        $query = "UPDATE webchat_users SET is_locked=0 WHERE name IN ( $placeholders );";
        NewDB::query($query, $escapedUsers);
    }

    public static function lockUsers($users) {
        
        $questionMarks = array();
        $escapedUsers = array();
        foreach ($users as $user) {
            $escapedUser = OldDB::esc($user);
            $escapedUsers[] = $escapedUser;
            $questionMarks[] = "?";
        }

        $placeholders = join(", ", $questionMarks);
        $query = "UPDATE webchat_users SET is_locked=1 WHERE name IN ( $placeholders );";
        NewDB::query($query, $escapedUsers);
    }
}

?>