<?php

/* Chat line is used for the chat entries */

class ChatLine extends ChatBase{
	
    protected $text = '', $author = '', $gravatarHash = '', $time ='', $id = '';

    public function getText() {
        return $this->text;
    }
    
    public function getAuthor() {
        return $this->author;
    }

    public function getGravatarFromHash() {
        return Converter::convertHashToGravatar($this->gravatarHash);
    }

    public function getTime() {
        return $this->time;
    }
    
    public function getId() {
        return $this->id;
    }

    public function save(){
            OldDB::query("
                    INSERT INTO webchat_lines (author, gravatar, text)
                    VALUES (
                            '".OldDB::esc($this->author)."',
                            '".OldDB::esc($this->gravatarHash)."',
                            '".OldDB::esc($this->text)."'
            )");

            // Returns the MySQLi object of the DB class

            return OldDB::getMySQLiObject();
    }
}

?>