<?php
	/*
	 * CxLogger is a library that allows PHP 
	 * applications to log in easier.
	 * Depending on configuration, it logs to 
	 * file, stdout or both. It distinguishes 
	 * between 4 log levels:
	 ** info - standard event
	 ** warning - first level of danger
	 ** standard_error - second level of danger, standard error
	 ** critical_error - critical danger, app stop working for example
	 * 
	 * Author: Cixo
	 */
	 
	 
	/* log levels */
	abstract class Level{
		const info = 0;
		const warning = 1;
		const standard_error = 2;
		const critical_error = 3;
	}
	 
	class CxLogger{
		
		public function __construct(
			?string $file_to_logging = null, 
			bool $log_to_stdout = true, 
			bool $log_to_stdout_warn_err = true
		  ){
			/*
			 * The constructor, if a path to a 
			 * file was given, opens it
			 */
			 
			$this->log_to_stdout = $log_to_stdout;
			$this->log_to_stdout_warn_err = $log_to_stdout_warn_err;
			
			if($file_to_logging !== null)
				$this->openLogFile($file_to_logging);
		}
		
		public function log(int $level, ...$messages){
			/*
			 * The function that creates the next 
			 * log entry, level is the danger level, 
			 * after which you can enter the 
			 * parameters that will be combined into 
			 * the log. After folding, he adds a 
			 * time stamp and saves it 
			 */
			 
			$message_content = '';
			foreach($messages as $message)
				$message_content .= $message.' ';
			$message_content .= "\n";
			
			$message_level = self::level_to_string[$level];
			$message_time = self::timeStamp();
			
			$message_to_save = "[$message_level] [$message_time] $message_content";
			
			$this->logStdout($message_to_save, $level);
			$this->logFile($message_to_save);
		}
		
		/* handler for log file, if not logging to a file, null */ 
		private $file_to_logging;
		
		/* log to stdout, if true, then all logs are also saved to STDERR */	
		private bool $log_to_stdout;
		
		/* 
		 * if it is true, but $ log_to_stdout false, 
		 * logs with log level> 0 will be added to STDERR 
		 */		
		private bool $log_to_stdout_warn_err;
		
		/* log levels to text const */ 
		private const level_to_string = [
			'INFO',
			'WARNING',
			'ERROR',
			'!!! CRITICAL ERROR !!!',
		];
		 
		private function openLogFile(string $file_to_logging){
			/*
			 * It tries to open the file to which 
			 * it is to log, if it succeeds, it 
			 * writes the handle, if not, it writes 
			 * null and logs about it
			 */
			 
			if(!@$this->file_to_logging = fopen($file_to_logging, 'a')){
				$this->file_to_logging = null;
				$this->log(
					Level::standard_error, 
					"Can not open log file [$file_to_logging]!"
				  );
			}
		}
		 
		private function closeLogFile(){
			/*
			 * Closes the log file, if it is open
			 */
			 
			if($this->file_to_logging !== null)
				fclose($this->file_to_logging);
		}
		 
		private static function timeStamp() : string{
			/*
			 * The function generates a timestamp
			 */
			 
			return date('Y-m-d H:i:s');
		}
		
		private function logStdout(string $message, int $level){
			/*
			 * Writes a message to SDTERR if 
			 * the parameters allow it
			 */
			 
			if($this->log_to_stdout or $this->log_to_stdout_warn_err and $level > 0)
				fwrite(STDERR, $message);
		}
		
		private function logFile(string $message){
			/*
			 * Writes the message to a file, 
			 * if it is open
			 */
			 
			if($this->file_to_logging !== null) 
				fputs($this->file_to_logging, $message);
		}
		
		public function __destruct(){
			/*
			 * Destruktor, closes the file after 
			 * destroying the logger
			 */
			 
			$this->closeLogFile();
		}
	}
?>
