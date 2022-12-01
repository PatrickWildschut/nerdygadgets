<?php

$gegevens = array("ID" => 0, "name" => "", "city" => "", "address" => "","postcode" => "", "email" => "", "melding" => "");

function maakVerbinding() {
    $host = 'localhost';
    #$user = 'klant';
    #$pass = 'dikkeklantjong';
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
		print('<td>');
		?>
		<form method="post">
		<input type="submit" name="verwijder" value="Verwijder" style="height:25px; width:100px;font-size: 15px;">
    <input type="text" name="id" value="<?php print($klant["ID"]); ?>" hidden>
</form>
    	<?php

		print('</td>');
		print("</tr>");
	}
}

function klantGegevensToevoegen($gegevens) {

	$connection = maakVerbinding();
	if (voegKlantToe($connection, $gegevens['name'], $gegevens["address"], $gegevens["postcode"], $gegevens["city"], $gegevens["email"]) == True) {
		$gegevens["melding"] = "De klant is toegevoegd";
        } else {
	 	$gegevens["melding"] = "Het toevoegen is mislukt";
        }
	sluitVerbinding($connection);
	return $gegevens;
}

function voegKlantToe($connection, $naam, $adres, $postcode, $woonplaats, $email) {

	$result = selecteerKlanten($connection);
	$bestaat = false;
	foreach ($result as $key => $value) {
		if($value['name'] == $naam)
		{
			$bestaat = true;
			break;
		}
	}

    // geen result, dus bestaat niet
    if(!$bestaat)
    {
    	$statement = mysqli_prepare($connection, "INSERT INTO website_customers(name, address, postcode, city, email) VALUES(?,?,?,?,?)");
	    mysqli_stmt_bind_param($statement, 'sssss', $naam, $adres, $postcode, $woonplaats, $email);
	    mysqli_stmt_execute($statement);
    } else{
    	// klant bestaat al, hoeft niet toegevoegd te worden.
    }

    return true;
}

function verwijderKlant($id) {
	$connection = maakVerbinding();

    $statement = mysqli_prepare($connection, "DELETE FROM website_customers WHERE ID = ?");

    mysqli_stmt_bind_param($statement, 'i', $id);
    mysqli_stmt_execute($statement);

    sluitVerbinding($connection);
}

?>