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

	public function save(){

        $q =
        "INSERT INTO webchat_users (name, password, gravatar, is_locked, is_logged_in)
        VALUES  (
                '".DB::esc($this->name)."',
                '".DB::esc($this->hashAndSalt)."',
                '".DB::esc($this->gravatar)."',
                ".var_export($this->isLocked, true).",
                ".var_export($this->isLoggedIn, true)."
                )";

		DB::query($q);

        return DB::getMySQLiObject();
	}
	
	public function update(){
		DB::query("
			INSERT INTO webchat_users (name, gravatar)
			VALUES (
				'".DB::esc($this->name)."',
				'".DB::esc($this->gravatar)."'
			) ON DUPLICATE KEY UPDATE last_activity = NOW()");
	}
}

?>