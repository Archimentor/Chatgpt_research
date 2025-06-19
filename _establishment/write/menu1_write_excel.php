<?php 
include_once('../../_common.php');
define('menu_establishment', true);

if($w == 'u') {
	
	$row = sql_fetch("select * from {$none['smart_list']} where seq = '$seq'");
	
	if(!$row)
		alert('데이터가 삭제되었거나 이동되었습니다.');
		
	$work_id = $row['work_id'];
	$date = $row['ns_date'];
}




if($w == '') {
	
	$work = sql_fetch("select * from {$none['worksite']} where seq = '$seq'");

}

if(!$_GET['date']) {
	$date = date('Y-m');
	
}
$preDate = date('Y-m', strtotime($date." -1 Month"));
$nxtDate = date('Y-m', strtotime($date." +1 Month"));

switch($index) {
	case 1 :
	$file_name = "_01 정산보고서.xls";
	$file_name2 = "정산보고서";
	break;
	case 2 :
	$file_name = "_02 정산서.xls";
	$file_name2 = "정산서";
	break;
	case 3 :
	$file_name = "_03 노임(인부정보).xls";
	$file_name2 = "노임(인부정보)";
	break;
	case 14 :
	$file_name = "_04 노임(용역회사).xls";
	$file_name2 = "노임(용역회사)";
	break;
	case 4 :
	$file_name = "_05 노임대장.xls";
	$file_name2 = "노임대장";
	break;
	case 5 :
	$file_name = "_06 식대.xls";
	$file_name2 = "식대";
	break;
	case 6 :
	$file_name = "_07 전도금정산서.xls";
	$file_name2 = "전도금 정산서";
	break;
	case 7 :
	$file_name = "_08 집행내역서(외주).xls";
	$file_name2 = "집행내역서(외주)";
	break;
	case 8 :
	$file_name = "_09 철근/레미콘현황.xls";
	$file_name2 = "철근/레미콘현황";
	break;
	case 9 :
	$file_name = "_10 집행내역서(자재).xls";
	$file_name2 = "집행내역(자재)";
	break;
	case 10 :
	$file_name = "_11 집행내역서(장비).xls";
	$file_name2 = "집행내역서(장비)";
	break;
	case 11 :
	$file_name = "_12 집행내역서(노무비).xls";
	$file_name2 = "집행내역서(노무비)";
	break;
	case 12 :
	$file_name = "_13 집행내역서(기타경비).xls";
	$file_name2 = "집행내역서(기타경비)";
	break;
	case 13 :
	$file_name = "_13 특기사항.xls";
	$file_name2 = "특기사항";
	break;
}

$file = $work['nw_code'].$file_name;
header( "Content-type: application/vnd.ms-excel; charset=utf-8");
header( "Content-Disposition: attachment; filename = \"{$file}\"" );     //filename = 저장되는 파일명을 설정합니다.
header( "Content-Description: PHP4 Generated Data" );
//if($index != 14 && $index >= 7) exit;
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 10">
<link rel=File-List href="aaaa.files/filelist.xml">
<link rel=Edit-Time-Data href="aaaa.files/editdata.mso">
<link rel=OLE-Object-Data href="aaaa.files/oledata.mso">


<!--[if gte mso 9]><xml>
 <x:ExcelWorkbook>
  <x:ExcelWorksheets>
   <x:ExcelWorksheet>
    <x:Name><?php echo $file_name2?></x:Name>
    <x:WorksheetOptions>
     <x:DefaultRowHeight>270</x:DefaultRowHeight>
     <x:Selected/>
     <x:DoNotDisplayGridlines/>
     <x:ProtectContents>False</x:ProtectContents>
     <x:ProtectObjects>False</x:ProtectObjects>
     <x:ProtectScenarios>False</x:ProtectScenarios>
    </x:WorksheetOptions>
   </x:ExcelWorksheet>
  </x:ExcelWorksheets>
  <x:WindowHeight>12720</x:WindowHeight>
  <x:WindowWidth>24960</x:WindowWidth>
  <x:WindowTopX>120</x:WindowTopX>
  <x:WindowTopY>30</x:WindowTopY>
  <x:ProtectStructure>False</x:ProtectStructure>
  <x:ProtectWindows>False</x:ProtectWindows>
 </x:ExcelWorkbook>
</xml><![endif]-->

<?php 
include_once('./include/menu'.$index.'_excel.php')?>
