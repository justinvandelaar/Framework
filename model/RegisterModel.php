<?php

require(ROOT . "model/playerStatModel.php");

function Checker($firstname, $prefire, $lastname, $email, $username, $password) {
     $db = openDatabaseConnection();

     $queryCheck = "SELECT * FROM user WHERE username=:username";
     $querySelect = $db->prepare($queryCheck);
     $querySelect->execute(array(
     	':username' => $username
     	));

     // Check if the user already exists
     $count = $querySelect->rowCount();
     if ($count < 0) {
     	echo "Nothing has been found";
          Register($firstname, $prefire, $lastname, $email, $username, $password);
     } elseif ($count == 1) {
         $_SESSION['username'] = $username;
     } else {
     	echo "You already exists";
          header("Location:" . URL . "home/start");
         $_SESSION['username'] = $username;
     }

   	$db = null;
}

function Register($firstname, $prefire, $lastname, $email, $username, $password) { 
	$db = openDatabaseConnection();
     // Turn password into a encryptie 
     $password = password_hash($password, PASSWORD_BCRYPT);
     $sql = "INSERT INTO user(firstname, prefire, lastname, email, username, password) VALUES(:firstname, :prefire, :lastname, :email, :username, :password)";
     $query = $db->prepare($sql);
     $query->execute(array(
		':firstname' => $firstname,
		':prefire' => $prefire,
		':lastname' => $lastname,
		':email' => $email,
		':username' => $username,
		':password' => $password
		));
    $_SESSION['username'] = $username;
    // Make new stats for the player
    //getAllPlayerStats();
	$db = null;
}