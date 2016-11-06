<?php

class ChatDB {
  
    public static function deleteChatsOlderThan5Minutes() {
        $fiveMinutesBeforeNow = new DateTime();
        $fiveMinutesBeforeNow->modify('-5 minutes');
        $fiveMinutesBeforeNowAsString = $fiveMinutesBeforeNow->format('Y-m-d H:i:s');
        DB::query("DELETE FROM webchat_lines WHERE ts < ?", array($fiveMinutesBeforeNowAsString));
    }
    
    public static function getChatLinesNewerThanId($lastID) {
        $queryResult = DB::query("SELECT * FROM webchat_lines WHERE id > ? ORDER BY id ASC", array($lastID));

        $chatLines = array();
        if ($queryResult->rowCount() > 0) {
            while ($result = $queryResult->fetch(PDO::FETCH_OBJ)) {
                $chatLine = new ChatLine(array(
                    'text'          => $result->text,
                    'author'     => $result->author,                 
                    'gravatarHash'   => $result->gravatar,
                    'time'         => $result->ts,
                    'id'             => $result->id,
                ));
                $chatLines[] = $chatLine;
            }
        }

        return $chatLines;
    }
}


?>