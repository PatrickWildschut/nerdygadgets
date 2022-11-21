<?php
include __DIR__ . "/header.php";
?>

<div class="center">
<form>
	Naam: <input type="text" name="naam" required>
	Adres: <input type="text" name="adres" required>
	Plaats: <input type="text" name="plaats" required>
	Email: <input type="text" name="email" required> <br> <br>

	<div class="center" style="border: none;">
	<select name="betaalwijze">
  		<option value="rabobank">Rabobank</option>
  		<option value="ing">ING</option>
  		<option value="abnamro">ABN Amro</option>
  		<option value="asnbank">ASN Bank</option>
	</select>
	</div>

	<input type="submit" name="" value="Afrekenen">
</form>
</div>
<?php
include __DIR__ . "/footer.php";
?>