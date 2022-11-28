<?php
include __DIR__ . "/header.php";
?>
    <head><meta charset="UTF-8"><title>Klant toevoegen</title></head>
    <body>
        <?php
            include 'klantfuncties.php';
            if (isset($_GET["toevoegen"])) {
                $gegevens["name"] = isset($_GET["name"]) ? $_GET["name"] : "";
                $gegevens["city"] = isset($_GET["city"]) ? $_GET["city"] : "";
                
                $gegevens["address"] = isset($_GET["address"]) ? $_GET["address"] : "";
                
                $gegevens["email"] = isset($_GET["email"]) ? $_GET["email"] : "";
                $gegevens = klantGegevensToevoegen($gegevens);
            }
        ?>

        <h1>Klant toevoegen</h1><br><br>
        <form method="get" action="toevoegenklant.php">
            <label>Naam</label>
            <input type="text" name="name" value="<?php print($gegevens['name']); ?>" required/> <br>
            <label>Woonplaats</label>
            <input type="text" name="city" value="<?php print($gegevens['city']); ?>" required/> <br>
            <label>Adres</label>
            <input type="text" name="address" value="<?php print($gegevens['address']); ?>" required/> <br>
            <label>Email</label>
            <input type="text" name="email" value="<?php print($gegevens['email']); ?>" required/> <br>
            <input type="submit" name="toevoegen" value="Toevoegen" required/>
        </form>
        <br><?php print($gegevens["melding"]); ?><br>
        <a href="bekijkenoverzicht.php">Terug naar het overzicht</a>
<?php
include __DIR__ . "/footer.php";
?>