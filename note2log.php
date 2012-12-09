#! /usr/bin/php
<?php
// note2log.php
require('config.ini.inc')
if(!isset($path_to_dropbox)) die('missing or incorrect config')

$continue = true;

// prompt for file name
print "note name:\n? ";
$note_name = str_replace(' ', '', ucwords(trim(fgets(STDIN))));

//clear the screen 
passthru('clear');

//create log filename using name and date
$date = new DateTime();
$file_name = $note_name.'-'.$date->format('Ymd').'.txt';
// create first line of file (or session if appending to existing file)
$note_line = $date->format('Y-m-d H:i:s') . "	**** Opened file for writing ****\n";
if(file_put_contents($path_to_dropbox.$file_name, $note_line, FILE_APPEND | LOCK_EX)) {
	print "opened {$file_name} for writing\n";
} else {
	print "problem opening/creating {$file_name}\n";
}

while($continue) {
	print "-> ";
	$line = trim(fgets(STDIN)); // reads one line from STDIN
	$date = new DateTime();
	$note_line = $date->format('Y-m-d H:i:s') . "	". $line . "\n";
	if($line != '.') {
		file_put_contents($path_to_dropbox.$file_name, $note_line, FILE_APPEND | LOCK_EX);
	} else {
		$continue = false;
		break;
	}
}
print "\n";
?>