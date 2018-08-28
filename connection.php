<?php
    function newCon() {
        $conn = new mysqli("localhost", "geeksden", "geeksden", "geeks_den");

        if ($conn->connect_error) {
            echo "Couldn't make a connection";
            exit;
        }
        return $conn;
    }
?>