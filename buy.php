<?php
include __DIR__ . "/header.php";

include 'klantfuncties.php';
if (isset($_GET["afrekenen"])) {
    $gegevens["name"] = isset($_GET["name"]) ? $_GET["name"] : "";
    $gegevens["city"] = isset($_GET["city"]) ? $_GET["city"] : "";
    
    $gegevens["address"] = isset($_GET["address"]) ? $_GET["address"] : "";
    
    $gegevens["email"] = isset($_GET["email"]) ? $_GET["email"] : "";
    $gegevens = klantGegevensToevoegen($gegevens);
}

?>

<div class="center">
<form method="get">
        <label>Naam</label>
        <input type="text" name="name" value="<?php print($gegevens['name']); ?>" required/> <br>
        <label>Woonplaats</label>
        <input type="text" name="city" value="<?php print($gegevens['city']); ?>" required/> <br>
        <label>Adres</label>
        <input type="text" name="address" value="<?php print($gegevens['address']); ?>" required/> <br>
        <label>Email</label>
        <input type="text" name="email" value="<?php print($gegevens['email']); ?>" required/> <br>

        <div class="center" style="border: none;">
		<select name="betaalwijze">
	  		<option value="rabobank">Rabobank</option>
	  		<option value="ing">ING</option>
	  		<option value="abnamro">ABN Amro</option>
	  		<option value="asnbank">ASN Bank</option>
		</select>
		</div>

		<?php
		$btw = 0.21 * $_SESSION['totaalprijs'];
		$btw = number_format($btw,2);
		print("BTW: € $btw");

		print("<br>Totaal prijs: € ".$_SESSION['totaalprijs']."<br>");
	    
		?>

        <input type="submit" name="afrekenen" value="Afrekenen" required/>
        
    </form>
</div>
<?php
include __DIR__ . "/footer.php";
?>