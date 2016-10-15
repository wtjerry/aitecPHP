<?php

class ChatUser extends ChatBase{
	
	protected $name = '', $gravatar = '', $hashAndSalt = '', $isLocked = true;
	
	public function save(){

		Logger::info("name: ".$this->name." | pw: ".$this->hashAndSalt." | gravatar: ".$this->gravatar." | isLocked: ".$this->isLocked);
		
		DB::query("
			INSERT INTO webchat_users (name, password, gravatar, is_locked)
			VALUES (
				'".DB::esc($this->name)."',
				'".DB::esc($this->hashAndSalt)."',
				'".DB::esc($this->gravatar)."',
				$this->isLocked
		)");

        $error = DB::getMySQLiObject()->error;
        if($error){
            Logger::info($error);
        }

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