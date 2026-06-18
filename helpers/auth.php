<?php

function isLogged()
{
    return isset($_SESSION['user_id']);
}