<?php
include "../utils/admin_check.php";
include "../utils/auth.php";

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int) $_GET['id']; 
    $stmt = $pdo->prepare("SELECT * FROM clients WHERE id = ?");
    $stmt->execute([$id]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$client) {
        header("Location: index.php");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du client</title>
<link rel="stylesheet" href="../css/client.css">
</head>
<body>
    <nav class="sidebar">
    <a href="../dashboard.php" class="link-dashboard">dashboard</a>

    <a href="../clients/index.php" class="link-clients">Clients</a>
    <ul>
        <li><a href="../clients/Ajouter.php">Ajouter un client</a></li>
    </ul>

    <a href="../chambres/index.php" class="link-chambres">Chambres</a>
    <ul>
        <li><a href="../chambres/ajouter.php">Ajouter une chambre</a></li>
    </ul>
</nav>
    <h1>Détails du client <?= htmlspecialchars($client['id']) ?></h1>
    <ul>
        <li><strong>Nom :</strong> <?= htmlspecialchars($client['nom']) ?></li>
        <li><strong>Prénom :</strong> <?= htmlspecialchars($client['prenom']) ?></li>
        <li><strong>Email :</strong> <?= htmlspecialchars($client['email']) ?></li>
        <li><strong>Téléphone :</strong> <?= htmlspecialchars($client['telephone']) ?></li>
        <li><strong>Nationality :</strong> <?= htmlspecialchars($client["nationality"]) ?></li>
        <li><strong>Ville :</strong> <?= htmlspecialchars($client["ville"]) ?></li>
        <li><strong>Pays :</strong> <?= htmlspecialchars($client["pays"]) ?></li>
        <li><strong>Adresse :</strong> <?= htmlspecialchars($client["adresse"]) ?></li>
        <li><strong>créé à :</strong> <?= htmlspecialchars($client["created_at"]) ?></li>


    </ul>
    <form action="index.php">  
          <button name="Retour " type="submit">Retour à la liste</button>
    </form>
</body>
</html>