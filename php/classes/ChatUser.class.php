<?php

class ChatUser extends ChatBase{
	
    protected $name = '', $gravatar = '', $hashAndSalt = '', $isLocked = true, $isLoggedIn = 0;

    public function getName(){
        return $this->name;
    }

    public function getGravatar(){
        return $this->gravatar;
    }

    public function getGravatarFromHash(){
        return Converter::convertHashToGravatar($this->gravatar);
    }

    public function getIsLoggedIn(){
        return $this->isLoggedIn;
    }

    public function getIsLocked(){
        return $this->isLocked;
    }

    public function save(){
        $q = "INSERT INTO webchat_users (name, password, gravatar, is_locked, is_logged_in) VALUES ( ?, ?, ?, ?, ?)";
        $params = array($this->name, $this->hashAndSalt, $this->gravatar, $this->isLocked, $this->isLoggedIn);
        DB::query($q, $params);
    }

    public function update(){
        UserDB::updateLastActivity($this->name);
    }
}

?>