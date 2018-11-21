<?php
require_once('db.php');

// Получение поездок с актуальными датами ( отфильтровываются старые поездки )

date_default_timezone_set('Europe/Moscow');
$dateTrip = strtotime($_POST['date']);	// дата, выбранная в календаре
$filter_min = date('Y-m-d', $dateTrip - 3 * 86400);		// минимальная актуальная дата поездки (исходя из максимального времени в пути, у нас это 4 дня )

// Запрос в БД и получение ассоциативного массива с ключами Дата, Курьер, Регион и Время в пути
$queryTrips = "SELECT t.date, c.name as courier, r.name as region, r.route_time FROM trips t INNER JOIN couriers c ON t.courier_id = c.courier_id INNER JOIN regions r ON t.region_id = r.region_id WHERE t.date >= ?";
$stmt_filter = $pdo->prepare($queryTrips);
$stmt_filter->execute([$filter_min]);
$trips = $stmt_filter->fetchAll(PDO::FETCH_ASSOC);

// Данный скрипт в последствии добавляется к двум другим скриптам