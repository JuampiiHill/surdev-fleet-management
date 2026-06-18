<?php

$password = '1234';

echo password_hash(
    $password,
    PASSWORD_DEFAULT
);