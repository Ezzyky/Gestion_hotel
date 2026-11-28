<?php
include "./utils/admin_check.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>
    <nav class="sidebar">
    <a href="../dashboard.php" class="link-dashboard">Dashboard</a>
    <a href="../clients/index.php" class="link-clients">Clients</a>
    <ul>
        <li><a href="../clients/Ajouter.php">Ajouter un client</a></li>
    </ul>

    <a href="../chambres/index.php" class="link-chambres">Chambres</a>
    <ul>
        <li><a href="../chambres/ajouter.php">Ajouter une chambre</a></li>
    </ul>
</nav>
    <h1>hi admin</h1>
    <form action="/auth/logout.php" method="POST">
       <button type="submit">logout</button>
    </form>