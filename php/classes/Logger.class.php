<?php

class Logger {
	
	public static function info($msg){
      error_log($msg."\n", 3, '/var/log/aitecPHP/log.txt');
	}
}

?>
