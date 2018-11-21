<?php
require_once('db.php');

$resultReg = $pdo->query("SELECT name FROM regions");
$rowReg = $resultReg->fetchAll(PDO::FETCH_ASSOC);
$regions = [];
foreach ($rowReg as $value) {
	$regions[] = $value['name'];
}

$resultCour = $pdo->query("SELECT name FROM couriers");
$rowCour = $resultCour->fetchAll(PDO::FETCH_ASSOC);
$couriers = [];
foreach ($rowCour as $value) {
	$couriers[] = $value['name'];
}

$dateStart = strtotime('2018-06-01');
$dateFinish = strtotime('2018-11-15');

$params = [];
foreach ($couriers as $key => $value) {
	for ($i = $dateStart + $key * 86400; $i < $dateFinish; $i += 4 * 86400) {
		$params[] = [':region' => $regions[array_rand($regions, 1)], ':date' => date('Y-m-d', $i), ':courier' => $value];
	}
}

$sql = "INSERT INTO trips SET date = :date, region_id = (SELECT region_id FROM regions WHERE name = :region), courier_id = (SELECT courier_id FROM couriers WHERE name = :courier)";
$stmt = $pdo->prepare($sql);
foreach ($params as $param) {
	$stmt->execute($param);
}

echo "Успешно заполнено";