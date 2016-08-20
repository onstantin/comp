<?php 	
	error_reporting(E_ALL);
	require __DIR__."/vendor/autoload.php";

$api = new \Yandex\Geo\Api();

if (isset($_GET['adress'])) {
	$adr = $_GET['adress'];

	$api->setQuery($adr);

	// Настройка фильтров
	$api
		->setLimit(1) // кол-во результатов
		->setLang(\Yandex\Geo\Api::LANG_RU) // локаль ответа
		->load();

	$response = $api->getResponse();
	$response->getFoundCount(); // кол-во найденных адресов
	$response->getQuery(); // исходный запрос
	$response->getLatitude(); // широта для исходного запроса
	$response->getLongitude(); // долгота для исходного запроса

	// Список найденных точек
	$collection = $response->getList();
	foreach ($collection as $item) {
		//$item->getAddress(); // вернет адрес
		$koord = "Координаты по адресу <i>$adr</i>: ".$item->getLatitude()." ".$item->getLongitude(); // широта
		$url = "https://static-maps.yandex.ru/1.x/?ll=".$item->getLongitude().",".$item->getLatitude()."&spn=0.002,0.002&pt=".$item->getLongitude().",".$item->getLatitude().",flag&l=map";
		$img = "<img src=\"".$url."\">";
	}	
} 	
	else {
		$koord = "";
		$img = "";
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Координаты</title>
	<meta charset="utf-8">
	<link type="text/css" href="style.css" rel="stylesheet" charset="utf-8"> 
</head>
<body> 
	<p>Введите адрес:</p>
	<form action="" method="get">
		<input type="text" name="adress">
		<button>OK</button>
	</form>
	
	<p><?= $koord ?></p>
	<p><?= $img ?></p>
</body> 	
</html>