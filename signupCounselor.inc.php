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

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $username = $_POST["username"];
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $appointedyear = $_POST["appointedyear"];
    $registrationnumber = $_POST["registrationnumber"];
    $mobilenumber = $_POST["mobilenumber"];
    $city = $_POST["city"];
    $pwd = $_POST["pwd"];
    $confirmpwd = $_POST["confirmpwd"];

    if( emptyInputSignupCounselor($username, $fullname, $email, $appointedyear, $registrationnumber, $mobilenumber, $city, $pwd, $confirmpwd) !== false ){
        header("location: ../Register/Register.html?error=emptyinput");
        exit();
    }
    if( invalidEmail($email) !== false ){
        header("location: ../Register/Register.html?error=invalidemail");
        exit();
    }
    if( invalidUserName($username) !== false ){
        header("location: ../Register/Register.html?error=invaliduserid");
        exit();
    }
    if( doesntMatchPassword($pwd, $confirmpwd) !== false ){
        header("location: ../Register/Register.html?error=passworddoesntmatch");
        exit();
    }

    if( $error = existEmail($conn, $email) !== false ){
        if($error === "stmtfailed"){
            header("location: ../Register/Register.html?error=stmtfailed");
            exit();
        }
        header("location: ../Register/Register.html?error=existemail");
        exit();
    }

    if( $error = existUser($conn, $username) !== false ){
        if($error === "stmtfailed"){
            header("location: ../Register/Register.html?error=stmtfailed");
            exit();
        }
        header("location: ../Register/Register.html?error=existuser");
        exit();
    }

    createCounselor( $conn, $username, $fullname, $email, $appointedyear, $registrationnumber, $mobilenumber, $city, $pwd);

}else{
    header("location: ../Register/Register.html");
}