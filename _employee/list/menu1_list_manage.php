<?php
// 파일명: menu1_list_manage.php

include_once('../../_common.php'); // 경로 조정
define('menu_employee', true);
include_once(NONE_PATH.'/header.php');

// -------------------------------------------
// 1) 년 / 월 파라미터 처리
// -------------------------------------------
$year  = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');

if ($month < 1 || $month > 12) $month = date('m');
if ($year  < 2020 || $year  > date('Y') + 5) { // 5년 후까지만 허용
    $year  = date('Y');
    $month = date('m');
}

// 이전/다음 달 계산
$prev_month = $month - 1; $prev_year = $year;
if ($prev_month == 0) { $prev_month = 12; $prev_year--; }
$next_month = $month + 1; $next_year = $year;
if ($next_month == 13) { $next_month = 1; $next_year++; }

// -------------------------------------------
// 2) 하드코딩 공휴일 (2025~2035 예시)
//    실제 데이터는 필요에 따라 수정하세요.
// -------------------------------------------
$hardcodedHolidays = [
    // 2025년
    '2025-01-01' => '신정',
    '2025-01-28' => '설날연휴',
    '2025-01-29' => '설날',
    '2025-01-30' => '설날연휴',
    '2025-03-01' => '삼일절',
    '2025-05-05' => '어린이날/부처님오신날',
    '2025-05-06' => '대체공휴일',
    '2025-06-06' => '현충일',
    '2025-08-15' => '광복절',
    '2025-10-03' => '개천절',
    '2025-10-05' => '추석연휴',
    '2025-10-06' => '추석',
    '2025-10-07' => '추석연휴',
    '2025-10-09' => '한글날',
    '2025-12-25' => '성탄절',
    // 2026년
    '2026-01-01' => '신정',
    '2026-02-15' => '설날연휴',
    '2026-02-16' => '설날',
    '2026-02-17' => '설날연휴',
    '2026-03-01' => '삼일절',
    '2026-05-05' => '어린이날',
    '2026-05-15' => '부처님오신날',
    '2026-06-06' => '현충일',
    '2026-08-15' => '광복절',
    '2026-09-24' => '추석연휴',
    '2026-09-25' => '추석',
    '2026-09-26' => '추석연휴',
    '2026-10-03' => '개천절',
    '2026-10-09' => '한글날',
    '2026-12-25' => '성탄절',
    // 2027년
    '2027-01-01' => '신정',
    '2027-02-05' => '설날연휴',
    '2027-02-06' => '설날',
    '2027-02-07' => '설날연휴',
    '2027-03-01' => '삼일절',
    '2027-05-05' => '어린이날',
    '2027-05-04' => '부처님오신날',
    '2027-06-06' => '현충일',
    '2027-08-15' => '광복절',
    '2027-09-14' => '추석연휴',
    '2027-09-15' => '추석',
    '2027-09-16' => '추석연휴',
    '2027-10-03' => '개천절',
    '2027-10-09' => '한글날',
    '2027-12-25' => '성탄절',
    // 2028년
    '2028-01-01' => '신정',
    '2028-01-26' => '설날연휴',
    '2028-01-27' => '설날',
    '2028-01-28' => '설날연휴',
    '2028-03-01' => '삼일절',
    '2028-05-05' => '어린이날',
    '2028-05-23' => '부처님오신날',
    '2028-06-06' => '현충일',
    '2028-08-15' => '광복절',
    '2028-10-02' => '추석연휴',
    '2028-10-03' => '추석/개천절',
    '2028-10-04' => '추석연휴',
    '2028-10-09' => '한글날',
    '2028-12-25' => '성탄절',
    // 2029년
    '2029-01-01' => '신정',
    '2029-02-13' => '설날연휴',
    '2029-02-14' => '설날',
    '2029-02-15' => '설날연휴',
    '2029-03-01' => '삼일절',
    '2029-05-05' => '어린이날',
    '2029-05-12' => '부처님오신날',
    '2029-06-06' => '현충일',
    '2029-08-15' => '광복절',
    '2029-09-21' => '추석연휴',
    '2029-09-22' => '추석',
    '2029-09-23' => '추석연휴',
    '2029-10-03' => '개천절',
    '2029-10-09' => '한글날',
    '2029-12-25' => '성탄절',
    // 2030년
    '2030-01-01' => '신정',
    '2030-02-03' => '설날연휴',
    '2030-02-04' => '설날',
    '2030-02-05' => '설날연휴',
    '2030-03-01' => '삼일절',
    '2030-05-05' => '어린이날',
    '2030-05-02' => '부처님오신날',
    '2030-06-06' => '현충일',
    '2030-08-15' => '광복절',
    '2030-09-12' => '추석연휴',
    '2030-09-13' => '추석',
    '2030-09-14' => '추석연휴',
    '2030-10-03' => '개천절',
    '2030-10-09' => '한글날',
    '2030-12-25' => '성탄절',
    // 2031년
    '2031-01-01' => '신정',
    '2031-02-22' => '설날연휴',
    '2031-02-23' => '설날',
    '2031-02-24' => '설날연휴',
    '2031-03-01' => '삼일절',
    '2031-05-05' => '어린이날',
    '2031-05-21' => '부처님오신날',
    '2031-06-06' => '현충일',
    '2031-08-15' => '광복절',
    '2031-09-11' => '추석연휴',
    '2031-09-12' => '추석',
    '2031-09-13' => '추석연휴',
    '2031-10-03' => '개천절',
    '2031-10-09' => '한글날',
    '2031-12-25' => '성탄절',
    // 2032년
    '2032-01-01' => '신정',
    '2032-02-10' => '설날연휴',
    '2032-02-11' => '설날',
    '2032-02-12' => '설날연휴',
    '2032-03-01' => '삼일절',
    '2032-05-05' => '어린이날',
    '2032-05-09' => '부처님오신날',
    '2032-06-06' => '현충일',
    '2032-08-15' => '광복절',
    '2032-09-30' => '추석연휴',
    '2032-10-01' => '추석',
    '2032-10-02' => '추석연휴',
    '2032-10-03' => '개천절',
    '2032-10-09' => '한글날',
    '2032-12-25' => '성탄절',
    // 2033년
    '2033-01-01' => '신정',
    '2033-01-29' => '설날연휴',
    '2033-01-30' => '설날',
    '2033-01-31' => '설날연휴',
    '2033-03-01' => '삼일절',
    '2033-05-05' => '어린이날',
    '2033-05-28' => '부처님오신날',
    '2033-06-06' => '현충일',
    '2033-08-15' => '광복절',
    '2033-09-19' => '추석연휴',
    '2033-09-20' => '추석',
    '2033-09-21' => '추석연휴',
    '2033-10-03' => '개천절',
    '2033-10-09' => '한글날',
    '2033-12-25' => '성탄절',
    // 2034년
    '2034-01-01' => '신정',
    '2034-02-17' => '설날연휴',
    '2034-02-18' => '설날',
    '2034-02-19' => '설날연휴',
    '2034-03-01' => '삼일절',
    '2034-05-05' => '어린이날',
    '2034-05-17' => '부처님오신날',
    '2034-06-06' => '현충일',
    '2034-08-15' => '광복절',
    '2034-10-07' => '추석연휴',
    '2034-10-08' => '추석',
    '2034-10-09' => '추석연휴/한글날',
    '2034-10-03' => '개천절',
    '2034-12-25' => '성탄절',
    // 2035년
    '2035-01-01' => '신정',
    '2035-02-06' => '설날연휴',
    '2035-02-07' => '설날',
    '2035-02-08' => '설날연휴',
    '2035-03-01' => '삼일절',
    '2035-05-05' => '어린이날',
    '2035-05-06' => '부처님오신날',
    '2035-06-06' => '현충일',
    '2035-08-15' => '광복절',
    '2035-09-26' => '추석연휴',
    '2035-09-27' => '추석',
    '2035-09-28' => '추석연휴',
    '2035-10-03' => '개천절',
    '2035-10-09' => '한글날',
    '2035-12-25' => '성탄절',
];

