<?php

class Logger {
	
	public static function info($msg){
	  $now = date("Y-m-d H:i:s");
      error_log($now.": ".$msg."\n", 3, '/var/log/aitecPHP/log.txt');
	}
}

?>
