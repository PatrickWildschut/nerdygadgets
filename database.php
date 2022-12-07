<!-- dit bestand bevat alle code die verbinding maakt met de database -->
<?php

function connectToDatabase() {
    $Connection = null;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Set MySQLi to throw exceptions
    try {
        $Connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
        mysqli_set_charset($Connection, 'latin1');
        $DatabaseAvailable = true;
    } catch (mysqli_sql_exception $e) {
        $DatabaseAvailable = false;
    }
    if (!$DatabaseAvailable) {
        ?><h2>Website wordt op dit moment onderhouden.</h2><?php
        die();
    }

    return $Connection;
}

function getHeaderStockGroups($databaseConnection) {
    $Query = "
                SELECT StockGroupID, StockGroupName, ImagePath
                FROM stockgroups 
                WHERE StockGroupID IN (
                                        SELECT StockGroupID 
                                        FROM stockitemstockgroups
                                        ) AND ImagePath IS NOT NULL
                ORDER BY StockGroupID ASC";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $HeaderStockGroups = mysqli_stmt_get_result($Statement);
    return $HeaderStockGroups;
}

function getStockGroups($databaseConnection) {
    $Query = "
            SELECT StockGroupID, StockGroupName, ImagePath
            FROM stockgroups 
            WHERE StockGroupID IN (
                                    SELECT StockGroupID 
                                    FROM stockitemstockgroups
                                    ) AND ImagePath IS NOT NULL
            ORDER BY StockGroupID ASC";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $StockGroups = mysqli_fetch_all($Result, MYSQLI_ASSOC);
    return $StockGroups;
}

function getStockItem($id, $databaseConnection) {
    $Result = null;

    $Query = " 
           SELECT SI.StockItemID, 
            (RecommendedRetailPrice*(1+(TaxRate/100))) AS SellPrice, 
            StockItemName,
            CONCAT('Voorraad: ',QuantityOnHand)AS QuantityOnHand,
            SearchDetails, 
            (CASE WHEN (RecommendedRetailPrice*(1+(TaxRate/100))) > 50 THEN 0 ELSE 6.95 END) AS SendCosts, MarketingComments, CustomFields, SI.Video,
            (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath   
            FROM stockitems SI 
            JOIN stockitemholdings SIH USING(stockitemid)
            JOIN stockitemstockgroups ON SI.StockItemID = stockitemstockgroups.StockItemID
            JOIN stockgroups USING(StockGroupID)
            WHERE SI.stockitemid = ?
            GROUP BY StockItemID";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $id);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    if ($ReturnableResult && mysqli_num_rows($ReturnableResult) == 1) {
        $Result = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC)[0];
    }

    return $Result;
}

function getStockItemImage($id, $databaseConnection) {

    $Query = "
                SELECT ImagePath
                FROM stockitemimages 
                WHERE StockItemID = ?";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $id);
    mysqli_stmt_execute($Statement);
    $R = mysqli_stmt_get_result($Statement);
    $R = mysqli_fetch_all($R, MYSQLI_ASSOC);

    return $R;
}

// Marijn en Patrick
function addToOrder($naam) {

    $databaseConnection = connectToDatabase();

    // klant id
    $klantquery = mysqli_prepare($databaseConnection, "SELECT ID FROM website_customers WHERE name=?");
    mysqli_stmt_bind_param($klantquery, 's', $naam);
    mysqli_stmt_execute($klantquery);
    $ID = mysqli_stmt_get_result($klantquery);
    if ($ID && mysqli_num_rows($ID)==1) {
        $ID = intval(mysqli_fetch_all($ID, MYSQLI_ASSOC)[0]['ID']);
    }else {
        return;
    }

    foreach ($_SESSION['cart'] as $key => $value)
    {
        // order
        $orderquery = mysqli_prepare($databaseConnection, "INSERT INTO website_orders(klantID) VALUES (?)");
        mysqli_stmt_bind_param($orderquery, 'i', $ID);
        mysqli_stmt_execute($orderquery);

        $orderID = mysqli_stmt_insert_id($orderquery);

        // orderline
        $item = getStockItem($key, $databaseConnection);

        $productID = $item['StockItemID'];
        $prijs = $item['SellPrice'];

        $statement = mysqli_prepare($databaseConnection,"INSERT INTO website_orderlines(orderID, productID, prijs, aantal) VALUES (?,?,?,?)");
        mysqli_stmt_bind_param($statement, 'iiii', $orderID,$productID, $prijs, $value);
        mysqli_stmt_execute($statement);

        // update product count
        decreaseProductCount($key, $value);
    }

    mysqli_close($databaseConnection);

    return true;
}

// Patrick
function decreaseProductCount($id, $count)
{
    $databaseConnection = connectToDatabase();

    $query = mysqli_prepare($databaseConnection, "UPDATE stockitemholdings SET QuantityOnHand = QuantityOnHand - ?
        WHERE StockItemID = ?");
        mysqli_stmt_bind_param($query, 'ii', $count, $id);
        mysqli_stmt_execute($query);

    mysqli_close($databaseConnection);
    return true;
}
