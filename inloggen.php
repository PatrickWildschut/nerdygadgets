<?php /* Can */
include __DIR__ . "/header.php";


maakVerbinding();




if(!empty($_POST['email']) && !empty($_POST['password'])) {

    $ingelogd = InloggenGegevens($_POST['email'], $_POST['password']);
    if($ingelogd > 0) {
        $_SESSION['ingelogd'] = true;
        $klantgegevens = HaalKlantUitDatabase($ingelogd);
        $_SESSION['klantnaam'] = $klantgegevens[0]['name'];
    }



 //if (session_status() === PHP_SESSION_ACTIVE) {
    //HaalKlantUitDatabase($ID);




    // Nu moet ik er voor  zorgen dat wanneer de klat is ingelogd de sessie automatisch loopt en dan de gegeves automatisch ingevuld worden.
   // echo 'There is an ongoing session';

    //    // vul gegevens [0]
//    $gegevens['name'] = $antwoord['name'];
//    $gegevens['city'] = $antwoord['city'];
//    $gegevens['address'] = $antwoord['address'];
//    $gegevens['postcode'] = $antwoord['postcode'];
//    $gegevens['email'] = $antwoord['email'];




//} else {
    // hier worden de gegevens niet ingevuld
   // echo 'There is no ongoing session';
}



?>





<h1 class="Text">Inlogpagina</h1>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset=”utf-8”>

</head>
<body>

<div class="Inloggen">

<div class="center">

    <h1 class="titels">Inloggen</h1>

<form method="post">


    e-mail: <input type="text" name="email" required><br>
    wachtwoord: <input type="password" name="password" required>

    <input type="submit" name="inloggen" value="Inloggen">
<a href="registreren.php">Registreren</a> <?php // zorgt ervoor dat je wordt door gestuurd naar de adresgegevens plek zodat je kan inloggen // ?>

<?php if (isset($_POST['inloggen'])) {
    if($_SESSION['ingelogd'] == true) {
        header('Location: index.php');
        exit;
    }
}
    ?>




</a>
</form>
</body>
</html>

<div/>

<div/>
<?php
include __DIR__ . "/footer.php";
?>

