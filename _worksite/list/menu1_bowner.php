<?php 
// 에러 표시 비활성화 (운영 환경에서는 권장)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(1);

// 공통 파일 포함
include_once('../../_common.php');
define('menu_owner', true);


// 건축주 ID 가져오기
$owner_id = isset($_GET['owner_id']) ? intval($_GET['owner_id']) : 0;

if ($owner_id <= 0) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>유효하지 않은 건축주 ID입니다.</div></div>";
    include_once(NONE_PATH.'/footer.php');
    exit;
}


// 데이터베이스에서 건축주 정보 조회 (Prepared Statement 사용)
$sql = "SELECT * FROM {$none['owner_list']} WHERE seq = '{$owner_id}' LIMIT 1";
$row = sql_fetch($sql);

if (!$row) {
    echo "<div class='container mt-5'><div class='alert alert-warning'>해당 건축주 정보를 찾을 수 없습니다.</div></div>";
    include_once(NONE_PATH.'/footer.php');
    exit;
}

// 함수들 (이미 none.functions.php에 정의되어 있을 경우 중복 선언 방지)
if (!function_exists('get_owner_txt')) {
    function get_owner_txt($ptype) {
        return htmlspecialchars($ptype);
    }
}
?>
    
<!-- 건축주 상세정보 -->
<div class="container mt-5">
    <h3>건축주 상세 정보</h3>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>사업자등록번호</th>
                <td><?php echo htmlspecialchars($row['no_bnum']); ?></td>
            </tr>
            <tr>
                <th>법인주소</th>
                <td><?php echo htmlspecialchars($row['no_baddr']); ?></td>
            </tr>
            <tr>
                <th>법인 이메일</th>
                <td><?php echo htmlspecialchars($row['no_bemail']); ?></td>
            </tr>
            <tr>
                <th>성명</th>
                <td><?php echo htmlspecialchars($row['no_name']); ?></td>
            </tr>
            <tr>
                <th>연락처</th>
                <td><?php echo htmlspecialchars($row['no_tel']); ?></td>
            </tr>
            <tr>
                <th>휴대전화</th>
                <td><?php echo htmlspecialchars($row['no_hp']); ?></td>
            </tr>
            <tr>
                <th>개인 이메일</th>
                <td><?php echo htmlspecialchars($row['no_email']); ?></td>
            </tr>
            <tr>
                <th>개인 주소</th>
                <td><?php echo htmlspecialchars($row['no_addr']); ?></td>
            </tr>
            <tr>
                <th>메모</th>
                <td><?php echo nl2br(htmlspecialchars($row['no_memo'])); ?></td>
            </tr>
        </tbody>
    </table>
    
</div>

<style>
/* 테이블 스타일 조정 */
.table-bordered th, .table-bordered td {
    padding: 10px;
    vertical-align: middle;
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
    .btn {
        padding: 6px 12px;
        font-size: 14px;
    }
}
</style>

<?php include_once(NONE_PATH.'/footer.php'); ?>
