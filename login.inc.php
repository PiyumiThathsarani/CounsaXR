<?php

    if(session_id() == ''){
        session_start();
    }
    if(!@include_once('functions.inc.php')) {
        include_once("functions.inc.php");
    }
    if(!@include_once('dbh.inc.php')) {
        include_once("dbh.inc.php");
    }

    function test_input($data) {
        
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
    $username = test_input($_POST["username"]);
    $pwd = test_input($_POST["pwd"]);

    if( emptyInputLogin($username, $pwd) !== false ){
        header("location: ../Login.php?error=emptyinput");
        exit();
    }
    loginUser($conn, $username, $pwd);
    }