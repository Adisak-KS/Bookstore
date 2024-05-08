<?php
// creating a password
$pass = "MyPass123@#";
// creating an array of options
$options = array(
    "salt" => "AGHUKJNJ…………behjgcbwbn",
    "cost" => 3
);
// using the PASSWORD_DEFAULT with a set of options
echo password_hash($pass, PASSWORD_DEFAULT, $options) . "<br>";
// output: $2y$13$AGHUKJNJ…………beiZP0PNHr4XYH63sEh9Unc2JU3fJpDEe
// using the PASSWORD_BCRYPT
echo password_hash($pass, PASSWORD_BCRYPT) . "<br>";
// output: $2y$10$pomI65Vl7wcYOBjP6bCHce9TVXZGT7DSjNQINuW8p9tSmuEty1cGG
// using the PASSWORD_ARGON2I
echo password_hash($pass, PASSWORD_ARGON2I) . "<br>";
// output: $argon2i$v=19$m=65536,t=4,p=1$NUl5bkFWM2pBZ0hJZ2RUUg$9a+JHfmT3P8OLYbdjUGiig4WrxOS05tMGWpI8DmM9M8
// using the PASSWORD_ARGON2ID
echo password_hash($pass, PASSWORD_ARGON2ID);
// output:
