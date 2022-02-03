# CxLogger
Custom logging system for PHP

## How to install it?
You need to copy CxLogger.php to your project's library directory, or if you prefer to include_path, then include it with require_once ("path / to / CxLogger.php")

## How using it?

### Creating logger
 * $logger = new CxLogger(); - The simplest logger, it only logs to STDERR
 * $logger = new CxLogger("path/to/log.log"); - Logs to both STDERR and file
 * $logger = new CxLogger("path/to/log.log", false); - Messages with the info level are logged to the file, and those with a level higher to the file and STDERR
 * $logger = new CxLogger("path/to/log.log", false, false); - Logs to file only

### Logging
$logger->log($level, $message_part_one, $message_part_two, ...);

#### $level
 * Level:info - zero level, info message
 * Level:warning - fisrt level
 * Level:standard_error - runtime error
 * Level:critical_error - critical app error

#### $message_part_*
 * messages with string or int or etc
 
### Examples
 * $logger->log(Level:info, "Create users:", 33);
 * $logger->log(Level:warning, "You are awesome!");
