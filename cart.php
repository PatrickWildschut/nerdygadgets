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
$cart = getCart();
$totalPrice = 0;

foreach($cart as $key => $value){
    $totalPrice += round(getStockItem($key, $databaseConnection)['SellPrice'], 2) * $value;
    #print_r(getStockItemImage($key, $databaseConnection));
    //gegevens van artikel uit database
    $item = getStockItem($key, $databaseConnection);
    $naam= $item['StockItemName'];
    $prijs = round($item['SellPrice'],2);

    print("Naam: $naam<br>");
    print("Aantal: $value <br>");
    print("Prijs: $prijs<br>");
    print("<br>");
}

print("<br>Totaal Prijs: $totalPrice<br>");
//gegevens per artikelen in $cart (naam, prijs, etc.) uit database halen
//totaal prijs berekenen
//mooi weergeven in html
//etc.

?>
<p><a href='view.php?id=0'>Naar artikelpagina van artikel 0</a></p>

<?php
include __DIR__ . "/footer.php";
?>