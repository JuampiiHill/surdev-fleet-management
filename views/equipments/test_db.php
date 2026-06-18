<?php

$conn = new mysqli(
    "127.0.0.1",
    "root",
    "",
    "surdev_db"
);

if ($conn->connect_error) {
    die("ERROR: " . $conn->connect_error);
}

echo "Conectado OK";