<!-- de inhoud van dit bestand wordt bovenaan elke pagina geplaatst -->
<?php
session_start();
include "database.php";
$databaseConnection = connectToDatabase();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>NerdyGadgets</title>

    <!-- Javascript -->
    <script src="Public/JS/fontawesome.js"></script>
    <script src="Public/JS/jquery.min.js"></script>
    <script src="Public/JS/bootstrap.min.js"></script>
    <script src="Public/JS/popper.min.js"></script>
    <script src="Public/JS/resizer.js"></script>

    <!-- Style sheets-->
    <link rel="stylesheet" href="Public/CSS/style.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/typekit.css">
</head>
<body>
<div class="Background">
    <div class="row" id="Header">
        <div class="col-2"><a href="./" id="LogoA">
                <div id="LogoImage"><img src="Public/Img/LogoNerdyGadgets.png" width="275px" height="80px"></div>
            </a></div>
        <div class="col-8" id="CategoriesBar">
            <ul id="ul-class">
                <?php
                $HeaderStockGroups = getHeaderStockGroups($databaseConnection);

                foreach ($HeaderStockGroups as $HeaderStockGroup) {
                    ?>
                    <li>
                        <a href="browse.php?category_id=<?php print $HeaderStockGroup['StockGroupID']; ?>"
                           class="HrefDecoration"><?php print $HeaderStockGroup['StockGroupName']; ?></a>
                    </li>
                    <?php
                }
                ?>
                <li>
                    <a href="categories.php" class="HrefDecoration">Alle categorieën</a>
                </li>
            </ul>
        </div>
<!-- code voor US3: zoeken -->
        <?php
        if (!isset($_SESSION['aantalProducts'])) // Thom: variabele bestaat niet? (!)
        {
            $_SESSION['aantalProducts'] = 0; // $_SESSION voor uitwisseling variabele tussen cart.php en header.php
        }
        if ($_SESSION['aantalProducts'] >= 1) { // zo ja, indicatie zichtbaar maken
        ?>
        <div class="indicatie"> <!-- Printen visuele indicatie -->
            <p class="popup"><?php print($_SESSION['aantalProducts']);?></p>
        </div>
        <?php
        }
        ?>

        <ul id="ul-class-navigation">

            <li class="winkelmand">
                <a href="cart.php" >
                    <img src="Public/Img/winkelmand.png" width="40px" height="40px">
                </a>
            </li>

            <li>
                <a href="browse.php" class="HrefDecoration"><i class="fas fa-search search"></i> Zoeken</a>
            </li>
        </ul>

<!-- einde code voor US3 zoeken -->
    </div>
    <div class="row" id="Content">
        <div class="col-12">
            <div id="SubContent">


