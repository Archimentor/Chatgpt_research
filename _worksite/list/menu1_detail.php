<?php 
// 에러 표시 비활성화 (운영 환경에서는 권장)
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

// 공통 파일 포함
include_once('../../_common.php');
define('menu_worksite', true);

// API 키 설정
$openweathermap_api_key = 'bfd67011672f07b556e3c8bcd388c0a6'; // 실제 API 키로 교체
$google_maps_api_key = 'AIzaSyDj4OFmhtST4kqAnlASG5g6uloYBVRy60M'; // 실제 API 키로 교체

// API 요청을 처리하는 함수
function get_api_response($url) {
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); // 요청 타임아웃 설정
    // SSL 인증서 검증 비활성화 (보안상 권장되지 않음)
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    $response = curl_exec($ch);
    
    if(curl_errno($ch)){
        // 에러 발생 시 로그에 기록
        error_log('cURL error: ' . curl_error($ch));
        curl_close($ch);
        return false;
    }
    
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($http_code != 200) {
        // HTTP 상태 코드가 200이 아닐 경우
        error_log('API 요청 실패. URL: ' . $url . ' | HTTP 코드: ' . $http_code);
        return false;
    }
    
    return $response;
}

// 현장 ID 가져오기
$site_id = isset($_GET['site_id']) ? addslashes($_GET['site_id']) : null;

if(!$site_id) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>현장 ID가 지정되지 않았습니다.</div></div>";
    include_once(NONE_PATH.'/footer.php');
    exit;
}

// 현장 정보 조회 (Prepared Statements 권장)
$sql = "SELECT * FROM {$none['worksite']} WHERE nw_code = '{$site_id}' LIMIT 1";
$detail = sql_fetch($sql);

if(!$detail) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>해당 현장을 찾을 수 없습니다.</div></div>";
    include_once(NONE_PATH.'/footer.php');
    exit;
}

// 작업일수 계산 함수 (none.functions.php에 이미 존재할 경우 중복 선언 방지)
if (!function_exists('calculate_work_days')) {
    function calculate_work_days($start_date, $end_date) {
        $today = date('Y-m-d');
        if(strtotime($today) <= strtotime($end_date)) {
            // 아직 마감일이 지나지 않음
            $days = (strtotime($today) - strtotime($start_date)) / (60 * 60 * 24);
            return ceil($days);
        } else {
            // 마감일이 지남
            $days = (strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24);
            return ceil($days);
        }
    }
}

// 함수들 (이미 none.functions.php에 정의되어 있을 경우 중복 선언 방지)
if (!function_exists('get_enterprise_txt')) {
    function get_enterprise_txt($ptype) {
        return htmlspecialchars($ptype);
    }
}

if (!function_exists('get_manager_txt')) {
    function get_manager_txt($ptype) {
        return htmlspecialchars($ptype);
    }
}

if (!function_exists('get_owner_txt')) {
    function get_owner_txt($ptype) {
        return htmlspecialchars($ptype);
    }
}

// 상세 정보 변수 설정
$raw_address = trim($detail['nw_addr']); // 원본 주소 (출력 및 지도용)

// 주소 단순화: [동, 구, 군, 시] 중 하나만 추출 (우선순위: 동 > 리 > 구 > 군 > 시)
if (preg_match('/([가-힣]+동)/u', $raw_address, $matches)) {
    $simplified_address = $matches[1];
} elseif (preg_match('/([가-힣]+리)/u', $raw_address, $matches)) {
    $simplified_address = $matches[1];
} elseif (preg_match('/([가-힣]+구)/u', $raw_address, $matches)) {
    $simplified_address = $matches[1];
} elseif (preg_match('/([가-힣]+군)/u', $raw_address, $matches)) {
    $simplified_address = $matches[1];
} elseif (preg_match('/([가-힣]+시)/u', $raw_address, $matches)) {
    $simplified_address = $matches[1];
} else {
    // 주소 형식이 예상과 다를 경우 전체 주소 사용
    $simplified_address = $raw_address;
}

