<?php
// this is my database connection file
$DBhost = "photoshare.cmeotg2tvbez.eu-west-1.rds.amazonaws.com";
$DBuser = "ryanj1992";
$DBpass = "eminem2020";
$DBname = "photoShare";

$DBcon = new MySQLi($DBhost, $DBuser, $DBpass, $DBname);

if ($DBcon->connect_errno) {
    die("ERROR : -> " . $DBcon->connect_error);
}
