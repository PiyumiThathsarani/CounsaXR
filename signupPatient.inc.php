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
    
    $fullname = $_POST["fullname"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $birthdate = $_POST["birthdate"];
    $avgearning = $_POST["avgearning"];
    $occupation = $_POST["occupation"];
    $mobilenumber = $_POST["mobilenumber"];
    $orientation = $_POST["orientation"];
    $relation = $_POST["relation"];
    $isreligious = $_POST["isreligious"];
    $evercounseled = $_POST["evercounseled"];
    $physicalhealth = $_POST["physicalhealth"];
    $eatinghabbit = $_POST["eatinghabbit"];
    $isdepressed = $_POST["isdepressed"];
    $ispleasure = $_POST["ispleasure"];
    $sex = $_POST["sex"];
    $pwd = $_POST["pwd"];
    $confirmpwd = $_POST["confirmpwd"];

    if( emptyInputSignupPatient($fullname, $username, $email, $birthdate, $avgearning, $occupation, $mobilenumber, $orientation, $relation, $isreligious, $evercounseled, $physicalhealth, $eatinghabbit, $isdepressed, $ispleasure, $sex, $pwd, $confirmpwd) !== false ){
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
    if(  $error = existUser($conn, $username) !== false ){
        if($error === "stmtfailed"){
            header("location: ../Register/Register.html?error=stmtfailed");
            exit();
        }
        header("location: ../Register/Register.html?error=existuser");
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

    createPatient($conn, $fullname, $username, $email, $birthdate, $avgearning, $occupation, $mobilenumber, $orientation, $relation, $isreligious, $evercounseled, $physicalhealth, $eatinghabbit, $isdepressed, $ispleasure, $sex, $pwd);

}else{
    header("location: ../Register/Register.html");
}