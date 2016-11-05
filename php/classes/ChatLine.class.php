<?php

/* Chat line is used for the chat entries */

class ChatLine extends ChatBase{
	
	protected $text = '', $author = '', $gravatar = '';
	
	public function save(){
		OldDB::query("
			INSERT INTO webchat_lines (author, gravatar, text)
			VALUES (
				'".OldDB::esc($this->author)."',
				'".OldDB::esc($this->gravatar)."',
				'".OldDB::esc($this->text)."'
		)");
		
		// Returns the MySQLi object of the DB class
		
		return OldDB::getMySQLiObject();
	}
}

?>