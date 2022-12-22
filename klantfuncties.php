<?php
$gegevens = array("ID" => 0, "name" => "", "city" => "", "address" => "","postcode" => "", "email" => "", "melding" => "","password"=>"");
$beoordeling = array("Sterren" => "", "Beoordeling" => "");


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
    $sql = "SELECT ID, name, email FROM website_customers ORDER BY ID";
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
    if (voegKlantToe($connection, $gegevens['name'], $gegevens["address"], $gegevens["postcode"], $gegevens["city"], $gegevens["email"],
            $gegevens["password"]) == True) {
        $gegevens["melding"] = "De klant is toegevoegd";

    } else {
	 	$gegevens["melding"] = "Het toevoegen is mislukt";
        }
	sluitVerbinding($connection);
	return $gegevens;
}

function voegKlantToe($connection, $naam, $adres, $postcode, $woonplaats, $email, $password=null) {
	$result = selecteerKlanten($connection);
	$bestaat = false;
	foreach ($result as $key => $value) {

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

function voegProductBeoordeling($klant_ID, $Sterren, $stockitem_ID, $Beoordeling)
{
    $connection = maakVerbinding();

    $statement = mysqli_prepare($connection, "INSERT INTO product_review(klant_ID, Sterren, stockitem_ID, Beoordeling) VALUES(?,?,?,?)");
    mysqli_stmt_bind_param($statement, 'iiis', $klant_ID, $Sterren, $stockitem_ID, $Beoordeling);
    mysqli_stmt_execute($statement);

    sluitVerbinding($connection);
}
function HaalKlantUitDatabase($ID) {
    $connection = maakVerbinding();
    $statement = mysqli_prepare($connection, "SELECT * FROM website_customers WHERE ID=? ");

    mysqli_stmt_bind_param($statement, "i", $ID);
    mysqli_stmt_execute($statement);

    $antwoord = mysqli_stmt_get_result($statement);
    $antwoord = mysqli_fetch_all($antwoord, MYSQLI_ASSOC);

    sluitVerbinding($connection);
    return $antwoord;
}

function InloggenGegevens($email, $password) {
    $connection = maakVerbinding();

    $statement = mysqli_prepare($connection, "SELECT ID, password FROM website_customers WHERE email=? ");

    mysqli_stmt_bind_param($statement, "s", $email);
    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC)[0];

    sluitVerbinding($connection);


    if(password_verify($password,$result['password'])) {
        print("Je bent ingelogd");
        return $result['ID'];
    } else {
        print("onjuist wachtwoord of onjuiste emailadres.");
        return false;
    }
}




?>