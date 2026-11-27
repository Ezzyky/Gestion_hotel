<?php
include "../utils/admin_check.php";
include "../utils/auth.php";
if (isset($_GET['id']) && !empty($_GET['id'])) {
$id = (int) $_GET['id']; 
$stmt = $pdo->prepare("DELETE FROM clients WHERE id = ?");
$stmt->execute([$id]);}
header("Location: index.php");
exit; 
?>