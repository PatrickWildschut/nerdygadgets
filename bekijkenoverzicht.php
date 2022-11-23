<?php 
include __DIR__ . "/header.php";
include __DIR__ . '/klantfuncties.php';
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

CREATE TABLE `website_customers` (\n  `ID` int(11) NOT NULL AUTO_INCREMENT,\n  `name` varchar(100) NOT NULL,\n  `city` varchar(100) NOT NULL,\n  `address` varchar(100) NOT NULL,\n  `email` varchar(100) NOT NULL,\n  PRIMARY KEY (`ID`)\n) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1'
