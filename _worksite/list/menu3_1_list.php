<?php
include_once('../../_common.php');
define('menu_worksite', true);
include_once(NONE_PATH.'/header.php');

// 시간대 및 문자셋 설정
date_default_timezone_set('Asia/Seoul');
header('Content-Type: text/html; charset=UTF-8');

// (1) 파라미터: year, status
$year   = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
$status = isset($_GET['status']) ? (int)$_GET['status'] : 0;  // 0: 진행중, 1: 완료

$prev_year = $year - 1;
$next_year = $year + 1;

// (2) 해당 연도 전체 기간
$start_date = new DateTime("{$year}-01-01");
$end_date   = new DateTime("{$year}-12-31");

// 날짜 목록 및 월별 날짜 수 계산
$allDates = [];
$daysInMonth = [];
$period = new DatePeriod(
    $start_date,
    new DateInterval('P1D'),
    $end_date->modify('+1 day') // 마지막 날 포함
);
foreach ($period as $dt) {
    $current_date = $dt->format('Y-m-d');
    $month = (int)$dt->format('m');
    $allDates[] = $current_date;
    if (!isset($daysInMonth[$month])) {
        $daysInMonth[$month] = 0;
    }
    $daysInMonth[$month]++;
}
ksort($daysInMonth); // 월 순서대로 정렬

// (3) 현장 리스트 불러오기
$sql_worksite = "
    SELECT nw_code, nw_subject
    FROM {$none['worksite']}
    WHERE nw_status = '{$status}'
    ORDER BY nw_code DESC
";
$result_ws = sql_query($sql_worksite);
$worksites = [];
while($ws = sql_fetch_array($result_ws)) {
    $worksites[] = $ws;
}

// (4) 공사일보(스마트일보) 조회 (해당 연도 전체)
$sql_daily = "
    SELECT seq, work_id, ns_date
    FROM {$none['smart_list']}
    WHERE ns_date BETWEEN '{$start_date->format('Y-m-d')}' AND '{$end_date->format('Y-m-d')}' /* DateTime 객체 원복 후 사용 */
    ORDER BY ns_date ASC
