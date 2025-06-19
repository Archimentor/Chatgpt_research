<?php
include_once($_SERVER['DOCUMENT_ROOT']."/core/common.php");
include_once($_SERVER['DOCUMENT_ROOT']."/classes/common.Class.php");


define('NONE_PATH', $_SERVER['DOCUMENT_ROOT']);
define('NONE_URL', 'http://gw.n1con.com'); //사내공간 도메인입력
define('NONE_HOME_URL', 'http://n1con.com/homepage/index.php'); //외부공간 도메인입력



define('NONE_TABLE_PREFIX', 'none_');

//db테이블
$none['worksite'] = NONE_TABLE_PREFIX.'worksite'; // 시공현황 
$none['worksite_add'] = NONE_TABLE_PREFIX.'worksite_add'; // 시공현황 계약추가
$none['smart_list'] = NONE_TABLE_PREFIX.'smart_list'; // 스마트일보 
$none['smart_jajae'] = NONE_TABLE_PREFIX.'smart_jajae'; // 스마트일보 자재
$none['smart_gongjong'] = NONE_TABLE_PREFIX.'smart_gongjong'; // 스마트일보 공종
$none['smart_machine'] = NONE_TABLE_PREFIX.'smart_machine'; // 스마트일보 장비
$none['owner_list'] = NONE_TABLE_PREFIX.'owner_list'; // 건축주
$none['enterprise_list'] = NONE_TABLE_PREFIX.'enterprise_list'; // 업체
$none['subcontract'] = NONE_TABLE_PREFIX.'subcontract'; // 하도급
$none['subcontract_add'] = NONE_TABLE_PREFIX.'subcontract_add'; // 하도급 계약추가
$none['repair_list'] = NONE_TABLE_PREFIX.'repair_list'; // 하자보수 
$none['repair_list2'] = NONE_TABLE_PREFIX.'repair_list2'; // 하자보증서발급현황
$none['repair_company'] = NONE_TABLE_PREFIX.'repair_company'; // 하자보증서 발급기관


$none['sales_list'] = NONE_TABLE_PREFIX.'sales_list'; // 통계-매출현황
$none['sign_line'] = NONE_TABLE_PREFIX.'sign_line'; // 전자결재 - 결제라인 설정


$none['sign_draft_comment'] = NONE_TABLE_PREFIX.'sign_draft_comment'; // 전자결재 - 댓글
$none['sign_draft'] = NONE_TABLE_PREFIX.'sign_draft'; // 전자결재 - 기안서
$none['sign_draft2'] = NONE_TABLE_PREFIX.'sign_draft2'; // 전자결재 - 지출결의서
$none['sign_draft3'] = NONE_TABLE_PREFIX.'sign_draft3'; // 전자결재 - 설계변경
$none['sign_draft4'] = NONE_TABLE_PREFIX.'sign_draft4'; // 전자결재 - 무상처리
$none['sign_draft6'] = NONE_TABLE_PREFIX.'sign_draft6'; // 전자결재 - 사고경위서


$none['est_noim'] = NONE_TABLE_PREFIX.'est_noim'; // 기성청구서 - 노임
$none['est_noim2'] = NONE_TABLE_PREFIX.'est_noim2'; // 기성청구서 - 노임대장
$none['est_jungsan'] = NONE_TABLE_PREFIX.'est_jungsan'; // 기성청구서 - 정산서
$none['est_jungsan_price'] = NONE_TABLE_PREFIX.'est_jungsan_price'; // 기성청구서 - 정산서(금회기성db)
$none['est_report'] = NONE_TABLE_PREFIX.'est_report'; // 기성청구서 - 정산보고서
$none['est_foodcost'] = NONE_TABLE_PREFIX.'est_foodcost'; // 기성청구서 - 식대
$none['est_imprest'] = NONE_TABLE_PREFIX.'est_imprest'; // 기성청구서 - 전도금정산서
$none['est_execution'] = NONE_TABLE_PREFIX.'est_execution'; // 기성청구서 - 집행내역서(외주)
$none['est_execution_txt'] = NONE_TABLE_PREFIX.'est_execution_txt'; // 기성청구서 - 집행내역서(외주) 하단 텍스트 DB
$none['est_concrete'] = NONE_TABLE_PREFIX.'est_concrete'; // 기성청구서 - 철근/레미콘
$none['est_concrete_price'] = NONE_TABLE_PREFIX.'est_concrete_price'; // 기성청구서 - 철근/레미콘 누계금액 db
$none['est_material'] = NONE_TABLE_PREFIX.'est_material'; // 기성청구서 - 자재
$none['est_equipment'] = NONE_TABLE_PREFIX.'est_equipment'; // 기성청구서 - 장비
$none['est_etc'] = NONE_TABLE_PREFIX.'est_etc'; // 기성청구서 - 기타
$none['est_nomu'] = NONE_TABLE_PREFIX.'est_nomu'; // 기성청구서 - 노무비
$none['est_nomu_confirm'] = NONE_TABLE_PREFIX.'est_nomu_confirm'; // 기성청구서 - 노임대장 작성,확인 저장용 테이블


$none['statistics4'] = NONE_TABLE_PREFIX.'statistics4'; // 현장별 기성집계표 일부데이터 저장 테이블





$none['branch_list'] = NONE_TABLE_PREFIX.'branch'; // 지사 테이블
$none['department_list'] = NONE_TABLE_PREFIX.'department'; // 부서 테이블
$none['member_position_list'] = NONE_TABLE_PREFIX.'member_position'; // 직급 테이블
$none['bank_list'] = NONE_TABLE_PREFIX.'bank_list'; // 은행목록 테이블
$none['member_level_list'] = NONE_TABLE_PREFIX.'member_level'; // 등급 테이블
$none['weather'] = NONE_TABLE_PREFIX.'weather'; // 좌표 , 공공데이터 기상청단기예보 엑셀데이터

//$none['employee_list'] = NONE_TABLE_PREFIX.'employee_list'; // 직원테이블은 g5_member로 통일함.


//외부공간

$none['home_project'] = NONE_TABLE_PREFIX.'home_project'; // 프로젝트
$none['home_request'] = NONE_TABLE_PREFIX.'home_request'; // 공사의뢰
$none['home_recruit'] = NONE_TABLE_PREFIX.'home_recruit'; // 채용공고 22.06.20 추가됨
$none['home_news'] = NONE_TABLE_PREFIX.'home_news'; // 뉴스
$none['home_board'] = NONE_TABLE_PREFIX.'board_list'; //게시판
$none['home_board_cate'] = NONE_TABLE_PREFIX.'board_category'; //게시판 카테고리
$none['home_gongsa'] = NONE_TABLE_PREFIX.'home_gongsa'; //지명원
?>