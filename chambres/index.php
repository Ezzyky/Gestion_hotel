<?php
include "../utils/admin_check.php";
include "../utils/auth.php";

$stmt = $pdo->query("SELECT * FROM chambres ORDER BY id DESC");
$chambres = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "GET"){
    if (isset($_GET["details"])) {
        $id = $_GET['id'];
        if ($id !== false && $id !== null && $id > 0) {
            header("Location: details.php?id=" . $id);
            exit;
        }
    }

    if (isset($_GET["Modifier"])) {
        $id = $_GET['id'];
        if ($id !== false && $id !== null && $id > 0) {
            header("Location: modifier.php?id=" . $id);
            exit;
        }        
    }
    }

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    if (isset($_POST["supprimer"])) {
        $id = $_POST['id'];
        if ($id !== false && $id !== null && $id > 0) {
            header("Location: delete.php?id=" . $id);
            exit;
        }
        header("Location: index.php");
        exit;

    }
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <form action="ajouter.php" method="GET">
            <button type="submit">Ajouter une chambre</button>
        </form>
    <table>
    <thead>
        <tr>
            <th>Numéro</th>
            <th>Type</th>
            <th>Prix/nuit</th>
            <th>Capacité</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php 
        if (empty($chambres)){
            echo $empty="";

        }
       
        foreach ($chambres as $chambre): ?>
        <tr>
            <td><?= htmlspecialchars($chambre['numero_chambre']) ?></td>
            <td><?= htmlspecialchars($chambre['type']) ?></td>
            <td><?= htmlspecialchars($chambre['prix_par_nuit']) ?></td>
            <td><?= htmlspecialchars($chambre['capacite']) ?></td>
            <td><?= htmlspecialchars($chambre['status']) ?></td>
            <td>
                
                <form action="index.php" method="GET">
                    <input type="hidden" name="id" value="<?=htmlspecialchars($chambre['id']);?>">
                    <button name="details" id="détails" type="submit">Voir détails</button>
                </form>
                <form action="index.php" method="GET">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($chambre['id']);?>">
                    <button name="Modifier" id="Modifier" type="submit">Modifier</button>
                </form>
                <form action="index.php" method="POST">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($chambre['id']);?>">
                    <button name="supprimer" id="supprimer" type="submit">Supprimer</button>
                </form>

            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>