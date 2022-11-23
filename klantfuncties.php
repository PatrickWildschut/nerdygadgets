<?php

$gegevens = array("ID" => 0, "name" => "", "city" => "", "address" => "", "email" => "", "melding" => "");

function maakVerbinding() {
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $databasename = "nerdygadgets";
    $connection = mysqli_connect($host, $user, $pass, $databasename);
    return $connection;
}

function sluitVerbinding($connection) {
    mysqli_close($connection);
}

function alleKlantenOpvragen() {
	$connection = maakVerbinding();
	$klanten = selecteerKlanten($connection);
	sluitVerbinding($connection);
	return $klanten;
}

function selecteerKlanten($connection) {
    $sql = "SELECT ID, name, city FROM website_customers ORDER BY ID";
    $result = mysqli_fetch_all(mysqli_query($connection, $sql),MYSQLI_ASSOC);
    return $result;
}

function toonKlantenOpHetScherm($klanten) {
	foreach ($klanten as $klant) {
		print("<tr>");
		print("<td>".$klant["ID"]."</td>");
		print("<td>".$klant["name"]."</td>");
		print("<td>".$klant["city"]."</td>");
		print("<td><a href=\"BewerkenKlant.php?id=".$klant["ID"]."\">Bewerk</a></td>");
		print("<td><a href=\"VerwijderenKlant.php?id=".$klant["ID"]."\">Verwijder</a></td>");
		print("</tr>");
	}
}

function klantGegevensToevoegen($gegevens) {
	$connection = maakVerbinding();
	if (voegKlantToe($connection, $gegevens['name'], $gegevens["city"], $gegevens["address"], $gegevens["email"]) == True) {
		$gegevens["melding"] = "De klant is toegevoegd";
        } else {
	 	$gegevens["melding"] = "Het toevoegen is mislukt";
        }
	sluitVerbinding($connection);
	return $gegevens;
}

function voegKlantToe($connection, $naam, $woonplaats, $adres, $email) {
	print('miauw1');
    $statement = mysqli_prepare($connection, "INSERT INTO website_customers (name, city, address, email) VALUES(?,?,?,?)");
    print('miauw2');
    mysqli_stmt_bind_param($statement, 'ssss', $naam, $woonplaats, $adres, $email);
    print('miauw3');
    mysqli_stmt_execute($statement);
    print('miauw4');
    return mysqli_stmt_affected_rows($statement) == 1;
}

?>