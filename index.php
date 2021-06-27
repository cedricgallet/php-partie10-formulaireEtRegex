<?php

// TABLEAU DIPLOMES
$arrayCertificate = ['Sans', 'Bac', 'Bac+2', 'Bac+3', 'Supérieur'];

// INITIALISATION TABLEAU VIDE POUR LES ERREURS
$error = [];

// Constanstante PHP + REGEX
define('REGEX_NO_NUMBER',"^[A-Za-z-éèêëàâäôöûüç' ]+$");
define('REGEX_FOR_DATE',"^[a-zA-Z]+\s{1}[0-9]{4}$");
define('REGEX_PHONE',"^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$");
define('REGEX_DATE',"^\d{4}-\d{2}-\d{2}$");
define('REGEX_NAME',"^[a-zA-Z]{1}[a-zA-ZàâæçéèêëîïôœùûüÿÀÂÆÇnÉÈÊËÎÏÔŒÙÛÜŸ -]+$");
define('REGEX_ADRESS',"^[a-z0-9A-ZàâæçéèêëîïôœùûüÿÀÂÆÇnÉÈÊËÎÏÔŒÙÛÜŸ -]+$");
define('REGEX_ouinon',"^(oui)|(non)$");
define('REGEX_NUMBER',"^[0-9]+$");

 //////////////////////////////////////////////////////////////////LASTNAME/////////////////////////////////////////////////////////

    // ON VERIFIE SI LE FORMULAIRE EST BIEN ENVOYÉ

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // ON NETTOIE LES CARACTERES SPÉCIAUX
        $lastname = trim(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));

        // On vérifie que ce n'est pas vide
        if(!empty($lastname)){
            $testRegex = preg_match("/".REGEX_NO_NUMBER."/",$lastname);

            // Avec une regex (constante déclarée plus haut), on vérifie si c'est le format attendu 
            if(!$testRegex){
                $error["lastname"] = "Le prénon n'est pas au bon format!!"; 
            } else {
                // Dans ce cas précis, on vérifie aussi la longueur des caractères (on aurait pu le faire aussi direct dans la regex)
                if(strlen($lastname)<=1 || strlen($lastname)>=70){
                    $error["lastname"] = "La longueur des caractères n'est pas bonne";
                }
            }
        } else { // Pour les champs obligatoires, on retourne une erreur
            $error["lastname"] = "Vous devez entrer un nom!!";
        }

        ////////////////////////////////////////////////////////////FIRSNAME//////////////////////////////////////////////////////////////////////

        $firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));

        // On vérifie que ce n'est pas vide
        if(!empty($firstname)){
        $testRegex = preg_match("/".REGEX_NO_NUMBER."/",$firstname);

            // Avec une regex (constante déclarée plus haut), on vérifie si c'est le format attendu 
            if(!$testRegex){
                $error["firstname"] = "Le nom n'est pas au bon format!!"; 
            } else {

                // Dans ce cas précis, on vérifie aussi la longueur des caractères (on aurait pu le faire aussi direct dans la regex)
                if(strlen($firstname)<=1 || strlen($firstname)>=70){
                    $error["firstname"] = "La longueur des caractères n'est pas bonne";
                }
            }
        } else { // Pour les champs obligatoires, on retourne une erreur
            $error["firstname"] = "Vous devez entrer un prénom!!";
        }

        /////////////////////////////////////////////////////////////BIRTHDAY/////////////////////////////////////////
        
        $birthday = trim(filter_input(INPUT_POST, 'birthday', FILTER_SANITIZE_STRING));
        if (!empty($birthday)) {
            $year = date('Y', strtotime($birthday));
            $month = date('m', strtotime($birthday));
            $day = date('d', strtotime($birthday));
            $checkdate = checkdate ($month, $day, $year);
            if ($checkdate == false) {
                $error['birthday'] = 'Votre date de naissance n\'est pas au bon format';
            }
        } else {
            $error['birthday'] = 'Vous devez entrer une date de naissance';
        }

       ///////////////////////////////////////////////////////////////COUNTRY////////////////////////////////////////////

       $country = trim(filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES)); 
       if(!empty($country)){
            $testRegex = preg_match('/'.REGEX_NAME.'/', $country);
            if(!$testRegex){
                $error['country'] = 'La ville n\'est pas au bon format!!';
            }
        } else {
                $error['country'] = 'Votre ville n\'est pas renseigné';
        }

        ///////////////////////////////////////////////////////NATIONALITY///////////////////////////////////////////////////

        $nationality = trim(filter_input(INPUT_POST, 'nationality', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        if(!empty($nationality)){
            $testRegex = preg_match('/'.REGEX_NAME.'/', $nationality);
            if(!$testRegex){
                $error['nationality'] = 'Votre nationalité n\'est pas au bon format!!';
            }
        } else {
                $error['nationality'] = 'Votre nationalité n\'est pas renseigné';
        }

        /////////////////////////////////////////////////////////ADRESS//////////////////////////////////////////////////////

        $adress = trim(filter_input(INPUT_POST, 'adress', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));    
        if(!empty($adress)){
            $testRegex = preg_match('/'.REGEX_ADRESS.'/', $adress);
            if(!$testRegex){
                $error['adress'] = 'Votre adresse n\'est pas au bon format!!';
            }
        } else {
                $error['adress'] = 'Votre adresse n\'est pas renseigné';
            }

        /////////////////////////////////////////////////////MAIL///////////////////////////////////////////////////////

        $mail = trim(filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL)); //PAS BESOIN DE REGEX LE FAIT NATIVEMENT
        if(!empty($mail)){
            $testRegex = filter_var($mail, FILTER_VALIDATE_EMAIL);
            if(!$testRegex){
                $error['mail'] = 'Le mail n\'est pas au bon format!!';
            }
        } else {
                $error['mail'] = 'Votre mail n\'est pas renseigné';
        }

        /////////////////////////////////////////////////////PHONE///////////////////////////////////////////////////////////
        
        $phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_NUMBER_INT));
        if(!empty($phone)){
            $testRegex = preg_match('/'.REGEX_PHONE.'/', $phone);
            if(!$testRegex){
                $error['phone'] = 'Le téléphone n\'est pas au bon format!!';
            }
        } else {
                $error['phone'] = 'Votre téléphone n\'est pas renseigné';
        }

        //////////////////////////////////////////////DIPLOME/////////////////////////////////////////////////////////////////

        $certificate = trim(filter_input(INPUT_POST, 'certificate', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        if(!empty($certificate)) {
            if (!in_array($certificate,$arrayCertificate)) {
                $error['certificate'] = 'Le diplome doit etre renseigné';
            }
        } 

        ////////////////////////////////////////////////////POLE EMPLOI///////////////////////////////////////////////////////

        $poleEmploi = trim(filter_input(INPUT_POST, 'poleEmploi', FILTER_SANITIZE_NUMBER_INT));    
        if(!empty($poleEmploi)){
            $testRegex = preg_match('/'.REGEX_NUMBER.'/', $poleEmploi);
            if(!$testRegex){
                $error['poleEmploi'] = 'Le numero pole emploi doit être renseigné!!';
            }
        }

        ////////////////////////////////////////////////BADGE/////////////////////////////////////////////////

        $badge = trim(filter_input(INPUT_POST, 'badge', FILTER_SANITIZE_NUMBER_INT));
        if(!empty($badge)){
            $testRegex = preg_match('/'.REGEX_NUMBER.'/', $badge);
            if(!$testRegex){
                $error['badge'] = 'Le nombre de badge doit être renseigné!!';
            }
        }

        //////////////////////////////////////////////////CODE ACADEMY/////////////////////////////////////////

        $codeAcademy = trim(filter_input(INPUT_POST, 'codeAcademy', FILTER_SANITIZE_URL)); //PAS BESOIN DE REGEX LE FAIT NATIVEMENT
        if(!empty($codeAcademy)){
            $testRegex = filter_var($codeAcademy,FILTER_VALIDATE_URL);
            if(!$testRegex){
                $error['codeAcademy'] = 'Le lien n\'est pas au bon format!!';
            }
        }

        ////////////////////////////////////////////////SUPER HERO//////////////////////////////////////////////

        $superHero = trim(filter_input(INPUT_POST, 'superHero', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        if(!empty($superHero)){
            if(strlen($superHero)<=1 || strlen($superHero)>=300){
                $error['superHero'] = 'Votre texte doit être compris entre 1 et 300 caracteres';
            }
        } else {
            $error['superHero'] = 'Votre texte n\'est pas renseigné';
        }

        ////////////////////////////////////////////////HACKS////////////////////////////////////////////////////

        $hacks = trim(filter_input(INPUT_POST, 'hacks', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));


        ////////////////////////////////////////////EXPERIENCE////////////////////////////////////////////////////

        $flexRadioDefault = trim(filter_input(INPUT_POST, 'codex', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////

    }

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Formulaire</title>
</head>

<body>
    <div id="firstContainer" class="container dotted p-4 mt-4 bg-secondary bg-gradient">

        <div class="row">
            <h1 class="text-center">Formulaire PHP</h1>


            <?php 
            var_dump($error);

            if ($_SERVER['REQUEST_METHOD'] != 'POST' || !empty($error) ) { ?>

            <form class="row" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

                <div class="col-12 col-lg-6">

                    <!-- ///////////////////////////////////////////////////NOM///////////////////////////////////////////////////////////////// -->

                    <div>
                        <input class="mt-3 form-control form-control-lg" type="text" name="lastname" id="lastname"
                            placeholder="Entrez votre nom" pattern="<?=REGEX_NO_NUMBER?>" required
                            value="<?= htmlentities($_POST['lastname'] ?? '')?>">
                        <?=htmlentities($error['lastname'] ?? '')?>
                    </div>
                    <!-- ///////////////////////////////////////////////////PRENOM////////////////////////////////////////////////////////////////// -->
                    <div>
                        <input class="mt-3 form-control form-control-lg" type="text" name="firstname" id="firstname"
                            placeholder="Entrez votre prénom" pattern="<?=REGEX_NO_NUMBER?>" required
                            value="<?=htmlentities($_POST['firstname'] ?? '')?>">
                        <?=htmlentities($error['firstname'] ?? '')?>
                    </div>
                    <!-- ////////////////////////////////////////////////DATE DE NAISSANCE///////////////////////////////////////////////////////////////////// -->


                    <div>
                        <input class="mt-3 form-control form-control-lg" type="date" name="birthday" id="birthday"
                            placeholder="Entrez votre date de naissance" pattern="<?=REGEX_DATE?>" required
                            value="<?=htmlentities($_POST['birthday'] ?? '')?>">
                        <?=htmlentities($error['birthday'] ?? '')?>
                    </div>
                    <!-- /////////////////////////////////////////////////VILLE///////////////////////////////////////////////////////////////// -->


                    <div>
                        <input class="mt-3 form-control form-control-lg" type="text" name="country" id="country"
                            placeholder="Renseigner votre ville" pattern="<?=REGEX_NAME?>" required
                            value="<?= htmlentities($_POST['country'] ?? '')?>">
                        <?=htmlentities($error['country'] ?? '')?>
                    </div>
                    <!-- /////////////////////////////////////////////////NATIONALITE/////////////////////////////////////////////////////////////////// -->


                    <div>
                        <input class="mt-3 form-control form-control-lg" type="text" name="nationality" id="nationality"
                            placeholder="Renseigner votre nationalité" pattern="<?=REGEX_NAME?>" required
                            value="<?= htmlentities($_POST['nationality'] ?? '')?>">
                        <?=htmlentities($error['nationality'] ?? '')?>
                    </div>
                    <!-- /////////////////////////////////////////////////ADRESSE///////////////////////////////////////////////////////////////////// -->



                    <div>
                        <input class="mt-3 form-control form-control-lg" type="text" name="adress" required
                            placeholder="Renseigner votre adresse" pattern="<?=REGEX_ADRESS?>"
                            value="<?= htmlentities($_POST['adress'] ?? '', ENT_QUOTES, 'UTF-8')?>">
                        <?=htmlentities($error['adress'] ?? '', ENT_QUOTES, 'UTF-8')?>
                    </div>
                </div>

                <!-- ///////////////////////////////////////////////////////EMAIL//////////////////////////////////////////////////////////////////////////////// -->

                <div class="col-12 col-lg-6">

                    <div>
                        <input class="mt-3 form-control form-control-lg" type="email" name="mail" id="email" required
                            placeholder="Votre mail"
                            value="<?= htmlentities($_POST['mail'] ?? '', ENT_QUOTES, 'UTF-8')?>">
                        <?= htmlentities($error['mail'] ?? '', ENT_QUOTES, 'UTF-8')?>
                    </div>
                    <!-- //////////////////////////////////////////////////TELEPHONE////////////////////////////////////////////////////////////////// -->


                    <div>
                        <input class="mt-3 form-control form-control-lg" type="tel" name="phone" id="phone"
                            maxlength="10" placeholder="Votre téléphone" pattern="<?=REGEX_PHONE?>" required
                            value="<?= htmlentities($_POST['phone'] ?? '', ENT_QUOTES, 'UTF-8')?>">
                        <?=htmlentities($error['phone'] ?? '', ENT_QUOTES, 'UTF-8')?>
                    </div>
                    <!-- //////////////////////////////////////////////////DIPLOMES///////////////////////////////////////////////////////////// -->


                    <div>
                        <select class="mt-3 form-select form-select-lg" aria-label=".form-select-lg" name="certificate"
                            id="certificate">
                            <!-- BOUCLER SUR LE TABLEAU DIPLOME POUR CONTROLER -->
                            <?php foreach($arrayCertificate as $value):?>
                            <option value="<?=$value?>" <?=$value==$certificate ? 'selected' : ''?>><?=$value?></option>
                            <?php endforeach?>
                        </select>
                        <?= htmlentities($error['certificate'] ?? '', ENT_QUOTES, 'UTF-8')?>
                    </div>
                    <!-- ////////////////////////////////////////////////// NUMERO POLE EMPLOI////////////////////////////////////////////////////////////// -->


                    <div>
                        <input class="mt-3 form-select form-select-lg" type="number" name="poleEmploi" id="poleEmploi"
                            placeholder="Votre numéro de pole emploi" pattern="<?=REGEX_NUMBER?>"
                            value="<?= htmlentities($poleEmploi ?? '', ENT_QUOTES, 'UTF-8')?>">
                        <?= htmlentities($error['poleEmploi'] ?? '', ENT_QUOTES, 'UTF-8')?>

                    </div>
                    <!-- ///////////////////////////////////////////////NUMERO BADGE///////////////////////////////////////////////////////////// -->


                    <div>
                        <input class="mt-3 form-select form-select-lg" type="number" name="badge" id="badge"
                            placeholder="Renseigner votre numéro de badge" pattern="<?=REGEX_NUMBER?>"
                            value="<?= htmlentities($badge ?? '', ENT_QUOTES, 'UTF-8')?>">
                        <?= htmlentities($error['badge'] ?? '', ENT_QUOTES, 'UTF-8')?>
                    </div>
                    <!-- ////////////////////////////////////////////////////CODE ACADEMY///////////////////////////////////////////////////////// -->


                    <div>
                        <input class="mt-3 form-select form-select-lg" type="url" name="codeAcademy" id="codeAcademy"
                            placeholder="Renseigner votre lien codecademy"
                            value="<?= htmlentities($_POST['codeAcademy'] ?? '', ENT_QUOTES, 'UTF-8')?>">
                        <?= htmlentities($error['codeAcademy'] ?? '', ENT_QUOTES, 'UTF-8')?>
                    </div>

                </div>
                <!-- ///////////////////////////////////////////SUPERO HERO////////////////////////////////////////////////////////////////////////// -->

                <div class="col-12 col-lg-12">

                    <div>
                        <textarea class="mt-3 form-control form-control-lg" 
                            name="superHero" id="superHero" rows="3"
                            placeholder="Si vous étiez un super héros/une super héroïne, qui seriez-vous et pourquoi"
                            required>
                            <?= htmlentities($superHero ?? '', ENT_QUOTES, 'UTF-8')?></textarea>
                        <?= htmlentities($error['superHero'] ?? '', ENT_QUOTES, 'UTF-8')?>
                    </div>

                    <!-- ///////////////////////////////////////////HACK//////////////////////////////////////////////////////////////////////// -->


                    <div>
                        <textarea class="mt-3 form-control form-control-lg"
                            name="hacks" id="hacks" rows="3"
                            placeholder="Racontez-nous un de vos hacks (pas forcément technique ou informatique)"
                            ></textarea>
                    </div>
                    <!-- ///////////////////////////////////////////////EXPERIENCE////////////////////////////////////////////////////////////////// -->


                    <div>
                        <select class="mt-3 form-select form-select-lg mb-3" aria-label=".form-select-lg">
                            <option selected>Avez vous déjà eu une expérience avec la programmation et/ou l'informatique
                                avant de remplir ce formulaire ?</option>
                            <option value="1">Oui</option>
                            <option value="2">Non</option>
                        </select>
                    </div>
                    <!-- //////////////////////////////////////////////BOUTTON///////////////////////////////////////////////////////////////////// -->


                    <div class="d-flex justify-content-center">
                        <input class="mt-3 btn btn-lg btn-outline-dark w-30" type="submit">
                    </div>
                </div>

            </form>


            <?php
                } else {  

                    echo "$lastname<br>";
                    echo "$firstname<br>";
                    echo "$birthday<br>";
                    echo "$country<br>";
                    echo "$nationality<br>";
                    echo "$adress<br>";
                    echo "$mail<br>";
                    echo "$phone<br>";
                    echo "$certificate<br>";
                    echo "$poleEmploi<br>";
                    echo "$badge<br>";
                    echo "$codeAcademy<br>";
                    echo "$superHero<br>";
    

                }
            ?>

        
        </div>

    </div>
</body>

</html>