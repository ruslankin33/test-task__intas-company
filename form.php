<?php
require_once ('db.php');

//	Вычисление даты прибытия в регион

// Данные о потенциальной поездке
$dateForm = $_POST['date'];
$regionForm = $_POST['region'];

if ( empty($dateForm) ) {

	echo "Выберите дату";

} else {

	// Получение из БД значения времени в пути
	$queryReg = "SELECT route_time FROM regions WHERE name = ?";
	$stmt = $pdo->prepare($queryReg);
	$stmt->execute([$regionForm]);
	$rowReg = $stmt->fetch(PDO::FETCH_NUM);
	
	$x = $rowReg[0];	// Преобразование полученного значения из массива в число
	if ($x == 1) {
		$y = strtotime($dateForm);	// Если время в пути равно одному дню, то дата прибытия в регион равна дате отправления
	} else {
		$y = strtotime($dateForm) + ceil($x / 2) * 86400;	// Если время в пути больше одного дня, то вычисляется дата прибытия в регион
	}
	$z = date('d.m.Y', $y);	// Преобразование времени в удобочитаемый вид
	echo $z;

}