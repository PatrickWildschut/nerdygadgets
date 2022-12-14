<?php
include __DIR__ . "/header.php";

include 'klantfuncties.php';
// Patrick
if (isset($_GET["afrekenen"])) {
    $gegevens["name"] = isset($_GET["name"]) ? $_GET["name"] : "";
    $gegevens["address"] = isset($_GET["address"]) ? $_GET["address"] : "";
    $gegevens["postcode"] = isset($_GET["postcode"]) ? $_GET["postcode"] : "";
    $gegevens["city"] = isset($_GET["city"]) ? $_GET["city"] : "";
    
    
    $gegevens["email"] = isset($_GET["email"]) ? $_GET["email"] : "";
    $gegevens = klantGegevensToevoegen($gegevens);
    addToOrder($gegevens["name"]);
    ?>
    <!-- Ideal popup site, kan misschien geblokt worden - Patrick -->
    <script type="text/javascript">
    	window.onload = function()
    	{
        	window.open('https://www.ideal.nl/demo/qr?app=<?php print($_GET["betaalwijze"]); ?>', "_blank");
    	}
	</script>
	<?php
}

?>
    <div class="verzendinformatie">
    <h1 class="titels">Verzendinformatie</h1>

        <form>
            Naam: <input class="text" type="text" name="name" value="<?php print($gegevens['name']); ?>" required>
            Adres: <input class="text" type="text" name="address" value="<?php print($gegevens['address']); ?>" required>
            Postcode: <input class="text" type="text" name="postcode" value="<?php print($gegevens['postcode']); ?>" required/>
            Plaats: <input class="text" type="text" name="city" value="<?php print($gegevens['city']); ?>" required>
            Email: <input class="text" type="email" name="email" value="<?php print($gegevens['email']); ?>" required>
       </div>

    <div class="verzendmethode">
    <h1 class="titels">Verzendmethode</h1>
        <select name="verzendmethode">
            <option value="PostNL">Verzenden met PostNL</option>
        </select></div>

    <div class="betaalmethode">
    <h1 class="titels">Betaalmethode</h1>
		<select name="betaalwijze">
	  		<option value="rabobank">Rabobank</option>
	  		<option value="ing">ING</option>
	  		<option value="abn">ABN Amro</option>
	  		<option value="knab">Knab</option>
		</select>
		</div>

    <div class="afrekenen">
    <h1 class="titels">Bevestigen</h1>
		<?php
		$btw = 0.21 * $_SESSION['totaalprijs'];
		$btw = number_format($btw,2);
		print("BTW: € $btw");

		print("<br>Totaal prijs: € ".number_format($_SESSION['totaalprijs'], 2)."<br>");
	    
		?>

    <input class="afreken" type="submit" name="afrekenen" value="Afrekenen" required/>
    </div>
    </form>
</div>
<?php
include __DIR__ . "/footer.php";
?>