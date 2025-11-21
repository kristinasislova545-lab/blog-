<?php
$pass = "123";
$hash = password_hash($pass, PASSWORD_DEFAULT);
echo $hash . "<br>";

var_dump(password_verify("123", $hash));

$pass = '123456qwer';

echo md5($pass);
