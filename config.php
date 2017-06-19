<?php
$db = parse_url($_ENV[“DATABASE_URL”]);
define(“dbname”, trim($db[“path”],”/”));
define(“user”, $db[“user”]);
define(“password”, $db[“pass”]);
define(“host”, $db[“host”]);
$conn = pg_connect("host=$hostname dbname=$database user=$username password=$password"); 
$Webmaster_Email =“ffaizi@salesforce.com”;
$Webmaster_Name =“from heroku mortgage cal“;
$Website_Name ="heroku mortgage”;
?>