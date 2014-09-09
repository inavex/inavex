<?php

if (!$_GET) {
	return false;
	exit;
}


/*
 * Получаем данные и проверяем
 */
//foreach($_POST as $dataFromPost){
//	if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i" ,$dataFromPost) === 0) {
//		$result = array(
//			'errors' => 'notValidSymbols'
//		);
//		header("Content-Type: application/json");
//		echo json_encode($result);
//		exit;
//	}
//}

require('phpQuery.php');

$artikul = $_GET['artikul'];


//exist.ru

$siteExist = file_get_contents('http://www.exist.ru/price.aspx?pcode='.$artikul);
$document = phpQuery::newDocument($siteExist);
$price['exist'] = $document->find('table.tbl .price')->html();


//www.autopiter.ru

//$sitePiter = file_get_contents('http://www.autopiter.ru/Home/PriceList?NumDetail='.$artikul.'&isFullSearch=true');
//$document = phpQuery::newDocument($sitePiter);
//$price['autopiter'] = $document->find('.w-tbl .a-alt td:eq(5)')->html();


//www.autodoc.ru

$siteDoc = file_get_contents('http://www.autodoc.ru/Web/price/art/'.$artikul);
$document = phpQuery::newDocument($siteDoc);
$price['autodoc'] = $document->find('#gridDetails tr:eq(1) td:eq(0)')->html();


header("Content-Type: application/json");
echo json_encode($price);

//var_dump($price);