<?php

class Logger {
	
	public static function info($msg){
      error_log($msg, 3, '/var/log/aitecPHP/log.txt');
	}
}

?>
