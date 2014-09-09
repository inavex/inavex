<?php
/**
 * User: Oknemi
*/
require_once 'PHPWord.php';

include '../calc2.php';

// New Word Document
$PHPWord = new PHPWord();

if ($_POST['type-vozrast'] == "1") {
    $document = $PHPWord->loadTemplate('calcTemplate.docx');
    $years = years($_POST['date-ts'], $_POST['date-dtp']);
    $yearsAccum = years($_POST['fact-acum'], $_POST['date-dtp']);
} elseif ($_POST['type-vozrast'] == "2") {
    $document = $PHPWord->loadTemplate('calcTemplateMRSE.docx');
    $years = $result['yearsByMR'];
    $yearsAccum = yearsByMR($_POST['fact-acum'], $_POST['date-dtp'], $_POST['type-vozrast']);
}

$battery = ($result['depreciationBattery'] == 'noDataForBattery') ? '' : $result['depreciationBattery'].'%';
$tires = ($result['depreciationTires'] == 'noDataForTires') ? '' : $result['depreciationTires'].'%';

$document->setValue('Value1', $result['depreciationBody'].'%');
$document->setValue('Value2', $result['depreciationPlastic'].'%');
$document->setValue('Value3', $result['depreciationOfOtherParts'].'%');
$document->setValue('Value4', $tires);
$document->setValue('Value5', $battery);
$document->setValue('Value6', $_POST['gsk']);
$document->setValue('Value7', $delta[$_POST['deltaId']]['0']);
$document->setValue('Value8', $years);
$document->setValue('Value9', $delta[$_POST['deltaId']]['1']);
$document->setValue('Value10', $_POST['probeg-ts']);
$document->setValue('Value11', $_POST['new-height-shina']);
$document->setValue('Value12', $_POST['fact-hp']);
$document->setValue('Value13', $_POST['minHeight']);
$document->setValue('Value14', $yearsAccum);
$document->setValue('Value15', normativeBattery($_POST['probeg-ts'], years($_POST['date-ts'], $_POST['date-dtp'])));


// // save as a random file in temp file
$temp_file = tempnam(sys_get_temp_dir(), 'calc');
$document->save($temp_file);

// Your browser will name the file "myFile.docx"
// regardless of what it's named on the server
header("Content-Disposition: attachment; filename='расчет_износа_inavex.ru.docx'");
readfile($temp_file); // or echo file_get_contents($temp_file);
unlink($temp_file);  // remove temp file