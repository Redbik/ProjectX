<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 03.09.2017
 * Time: 12:54
 */
include ("actions/config.php");
setcookie('id', "0", time()-1);
header("Location:".$location);