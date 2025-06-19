<?php
include_once('../../_common.php'); // 경로와 환경에 맞춰 조정
define('menu_holiday_management', true);
include_once(NONE_PATH.'/header.php');

$feedback_message = '';
$feedback_type = 'info';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    // 공휴일 추가
    if ($_POST['action'] === 'add' && isset($_POST['ch_date'], $_POST['ch_name'])) {
        $ch_date = trim($_POST['ch_date']);
        $ch_name = strip_tags(trim($_POST['ch_name']));

        if ($ch_date && $ch_name && strtotime($ch_date) !== false) {
            $ch_date_sql = sql_real_escape_string($ch_date);
            $ch_name_sql = sql_real_escape_string($ch_name);

            $sql_insert = "INSERT INTO none_member_holidays (ch_date, ch_name)
                           VALUES ('{$ch_date_sql}', '{$ch_name_sql}')";
            if (sql_query($sql_insert)) {
                $feedback_message = '"' . htmlspecialchars($ch_name) . '" 공휴일이 추가되었습니다.';
                $feedback_type = 'success';
            } else {
                $feedback_message = 'DB 오류로 공휴일 추가에 실패했습니다. (오류: ' . sql_error() . ')';
                $feedback_type = 'danger';
            }
        } else {
            $feedback_message = '날짜와 공휴일 이름을 정확히 입력하세요.';
            $feedback_type = 'warning';
        }
    }

    // 공휴일 삭제
    if ($_POST['action'] === 'delete' && isset($_POST['ch_id'])) {
        $ch_id = (int)$_POST['ch_id'];
        if ($ch_id > 0) {
            $row_del = sql_fetch("SELECT ch_name FROM none_member_holidays WHERE ch_id = {$ch_id}");
            $deleted_name = $row_del ? $row_del['ch_name'] : '';

            $sql_delete = "DELETE FROM none_member_holidays WHERE ch_id = {$ch_id}";
            if (sql_query($sql_delete)) {
                $feedback_message = '"' . htmlspecialchars($deleted_name) . '" 공휴일이 삭제되었습니다.';
                $feedback_type = 'success';
            } else {
                $feedback_message = 'DB 오류로 공휴일 삭제에 실패했습니다. (오류: ' . sql_error() . ')';
                $feedback_type = 'danger';
            }
        } else {
            $feedback_message = '잘못된 요청입니다.';
            $feedback_type = 'danger';
        }
    }
}

// 공휴일 목록 조회
$holiday_list = [];
$sql_select = "SELECT ch_id, ch_date, ch_name
               FROM none_member_holidays
               ORDER BY ch_date DESC";
$result = sql_query($sql_select);

if ($result) {
    while ($row = sql_fetch_array($result)) {
        $holiday_list[] = $row;
    }
} else {
    $feedback_message = '공휴일 목록을 불러오는 중 오류가 발생했습니다.';
    $feedback_type = 'danger';
}
?>

<style>
.feedback-alert { margin-top: 15px; }
.holiday-list-table td { vertical-align: middle; }
.form-inline .form-group { margin-bottom: 0.5rem; }
.form-inline .btn { margin-bottom: 0.5rem; }
</style>

<div id="main-content">
  <div class="container-fluid">
    <div class="block-header">
      <div class="row">
        <div class="col-lg-6 col-md-8 col-sm-12">
          <h2>
            <a href="javascript:history.back()" class="btn btn-xs btn-link" title="뒤로가기">
              <i class="fa fa-arrow-left"></i>
            </a> 공휴일 관리
          </h2>
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i> 홈</a></li>
            <li class="breadcrumb-item">직원 관리</li>
            <li class="breadcrumb-item active">공휴일 관리</li>
          </ul>
        </div>
      </div>
    </div>

    <?php if ($feedback_message): ?>
      <div class="alert alert-<?php echo $feedback_type; ?> feedback-alert alert-dismissible fade show">
        <?php echo $feedback_message; ?>
        <button type="button" class="close" data-dismiss="alert">
          <span>&times;</span>
        </button>
      </div>
    <?php endif; ?>

    <div class="row clearfix">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">신규 공휴일 추가</h3>
          </div>
          <div class="card-body">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-inline">
              <input type="hidden" name="action" value="add">
              <div class="form-group mb-2 mr-sm-3">
                <label for="ch_date" class="sr-only">날짜</label>
                <input type="date" class="form-control" id="ch_date" name="ch_date" required>
              </div>
              <div class="form-group mb-2 mr-sm-3">
                <label for="ch_name" class="sr-only">공휴일 이름</label>
                <input type="text" class="form-control" id="ch_name" name="ch_name"
                       placeholder="공휴일 이름" required>
              </div>
              <button type="submit" class="btn btn-primary mb-2">
                <i class="fa fa-plus"></i> 추가
              </button>
            </form>
            <small class="form-text text-muted">추가할 공휴일의 날짜와 이름을 입력하세요.</small>
          </div>
        </div>
      </div>
    </div>

    <div class="row clearfix">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">등록된 공휴일 목록</h3>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover table-striped holiday-list-table">
                <thead class="thead-light">
                  <tr>
                    <th style="width: 25%;">날짜</th>
                    <th>공휴일 이름</th>
                    <th style="width: 15%;" class="text-center">관리</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (count($holiday_list) > 0): ?>
                    <?php foreach ($holiday_list as $holiday): ?>
                      <tr>
                        <td><?php echo htmlspecialchars($holiday['ch_date']); ?></td>
                        <td><?php echo htmlspecialchars($holiday['ch_name']); ?></td>
                        <td class="text-center">
                          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"
                                style="display:inline;"
                                onsubmit="return confirm('<?php echo htmlspecialchars(addslashes($holiday['ch_name'])); ?> 공휴일을 삭제하시겠습니까?');">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="ch_id" value="<?php echo $holiday['ch_id']; ?>">
                            <button type="submit" class="btn btn-sm btn-danger">
                              <i class="fa fa-trash-o"></i> 삭제
                            </button>
                          </form>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="3" class="text-center">등록된 공휴일이 없습니다.</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
            <small class="form-text text-muted">이곳에 등록된 공휴일은 메인 달력에 표시됩니다.</small>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php include_once(NONE_PATH.'/footer.php'); ?>
