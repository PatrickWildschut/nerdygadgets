<?php
include __DIR__ . "/cartfuncties.php";
// include __DIR__. "/database.php";
?>

<?php

$cart = getCart();
$totalPrice = 0;

if (isset($_POST['aantal'])) {
// Verwijder artikels als het nodig is
    if (!empty($_POST['verwijder'])) {
        removeProductFromCart($_POST['artikel']);

        // maak $_POST['verwijder'] empty zodat hij niet blijft verwijderen :)
        $_POST['verwijder'] = '';
    } else if ($_POST['aantal'] != $cart[$_POST["artikel"]]) {
        updateProductFromCart($_POST['artikel'], $_POST['aantal']);

    } else if (!empty($_POST['max'])) {
        addProductToCart($_POST['artikel']);
        $_POST['max'] = '';
    } else if (!empty($_POST['min'])) {
        subtractProductFromCart($_POST['artikel']);
        $_POST['min'] = '';
    }

}

getProductCount();
include __DIR__ . "/header.php";
$_SESSION['heeftkorting'] = false;
?>

    <h1 class="center">Inhoud Winkelwagen</h1>


<?php
$cart = getCart();
if (count($cart) != 0) {
    ?>
    <div id="ten-countdown"></div>
    <script src="Public/JS/index.js"></script>
    <?php   
}
$_SESSION['totaalprijs'] = 0;

foreach ($cart as $key => $value) {

    ?>
    <div class="winkelmandArtikel">
        <?php

        $totalPrice += round(getStockItem($key, $databaseConnection)['SellPrice'], 2) * $value;

        //gegevens van artikel uit database
        $image = getStockItemImage($key, $databaseConnection);

        if ($image == true) {
            ?>
            <img class="winkelmandFoto"
                 src="Public/StockItemIMG/<?php print(getStockItemImage($key, $databaseConnection)[0]['ImagePath']); ?> "
                 width="250" height="225"> <br>
            <?php
        } else {
            ?>
            <img class="winkelmandFoto"
                 src="Public/StockGroupIMG/<?php print_r(getStockItem($key, $databaseConnection)['BackupImagePath']); ?> "
                 width="250" height="225"> <br>
            <?php
        }

        $item = getStockItem($key, $databaseConnection);
        $naam = $item['StockItemName'];
        $prijs = number_format($item['SellPrice'], 2);
        $_SESSION['totaalprijs'] += $prijs * $value;


        print("<p class='StockItemName'>$naam</p><br>");


        ?>
        <form method="post">

            <input type="submit" name="min" value="-" style="height:25px; width:100px;font-size: 15px;">

            <input name="aantal" min="1" max="<?php print(getProductStock($key)); ?>" type="number"
                   value="<?php print("$value"); ?>" style="height:25px; width:100px;font-size: 15px;">
            <input type="submit" name="max" value="+" style="height:25px; width:100px;font-size: 15px;">


            <?php
            print("<br>Prijs (incl. 21% btw):€ " . number_format($prijs * $value, 2) . "<br>");

            ?>
            <p><a href='view.php?id=<?php print($key); ?>'>Naar Artikelpagina</a></p>

            <input type="submit" name="verwijder" value="Verwijder" style="height:25px; width:100px;font-size: 15px;">
            <input type="text" name="artikel" value="<?php print($key); ?>" hidden>

        </form>

    </div>
    <?php
    print("<br>");

}


//gegevens per artikelen in $cart (naam, prijs, etc.) uit database halen
//totaal prijs berekenen
//mooi weergeven in html
//etc.

// lege winkelmand //

$telOp = count($cart);

if ($telOp == 0) {
    ?>  <h2 class="ninja">je winkelwagen is leeg...<br> <img class="aikido" src="Public/Img/ninjaaikido.png"></h2>


    <?php
} else {

    $btw = 0.21 * $_SESSION['totaalprijs'];
    $btw = number_format($btw, 2);

    ?>
    <p class="winkelmandPrijzen"> BTW: <?php print($btw); ?></p>

    <p class="winkelmandPrijzen">Totaal prijs: € <?php print(number_format($_SESSION['totaalprijs'], 2)); ?></p>
    <br>
    <form action="buy.php" class="winkelmandAfrekenen">
        <input type="submit" name="" value="Afrekenen" style="font-weight: bold;">
    </form>
    <br>
    <br>
    <?php
}

include __DIR__ . "/footer.php";


?>