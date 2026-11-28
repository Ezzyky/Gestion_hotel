<?php
include "../utils/admin_check.php";
include "../utils/auth.php";
 
$id = 0;

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
}

if (!$id || $id <= 0) {
    header("Location: index.php");
    exit;
}
$stmt = $pdo->prepare("SELECT * FROM chambres WHERE id = ?");
$stmt->execute([$id]);
$chambres = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$chambres) {
    header("Location: index.php");
    exit;
}

$error="";
$numero_empty = "";
$numero_invalid = "";
$numero_exists = "";
$type_empty = "";
$prix_empty = "";
$prix_invalid = "";
$capacite_empty = "";
$capacite_invalid = "";
$status_empty = "";
$description_invalid = "";

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $flag=0;
    if (isset($_POST["modifier"])) {
        $numero_chambre = trim($_POST["numero_chambre"]);
        $type = trim($_POST["type"]);
        $prix_par_nuit = trim($_POST["prix_par_nuit"]);
        $capacite = trim($_POST["capacite"]);
        $status = $_POST["status"];
        $description = trim($_POST["description"]);

        if (mb_strlen($description) > 1000) {
            $description_invalid = "La description ne doit pas dépasser 1000 caractères.";
            $flag++;
        }
        if (empty($status)){
            $status_empty="Veuillez sélectionner le statut de la chambre";
            $flag++;
                }
        if (empty($type)){
            $type_empty="Veuillez sélectionner un type de chambre.";
            $flag++;
        }

        if (empty($prix_par_nuit)){
            $prix_empty="Veuillez saisir le prix par nuit.";
            $flag++;
        }
        elseif (!is_numeric($prix_par_nuit) || $prix_par_nuit <= 0) {
            $prix_invalid = "Veuillez saisir un prix valide supérieur à 0.";
            $flag++;
        }
        if (empty($capacite)){
            $capacite_empty="Veuillez saisir la capacité de la chambre.";
            $flag++;
        }
        elseif ($capacite>10 || $capacite<1 || filter_var($capacite, FILTER_VALIDATE_INT) === false ){
            $capacite_invalid="La capacité doit être un entier compris entre 1 et 10.";
            $flag++;
        }
        elseif ($type==="simple" && $capacite!=1){
            $capacite_invalid="Une chambre simple doit accueillir 1 personne.";
            $flag++;
        }
        elseif (($type==="double" || $type==="twin" ) && ($capacite>2)){
            $capacite_invalid="Une chambre double ou twin ne peut pas accueillir plus de 2 personnes.";
            $flag++;
        }
        elseif ($type==="triple"  && ($capacite>3 )){
            $capacite_invalid="Une chambre triple ne peut pas accueillir plus de 3 personnes";
            $flag++;
        }
        elseif ($type==="familiale" && ($capacite>5 )){
            $capacite_invalid="Une chambre familiale ne peut pas accueillir plus de 5 personnes.";
            $flag++;
        }
        elseif ($type==="suite" && ($capacite>6 )){
            $capacite_invalid="Une suite ne peut pas accueillir plus de 6 personnes.";
            $flag++;
        }

        if (empty($numero_chambre)){
            $numero_empty="Veuillez saisir le numéro de la chambre.";
            $flag++;
        }

        elseif (filter_var($numero_chambre, FILTER_VALIDATE_INT) === false || $numero_chambre <= 0) {
            $numero_invalid = "Le numéro de chambre doit être un entier positif.";
            $flag++;
        }
        else{
            try {
            $stmt = $pdo->prepare("
                SELECT id FROM chambres
                WHERE numero_chambre = ? AND id != ?
                LIMIT 1
            ");
            $stmt->execute([$numero_chambre, $id]);
            if($stmt->fetch()){
                $numero_exists = "Ce numéro de chambre existe déjà.";
                $flag++;
            } 
            }
            catch (PDOException $e) {
            
            }
        }
        
        if ($flag===0){
             $sql = "UPDATE chambres
        SET numero_chambre = ?, type = ?, prix_par_nuit = ?, capacite = ?,
            status = ?, description = ?
        WHERE id = ?";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
        $numero_chambre,
        $type,
        $prix_par_nuit,
        $capacite,
        $status,
        $description,
        $id,
        ]);
            header("Location: index.php");
            exit();
        }
    else{
        $error = "Impossible d'ajouter la chambre pour le moment. Veuillez réessayer ultérieurement.";       
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une chambre</title>
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
        <form action="" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
        <h1>Modifier une chambre</h1>

        <label for="numero_chambre">Numero de chambre</label><br>
        <input type="number" id="numero_chambre" name="numero_chambre" placeholder="Saisissez le numéro de la chambre."  value="<?=htmlspecialchars($chambres['numero_chambre']) ?>"><br>
        <span style="color: red;"><?php
        if (!empty($numero_empty)){

            echo $numero_empty;
        } 
        elseif (!empty($numero_invalid)) {
            echo $numero_invalid;
        }
        elseif (!empty($numero_exists)){
            echo $numero_exists;
        
         }
         ?></span><br>

        <label for="type">Type</label><br>
        <select name="type" id="type">
            <option value="<?= htmlspecialchars($chambres["type"]) ?>" selected><?= htmlspecialchars($chambres["type"]) ?></option>
            <option value="">-- Sélectionnez un type de chambre --</option>
            <option value="simple">Chambre simple</option>
            <option value="double">Chambre double</option>
            <option value="triple">Chambre triple</option>
            <option value="twin">Chambre twin</option>
            <option value="familiale">Chambre familiale</option>
            <option value="suite">Suite</option>
        </select><br>     
        <span style="color: red;"><?php
        if (!empty($type_empty)){
            echo $type_empty;
        }
        ?></span><br>

        <label for="prix_par_nuit"></label>Prix par nuit<br>
        <input type="number" id="prix_par_nuit" name="prix_par_nuit" placeholder="Saisissez le prix par nuit en MAD." value="<?=htmlspecialchars($chambres['prix_par_nuit']) ?>"  ><br>
        <span style="color: red;"><?php
        if(!empty($prix_empty)){
            echo $prix_empty;
        }
        elseif(!empty($prix_invalid)){
            print $prix_invalid;
        }
        ?></span><br>

        <label for="capacite">Capacité</label><br>
        <input type="number" id="capacite" name="capacite" placeholder="Saisissez le nombre maximum de personnes." value="<?=htmlspecialchars($chambres['capacite']) ?>">
        <span style="color: red;"><?php 
        if(!empty($capacite_empty)){
            echo $capacite_empty;
        }
        elseif(!empty($capacite_invalid)){
            print $capacite_invalid;
        }
        ?></span><br>
   
        <label for="status">status</label><br>
        <select name="status" id="status">
            <option value="<?= htmlspecialchars($chambres["status"]) ?>" selected><?= htmlspecialchars($chambres["status"]) ?></option>
            <option value="">-- Sélectionnez un statut --</option>
            <option value="disponible">Disponible</option>
            <option value="occupee">Occupée</option>
        </select><br>     
        <span style="color: red;"><?php 
        if(!empty($status_empty)){
            echo $status_empty;
        }
        ?></span><br>

        <label for="description">Description</label><br>
        <textarea id="description" name="description"placeholder="Décrivez brièvement la chambre."><?= htmlspecialchars($chambres['description']) ?></textarea>
        <span style="color: red;"><?php 
        if(!empty($description_invalid)){
            echo $description_invalid;
        }
        if(!empty($error)){
            echo $error;
        }
        ?></span><br>

        <button type="submit" name="modifier" >Modifier</button>

        </form>
        <form action="index.php">  
          <button name="Retour " type="submit">Retour à la liste</button>
        </form>

</body>
</html>