<?php
include "../utils/admin_check.php";
include "../utils/auth.php";

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int) $_GET['id']; 
    $stmt = $pdo->prepare("SELECT * FROM chambres WHERE id = ?");
    $stmt->execute([$id]);
    $chambres = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$chambres) {
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
    <link rel="stylesheet" href="../css/chambre.css">

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
    <h1>Détails du chambres <?= htmlspecialchars($chambres['id']) ?></h1>
    <ul>
        <li><strong>Numero de chambre :</strong> <?= htmlspecialchars($chambres['numero_chambre']) ?></li>
        <li><strong>Type :</strong> <?= htmlspecialchars($chambres['type']) ?></li>
        <li><strong>Prix par nuit :</strong> <?= htmlspecialchars($chambres['prix_par_nuit']) ?></li>
        <li><strong>Capacité :</strong> <?= htmlspecialchars($chambres['capacite']) ?></li>
        <li><strong>status :</strong> <?= htmlspecialchars($chambres["status"]) ?></li>
        <li><strong>créé à :</strong> <?= htmlspecialchars($chambres["created_at"]) ?></li>
    </ul>
    <form action="index.php">  
          <button name="Retour " type="submit">Retour à la liste</button>
    </form>
</body>
</html>