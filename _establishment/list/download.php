<?php 
include_once('../../_common.php');
include_once(G5_LIB_PATH.'/PHPExcel.php');
define('menu_establishment', true);

$work = sql_fetch("select * from {$none['worksite']} where seq = '$seq'");


ob_start();
require_once ('../write/include/menu1_inc.php');
$content[0] = ob_get_contents();
ob_end_clean();

ob_start();
require_once ('../write/include/menu2_inc.php');
$content[1] = ob_get_contents();
ob_end_clean();



//echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";


$objPHPExcel = new PHPExcel();



$rocketPunch = array("정산보고서", "정산서", "노임(인부정보)", "노임(용역회사)", "노임대장", "식대", "전도금 정산서", "집행내역서");


// @breif Worksheet 라는 이름으로 생성되는 기본 시트를 삭제한다.

$objPHPExcel -> removeSheetByIndex(0);


// @breif 생성할 시트의 순번

$sheetNum = 0;

for($i=0; $i<=count($rocketPunch)-1; $i++) {

	$tit = $rocketPunch[$i];

    // @breif createSheet( ) 함수로 새로운 시트를 생성한다.

    $objWorkSheet = $objPHPExcel -> createSheet($i);

    // @breif 엑셀 시트 이름 지정
    $objWorkSheet -> setTitle($tit);
    $objWorkSheet -> setCellValue('A1', $content[$i]);

	

    $sheetNum++;

}



// @breif 문서를 오픈할 시 첫번째 시트로 열리게 설정

$objPHPExcel -> setActiveSheetIndex(0);



// @breif 파일의 저장형식이 utf-8일 경우 한글파일 이름은 깨지므로 euc-kr로 변환해준다.

$filename = iconv("UTF-8", "EUC-KR", "기성청구서");



header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

header('Content-Transfer-Encoding: binary');

header('Cache-Control: must-revalidate');
header('Pragma: public');

header("Content-Disposition: attachment;filename=".$filename.".xls");

header("Cache-Control:max-age=0");



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");

$objWriter -> save("php://output");

?>