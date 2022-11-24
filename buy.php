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

	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d155984.57352126975!2d5.46216585!3d52.347588349999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c63a4fa67cac6b%3A0xef03e8338facf090!2sZeewolde!5e0!3m2!1snl!2snl!4v1669198330061!5m2!1snl!2snl" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

	<input type="submit" name="" value="Afrekenen">
</form>
</div>
<?php
include __DIR__ . "/footer.php";
?>