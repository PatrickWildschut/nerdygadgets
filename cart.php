<?php
include __DIR__ . "/header.php";
include __DIR__ . "/cartfuncties.php";
// include __DIR__. "/database.php";
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Winkelwagen</title>
</head>
<body>
<h1>Inhoud Winkelwagen</h1>

<?php

// Verwijder artikels als het nodig is
if(!empty($_POST['verwijder']))
{
    removeProductFromCart($_POST['artikel']);

    // maak $_POST['verwijder'] empty zodat hij niet blijft verwijderen :)
    $_POST['verwijder'] = '';
}

$cart = getCart();
$totalPrice = 0;

foreach($cart as $key => $value){
    $totalPrice += round(getStockItem($key, $databaseConnection)['SellPrice'], 2) * $value;

    //gegevens van artikel uit database
    $item = getStockItem($key, $databaseConnection);
    $naam= $item['StockItemName'];
    $prijs = number_format($item['SellPrice'], 2);

    print("Naam: $naam<br>");

    ?>
    <form method="post">
    <img src="Public/StockItemIMG/<?php getStockItemImage($key, $databaseConnection)[0]['ImagePath']; ?> "> <br>
    <?php

    print("Aantal: $value <br>");
    print("Prijs: $prijs<br>");
    ?>
    <p><a href='view.php?id=<?php print($key); ?>'>Naar Artikelpagina</a></p>

    <input type="submit" name="verwijder" value="Verwijder" style="height:25px; width:100px;font-size: 15px;">
    <input type="text" name="artikel" value="<?php print($key); ?>" hidden>

    </form>
    <?php
    print("<br>");
}

print("<br>Totaal Prijs: ".number_format($totalPrice, 2)."<br>");
//gegevens per artikelen in $cart (naam, prijs, etc.) uit database halen
//totaal prijs berekenen
//mooi weergeven in html
//etc.
include __DIR__ . "/footer.php";
?>