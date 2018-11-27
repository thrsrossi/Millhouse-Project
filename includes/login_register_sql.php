<?php
session_start(); 
include 'database_connection.php';

/**
* 1. Koppla upp till databasen
* 2. Hämta användaren från databasen
* 3. Kolla så att lösenordet stämmer
* överrens med lösenordet som användaren
* fyllt i formuläret: password_verify
*/

//if user fills in login fields
if(isset($_POST["username"]) && isset($_POST["password"])){
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $select_all_with_username = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    
    $select_all_with_username->execute(
        [
            ":username" => $username
        ]
);

$fetched_user = $select_all_with_username->fetch();

// compare
$is_password_correct = password_verify($password, $fetched_user["password"]);

if($is_password_correct){
    //save user globally to session
    $_SESSION["username"] = $fetched_user["username"];
    $_SESSION["user_id"] = $fetched_user["id"];
    //go to product page
    header('Location: ../index.php ');
    
}else{
    //handle errors, go back to front page and populate $_GET
    header('Location: ../views/login.php?error=Your username or password is incorrect');
}
}

// register user if all fields are set

elseif(isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["email"]) && isset($_POST["date_of_birth"]) && isset($_POST["register_username"]) && isset($_POST["register_password"])){
    
    $register_username = $_POST["register_username"];
    
    //Gets all user with post variable for registered username
    $check_username_rows = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $check_username_rows->execute(
        [
            ":username" => $register_username
        ]
        );
    
    //if nr of rows from db is larger than 0 send error msg
    if($check_username_rows->rowCount() > 0){
        header('Location:../index.php?error=This username is already registered, pick a new one.');
    }
    
//create hashed password for better security

if(isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["email"]) && isset($_POST["date_of_birth"]) && isset($_POST["register_username"]) && isset($_POST["register_password"])){
       
$hashed_password = password_hash($_POST["register_password"], PASSWORD_DEFAULT);

$register_user_to_database = $pdo->prepare("INSERT INTO users
  (username, password, email, first_name, last_name, date_of_birth) VALUES (:username, :password, :email, :first_name, :last_name, :date_of_birth)");
    
// Executing the statement
$register_user_to_database->execute(
  [
    ":username" => $_POST["register_username"],
    ":password" => $hashed_password,
    ":email" => $_POST["email"],
    ":first_name" => $_POST["first_name"],
    ":last_name" => $_POST["last_name"],
    ":date_of_birth" => $_POST["date_of_birth"]
  ]
);  
    //prepare statement to select all from registered user
    $select_registered_user = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    
    $select_registered_user->execute(
        [
            ":username" => $_POST["register_username"]
        ]
);
    $fetched_user = $select_registered_user->fetch();
    //Save fetched user in to session
    $_SESSION["username"] = $fetched_user["username"];
    $_SESSION["user_id"] = $fetched_user["id"];
    
    header('Location: ../index.php ');  
    
}else{
    header('Location: ../views/register.php?error=Please fill in all details');
}