<?php
require_once ('data.php');	// Скрипт вовращает два массива: всех курьеров и все регионы
?>

<!DOCTYPE html>
<html>
<head>
	<title>Расписание</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/ion.calendar.css">
	<link rel="stylesheet" type="text/css" href="css/normalize.min.css">
</head>
<body>
	<div class="container">
		<div class="wrap">
			<div class="myCalendar" id="myCalendar-1"></div>
			<div class="result" id="result-1"></div>
		</div>
		<div class="form">
			<h4>Назначить новую поездку<br></h4>
			<form id="add_trip" action="add.php" method="post">
				<p>Выберите регион:<br>
					<select id="city" class="js-arriveTime" name="region" value="Выберите город" >
					    <?php foreach ($regions as $region): ?>
					    	<option value="<?= $region['name'] ?>"><?= $region['name'] ?></option>
						<?php endforeach; ?>
				  	</select>
				</p>
				<p>Выберите дату выезда из Москвы:<br>
					<input id="depart" class="js-arriveTime" type="date" name="date" required/>
				</p>
				<p>Выберите курьера:<br>
					<select id="couriers" name="courier">
						<?php foreach ($couriers as $courier): ?>
					    	<option value="<?= $courier['name'] ?>"><?= $courier['name'] ?></option>
						<?php endforeach; ?>
				  	</select>
				</p>
				<p>Время прибытия в регион:<br>
					<span id="arrive"></span>
				</p>
				<input type="submit" value="Отправить">
			</form>
		</div>
	</div>
	<script src="js/jquery.min.js"></script>
	<script src="js/moment-with-locales.min.js"></script>
	<script src="js/ion.calendar.min.js"></script>
	<script src="js/main.js"></script>
</body>
</html>