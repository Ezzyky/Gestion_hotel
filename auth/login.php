<?php
    session_start();
   
    include "../utils/auth.php";
    $empty_email = "";
    $empty_password = "";
    $password_8="";
    $error="";
    $emailError="";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        $password = ($_POST['password'] ?? '');
        $email = trim($_POST['email'] ?? '');
       
        if (empty($email) ){
        $empty_email = "Veuillez saisir votre adresse e-mail.";
        }
        elseif (empty($password)){
            $empty_password="Veuillez saisir votre mot de passe.";
        }
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Veuillez saisir une adresse e-mail valide.";
        }
        elseif(strlen($password)<8){
        $password_8="Le mot de passe doit contenir au moins 8 caractères.";
        }
        else{
            $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = ?");
            $stmt->execute([$email]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['username'];
            
            header("Location: ../dashboard.php");
             
            exit();}
            else {
            $error = "Adresse e-mail ou mot de passe incorrect.";
        }
        }

    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="/css/login.css">
</head>
<body>

    <form action="/auth/login.php" method="POST">
            <h1>login page</h1>
        <label for="email">Adresse e-mail</label><br>
        <input type="email" id="email" name="email" placeholder="Saisissez votre e-mail"><br>
        <span style="color: red;"><?php 
        if (!empty($empty_email)){
            echo $empty_email;} 
        elseif(!empty($emailError)){
            echo $emailError;
        }
            ?></span>

        <label for="password">Mot de passe</label><br>
        <input type="password" id="password" name="password" placeholder="Saisissez votre mot de passe" ><br>
        <span style="color: red;"><?php 
        if (!empty($password_8)){
            echo $password_8;} 
        elseif(!empty($empty_password)){
            echo $empty_password;
        }
        elseif(!empty($error)){
            echo $error;
        }
            ?></span><br>

        <button type="submit" >login</button>

    </form>
    
</body>
</html>