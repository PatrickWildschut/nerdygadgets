<?php

if(session_status()<>PHP_SESSION_ACTIVE)   {
    session_start();
}                         // altijd hiermee starten als je gebruik wilt maken van sessiegegevens

function getCart(){
    if(isset($_SESSION['cart'])){               //controleren of winkelmandje (=cart) al bestaat
        $cart = $_SESSION['cart'];                  //zo ja:  ophalen
    } else{
        $cart = array();                            //zo nee: dan een nieuwe (nog lege) array
    }
    return $cart;                               // resulterend winkelmandje terug naar aanroeper functie
}

function saveCart($cart){
    $_SESSION["cart"] = $cart;                  // werk de "gedeelde" $_SESSION["cart"] bij met de meegestuurde gegevens
}

function addProductToCart($stockItemID){
    $cart = getCart();                          // eerst de huidige cart ophalen

    if(array_key_exists($stockItemID, $cart)){  //controleren of $stockItemID(=key!) al in array staat
        $cart[$stockItemID] += 1;                   //zo ja:  aantal met 1 verhogen
    }else{
        $cart[$stockItemID] = 1;                    //zo nee: key toevoegen en aantal op 1 zetten.
    }

    saveCart($cart);                            // werk de "gedeelde" $_SESSION["cart"] bij met de bijgewerkte cart
}
// Patrick
function subtractProductFromCart($stockItemID){
    $cart = getCart();

    if(array_key_exists($stockItemID, $cart)) {
        if ($cart[$stockItemID] > 1) {
            $cart[$stockItemID] -= 1;
            saveCart($cart);
        } else {
            removeProductFromCart($stockItemID);
        }
    }
}
// Patrick
function removeProductFromCart($stockItemID){
    $cart = getCart();                          

    // Alleen verwijderen als het in de cart zit, voor als er een leuke hacker voorbij komt :)
    if(array_key_exists($stockItemID, $cart)){  
        unset($cart[$stockItemID]);                   
    }

    saveCart($cart);                            
}
// Uzeyir
function updateProductFromCart($stockItemID,$aantal){
    $cart = getCart();
    if(array_key_exists($stockItemID,$cart)) {
        $cart[$stockItemID] = $aantal;
    }

    saveCart($cart);
}

// Patrick
function getProductCount()
{
    $cart = getCart();
    $_SESSION['aantalProducts']  = 0;

    foreach ($cart as $key => $value) {
        // We setten de globale variabele
        $_SESSION['aantalProducts'] += $value;
    }
    // en returnen dezelfde waarde zodat we kunnen kiezen hoe we het willen gebruiken :)
    return $_SESSION['aantalProducts'];
}

// Patrick
function getProductStock($stockItemID)
{   
    $connection = maakVerbinding();

    $stockitem = getStockItem($stockItemID, $connection);

    sluitVerbinding($connection);

    return intval(trim(explode(":", $stockitem['QuantityOnHand'])[1]));
}