";
$result_daily = sql_query($sql_daily);
$calendarData = [];
while($row = sql_fetch_array($result_daily)) {
    $work_id = $row['work_id'];
    $day     = $row['ns_date'];
    $seq     = $row['seq'];

    $w = date('w', strtotime($day));
    $mark = ($w == 6 || $w == 0) ? '◎' : 'ㅇ';
    if(!isset($calendarData[$work_id][$day])) {
        $calendarData[$work_id][$day] = [
            'mark' => $mark,
            'seq'  => $seq
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<title>연간 공사일보</title>
<style>
/* 기본 폰트 및 여백 */
body {
    /* margin 제거 (main-content에서 관리) */
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; /* 시스템 폰트 우선 */
    font-size: 14px;
    color: #333;
    background-color: #f8f9fa; /* 페이지 배경색 */
}
#main-content { padding: 20px; } /* 메인 콘텐츠 영역 여백 */

a { text-decoration: none; color: #007bff; } /* 링크 색상 변경 */
a:hover { color: #0056b3; text-decoration: underline;}

/* 카드 스타일 */
.card { margin-bottom: 20px; }

/* 헤더 영역 (.card-header 또는 .card-body 상단) */
.header-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem; /* 테이블과의 간격 */
    padding: 0.5rem 0; /* 상하 약간의 여백 */
}
.header-controls .year-display {
    font-size: 1.5rem; /* 연도 글자 크기 키움 */
    font-weight: 600;
}
.header-controls .year-nav a {
    font-size: 0.9rem;
    margin-left: 5px; /* 버튼 간 간격 */
    padding: 0.375rem 0.75rem; /* 부트스트랩 버튼 패딩과 유사하게 */
    border: 1px solid #ced4da;
    background-color: #fff;
    border-radius: 0.25rem;
    color: #495057;
    transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out;
}
.header-controls .year-nav a:hover {
    background-color: #e9ecef;
    border-color: #adb5bd;
    text-decoration: none;
}
.header-controls .status-filter select {
    /* 부트스트랩 form-control 스타일 사용 권장 */
    /* 아래는 기본 스타일 예시 */
    padding: 0.375rem 0.75rem;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    font-size: 0.9rem;
}

/* 테이블 및 스크롤 영역 */
.table-container {
    overflow-x: auto;
    position: relative;
    border: 1px solid #dee2e6; /* 컨테이너에도 테두리 */
    border-radius: 0.25rem;
}
.calendar-table {
    border-collapse: collapse;
    min-width: 1800px; /* 내용에 따라 자동 조절되거나 충분히 넓게 */
    text-align: center;
    width: 100%; /* 컨테이너 너비에 맞춤 */
    border-spacing: 0;
    background-color: #fff; /* 테이블 기본 배경 흰색 */
}
.calendar-table th,
.calendar-table td {
    border: 1px solid #dee2e6; /* 부드러운 테두리 색상 */
    padding: 8px 6px; /* 셀 여백 조정 (상하8px, 좌우6px) */
    white-space: nowrap;
    font-size: 13px; /* 폰트 크기 유지 */
    vertical-align: middle;
}

/* 테이블 헤더 스타일 */
.calendar-table thead {
    background-color: #f8f9fa; /* 헤더 배경색 */
    color: #495057;
    font-weight: 600; /* 약간 굵게 */
    font-size: 12px; /* 날짜 헤더 폰트 약간 작게 */
}
.calendar-table thead th {
    border-bottom-width: 2px; /* 아래 테두리 강조 */
}
.month-header th { /* 월 헤더 */
    background-color: #e9ecef; /* 월 헤더 배경색 */
    font-weight: bold;
    font-size: 13px; /* 월 헤더 폰트 크기 */
    border-right: 2px solid #ced4da; /* 월 구분선 */
}
.month-header th:last-child {
     border-right: 1px solid #dee2e6; /* 마지막 월 구분선은 일반 테두리 */
}


/* 주말 및 데이터 없음 스타일 */
.sat { background-color: #e3f2fd !important; color: #0d47a1; } /* 파스텔 블루 */
.sun { background-color: #ffebee !important; color: #b71c1c; } /* 파스텔 핑크 */
.no-report { color: #adb5bd; font-style: italic; } /* 데이터 없을 때 */

/* 데이터 표시 링크 스타일 ('ㅇ'/'◎') */
.report-link a {
    display: inline-block;
    width: 20px;
    height: 20px;
    line-height: 18px; /* 원 중앙 정렬 */
    border-radius: 50%;
    font-weight: bold;
    color: #28a745; /* 기본 초록색 */
    border: 1px solid transparent;
    transition: all 0.2s ease;
}
.report-link a:hover {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
    text-decoration: none;
}
.report-link.sat a, .report-link.sun a { /* 주말 마크 색상 */
    color: #dc3545;
}
.report-link.sat a:hover, .report-link.sun a:hover {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}

/* 고정 열 스타일 */
.sticky-col {
    position: -webkit-sticky; /* Safari */
    position: sticky;
    left: 0;
    z-index: 2;
    /* 고정 열 오른쪽 구분선 및 그림자 */
    border-right-width: 2px !important; /* 두꺼운 오른쪽 구분선 */
    border-right-color: #ced4da !important;
    box-shadow: 2px 0 5px rgba(0,0,0,0.1); /* 오른쪽 그림자 */
}
/* 고정 열 배경색 */
.calendar-table thead th.sticky-col {
    background-color: #e9ecef; /* 헤더 배경색과 일치 (월 헤더 색상 사용) */
}
.calendar-table tbody td.sticky-col {
    background-color: #fff !important; /* tbody 배경색 (흰색) - hover보다 우선 적용 */
    text-align: left;
    font-weight: 600; /* 현장명 약간 굵게 */
    min-width: 180px; /* 최소 너비 증가 */
}

/* 행 호버 스타일 */
.calendar-table tbody tr:hover td {
    background-color: #f5f5f5; /* 전체 행 호버 배경색 */
}
/* 고정 열은 호버 시에도 원래 배경색 유지 (선택적, 위 !important로 이미 적용됨) */
/*
.calendar-table tbody tr:hover td.sticky-col {
    background-color: #fff;
}
*/


/* [일괄출력] 링크 스타일 */
.allprint-link {
    margin-left: 8px;
    font-size: 11px;
    font-weight: normal;
    color: #6c757d;
    vertical-align: middle;
}
.allprint-link:hover {
    color: #343a40;
}
</style>
</head>
<body>
<div id="main-content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>스마트일보(작성유무)</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item">현장관리</li>
                    <li class="breadcrumb-item active">스마트일보(작성유무)</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="header-controls">
                <div class="year-display">
                    <?php echo $year; ?>년
                    <span class="year-nav">
                        <a href="?year=<?php echo $prev_year; ?>&status=<?php echo $status; ?>">&lt;</a>
                        <a href="?year=<?php echo $next_year; ?>&status=<?php echo $status; ?>">&gt;</a>
                    </span>
                </div>
                <div class="status-filter">
                    <form method="get" style="margin:0;">
                        <input type="hidden" name="year" value="<?php echo $year; ?>">
                        <select name="status" class="form-control form-control-sm d-inline-block w-auto" onchange="this.form.submit()">
                            <option value="0" <?php echo ($status===0 ? 'selected' : ''); ?>>진행중 현장</option>
                            <option value="1" <?php echo ($status===1 ? 'selected' : ''); ?>>완료 현장</option>
                        </select>
                    </form>
                </div>
            </div>

            <div class="table-container">
                <table class="calendar-table">
                    <thead>
                        <tr class="month-header">
                            <th rowspan="2" class="sticky-col">현장명</th>
                            <?php
                            // 월(Month) 헤더 생성
                            foreach ($daysInMonth as $month => $days) {
                                echo '<th colspan="'.$days.'">'.$month.'월</th>';
                            }
                            ?>
                        </tr>
                        <tr>
                            <?php
                            // 날짜(m-d) 헤더 생성
                            foreach($allDates as $d) {
                                $w = date('w', strtotime($d)); // 요일
                                $day_num = date('d', strtotime($d)); // 일자
                                $date_header = date('m-d', strtotime($d));
                                $thClass = '';
                                if($w == 6) $thClass = 'sat';
                                if($w == 0) $thClass = 'sun';
                                // 주말 날짜 굵게 표시 (선택적)
                                // $date_label = ($w == 0 || $w == 6) ? "<strong>{$day_num}</strong>" : $day_num;
                                echo '<th class="'.$thClass.'">'.$date_header.'</th>';
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(count($worksites) == 0) {
                            echo '<tr><td colspan="'.(1 + count($allDates)).'" class="text-center py-5">해당 상태의 현장이 없습니다.</td></tr>';
                        } else {
                            foreach($worksites as $ws) {
                                $work_id   = $ws['nw_code'];
                                $work_name = $ws['nw_subject'];
                                echo '<tr>';
                                // 현장명 셀 (고정)
                                echo '<td class="sticky-col">';
                                echo '['.$work_id.'] '.htmlspecialchars($work_name);
                                // 일괄출력 링크 (URL 확인 필요)
                                echo '<a href="/_worksite/view/menu3_printall.php?work_id='.urlencode($work_id).'" class="allprint-link" target="_blank">[출력]</a>';
                                echo '</td>';

                                // 날짜 셀
                                foreach($allDates as $d) {
                                    $w = date('w', strtotime($d));
                                    $tdClass = '';
                                    if($w == 6) $tdClass .= ' sat';
                                    if($w == 0) $tdClass .= ' sun';

                                    if(isset($calendarData[$work_id][$d])) {
                                        $mark = $calendarData[$work_id][$d]['mark'];
                                        $seq  = $calendarData[$work_id][$d]['seq'];
                                        $tdClass .= ' report-link'; // 링크 스타일 적용 클래스
                                        echo '<td class="'.trim($tdClass).'"><a href="/_worksite/view/menu3_view.php?seq='.$seq.'">'.$mark.'</a></td>';
                                    } else {
                                        echo '<td class="'.trim($tdClass).' no-report">-</td>';
                                    }
                                }
                                echo '</tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div></div> </div> </div><?php include_once(NONE_PATH.'/footer.php'); ?>
</body>
</html>