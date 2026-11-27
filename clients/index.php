<?php
include "../utils/admin_check.php";
include "../utils/auth.php";

$stmt = $pdo->query("SELECT * FROM clients ORDER BY id DESC");
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    if (isset($_POST["Supprimer"])) {
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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
<link rel="stylesheet" href="../css/client.css">
</head>
<body>
    <form action="Ajouter.php" method="GET">
            <button type="submit">Ajouter un client</button>
        </form>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php 
        if (empty($clients)){
            echo $empty="Aucun client enregistré pour le moment.";

        }
       
        foreach ($clients as $client): ?>
        <tr>
            <td><?= htmlspecialchars($client['id']) ?></td>
            <td><?= htmlspecialchars($client['nom']) ?></td>
            <td><?= htmlspecialchars($client['prenom']) ?></td>
            <td><?= htmlspecialchars($client['email']) ?></td>
            <td><?= htmlspecialchars($client['telephone']) ?></td>
            <td>
                
                <form action="index.php" method="GET">
                    <input type="hidden" name="id" value="<?=htmlspecialchars($client['id']);?>">
                    <button name="details" id="détails" type="submit">Voir détails</button>
                </form>
                <form action="index.php" method="GET">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($client['id']);?>">
                    <button name="Modifier" id="Modifier" type="submit">Modifier</button>
                </form>
                <form action="index.php" method="POST">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($client['id']);?>">
                    <button name="Supprimer" id="Supprimer" type="submit">Supprimer</button>
                </form>

            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>