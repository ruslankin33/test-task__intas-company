<?php

// Выборка занятых курьеров

require_once('filterTrips.php');

$regionPot = $_POST['region'];	// Значение региона, которое пользователь изменяет в форме

//	Время в пути выбранного региона
$queryRouteTime = "SELECT route_time FROM regions WHERE name = ?";
$stmtRT = $pdo->prepare($queryRouteTime);
$stmtRT->execute([$regionPot]);
$resultRT = $stmtRT->fetch(PDO::FETCH_NUM);
$route_time = $resultRT[0];

//	Массив с днями, которые курьер потенциально будет находиться в пути (в зависимости от выбираемых пользователем данных Даты и Региона)
$potDates = [];
for ($i = $dateTrip; $i < $dateTrip + $route_time * 86400; $i += 86400) {
	$potDates[] = date('Y-m-d', $i);
}

$busyCouriers = [];
foreach ($trips as $trip) {	//	Перебор массива с поездками
	$stt = strtotime($trip['date']);
	for ($j = $stt, $x = $trip['route_time']; $j < $stt + $x * 86400; $j += 86400) {	// Перебор дней, когда курьер находится в пути
		$day = date('Y-m-d', $j);
		if (in_array($day, $potDates)) {	// Сравнение дня, когда курьер находится в пути, с днями, когда курьер потенциально должен быть в пути
			$busyCouriers[] = $trip['courier'];	// Сохранение в массив занятого курьера в выбираемый День и Регион
		}
	}
}

$uniqueMassiv = array_unique($busyCouriers);	// Выборка уникальных значений
echo json_encode($uniqueMassiv);