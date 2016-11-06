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
        $q = "INSERT INTO webchat_lines (author, gravatar, text) VALUES ( ?, ?, ?)";
        $params = array($this->author, $this->gravatarHash, $this->text);
        NewDB::query($q, $params);
        return NewDB::getInstance()->lastInsertId();
    }
}

?>