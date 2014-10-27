<?php
/**
 * User: Oknemi
*/

if (!$_POST) {
    return false;
    exit;
}


/*
 * Получаем данные и проверяем
 */
foreach($_POST as $dataFromPost){
    if (preg_match("/^[0-9.]{0,20}$/",$dataFromPost) === 0) {
        $result = array(
            'errors' => 'notValidSymbols'
        );
        header("Content-Type: application/json");
        echo json_encode($result);
        exit;
    }
}


// Список значения коэффициентов
$delta = array(
    array(),
    array( "0.057", "0.0030" ),
    array( "0.057", "0.0029" ),
    array( "0.042", "0.0023" ),
    array( "0.045", "0.0024" ),
    array( "0.052", "0.0026" ),
    array( "0.049", "0.0025" ),
    array( "0.077", "0.0023" ),
    array( "0.113", "0.0008" ),
    array( "0.098", "0.0008" ),
    array( "0.09", "0" ),
    array( "0.06", "0" ),
    array( "0.07", "0" ),
    array( "0.09", "0" ),
    array( "0.15", "0" ),
    array( "0.04", "0" )
);


/**
 * Возраст в годах
 * @param $date1
 * @param $date2
 * @return int
 */
function years($date1, $date2) {
    if (!isset($date1, $date2)) {
        return false;
    }

    $date1 = new DateTime($date1);
    $date2 = new DateTime($date2);

    return $date1->diff($date2)->y;
}


/**
 * Средний пробег
 * @param $mileage
 * @param $years
 * @return float
 */
function averageMileage($mileage, $years) {
    if (!isset($mileage, $years) && $years != '0') {
        return false;
    } elseif ($years != '0') {
        return $mileage / $years;
    }
}


/**
 * Считаем "Износ несъемных элементов кузова транспортного средства принимается равным"
 * е - основание натуральных логарифмов (е приблизительно равно 2,72);
 * @param $tKuz
 * @param $tSk - гарантия от сквозной коррозии кузова предоставляемая производителем АМТС (лет).
 * @internal param $dateOfTs
 * @internal param $dateDtp
 * @internal param $dateNow
 * @internal param $tKuz - возраст кузова транспортного средства (лет)
 * @return float
 */
function calcDepreciationBody($tKuz, $tSk) {
    $result = round(100 * (  1 - pow(2.72, -(4 * $tKuz)/(20+4 * $tSk)) ), 2);
    return ($result > 50) ? '50' : $result;
}


/**
 * Считаем "Износ шины АМТС рассчитывается по формуле"
 * @param $Nn - высота рисунка протектора новой шины (миллиметров);
 * @param $Nf - фактическая высота рисунка протектора шины (миллиметров);
 * @param $Ndop - минимально допустимая высота рисунка протектора шины по требованиям законодательства РФ (миллиметров).
 * @param $dateOfShina
 * @param $dateNow
 * @return float
 * @internal param $date
 * @internal param $years - возраст шины
 */
function calcDepreciationTires($Nn, $Nf, $Ndop, $dateOfShina, $dateNow) {
    if (empty($Nn) || empty($Nf) || empty($Ndop) || empty($dateOfShina)) {
        return 'noDataForTires';
    }

    // Считаем возраст шины
    $years = years($dateOfShina, $dateNow);

    $result = (($Nn-$Nf)/($Nn-$Ndop)) * 100;

    // @TODO Уточнить у заказчика алгоритм работы, добавлять к результатам процентов или добавлять к процентам при вычеслении
    // Износ шины дополнительно увеличивается
    // для шин с возрастом от 3 до 5 лет - на 15 процентов,
    // свыше 5 лет - на 25 процентов.

    if ($years > 2 && $years < 6) {
        //Пока считаем как в программе
        //$result = $result + (($result * 15)/100);
        $result += 15;
    } elseif ($years > 5) {
        //$result = $result + (($result * 25)/100);
        $result += 25;
    }

    $result = round($result, 2);

    return ($result > 50) ? '50' : $result;
}


/**
 * Износ аккумуляторной батареи ТС
 * @param $Tak - Дата выпуска аккумуляторной батареи
 * @param $years
 * @param $dateNow
 * @param $mileage
 * @internal param $dateOfTs
 * @return float|int
 */
function calcDepreciationBattery($Tak, $years, $dateNow, $mileage){

    if (empty($Tak)){
        return 'noDataForBattery';
    }

    // Считаем нормативный срок службы
    if (averageMileage($mileage, $years) <= 40000) {
        $normativeAge = 4;
    }
    elseif (averageMileage($mileage, $years) > 40000) {
        $normativeAge = 3;
    }

    // Считаем возраст аккамулятора
    $ageOfTheBattery = years($Tak, $dateNow);

    $result = ($ageOfTheBattery/$normativeAge) * 100;

    // Не может быть больше 80%
    if ($result > 50) {
        $result = 50;
    }

    return round($result,2);
}


