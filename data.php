<?php
require_once('db.php');

// Получение перечня всех курьеров в виде массива
$resultCour = $pdo->query("SELECT name FROM couriers");
$couriers = $resultCour->fetchAll(PDO::FETCH_ASSOC);

// Получение перечня всех городов в виде массива
$resultReg = $pdo->query("SELECT name FROM regions");
$regions = $resultReg->fetchAll(PDO::FETCH_ASSOC);