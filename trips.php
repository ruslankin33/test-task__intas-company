<?php

// Перебор поездок с актуальными датами для получения информации по поездкам на определённую дату

require_once('filterTrips.php');

foreach ($trips as $trip) {
	$stt = strtotime($trip['date']);
	for ($i = $stt, $x = $trip['route_time']; $i < $stt + $x * 86400; $i += 86400) {	// Перебор дней, когда курьер находится в пути
		if (date('Y-m-d', $i) == date('Y-m-d', $dateTrip)) {	// Сравнение дня, когда курьер в пути, с выбранным в календаре днём
			echo "Курьер: " . $trip['courier'] . "<br>";
			echo "Пункт доставки: " . $trip['region'] . "<br>";
			echo "Дата выезда из Москвы: " . date('d.m.Y', $stt) . "<br>";
			echo "Дата прибытия в Москву: " . date('d.m.Y', $stt + ($x-1) * 86400) . "<br><hr>";
		}
	}
}

