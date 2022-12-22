<?php
include __DIR__ . "/header.php";

//uzeyir

if (isset($_POST["testtest"])){
   if($_POST["testtest"]==0){
       print('<meta http-equiv="refresh" content="0;url=blabla.php" />');
       $_SESSION['cart'] = [];
   }
}else{
    print('');
}
// Patrick
if (isset($_GET["afrekenen"]) || isset($_GET["Toevoegen"])) {
    $gegevens["name"] = isset($_GET["name"]) ? $_GET["name"] : "";
    $gegevens["address"] = isset($_GET["address"]) ? $_GET["address"] : "";
    $gegevens["postcode"] = isset($_GET["postcode"]) ? $_GET["postcode"] : "";
    $gegevens["city"] = isset($_GET["city"]) ? $_GET["city"] : "";
    $gegevens["email"] = isset($_GET["email"]) ? $_GET["email"] : "";

    }

if (isset($_GET["afrekenen"])) {
    $gegevens = klantGegevensToevoegen($gegevens);
    addToOrder($gegevens["name"]);

    // clear winkelmand
    $_SESSION['cart'] = [];
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
    <!-- Marijn start -->

    <div class="kortingscode">
        <h1 class="titels">Kortingscode</h1>
        <input class="text" type="text" name="kortingscode" value="<?php if(empty($_GET['kortingscode'])){print(""); }else{print($_GET['kortingscode']);} ?>">
        <input class="Toevoegen" type="submit" name="Toevoegen" value="Toevoegen">
        <a href="wheel.html">Spin het wiel voor korting!</a>
        <?php


        if(!empty($_GET['kortingscode'])){

            $naam = $_GET['kortingscode'];

            if($_SESSION['heeftkorting'] == false)
            {
                if (ControlerenKorting($naam) == true) {
                    $korting = Ophalenkorting($naam);

                    $_SESSION['totaalprijs'] = $_SESSION['totaalprijs'] - (($_SESSION['totaalprijs'] / 100) * $korting);
                    $_SESSION['heeftkorting'] = true;
                    print("Kortingscode: '$naam' toegepast!");
                }else {
                    print("Ongeldige kortingscode!");
                }
            } else{
                print("Er is al een kortingscode in gebruik!");
            }


        }
        ?>
    </div>
    <!-- Marijn end -->

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
