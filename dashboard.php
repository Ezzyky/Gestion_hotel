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
    <h1>hi admin</h1>
    <form action="/auth/logout.php" method="POST">
       <button type="submit">logout</button>
    </form>