// 3) DB 공휴일 불러오기
$holidays_for_month_db = [];
$sql_holidays_db = "
    SELECT ch_date, ch_name
    FROM   none_member_holidays
    WHERE  YEAR(ch_date)  = {$year}
      AND  MONTH(ch_date) = {$month}
    ORDER BY ch_date ASC
";
$result_holidays_db = sql_query($sql_holidays_db);
if ($result_holidays_db) {
    while ($row_holiday = sql_fetch_array($result_holidays_db)) {
        $ts = strtotime($row_holiday['ch_date']);
        if ($ts === false) continue;
        $day = (int)date('d', $ts);
        // 날짜별로 공휴일 이름 배열 관리 (중복될 수 있으므로)
        if (!isset($holidays_for_month_db[$day])) {
            $holidays_for_month_db[$day] = [];
        }
        // DB에서 가져온 공휴일 이름 추가 (중복 방지)
        if (!in_array($row_holiday['ch_name'], $holidays_for_month_db[$day])) {
             $holidays_for_month_db[$day][] = $row_holiday['ch_name'];
        }
    }
}

// 4) 하드코드 ↔ DB 합치기 (중복 이름 방지)
foreach ($hardcodedHolidays as $dateStr => $hName) {
    if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $dateStr, $m)) {
        if ((int)$m[1] == $year && (int)$m[2] == $month) {
            $d = (int)$m[3];
            if (!isset($holidays_for_month_db[$d])) {
                $holidays_for_month_db[$d] = [];
            }
            // 하드코딩된 공휴일 이름 추가 (중복 방지)
            if (!in_array($hName, $holidays_for_month_db[$d])) {
                $holidays_for_month_db[$d][] = $hName;
            }
        }
    }
}

