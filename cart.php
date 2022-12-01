<?php
include __DIR__ . "/cartfuncties.php";
// include __DIR__. "/database.php";
?>

<?php

$cart = getCart();
$totalPrice = 0;

if(isset($_POST['aantal']))
{
// Verwijder artikels als het nodig is
    if(!empty($_POST['verwijder']))
    {
        removeProductFromCart($_POST['artikel']);

        // maak $_POST['verwijder'] empty zodat hij niet blijft verwijderen :)
        $_POST['verwijder'] = '';
    } else if ($_POST['aantal'] != $cart[$_POST["artikel"]])
    {
        updateProductFromCart($_POST['artikel'],$_POST['aantal']);

    } else if (!empty($_POST['max']))
    {
        addProductToCart($_POST['artikel']);
        $_POST['max'] = '';
    }  else if (!empty($_POST['min']))
    {
        subtractProductFromCart($_POST['artikel']);
        $_POST['min'] = '';
    }

}

getProductCount();
include __DIR__ . "/header.php";

?>

<head>
    <meta charset="UTF-8">
    <title>Winkelwagen</title>
</head>
<body>
<h1>Inhoud Winkelwagen</h1>

<?php
$cart = getCart();
$_SESSION['totaalprijs'] = 0;

foreach($cart as $key => $value){
    $totalPrice += round(getStockItem($key, $databaseConnection)['SellPrice'], 2) * $value;

    //gegevens van artikel uit database
    $item = getStockItem($key, $databaseConnection);
    $naam= $item['StockItemName'];
    $prijs = number_format($item['SellPrice'], 2);
    $_SESSION['totaalprijs'] += $prijs * $value;
    $image = getStockItemImage($key, $databaseConnection);

    print("Naam: $naam<br>");

    if($image==true){
        ?>
        <img src="Public/StockItemIMG/<?php print(getStockItemImage($key, $databaseConnection)[0]['ImagePath']); ?> " width="250" height="250"> <br>
        <?php
    }else{
        ?>
        <img src="Public/StockGroupIMG/<?php print_r(getStockItem($key, $databaseConnection)['BackupImagePath']); ?> " width="250" height="250"> <br>
        <?php
    }

    ?>
    <form method="post">

        <input type="submit" name="min" value="-" style="height:25px; width:100px;font-size: 15px;">

        <input name="aantal" min="1" max="<?php print(getProductStock($key)); ?>" type="number"value="<?php print("$value"); ?>"style="height:25px; width:100px;font-size: 15px;">
        <input type="submit" name="max" value="+" style="height:25px; width:100px;font-size: 15px;">



<?php
    print("<br>Prijs (incl. 21% btw):€ ".$prijs * $value."<br>");

    ?>
    <p><a href='view.php?id=<?php print($key); ?>'>Naar Artikelpagina</a></p>

    <input type="submit" name="verwijder" value="Verwijder" style="height:25px; width:100px;font-size: 15px;">
    <input type="text" name="artikel" value="<?php print($key); ?>" hidden>

    </form>
    <?php
    print("<br>");

}


//gegevens per artikelen in $cart (naam, prijs, etc.) uit database halen
//totaal prijs berekenen
//mooi weergeven in html
//etc.

// lege winkelmand //

$telOp = count($cart);

if($telOp == 0) {
   ?>  <h2 class="ninja">je winkelwagen is leeg...<br> <img  class="aikido"src="Public/Img/ninjaaikido.png"> </h2>



<?php
} else{
    $btw = 0.21 * $_SESSION['totaalprijs'];
    $btw = number_format($btw,2);
    print("BTW: € $btw");

    print("<br>Totaal prijs: € ".$_SESSION['totaalprijs']."<br>");
    ?>
        <br>
    <form action="buy.php">
        <input type="submit" name="" value="Afrekenen" style="height:25px; width:200px;font-size: 15px;">
    </form> 
<br>
    <br>
    <?php
}

?>
<form action="bekijkenoverzicht.php">
        <input type="submit" name="" value="Bekijk Klanten">
</form>

<?php





include __DIR__ . "/footer.php";


?> jvbhu9