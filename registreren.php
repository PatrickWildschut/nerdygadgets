<?php /* Can */
include __DIR__ . "/header.php";


if(isset($_GET['Opslaan'])) {
    $gegevens['password'] = isset($_GET["password"]) ? $_GET["password"] : "";
    $gegevens['password'] = password_hash($gegevens['password'],PASSWORD_DEFAULT );

    $gegevens["name"] = isset($_GET["name"]) ? $_GET["name"] : "";
    $gegevens["address"] = isset($_GET["address"]) ? $_GET["address"] : "";
    $gegevens["postcode"] = isset($_GET["postcode"]) ? $_GET["postcode"] : "";
    $gegevens["city"] = isset($_GET["city"]) ? $_GET["city"] : "";


    $gegevens["email"] = isset($_GET["email"]) ? $_GET["email"] : "";
    $gegevens = klantGegevensToevoegen($gegevens);
}
?>

<div class="Registreren">




    <div class="center">
        <h1 class="titels">Registreren</h1>

        <form>
            Naam: <input class="text" type="text" name="name" value="<?php print($gegevens['name']); ?>" required>
            Adres: <input class="text" type="text" name="address" value="<?php print($gegevens['address']); ?>" required>
            Postcode: <input class="text" type="text" name="postcode" value="<?php print($gegevens['postcode']); ?>" required/>
            Plaats: <input class="text" type="text" name="city" value="<?php print($gegevens['city']); ?>" required>
            Email: <input class="text" type="email" name="email" value="<?php print($gegevens['email']); ?>" required>
            Wachtwoord: <input class="text" type="password" name="password" value="" required>
<input class="text" type="submit" name="Opslaan" value="Registreren">

    <a href="inloggen.php">ga terug naar inloggen</a>

</div>
<?php
include __DIR__ . "/footer.php";
