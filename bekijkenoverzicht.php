<?php 
include __DIR__ . "/header.php";
include __DIR__ . '/klantfuncties.php';

// Verwijder
if(!empty($_POST['verwijder']))
{
    verwijderKlant($_POST['id']);

    // Maak verwijder weer leeg
    $_POST['verwijder'] = '';
}

$klanten = alleKlantenOpvragen();
?>

<!DOCTYPE html>
<html>
    <head><meta charset="UTF-8"><title>Klantenoverzicht</title></head>
    <body>
        <h1>Klanten overzicht</h1>
        <br>
        <p><a href="toevoegenklant.php">Nieuwe klant toevoegen</a></p>
        <table>
            <thead >
                <tr><th>Nr</th><th>Naam</th><th>Woonplaats</th><th></th><th></th></tr>
            </thead>
            <tbody>
                <?php toonKlantenOpHetScherm($klanten); ?>
            </tbody>
        </table>

<?php
include __DIR__ . "/footer.php";
?>