// 5) 직원 목록·생일·신규입사자
$sql_where = " WHERE mb_level = 10 AND mb_id != 'admin' AND mb_level2 != 4 ";
$sql_order = " ORDER BY mb_name ASC ";
$sql = "
    SELECT mb_id,
           mb_name,
           mb_3                 AS mb_position,
           mb_hp,
           mb_email,
           mb_in_date,
           mb_birth
    FROM   {$g5['member_table']}
    {$sql_where}
    {$sql_order}
";
$result = sql_query($sql);

// 근속연수 계산 함수
function get_seniority_years($in_date) {
    if (!$in_date || $in_date === '0000-00-00' || $in_date === null) return 0;
    try {
        // 날짜 형식 유효성 검사 강화
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $in_date)) return 0;
        $start = new DateTime($in_date);
        $today = new DateTime(date('Y-m-d'));
        if ($start > $today) return 0; // 입사일이 오늘보다 미래면 0년
        return $today->diff($start)->y;
    } catch (Exception $e) {
        // 날짜 변환 실패 시 오류 로깅 또는 0 반환
        // error_log('Date calculation error: ' . $e->getMessage());
        return 0;
    }
}

// 입사 7일 이내? (오늘 기준)
function is_new_hire($in_date) {
    if (!$in_date || $in_date === '0000-00-00' || $in_date === null) return false;
    // 날짜 형식 유효성 검사
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $in_date)) return false;

    $in_date_ts = strtotime($in_date);
    if ($in_date_ts === false) return false; // 유효하지 않은 날짜 문자열

    $today_ts = strtotime(date('Y-m-d'));
    $seven_days_after_in_date_ts = strtotime('+7 days', $in_date_ts);

    // 입사일이 오늘보다 미래가 아니고, 오늘이 입사일+7일 이내에 포함되면 true
    return ($in_date_ts <= $today_ts) && ($today_ts <= $seven_days_after_in_date_ts);
}

// 직급 코드 → 직급명 매핑
function get_mposition_name($code){
    $code = ltrim((string)$code, '0');
    if (function_exists('get_mposition_txt')) {
        return get_mposition_txt($code);
    }
    // get_mposition_txt 함수가 없을 경우 대비
    // 필요하다면 여기에 직접 매핑 로직 추가
    // 예: $positions = ['1' => '사원', '2' => '주임', ...]; return $positions[$code] ?? $code;
    return $code; // 기본값으로 코드 반환
}

