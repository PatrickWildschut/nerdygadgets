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
foreach($cart as $key => $value){
    print_r(getStockItem($key, $databaseConnection));
    print(getStockItemImage($key, $databaseConnection));
}
//gegevens per artikelen in $cart (naam, prijs, etc.) uit database halen
//totaal prijs berekenen
//mooi weergeven in html
//etc.

?>
<p><a href='view.php?id=0'>Naar artikelpagina van artikel 0</a></p>

<?php
include __DIR__ . "/footer.php";
?>