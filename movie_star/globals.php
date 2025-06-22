<?php
   session_start();

   $BASE_URL = "http://". $_SERVER["SERVER_NAME"] . ":3000" . str_replace("\\", "/", dirname($_SERVER["REQUEST_URI"] ."?"));

?>