$birthdays_this_month = [];
$employee_list_data   = [];
$new_hires            = [];

while ($row = sql_fetch_array($result)) {
    // mb_position 값이 없을 경우 대비
    $row['pos_name'] = isset($row['mb_position']) ? get_mposition_name($row['mb_position']) : '';
    // 근속년수 미리 계산하여 배열에 포함 (정렬용)
    $row['seniority_years'] = get_seniority_years($row['mb_in_date']);
    $employee_list_data[] = $row;

    // 생일 집계 (생년월일 형식 'YYYY-MM-DD' 또는 'MM-DD' 가정)
    $birth_month = null;
    $birth_day   = null;
    if (!empty($row['mb_birth']) && $row['mb_birth'] !== '0000-00-00') {
        // 'YYYY-MM-DD' 형식 처리
        if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', trim($row['mb_birth']), $mm)) {
            $birth_month = (int)$mm[2];
            $birth_day   = (int)$mm[3];
        }
        // 'MM-DD' 형식 처리 (년도 없이)
        elseif (preg_match('/^(\d{2})-(\d{2})$/', trim($row['mb_birth']), $mm)) {
             $birth_month = (int)$mm[1];
             $birth_day   = (int)$mm[2];
        }
    }

    if ($birth_month == $month && $birth_day !== null) {
         $yrs = $row['seniority_years'];
         $label = $row['mb_name'].' '.$row['pos_name'].' ('.$yrs.'년) | '.$row['mb_hp'];
         if (!isset($birthdays_this_month[$birth_day])) {
             $birthdays_this_month[$birth_day] = [];
         }
         $birthdays_this_month[$birth_day][] = $label;
    }

    // 신규 입사자 집계 (is_new_hire 함수 사용)
    if (is_new_hire($row['mb_in_date'])) {
        $new_hires[] = $row;
    }
}

// 근속년수(내림차순) 및 이름(오름차순)으로 직원 목록 정렬
usort($employee_list_data, function($a, $b){
    if ($a['seniority_years'] == $b['seniority_years']) {
        return strcmp($a['mb_name'], $b['mb_name']);
    }
    return $b['seniority_years'] <=> $a['seniority_years'];
});

