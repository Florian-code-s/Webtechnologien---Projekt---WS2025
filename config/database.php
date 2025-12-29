<?php
/*
Einstellungen zu Fehlerhandling: 
REPORT_ERROR: gibt MySQL-Fehler detailliert aus
REPORT_STRICT: wandelt MySQL-Fehler in Exceptions um
*/
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$DB_HOST = 'localhost';
$DB_USER = 'create_styling_skills';
$DB_PASS = 'einszweidrei';
$DB_NAME = 'create_styling_skills';

//$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
//$conn->set_charset('utf8mb4');
?>