$address = htmlspecialchars($raw_address); // 출력용 주소 (원본)
// 새로운 코드: smart_list 테이블에서 가장 최근의 ns_persent 가져오기
$progress_sql = "SELECT ns_persent FROM {$none['smart_list']} WHERE work_id = '{$site_id}' ORDER BY ns_date DESC LIMIT 1";
$progress_detail = sql_fetch($progress_sql);

if ($progress_detail && isset($progress_detail['ns_persent'])) {
    $progress = htmlspecialchars($progress_detail['ns_persent']);
} else {
    $progress = '';
}
$start_date = $detail['nw_sdate'];
$end_date = $detail['nw_edate'];
$work_days = calculate_work_days($start_date, $end_date);
$floor_basement = htmlspecialchars($detail['nw_floor2']); // 지하층수
$floor_ground = htmlspecialchars($detail['nw_floor1']); // 지상층수
$land_area = htmlspecialchars($detail['nw_area1']); // 대지면적
$building_area = htmlspecialchars($detail['nw_area2']); // 건축면적
$total_area = htmlspecialchars($detail['nw_area3']); // 연면적

// 날씨 정보 초기화
$current_weather = '정보 없음';
$tomorrow_weather = '정보 없음';
$day_after_weather = '정보 없음';

if (!empty($simplified_address) && $openweathermap_api_key !== 'YOUR_OPENWEATHERMAP_API_KEY') {
    // 주소를 기반으로 위도와 경도 가져오기 (Geocoding API)
    $geocode_url = "https://api.openweathermap.org/geo/1.0/direct?q=" . urlencode($simplified_address) . ",KR&limit=1&appid={$openweathermap_api_key}";
    
    $geocode_response = get_api_response($geocode_url);
    
    if ($geocode_response !== false) {
        $geocode_data = json_decode($geocode_response, true);
        if (!empty($geocode_data)) {
            $lat = $geocode_data[0]['lat'];
            $lon = $geocode_data[0]['lon'];
            
            // 현재날씨 가져오기 (Current Weather Data API)
            $weather_url = "https://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&units=metric&appid={$openweathermap_api_key}";
            
            $weather_response = get_api_response($weather_url);
            
            if ($weather_response !== false) {
                $weather_data = json_decode($weather_response, true);
                if (isset($weather_data['weather'][0]['description']) && isset($weather_data['main']['temp'])) {
                    $current_weather = ucfirst($weather_data['weather'][0]['description']) . ", " . $weather_data['main']['temp'] . "°C";
                }
            }
            
            // 내일과 모레 날씨 가져오기 (5 Day / 3 Hour Forecast API)
            $forecast_url = "https://api.openweathermap.org/data/2.5/forecast?lat={$lat}&lon={$lon}&units=metric&appid={$openweathermap_api_key}";
            
            $forecast_response = get_api_response($forecast_url);
            
            if ($forecast_response !== false) {
                $forecast_data = json_decode($forecast_response, true);
                if (isset($forecast_data['list']) && is_array($forecast_data['list'])) {
                    // 오늘 날짜
                    $today_date = date('Y-m-d');
                    
                    // 내일과 모레 날짜
                    $tomorrow_date = date('Y-m-d', strtotime('+1 day'));
                    $day_after_date = date('Y-m-d', strtotime('+2 day'));
                    
                    // 초기화
                    $tomorrow_temps = [];
                    $tomorrow_descriptions = [];
                    $day_after_temps = [];
                    $day_after_descriptions = [];
                    
                    foreach ($forecast_data['list'] as $forecast) {
                        $forecast_dt = date('Y-m-d', $forecast['dt']);
                        $forecast_time = date('H:i:s', $forecast['dt']);
                        
                        if ($forecast_dt == $tomorrow_date) {
                            $tomorrow_temps[] = $forecast['main']['temp'];
                            $tomorrow_descriptions[] = $forecast['weather'][0]['description'];
                        } elseif ($forecast_dt == $day_after_date) {
                            $day_after_temps[] = $forecast['main']['temp'];
                            $day_after_descriptions[] = $forecast['weather'][0]['description'];
                        }
                    }
                    
                    // 내일 날씨 평균 온도 및 가장 빈번한 날씨 상태
                    if (!empty($tomorrow_temps)) {
                        $avg_tomorrow_temp = round(array_sum($tomorrow_temps) / count($tomorrow_temps), 1);
                        $tomorrow_weather_desc = most_frequent($tomorrow_descriptions);
                        $tomorrow_weather = ucfirst($tomorrow_weather_desc) . ", " . $avg_tomorrow_temp . "°C";
                    }
                    
                    // 모레 날씨 평균 온도 및 가장 빈번한 날씨 상태
                    if (!empty($day_after_temps)) {
                        $avg_day_after_temp = round(array_sum($day_after_temps) / count($day_after_temps), 1);
                        $day_after_weather_desc = most_frequent($day_after_descriptions);
                        $day_after_weather = ucfirst($day_after_weather_desc) . ", " . $avg_day_after_temp . "°C";
                    }
                }
            }
        }
    }
}

