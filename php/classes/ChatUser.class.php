<?php

class ChatUser extends ChatBase{
	
	protected $name = '', $gravatar = '', $isLocked = true;
	
	public function save(){

		Logger::info("name: ".$this->name." | gravatar: ".$this->gravatar." | isLocked: ".$this->isLocked);
		
		DB::query("
			INSERT INTO webchat_users (name, gravatar, is_locked)
			VALUES (
				'".DB::esc($this->name)."',
				'".DB::esc($this->gravatar)."',
				'".DB::esc($this->isLocked)."'
		)");
		
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