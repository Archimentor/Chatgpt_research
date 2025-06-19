<?php 
// 에러 표시 비활성화 (운영 환경에서는 권장)
ini_set('display_errors', 0); // 운영 환경에서는 0으로 설정
ini_set('display_startup_errors', 0);
error_reporting(0);

// 공통 파일 포함
include_once('../../_common.php');
define('menu_enterprise', true);

// 건축사 ID 가져오기 (seq 값을 사용)
$architect_id = isset($_GET['architect_id']) ? intval($_GET['architect_id']) : 0;

if ($architect_id <= 0) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>유효하지 않은 건축사 ID입니다.</div></div>";
    include_once(NONE_PATH.'/footer.php');
    exit;
}

// 데이터베이스에서 건축사 정보 조회 (Prepared Statement 사용 권장)
$sql = "SELECT * FROM {$none['enterprise_list']} WHERE seq = '{$architect_id}' LIMIT 1";
$row = sql_fetch($sql);

if (!$row) {
    echo "<div class='container mt-5'><div class='alert alert-warning'>해당 건축사 정보를 찾을 수 없습니다.</div></div>";
    include_once(NONE_PATH.'/footer.php');
    exit;
}

// 함수들 (이미 none.functions.php에 정의되어 있을 경우 중복 선언 방지)
if (!function_exists('get_enterprise_txt')) {
    function get_enterprise_txt($ptype) {
        return htmlspecialchars($ptype);
    }
}
?>
    
<!-- 건축사 상세정보 -->
<div class="container mt-5">
    <h3>건축사 상세 정보</h3>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>대표자</th>
                <td><?php echo htmlspecialchars($row['no_bname']); ?></td>
            </tr>
            <tr>
                <th>대표번호</th>
                <td><?php echo htmlspecialchars($row['no_btel']); ?></td>
            </tr>
            <tr>
                <th>팩스번호</th>
                <td><?php echo htmlspecialchars($row['no_bfax']); ?></td>
            </tr>
            <tr>
                <th>이메일</th>
                <td><?php echo htmlspecialchars($row['no_bemail']); ?></td>
            </tr>
            <tr>
                <th>주소</th>
                <td><?php echo htmlspecialchars($row['no_baddr']); ?></td>
            </tr>
            <tr>
                <th>담당자</th>
                <td>
                    <?php 
                        echo htmlspecialchars($row['no_name']) . ' ' . htmlspecialchars($row['no_position']);
                    ?>
                </td>
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