// 6) 달력용 변수 계산
$first_day_timestamp = mktime(0,0,0,$month,1,$year);
$days_in_month       = (int)date('t', $first_day_timestamp);
$first_day_of_week   = (int)date('w', $first_day_timestamp); // 0:일요일, 6:토요일
$week_days           = ['일','월','화','수','목','금','토'];
?>
<style>
/* (기존과 동일한 CSS 유지) */
.birthday-calendar { margin-bottom: 30px; background: #fff; padding: 20px; border-radius: 5px; height: 100%; } /* height: 100% 추가 */
.birthday-calendar-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
.calendar-table { width: 100%; border-collapse: collapse; table-layout: fixed; }
.calendar-table th, .calendar-table td { border: 1px solid #eee; padding: 8px; text-align: left; vertical-align: top; height: 130px; overflow: hidden; } /* 높이 조절 필요 시 수정 */
.calendar-table th { background: #f8f9fa; text-align: center; font-weight: bold; }
.calendar-table th.sunday { color: red; }
.calendar-table th.saturday { color: blue; }
.calendar-table td.sunday .day-number, .calendar-table td.holiday .day-number { color: red; }
.calendar-table td.saturday:not(.holiday) .day-number { color: blue; }
.calendar-table td.today { background: #fff9e6; }
.calendar-table td.other-month { background: #fdfdfd; color: #ccc; }
.calendar-table td .day-number { font-weight: bold; font-size: .9em; margin-bottom: 5px; display: block; }
.calendar-table td .holiday-name { font-size: .75em; color: red; font-weight: bold; display: block; margin-bottom: 2px; }
.calendar-table td .birthdays { font-size: .8em; line-height: 1.4; max-height: 60px; overflow-y: auto; } /* 생일 목록 높이 조절 필요 시 수정 */
.calendar-table td .birthdays div { margin-bottom: 3px; word-break: keep-all; }

/* 직원 목록 관련 스타일 */
.table th, .table td { vertical-align: middle; }
.badge-danger { background: #dc3545; color: white; }

/* 오른쪽 정보 카드 스타일 */
.info-card { height: 100%; } /* 높이를 100%로 설정하여 달력과 맞춤 */
.info-card .card-body { height: calc(100% - 50px); overflow-y: auto; } /* 헤더 높이 제외하고 스크롤 적용 (헤더 높이 확인 필요) */
.info-card ul { padding-left: 20px; margin-bottom: 15px; }
.info-card li { margin-bottom: 5px; }

</style>

<div id="main-content">
  <div class="container-fluid">
    <div class="block-header">
      <div class="row">
        <div class="col-lg-5 col-md-8 col-sm-12">
          <h2><a class="btn btn-xs btn-link btn-toggle-fullwidth" href="javascript:void(0);">
            <i class="fa fa-arrow-left"></i></a> 직원관리</h2>
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>
            <li class="breadcrumb-item">직원관리</li>
            <li class="breadcrumb-item active">직원목록 및 생일달력</li>
          </ul>
        </div>
      </div>
    </div>

    <div class="row clearfix">

      <div class="col-lg-8">
        <div class="card birthday-calendar">
          <div class="card-body">
            <div class="birthday-calendar-header">
              <div class="birthday-calendar-nav">
                <a href="?year=<?=$prev_year?>&month=<?=sprintf('%02d',$prev_month)?>" class="btn btn-sm btn-outline-secondary">
                  &lt; 이전달</a>
              </div>
              <h3 style="margin: 0;"><?=$year?>년 <?=sprintf('%02d',$month)?>월</h3>
              <div class="birthday-calendar-nav">
                <a href="?year=<?=$next_year?>&month=<?=sprintf('%02d',$next_month)?>" class="btn btn-sm btn-outline-secondary">
                  다음달 &gt;</a>
              </div>
            </div>
            <table class="calendar-table">
              <thead><tr>
                <?php foreach($week_days as $idx=>$wd){
                  $cls = $idx==0 ? 'sunday' : ($idx==6 ? 'saturday' : '');
                  echo "<th class='{$cls}'>$wd</th>";
                } ?>
              </tr></thead>
              <tbody>
                <?php
                  echo '<tr>';
                  // 1. 첫 주 시작 전 빈 칸 채우기
                  for($i=0; $i<$first_day_of_week; $i++){
                    echo '<td class="other-month"></td>';
                  }

                  $current_col = $first_day_of_week; // 현재 요일 인덱스 (0=일 ~ 6=토)
                  $day = 1;

                  // 2. 해당 월의 날짜 채우기
                  while($day <= $days_in_month){
                    // 토요일 다음이면 줄바꿈
                    if($current_col == 7){
                      echo '</tr><tr>';
                      $current_col = 0;
                    }

                    $classes = [];
                    if($current_col == 0) $classes[]='sunday';     // 일요일
                    if($current_col == 6) $classes[]='saturday';   // 토요일

                    $is_holiday = isset($holidays_for_month_db[$day]);
                    if($is_holiday){
                        $classes[]='holiday';
                        // 공휴일이면서 일요일이 아니면 글자색 빨강 적용 위해 sunday 클래스 추가 (CSS 선택자 단순화)
                        if (!in_array('sunday', $classes)) {
                             $classes[] = 'sunday'; // .sunday .day-number { color: red; } 사용
                        }
                    }
                    // 오늘 날짜 표시
                    if($year == date('Y') && $month == date('m') && $day == date('d')) $classes[]='today';

                    echo '<td class="'.implode(' ', array_unique($classes)).'">'; // 중복 클래스 제거
                      echo '<span class="day-number">'.$day.'</span>';

                      // 공휴일 이름 출력
                      if($is_holiday){
                        foreach($holidays_for_month_db[$day] as $holiday_name){
                          echo '<span class="holiday-name">'.htmlspecialchars($holiday_name).'</span>';
                        }
                      }

                      // 생일자 출력
                      if(isset($birthdays_this_month[$day])){
                        echo '<div class="birthdays">';
                          foreach($birthdays_this_month[$day] as $birthday_label){
                            echo '<div>'.htmlspecialchars($birthday_label).'</div>';
                          }
                        echo '</div>';
                      }
                    echo '</td>';

                    $day++;
                    $current_col++;
                  }

                  // 3. 마지막 주 남은 빈 칸 채우기
                  while($current_col < 7){
                    echo '<td class="other-month"></td>';
                    $current_col++;
                  }
                  echo '</tr>';
                ?>
              </tbody>
            </table>
            <div class="text-right mt-3">
                <a href="./menu1_list_ma_holidays.php" class="btn btn-secondary btn-sm">
                    <i class="fa fa-cog"></i> 공휴일 관리
                </a>
            </div>
          </div>
        </div>
      </div><div class="col-lg-4">
        <div class="card info-card"> <div class="card-header">
            <h3 class="card-title">이달의 정보</h3>
          </div>
          <div class="card-body"> <h6 class="mb-2">🎂 <?=$month?>월 생일</h6>
            <?php if(empty($birthdays_this_month)): ?>
              <p class="text-muted mb-3">해당 월 생일자가 없습니다.</p>
            <?php else: ?>
              <ul>
                <?php ksort($birthdays_this_month); // 날짜순 정렬
                  foreach($birthdays_this_month as $d => $arr){
                    foreach($arr as $label){
                      echo '<li>'.sprintf('%02d',$d).'일 - '.htmlspecialchars($label).'</li>';
                    }
                  }
                ?>
              </ul>
            <?php endif; ?>

            <hr>
            <h6 class="mb-2">🆕 신규 입사자 (최근 7일)</h6>
            <?php if(empty($new_hires)): ?>
              <p class="text-muted">최근 신규 입사자가 없습니다.</p>
            <?php else: ?>
              <ul>
                <?php foreach($new_hires as $u): ?>
                  <li>
                    <?=htmlspecialchars($u['mb_in_date'])?> -
                    <?=htmlspecialchars($u['mb_name'].' '.$u['pos_name'])?>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div></div>
      </div></div><div class="row clearfix">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">직원 목록 (근속년수, 이름순)</h3>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover table-striped">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" style="width:18%;">이름 (직급)</th>
                    <th class="text-center" style="width:14%;">연락처</th>
                    <th class="text-center" style="width:18%;">이메일</th>
                    <th class="text-center" style="width:15%;">입사일</th>
                    <th class="text-center" style="width:15%;">생년월일</th>
                    <th class="text-center" style="width:10%;">근속년수</th>
                    <th class="text-center" style="width:10%;">관리</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $employee_count=0;
                    foreach($employee_list_data as $row){
                      $employee_count++;
                      $seniority_years = $row['seniority_years'];
                      $name_label = htmlspecialchars($row['mb_name'].' '.$row['pos_name']);
                      // 신규 입사자 뱃지 추가
                      if(is_new_hire($row['mb_in_date'])){
                        $name_label = '<span class="badge badge-danger mr-1">New</span>'.$name_label;
                      }
                      echo '<tr>';
                      echo '<td class="text-center">'.$name_label.'</td>';
                      echo '<td class="text-center">'.htmlspecialchars($row['mb_hp'] ?? '-').'</td>'; // null 병합 연산자 사용
                      echo '<td class="text-center">'.htmlspecialchars($row['mb_email'] ?? '-').'</td>';
                      echo '<td class="text-center">'.htmlspecialchars($row['mb_in_date'] ?? '-').'</td>';
                      echo '<td class="text-center">'.htmlspecialchars($row['mb_birth'] ?? '-').'</td>';
                      echo '<td class="text-center">'.$seniority_years.'년</td>';
                      echo '<td class="text-center">
                              <a href="../write/menu1_write.php?w=u&amp;mb_id='.urlencode($row['mb_id']).'"
                                 class="btn btn-sm btn-primary">수정</a>
                            </td>';
                      echo '</tr>';
                    }
                    if($employee_count === 0){
                      echo '<tr><td colspan="7" class="text-center">표시할 직원이 없습니다.</td></tr>';
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div></div></div><?php include_once(NONE_PATH.'/footer.php'); ?>