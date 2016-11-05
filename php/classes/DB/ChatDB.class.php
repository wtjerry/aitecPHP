<?php

class ChatDB {
  
    public static function deleteChatsOlderThan5Minutes() {
        $fiveMinutesBeforeNow = new DateTime();
        $fiveMinutesBeforeNow->modify('-5 minutes');
        $fiveMinutesBeforeNowAsString = $fiveMinutesBeforeNow->format('Y-m-d H:i:s');
        Logger::info($fiveMinutesBeforeNowAsString);
        NewDB::query("DELETE FROM webchat_lines WHERE ts < ?", array($fiveMinutesBeforeNowAsString));
    }
}


?>