/**
 * Нормативный срок службы акумулятора
 * @param $mileage
 * @param $years
 * @return int
 */
function normativeBattery($mileage, $years) {
    if (averageMileage($mileage, $years) <= 40000) {
        return 4;
    }
    elseif (averageMileage($mileage, $years) > 40000) {
        return 3;
    }
}


/**
 * Износ пластиковых деталей
 * @param $releaseDateOfVehicle
 * @param $dateNow
 * @return float
 */
function calcDepreciationPlastic($ageOfVehicle) {
    $result = 100 * ( 1 - pow(2.72, -(0.1 * $ageOfVehicle)));
    $result = round($result,2);
    return ($result > 50) ? '50' : $result;
}


/**
 * Период времени, с даты выпуска АМТС до момента, на который рассчитывается износ (дата ДТП), определяется в годах с точностью до одного знака после запятой.
 * @param $date1
 * @param $date2
 * @return bool|float|int
 */
function yearsByMR($date1, $date2) {

    if (!isset($date1, $date2)) {
        return false;
    }
    $date1 = explode('.', $date1);
    $date1 = $date1[2].'-'.$date1[1].'-'.$date1[0];

    $date2 = explode('.', $date2);
    $date2 = $date2[2].'-'.$date2[1].'-'.$date2[0];

    $diff = abs(strtotime($date2) - strtotime($date1));

    $ageOfVehicleYears = floor($diff / (365*60*60*24));
    $ageOfVehicleMonth = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
    #$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24) / (60*60*24));

    return round($ageOfVehicleMonth*0.08);


}


/**
 * Износ остальных деталей, узлов и агрегатов ТС
 * @param $delta
 * @param $idOfDelta
 * @param $releaseDateOfVehicle
 * @param $dateNow
 * @param $mileage
 * @return float
 */
function depreciationOfOtherParts($delta, $idOfDelta, $mileage, $ageOfVehicle) {
    $result = 100 * ( 1 - pow(2.72, -( $delta[$idOfDelta]['0']*$ageOfVehicle + $delta[$idOfDelta]['1']*($mileage / 1000) )) );
    $result = round($result, 2);
    return ($result > 50) ? '50' : $result;
}


function getTypeOfYears($date1, $date2, $typevozrast) {
    //if ($typevozrast == "1") {
    //    return years($date1, $date2);
    //} else if ($typevozrast == "2") {
    return yearsByMR($date1, $date2);
    //}
}

$result = array(
    'depreciationBody' => calcDepreciationBody(getTypeOfYears($_POST['date-ts'], $_POST['date-dtp'], $_POST['type-vozrast']), $_POST['gsk']),
    'depreciationTires' => calcDepreciationTires($_POST['new-height-shina'], $_POST['fact-hp'], $_POST['minHeight'], $_POST['fact-shina-date'], $_POST['date-dtp']),
    'depreciationBattery' => calcDepreciationBattery($_POST['fact-acum'], getTypeOfYears($_POST['date-ts'], $_POST['date-dtp'], $_POST['type-vozrast']), $_POST['date-dtp'], $_POST['probeg-ts']),
    'depreciationPlastic' => calcDepreciationPlastic(getTypeOfYears($_POST['date-ts'], $_POST['date-dtp'], $_POST['type-vozrast'])),
    'depreciationOfOtherParts' => depreciationOfOtherParts($delta, $_POST['deltaId'], $_POST['probeg-ts'], getTypeOfYears($_POST['date-ts'], $_POST['date-dtp'], $_POST['type-vozrast'])),
    'ageOfVehicle' => years($_POST['date-ts'], $_POST['date-dtp']),
    'yearsByMR' => yearsByMR($_POST['date-ts'], $_POST['date-dtp'], $_POST['type-vozrast']),
    'annualMileage' => round(averageMileage($_POST['probeg-ts'], getTypeOfYears($_POST['date-ts'], $_POST['date-dtp'], $_POST['type-vozrast'])), 0),
    'delta' => $delta[$_POST['deltaId']]
);


if ((
        $result['depreciationBody'] +
        $result['depreciationTires'] +
        $result['depreciationBattery'] +
        $result['depreciationPlastic'] +
        $result['depreciationOfOtherParts'] +
        $result['ageOfVehicle'] +
        $result['yearsByMR'] +
        $result['annualMileage']) == 0) {
    header("Content-Type: application/json");
    $result = array(
        'errors' => 'noData',
        'delta' => $delta[$_POST['deltaId']]
    );
    echo json_encode($result);
    exit;
}