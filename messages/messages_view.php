<?php
/*-------------------------------------------------
  쪽지 상세 보기 - 개선된 UI (직급 표시 수정)
--------------------------------------------------*/
include_once $_SERVER['DOCUMENT_ROOT'] . '/_common.php';
if ($is_guest) {
    goto_url('/member/login.php');
}

$me     = $member['mb_id'];
$msg_id = (int) ($_GET['msg_id'] ?? 0);
$box    = ($_GET['box'] ?? 'in') === 'out' ? 'out' : 'in';

/* 본문 + 권한 체크 */
$sql_select = "SELECT m.* ";
$sql_from = "";
$sql_where = "";

if ($box === 'in') {
    $sql_select .= ", r.is_read, r.read_at ";
    $sql_from = " FROM none_member_message_recipient r JOIN none_member_message m ON m.msg_id = r.msg_id ";
    $sql_where = " WHERE r.msg_id = '{$msg_id}' AND r.receiver_id = '{$me}' ";
} else {
    $sql_from = " FROM none_member_message m ";
    $sql_where = " WHERE m.msg_id = '{$msg_id}' AND m.sender_id = '{$me}' ";
}

$row = sql_fetch($sql_select . $sql_from . $sql_where);

if (!$row) {
    alert('볼 수 없는 쪽지입니다.', 'messages_list.php');
}