/**
 * 가장 빈번하게 나타나는 값 반환 함수
 * @param array $arr
 * @return string
 */
function most_frequent($arr) {
    if (empty($arr)) return '';
    $values = array_count_values($arr);
    arsort($values);
    return key($values);
}
    
// 공사기간은 삭제됨
?>
    
<!-- 현장 상세 정보 -->
<div class="container mt-5">
    <h3>현장 상세 정보</h3>
    <table class="table table-bordered">
        <!-- 삭제된 항목들: 현장코드, 현장명, 현장소장, 건축주, 공사기간 -->
        
        <!-- 추가된 항목들 -->
        <tr>
            <th>현재날씨</th>
            <td><?php echo $current_weather; ?></td>
        </tr>
        <tr>
            <th>내일날씨</th>
            <td><?php echo $tomorrow_weather; ?></td>
        </tr>
        <tr>
            <th>모레날씨</th>
            <td><?php echo $day_after_weather; ?></td>
        </tr>
        <tr>
            <th>주소</th>
            <td><?php echo $address; ?></td>
        </tr>
        <tr>
            <th>공정률</th>
            <td><?php echo $progress; ?>%</td>
        </tr>
        <tr>
            <th>작업일수</th>
            <td><?php echo $work_days; ?>일</td>
        </tr>
        <tr>
            <th>규모</th>
            <td>지하 <?php echo $floor_basement; ?>층, 지상 <?php echo $floor_ground; ?>층</td>
        </tr>
        <tr>
            <th>대지면적</th>
            <td><?php echo $land_area; ?>㎡</td>
        </tr>
        <tr>
            <th>건축면적</th>
            <td><?php echo $building_area; ?>㎡</td>
        </tr>
        <tr>
            <th>연면적</th>
            <td><?php echo $total_area; ?>㎡</td>
        </tr>
    </table>

    <!-- 구글 지도 표시 -->
    <div class="map-container">
        <iframe
            loading="lazy"
            allowfullscreen
            src="<?php echo "https://www.google.com/maps/embed/v1/place?key={$google_maps_api_key}&q=" . urlencode($raw_address); ?>">
        </iframe>
    </div>
</div>

<style>
/* 테이블 스타일 조정 */
.table-bordered th, .table-bordered td {
    padding: 10px;
    vertical-align: middle;
}

/* 반응형 지도 */
.map-container {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 */
    height: 0;
    overflow: hidden;
    margin-top: 20px;
}
.map-container iframe {
    position: absolute;
    top:0;
    left: 0;
    width: 100%;
    height: 100%;
    border:0;
}

/* 반응형 디자인 */
@media (max-width: 768px) {
    .container {
        padding: 10px;
    }
    .table-bordered th, .table-bordered td {
        padding: 8px;
        font-size: 14px;
    }
}
</style>

<?php include_once(NONE_PATH.'/footer.php'); ?>
