<?php
$db = mysqli_connect("127.0.0.1", "root", "", "tofu");
mysqli_select_db($db,"tofu");
mysqli_set_charset($db, 'utf8');
$location= "http://localhost/www/ProjectX/";