/* 읽음 처리 (받은 쪽지 처음 볼 때) */
if ($box === 'in' && !$row['is_read']) {
    sql_query("UPDATE none_member_message_recipient
               SET is_read = 1, read_at = NOW()
               WHERE msg_id = '{$msg_id}' AND receiver_id = '{$me}'");
    // 페이지 새로고침 시 다시 업데이트되는 것을 방지하기 위해 is_read 상태를 1로 변경
    $row['is_read'] = 1;
}

// ★ 여러 사용자 ID로 이름+직급(텍스트) 가져오는 함수 수정 ★
function get_recipient_details(array $ids)
{
    global $g5; // GnuBoard 등 사용 시 필요
    if (empty($ids)) {
        return [];
    }
    $details = [];
    $ids_str = "'" . implode("','", array_map('sql_real_escape_string', $ids)) . "'";
    // 실제 환경에 맞게 테이블명과 컬럼명 확인 필요
    $sql = "SELECT mb_id, mb_name, mb_3
            FROM {$g5['member_table']}
            WHERE mb_id IN ({$ids_str})";
    $result = sql_query($sql);
    while ($r = sql_fetch_array($result)) {
         $name_part = trim($r['mb_name']);
         $position_part = ''; // 직급 텍스트 초기화

         // mb_3 값이 있고, get_mposition_txt 함수가 존재하는지 확인
         if (!empty($r['mb_3']) && function_exists('get_mposition_txt')) {
             // get_mposition_txt 함수를 사용하여 직급 코드(mb_3)를 텍스트로 변환
             $position_text = get_mposition_txt($r['mb_3']);
             if ($position_text) {
                 $position_part = ' ' . $position_text; // 변환된 텍스트가 있으면 공백과 함께 추가
             }
         }
         // 변환 함수가 없거나 mb_3 값이 비어있으면 $position_part는 빈 문자열 유지

         // 이름과 직급(텍스트) 합치기 (이름이 없으면 ID 사용)
         $details[$r['mb_id']] = ($name_part ? $name_part . $position_part : $r['mb_id']);
    }
    return $details;
    /* --- 이전 코드 ---
    while ($r = sql_fetch_array($result)) {
        // 이름(직급) 또는 이름 직급 형식 - 일관성 유지 (여기서는 '이름 직급' 사용)
        $name = trim($r['mb_name'] . ($r['mb_3'] ? ' ' . $r['mb_3'] : '')); // 숫자가 그대로 붙음
        $details[$r['mb_id']] = $name ?: $r['mb_id']; // 이름 없으면 ID 사용
    }
    return $details;
    */
}

// 보낸 사람 정보 가져오기 (수정된 함수 사용)
$sender_details = get_recipient_details([$row['sender_id']]);
$sender_name = htmlspecialchars($sender_details[$row['sender_id']] ?? $row['sender_id']);

// 받는 사람 목록 가져오기 (수정된 함수 사용)
$recipient_ids = [];
$q = sql_query("SELECT receiver_id FROM none_member_message_recipient WHERE msg_id='{$msg_id}'");
while ($r = sql_fetch_array($q)) {
    $recipient_ids[] = $r['receiver_id'];
}
$recipient_details = get_recipient_details($recipient_ids);

// 제목 및 내용 이스케이프 처리
$subject = htmlspecialchars($row['subject'] ?: '(제목 없음)');
$content = nl2br(htmlspecialchars($row['content'])); // nl2br로 줄바꿈 처리

// 날짜 형식화
$sent_at_formatted = date('Y년 m월 d일 H:i', strtotime($row['sent_at']));
$read_at_formatted = ($box === 'in' && isset($row['read_at']) && $row['read_at']) ? date('Y년 m월 d일 H:i', strtotime($row['read_at'])) : null;

?>
<!doctype html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>쪽지 보기: <?php echo $subject; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* 스타일은 이전과 동일하게 유지 */
        body { background-color: #f8f9fa; }
        .container { max-width: 960px; }
        .message-header { padding-bottom: 1rem; margin-bottom: 1rem; border-bottom: 1px solid #dee2e6; }
        .message-header .sender-info { display: flex; align-items: center; gap: 0.5rem; font-weight: 500; }
        .message-header .date-info { font-size: 0.875rem; color: #6c757d; }
        .message-recipients { margin-top: 0.75rem; font-size: 0.9rem; }
        .recipient-badge { font-size: 0.8rem; margin-right: 0.3rem; margin-bottom: 0.3rem; font-weight: normal; }
        .message-subject { margin-top: 1rem; margin-bottom: 1.5rem; font-size: 1.3rem; font-weight: 500; }
        .message-content { padding: 1.5rem 0; line-height: 1.7; white-space: pre-wrap; word-break: break-all; }
        .message-actions { margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; }
        .message-actions .btn-group { gap: 0.5rem; }
    </style>
</head>
<body class="p-3 p-md-4">
<div class="container">
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="message-header">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="sender-info">
                        <i class="bi bi-person-circle fs-4 text-secondary"></i>
                        <span><?php echo $sender_name; // 이제 직급 텍스트 포함 ?></span>
                    </div>
                    <div class="date-info text-end">
                        <span>보낸 시간: <?php echo $sent_at_formatted; ?></span>
                        <?php if ($read_at_formatted): ?>
                            <br><span class="text-primary">읽은 시간: <?php echo $read_at_formatted; ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="message-recipients text-muted">
                    <strong class="me-2">받는 사람:</strong>
                    <?php if (empty($recipient_details)): ?>
                        <span>정보 없음</span>
                    <?php else: ?>
                        <?php $count = 0; ?>
                        <?php foreach ($recipient_details as $id => $name): // $name 변수에 직급 텍스트 포함 ?>
                            <?php
                                // 받는 사람 목록 축약 표시 로직
                                if ($count >= 5 && count($recipient_details) > 7) {
                                     echo '<span class="badge bg-light text-dark border recipient-badge">+' . (count($recipient_details) - $count) . '명 더보기</span>';
                                     break;
                                }
                                $badge_class = ($id === $me) ? 'bg-primary' : 'bg-secondary';
                            ?>
                            <span class="badge <?php echo $badge_class; ?> recipient-badge"><?php echo htmlspecialchars($name); ?></span>
                            <?php $count++; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <h5 class="message-subject"><?php echo $subject; ?></h5>

            <div class="message-content">
                <?php echo $content; // 이미 nl2br, htmlspecialchars 처리됨 ?>
            </div>

            <div class="message-actions">
                <a href="messages_list.php?box=<?php echo $box; ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-list-ul me-1"></i> 목록으로
                </a>
                <div class="btn-group">
                    <?php // TODO: 삭제 기능 추가 시
                    /*
                    <form method="post" action="messages_delete_process.php" onsubmit="return confirm('이 쪽지를 삭제하시겠습니까?');" style="display: inline;">
                        <input type="hidden" name="msg_id" value="<?php echo $msg_id; ?>">
                        <input type="hidden" name="box" value="<?php echo $box; ?>">
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-trash me-1"></i> 삭제
                        </button>
                    </form>
                    */
                    ?>
                     <a href="messages_send.php?reply_to=<?php echo $msg_id; ?>" class="btn btn-primary">
                        <i class="bi bi-reply-fill me-1"></i> 답장하기
                    </a>
                </div>
            </div>

        </div> </div> </div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// 필요한 경우 여기에 JavaScript 추가 (예: 받는 사람 '더보기' 기능)
</script>
</body>
</html>