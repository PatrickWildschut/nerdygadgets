<?php
include "database.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kortingscode</title>
</head>
<body>
<h1 class="titels">Nieuwe kortingscode</h1>

<form method="get" action="Kortingscode.php">
    Naam: <input type="text" name="Naam" value="<?php if(empty($_GET['Naam'])){print("");}    else{print($_GET['Naam']);} ?>"> <br>
    Aantal procent korting: <input type="number" name="KortingPercentage" min="0" max="100" value="<?php if(empty($_GET['KortingPercentage'])){print("");}    else{print($_GET['KortingPercentage']);} ?>"> <br>
    <input type="submit" name="AanmakenCode" value="Aanmaken Code">

</form>
<?php
if(isset($_GET['AanmakenCode'])) {

    $naam = $_GET['Naam'];
    $discountpercentage = $_GET['KortingPercentage'];
    NewDiscount($naam,$discountpercentage);
}

?>

</body>
</html>
