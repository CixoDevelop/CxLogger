<?php
	/*
	 * Simple tests for CxLogger
	 */
	 
	/* Fisrt, reuire and create logger to file */
	require_once("CxLogger.php");
	 
	$log_to_stdout = new CxLogger();
	$log_to_stdout->log(Level::info, "If you see it, logging only to STDERR work");
	$log_to_stdout->log(Level::warning, "If you see it", "message with more elements", "works", 45, True);
	$log_to_stdout->log(Level::standard_error, "standard error");
	$log_to_stdout->log(Level::critical_error, "critical error");
	unset($log_to_stdout);
	 
	$log_to_file = new CxLogger("./log_to_file_and_stderr.log");
	$log_to_file->log(Level::info, "Standard log to file and STDERR");
	unset($log_to_file);
	 
	$log_to_file = new CxLogger("./log_to_file_and_warn_to_stderr.log", false);
	$log_to_file->log(Level::info, "This message is in log file only!");
	$log_to_file->log(Level::warning, "But this is in log and STDERR");
	unset($log_to_file);
	 
	$log_to_file = new CxLogger("./log_to_file_and_not_warn_to_stderr.log", false, false);
	$log_to_file->log(Level::info, "This message is in log file only!");
	$log_to_file->log(Level::warning, "and this is in log only");
	unset($log_to_file);
	 
	function showLog($log){
		echo("Log file: $log \n");
		system("cat $log");
		echo("\n");
	}
	 
	echo("\n");
	 
	showLog("./log_to_file_and_stderr.log");
	showLog("./log_to_file_and_warn_to_stderr.log");
	showLog("./log_to_file_and_not_warn_to_stderr.log");
	
	system("rm ./log_to_file_and_stderr.log");
	system("rm ./log_to_file_and_warn_to_stderr.log");
	system("rm ./log_to_file_and_not_warn_to_stderr.log");
?>
