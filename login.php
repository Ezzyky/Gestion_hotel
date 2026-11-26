<?php
    session_start();
   
    $host = 'localhost';
    $dbname = 'gestion_hotel';
    $username = 'root'; 
    $password = ''; 
    $error1 = "";
    $error2 = "";


    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }


    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        $password = ($_POST['password'] ?? '');
        $email = trim($_POST['email'] ?? '');
       
        if (empty($email) || empty($password)){
        $error1 = "Veuillez saisir votre adresse e-mail.";
        }
        if (strlen($password)<8){
            $error2="the password need to be 8 charcter";
        }
        else{
             $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password_hash'])) {
            
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['username'];
            
            header("Location: dashboard.php"); 
            exit();}
            else {
            $error = "Invalid email or password.";
        }
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>

    <form action="login.php" method="POST">
        <label></label>
        <input type="email" id="email" name="email" placeholder="email" required><br><br>
        
        <input type="password" id="password" name="password" placeholder="password<?php echo $error2?>" required> 

        <button type="submit" >login</button>

    </form>
    
</body>
</html>