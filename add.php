<?php
require_once('db.php');

//	Добавление новой поездки в БД

if ( empty($_POST['courier']) ) {

	echo 'Данный курьер занят, выберите другого курьера';

} else {

	// Методом POST получаем данные о поездке
	$regionAdd = $_POST['region'];
	$dateAdd = $_POST['date'];
	$courierAdd = $_POST['courier'];

	// Добавляем новую поездку в БД
	$sql = "INSERT INTO trips SET date = :date, region_id = (SELECT region_id FROM regions WHERE name = :region), courier_id = (SELECT courier_id FROM couriers WHERE name = :courier)";
	$params = [':date' => $dateAdd, ':region' => $regionAdd, ':courier' => $courierAdd];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($params);

	echo 'Запись успешно внесена!';
}

