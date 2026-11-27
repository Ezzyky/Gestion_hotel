<?php
include "../utils/admin_check.php";

include "../utils/auth.php";
 

$error="";
$nom_empty = "";
$prenom_empty = "";
$email_empty = "";
$email_invalid = "";
$email_exists = "";
$telephone_empty = "";
$telephone_invalid = "";
$nationality_empty = "";
$ville_invalid = "";
$pays_invalid = "";
$adresse_invalid = "";

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $flag=0;
    if (isset($_POST["ajouter"])) {
        $nom = trim($_POST["nom"]);
        $prenom = trim($_POST["prenom"]);
        $email = trim($_POST["email"]);
        $telephone = trim($_POST["telephone"]);
        $nationality = $_POST["nationality"];
        $ville = trim($_POST["ville"]);
        $pays = trim($_POST["pays"]);
        $adresse = trim($_POST["adresse"]);

    if (empty($nom)){
        $nom_empty="Veuillez saisir un nom valide.";
        $flag++;
    }

    if (empty($prenom)){
        $prenom_empty="Veuillez saisir un prénom valide.";
        $flag++;
    }

    
    if (empty($telephone)){
        $telephone_empty="Veuillez saisir le numéro de téléphone du client.";
        $flag++;
        }
        
    elseif (!preg_match('/^\+?[0-9]{8,15}$/',$telephone)) {
            $telephone_invalid = "Veuillez saisir un numéro de téléphone valide (8 à 15 chiffres).";
            $flag++;
            }
    if (empty($nationality)) {
            $nationality_empty = "Veuillez sélectionner la nationalité du client.";
            $flag++;
            }
            
    if (empty($ville)){
            $ville_invalid="Veuillez saisir un nom de ville valide.";
            $flag++;
            }
                
    if (empty($pays)){
            $pays_invalid="Veuillez saisir un nom de pays valide.";
            $flag++;
            }
    if (empty($adresse)){
            $adresse_invalid="	Veuillez saisir une adresse valide.";
            $flag++;
            }
    if (empty($email)){
            $email_empty="Veuillez saisir l'adresse e-mail du client.";
            $flag++;
        }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $email_invalid="Veuillez saisir une adresse e-mail valide.";
            $flag++;
        }
    
               
    else{
            try {
            $stmt = $pdo->prepare("SELECT id FROM clients WHERE email = ? LIMIT 1");
            $stmt->execute([$email]);

            if ($stmt->fetch()) {
                $email_exists = "Cette adresse e-mail est déjà associée à un autre client.";
                $flag++;
            }
        } catch (PDOException $e) {
            $error = "Une erreur est survenue lors de la vérification de l'adresse e-mail.";
            $flag++;
        }
        }
        if ($flag===0){
            $sql = "INSERT INTO clients (nom, prenom, email, telephone, nationality ,ville ,pays ,adresse)
            VALUES (?, ?, ?, ? , ? , ?, ? ,?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nom, $prenom, $email, $telephone, $nationality ,$ville ,$pays ,$adresse]);
            header("Location: index.php");
            exit();
        }
    else{
        $error="Une erreur est survenue lors de l'ajout du client. Veuillez réessayer.";
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un client</title>
<link rel="stylesheet" href="../css/client.css">

</head>
<body>
        <form action="" method="POST">

        <h1>Ajouter un client</h1>

        <label for="nom">Nom</label><br>
        <input type="text" id="nom" name="nom" placeholder="Entrez le nom du client"   ><br>
        <span style="color: red;"><?php 
        if(!empty($nom_empty)){
        echo $nom_empty;
        }
        ?></span><br>

        <label for="Prenom">Prénom</label><br>
        <input type="text" id="prenom" name="prenom" placeholder="Entrez le prénom du client"  ><br>
        <span style="color: red;"><?php 
            if(!empty($prenom_empty)){
                echo $prenom_empty;
            }
        ?></span><br>

        <label for="email">Email</label><br>
        <input type="email" id="email" name="email" placeholder="Saisissez l'adresse e-mail du client. " ><br>
        <span style="color: red;"><?php 
            if(!empty($email_empty)){
                echo $email_empty;
            }
            if(!empty($email_invalid)){
                echo $email_invalid;
                }
            if(!empty($email_exists)){
                echo $email_exists;
                }
                ?>
        </span><br>  

        <label for="telephone">telephone</label><br>
        <input type="tel" id="telephone" name="telephone" placeholder="saisir un numéro de téléphone valide"  ><br>
        <span style="color: red;"><?php 
        if(!empty($telephone_empty)){
        echo $telephone_empty;}
        if(!empty($telephone_invalid)){
            echo $telephone_invalid;
        
        }
        ?></span><br>        
        <label for="nationality">nationality</label><br>
        <select name="nationality" id="nationality">
        <option value="">-- select one --</option>
        <option value="afghan">Afghan</option>
        <option value="albanian">Albanian</option>
        <option value="algerian">Algerian</option>
        <option value="american">American</option>
        <option value="andorran">Andorran</option>
        <option value="angolan">Angolan</option>
        <option value="antiguans">Antiguans</option>
        <option value="argentinean">Argentinean</option>
        <option value="armenian">Armenian</option>
        <option value="australian">Australian</option>
        <option value="austrian">Austrian</option>
        <option value="azerbaijani">Azerbaijani</option>
        <option value="bahamian">Bahamian</option>
        <option value="bahraini">Bahraini</option>
        <option value="bangladeshi">Bangladeshi</option>
        <option value="barbadian">Barbadian</option>
        <option value="barbudans">Barbudans</option>
        <option value="batswana">Batswana</option>
        <option value="belarusian">Belarusian</option>
        <option value="belgian">Belgian</option>
        <option value="belizean">Belizean</option>
        <option value="beninese">Beninese</option>
        <option value="bhutanese">Bhutanese</option>
        <option value="bolivian">Bolivian</option>
        <option value="bosnian">Bosnian</option>
        <option value="brazilian">Brazilian</option>
        <option value="british">British</option>
        <option value="bruneian">Bruneian</option>
        <option value="bulgarian">Bulgarian</option>
        <option value="burkinabe">Burkinabe</option>
        <option value="burmese">Burmese</option>
        <option value="burundian">Burundian</option>
        <option value="cambodian">Cambodian</option>
        <option value="cameroonian">Cameroonian</option>
        <option value="canadian">Canadian</option>
        <option value="cape verdean">Cape Verdean</option>
        <option value="central african">Central African</option>
        <option value="chadian">Chadian</option>
        <option value="chilean">Chilean</option>
        <option value="chinese">Chinese</option>
        <option value="colombian">Colombian</option>
        <option value="comoran">Comoran</option>
        <option value="congolese">Congolese</option>
        <option value="costa rican">Costa Rican</option>
        <option value="croatian">Croatian</option>
        <option value="cuban">Cuban</option>
        <option value="cypriot">Cypriot</option>
        <option value="czech">Czech</option>
        <option value="danish">Danish</option>
        <option value="djibouti">Djibouti</option>
        <option value="dominican">Dominican</option>
        <option value="dutch">Dutch</option>
        <option value="east timorese">East Timorese</option>
        <option value="ecuadorean">Ecuadorean</option>
        <option value="egyptian">Egyptian</option>
        <option value="emirian">Emirian</option>
        <option value="equatorial guinean">Equatorial Guinean</option>
        <option value="eritrean">Eritrean</option>
        <option value="estonian">Estonian</option>
        <option value="ethiopian">Ethiopian</option>
        <option value="fijian">Fijian</option>
        <option value="filipino">Filipino</option>
        <option value="finnish">Finnish</option>
        <option value="french">French</option>
        <option value="gabonese">Gabonese</option>
        <option value="gambian">Gambian</option>
        <option value="georgian">Georgian</option>
        <option value="german">German</option>
        <option value="ghanaian">Ghanaian</option>
        <option value="greek">Greek</option>
        <option value="grenadian">Grenadian</option>
        <option value="guatemalan">Guatemalan</option>
        <option value="guinea-bissauan">Guinea-Bissauan</option>
        <option value="guinean">Guinean</option>
        <option value="guyanese">Guyanese</option>
        <option value="haitian">Haitian</option>
        <option value="herzegovinian">Herzegovinian</option>
        <option value="honduran">Honduran</option>
        <option value="hungarian">Hungarian</option>
        <option value="icelander">Icelander</option>
        <option value="indian">Indian</option>
        <option value="indonesian">Indonesian</option>
        <option value="iranian">Iranian</option>
        <option value="iraqi">Iraqi</option>
        <option value="irish">Irish</option>
        <option value="israeli">Israeli</option>
        <option value="italian">Italian</option>
        <option value="ivorian">Ivorian</option>
        <option value="jamaican">Jamaican</option>
        <option value="japanese">Japanese</option>
        <option value="jordanian">Jordanian</option>
        <option value="kazakhstani">Kazakhstani</option>
        <option value="kenyan">Kenyan</option>
        <option value="kittian and nevisian">Kittian and Nevisian</option>
        <option value="kuwaiti">Kuwaiti</option>
        <option value="kyrgyz">Kyrgyz</option>
        <option value="laotian">Laotian</option>
        <option value="latvian">Latvian</option>
        <option value="lebanese">Lebanese</option>
        <option value="liberian">Liberian</option>
        <option value="libyan">Libyan</option>
        <option value="liechtensteiner">Liechtensteiner</option>
        <option value="lithuanian">Lithuanian</option>
        <option value="luxembourger">Luxembourger</option>
        <option value="macedonian">Macedonian</option>
        <option value="malagasy">Malagasy</option>
        <option value="malawian">Malawian</option>
        <option value="malaysian">Malaysian</option>
        <option value="maldivan">Maldivan</option>
        <option value="malian">Malian</option>
        <option value="maltese">Maltese</option>
        <option value="marshallese">Marshallese</option>
        <option value="mauritanian">Mauritanian</option>
        <option value="mauritian">Mauritian</option>
        <option value="mexican">Mexican</option>
        <option value="micronesian">Micronesian</option>
        <option value="moldovan">Moldovan</option>
        <option value="monacan">Monacan</option>
        <option value="mongolian">Mongolian</option>
        <option value="moroccan">Moroccan</option>
        <option value="mosotho">Mosotho</option>
        <option value="motswana">Motswana</option>
        <option value="mozambican">Mozambican</option>
        <option value="namibian">Namibian</option>
        <option value="nauruan">Nauruan</option>
        <option value="nepalese">Nepalese</option>
        <option value="new zealander">New Zealander</option>
        <option value="ni-vanuatu">Ni-Vanuatu</option>
        <option value="nicaraguan">Nicaraguan</option>
        <option value="nigerien">Nigerien</option>
        <option value="north korean">North Korean</option>
        <option value="northern irish">Northern Irish</option>
        <option value="norwegian">Norwegian</option>
        <option value="omani">Omani</option>
        <option value="pakistani">Pakistani</option>
        <option value="palauan">Palauan</option>
        <option value="panamanian">Panamanian</option>
        <option value="papua new guinean">Papua New Guinean</option>
        <option value="paraguayan">Paraguayan</option>
        <option value="peruvian">Peruvian</option>
        <option value="polish">Polish</option>
        <option value="portuguese">Portuguese</option>
        <option value="qatari">Qatari</option>
        <option value="romanian">Romanian</option>
        <option value="russian">Russian</option>
        <option value="rwandan">Rwandan</option>
        <option value="saint lucian">Saint Lucian</option>
        <option value="salvadoran">Salvadoran</option>
        <option value="samoan">Samoan</option>
        <option value="san marinese">San Marinese</option>
        <option value="sao tomean">Sao Tomean</option>
        <option value="saudi">Saudi</option>
        <option value="scottish">Scottish</option>
        <option value="senegalese">Senegalese</option>
        <option value="serbian">Serbian</option>
        <option value="seychellois">Seychellois</option>
        <option value="sierra leonean">Sierra Leonean</option>
        <option value="singaporean">Singaporean</option>
        <option value="slovakian">Slovakian</option>
        <option value="slovenian">Slovenian</option>
        <option value="solomon islander">Solomon Islander</option>
        <option value="somali">Somali</option>
        <option value="south african">South African</option>
        <option value="south korean">South Korean</option>
        <option value="spanish">Spanish</option>
        <option value="sri lankan">Sri Lankan</option>
        <option value="sudanese">Sudanese</option>
        <option value="surinamer">Surinamer</option>
        <option value="swazi">Swazi</option>
        <option value="swedish">Swedish</option>
        <option value="swiss">Swiss</option>
        <option value="syrian">Syrian</option>
        <option value="taiwanese">Taiwanese</option>
        <option value="tajik">Tajik</option>
        <option value="tanzanian">Tanzanian</option>
        <option value="thai">Thai</option>
        <option value="togolese">Togolese</option>
        <option value="tongan">Tongan</option>
        <option value="trinidadian or tobagonian">Trinidadian or Tobagonian</option>
        <option value="tunisian">Tunisian</option>
        <option value="turkish">Turkish</option>
        <option value="tuvaluan">Tuvaluan</option>
        <option value="ugandan">Ugandan</option>
        <option value="ukrainian">Ukrainian</option>
        <option value="uruguayan">Uruguayan</option>
        <option value="uzbekistani">Uzbekistani</option>
        <option value="venezuelan">Venezuelan</option>
        <option value="vietnamese">Vietnamese</option>
        <option value="welsh">Welsh</option>
        <option value="yemenite">Yemenite</option>
        <option value="zambian">Zambian</option>
        <option value="zimbabwean">Zimbabwean</option>
        </select>
        <span style="color: red;"><?php 
        if(!empty($nationality_empty)){
        echo $nationality_empty;
        }
        ?></span><br> 

        <label for="pays">pays</label><br>
        <input type="text" id="pays" name="pays" placeholder="Veuillez sélectionner un pays valide."  ><br>
        <span style="color: red;"><?php 
        if(!empty($pays_invalid)){
        echo $pays_invalid;
        }
        ?></span><br>
        <label for="ville">ville</label><br>
        <input type="text" id="ville" name="ville" placeholder="Veuillez saisir une ville valide."  ><br>
        <span style="color: red;"><?php
        if(!empty($ville_invalid)){
        echo $ville_invalid;
        }
        ?></span>

        <label for="adresse">Adresse</label><br>
        <input type="text" id="adresse" name="adresse" placeholder="Veuillez saisir une adresse valide."  ><br>
        <span style="color: red;"><?php 
        
        if(!empty($adresse_invalid)){
            echo $adresse_invalid;
        }
        if(!empty($error)){
        echo $error;
        }
        ?></span><br>    
        <button type="submit" name="ajouter" >Ajouter</button>

        </form>
        <form action="index.php">  
          <button name="Retour " type="submit">Retour à la liste</button>
        </form>

</body>
</html>