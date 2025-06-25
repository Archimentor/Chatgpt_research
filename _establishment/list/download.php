<?php
include_once('../../_common.php');
include_once(G5_LIB_PATH.'/PHPExcel.php');
define('menu_establishment', true);

$work = sql_fetch("select * from {$none['worksite']} where seq = '$seq'");

$sheetMap = [
    1  => '정산보고서',
    2  => '정산서',
    3  => '노임(인부정보)',
    14 => '노임(용역회사)',
    4  => '노임대장',
    5  => '식대',
    6  => '전도금 정산서',
    7  => '집행내역서(외주)',
    8  => '철근/레미콘현황',
    9  => '집행내역서(자재)',
    10 => '집행내역서(장비)',
    11 => '집행내역서(노무비)',
    12 => '집행내역서(기타경비)',
    13 => '특기사항'
];

$objPHPExcel = new PHPExcel();
$objPHPExcel->removeSheetByIndex(0);

$idx = 0;
foreach ($sheetMap as $no => $title) {
    $inc = "../write/include/menu{$no}_inc.php";
    $excel = "../write/include/menu{$no}_excel.php";

    ob_start();
    if (file_exists($excel)) {
        include $excel;
    } elseif (file_exists($inc)) {
        include $inc;
    }
    $html = ob_get_clean();

    if (trim($html) === '') {
        continue;
    }

    $temp = tempnam(sys_get_temp_dir(), 'xls');
    file_put_contents($temp, $html);

    $reader = new PHPExcel_Reader_HTML();
    $reader->setSheetIndex($idx);
    $objPHPExcel = $reader->loadIntoExisting($temp, $objPHPExcel);
    $objPHPExcel->getActiveSheet()->setTitle($title);
    unlink($temp);
    $idx++;
}

$objPHPExcel->setActiveSheetIndex(0);
$filename = iconv('UTF-8', 'EUC-KR', '기성청구서') . '.xls';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename=' . $filename);
header('Cache-Control: max-age=0');

$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$writer->save('php://output');
