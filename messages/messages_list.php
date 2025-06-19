<?php
/*-------------------------------------------------
 쪽지함 목록 : 받은(in) / 보낸(out)
--------------------------------------------------*/
include_once $_SERVER['DOCUMENT_ROOT'] . '/_common.php';
if ($is_guest) {
    goto_url('/member/login.php');
}

$me = $member['mb_id'];
$box = (isset($_GET['box']) && $_GET['box'] === 'out') ? 'out' : 'in';
$page = max(1, (int) ($_GET['page'] ?? 1));
$rows = 15; // 페이지당 항목 수를 조절하여 UI 밀도를 조정할 수 있습니다.
$from = ($page - 1) * $rows;

// 이름 + 직급 함수 (기존 유지)
function name_pos($id)
{
    global $g5; // GnuBoard 사용 시 필요할 수 있음
    $m = sql_fetch("SELECT mb_name, mb_3 FROM {$g5['member_table']} WHERE mb_id='" . sql_real_escape_string($id) . "'");
    // 실제 환경에 맞게 테이블명과 컬럼명을 확인하세요. (예: get_mposition_txt 함수 존재 여부)
    // return $m ? trim($m['mb_name'] . ' ' . get_mposition_txt($m['mb_3'])) : $id;
    // get_mposition_txt 함수가 없다면 간단하게 이름만 반환하거나 직급 필드를 직접 사용
    return $m ? trim($m['mb_name'].' '.get_mposition_txt($m['mb_3'])) : $id;
}

// 데이터 조회
$sql_common = "";
$sql_order = " ORDER BY m.sent_at DESC ";
$sql_limit = " LIMIT {$from}, {$rows} ";

if ($box === 'in') {
    // 받은 쪽지함
    $sql_where = " WHERE r.receiver_id = '{$me}' AND r.is_archived = 0 ";

    $count_sql = "SELECT COUNT(*) AS cnt
                  FROM none_member_message_recipient r
                  {$sql_where}";

    $list_sql = "SELECT m.msg_id, m.sender_id, m.subject, m.sent_at, r.is_read
                 FROM none_member_message_recipient r
                 JOIN none_member_message m ON m.msg_id = r.msg_id
                 {$sql_where}
                 {$sql_order}
                 {$sql_limit}";
    $col_count = 4; // 테이블 컬럼 수 (번호, 보낸사람, 제목, 날짜)

} else {
    // 보낸 쪽지함
    $sql_where = " WHERE m.sender_id = '{$me}' ";

    $count_sql = "SELECT COUNT(*) AS cnt
                  FROM none_member_message m
                  {$sql_where}";

    $list_sql = "SELECT m.msg_id, m.subject, m.sent_at,
                        (SELECT GROUP_CONCAT(mmr.receiver_id SEPARATOR ', ')
                         FROM none_member_message_recipient mmr
                         WHERE mmr.msg_id = m.msg_id) AS recipients_ids,
                        (SELECT COUNT(*)
                         FROM none_member_message_recipient mmr
                         WHERE mmr.msg_id = m.msg_id) AS total_recipients,
                        (SELECT COUNT(*)
                         FROM none_member_message_recipient mmr
                         WHERE mmr.msg_id = m.msg_id AND mmr.is_read = 1) AS read_recipients
                 FROM none_member_message m
                 {$sql_where}
                 {$sql_order}
                 {$sql_limit}";
     $col_count = 5; // 테이블 컬럼 수 (번호, 받는사람, 제목, 확인, 날짜)
}

$total_result = sql_fetch($count_sql);
$total = $total_result['cnt'] ?? 0;
$total_page = ceil($total / $rows);
$res = sql_query($list_sql);

?>
<!doctype html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>쪽지함 - <?php echo $box === 'in' ? '받은 쪽지' : '보낸 쪽지'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* 전체 배경색 약간 변경 */
        }
        .container {
            max-width: 1140px; /* 컨텐츠 최대 너비 설정 */
        }
        .message-list .list-group-item {
            border-left: 4px solid transparent; /* 읽음/안읽음 표시를 위해 왼쪽 테두리 활용 */
            transition: background-color 0.15s ease-in-out;
        }
        .message-list .list-group-item:hover {
            background-color: #e9ecef; /* 호버 효과 */
            cursor: pointer;
        }
        .message-list .list-group-item.unread {
            font-weight: bold; /* 안 읽은 메시지 강조 */
            border-left-color: var(--bs-primary); /* 안 읽은 메시지 왼쪽 테두리 색상 */
            background-color: #fff; /* 안 읽은 메시지 배경색 */
        }
         .message-list .list-group-item.read {
             color: #6c757d; /* 읽은 메시지 텍스트 약간 흐리게 */
             background-color: #f8f9fa; /* 읽은 메시지 배경색 */
         }
        .message-actor { /* 보낸사람/받는사람 영역 스타일 */
            font-size: 0.9rem;
            color: #495057;
            display: flex;
            align-items: center;
        }
        .message-subject { /* 제목 영역 스타일 */
            display: block; /* 제목이 길 경우 다음 줄로 넘어가도록 */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis; /* 긴 제목은 ... 처리 */
            font-size: 1rem;
            margin-bottom: 0.1rem; /* 제목과 날짜 사이 간격 */
        }
        .message-date { /* 날짜 영역 스타일 */
            font-size: 0.8rem;
            color: #6c757d;
        }
        .message-read-status { /* 보낸 쪽지 읽음 상태 */
            font-size: 0.8rem;
            color: #6c757d;
        }
        .nav-tabs .nav-link {
             color: #6c757d;
        }
        .nav-tabs .nav-link.active {
            color: #0d6efd;
            font-weight: bold;
            border-color: #dee2e6 #dee2e6 #fff;
        }
        .card {
            border: none; /* 카드 테두리 제거 */
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); /* 그림자 효과 약간 조정 */
        }
        .pagination .page-link {
            color: #0d6efd;
        }
         .pagination .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
         .no-messages {
            text-align: center;
            padding: 3rem 0;
            color: #6c757d;
         }
    </style>
</head>
<body class="p-3 p-md-4">
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0"><i class="bi bi-envelope-paper me-2"></i>쪽지함</h3>
        <a href="messages_send.php" class="btn btn-primary">
            <i class="bi bi-pencil-square me-1"></i> 새 쪽지 작성
        </a>
    </div>

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link <?php echo $box === 'in' ? 'active' : ''; ?>" aria-current="<?php echo $box === 'in' ? 'page' : 'false'; ?>" href="?box=in">
                <i class="bi bi-inbox-fill me-1"></i> 받은 쪽지함
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $box === 'out' ? 'active' : ''; ?>" aria-current="<?php echo $box === 'out' ? 'page' : 'false'; ?>" href="?box=out">
                <i class="bi bi-send-fill me-1"></i> 보낸 쪽지함
            </a>
        </li>
    </ul>

    <div class="card">
        <div class="list-group list-group-flush message-list">
            <?php if (!$total) : ?>
                <div class="list-group-item no-messages">
                    <?php echo $box === 'in' ? '받은 쪽지가 없습니다.' : '보낸 쪽지가 없습니다.'; ?>
                </div>
            <?php else :
                $list_num = $total - $from; // 번호 부여 (역순)
                while ($row = sql_fetch_array($res)) :
                    $link = 'messages_view.php?msg_id=' . $row['msg_id'] . '&box=' . $box;
                    $subject = htmlspecialchars($row['subject'] ?: '(제목 없음)');
                    $sent_at = date('Y-m-d H:i', strtotime($row['sent_at']));

                    if ($box === 'in') {
                        // 받은 쪽지
                        $is_read = (bool) $row['is_read'];
                        $item_class = $is_read ? 'read' : 'unread';
                        $actor_name = htmlspecialchars(name_pos($row['sender_id']));
                        $actor_icon = '<i class="bi bi-person-circle me-1"></i>';
                        $badge = !$is_read ? '<span class="badge bg-primary rounded-pill ms-2">N</span>' : ''; // 안읽음 배지 스타일 변경
                    } else {
                        // 보낸 쪽지
                        $item_class = 'read'; // 보낸 쪽지는 항상 '읽음' 상태로 표시 (구분을 위해)
                        $actor_name = ''; // 보낸 쪽지 목록에서는 받는 사람을 제목 아래나 다른 곳에 표시 가능
                        $recipient_ids = explode(', ', $row['recipients_ids'] ?? '');
                        $recipient_names = [];
                        if (!empty($recipient_ids)) {
                            foreach ($recipient_ids as $recipient_id) {
                                if (trim($recipient_id)) {
                                     $recipient_names[] = htmlspecialchars(name_pos(trim($recipient_id)));
                                }
                            }
                        }
                         $actor_name = !empty($recipient_names) ? implode(', ', $recipient_names) : '알 수 없음';
                         if (count($recipient_names) > 2) { // 받는 사람이 너무 많으면 첫 2명 + 외 N명 표시
                             $actor_name = $recipient_names[0] . ', ' . $recipient_names[1] . ' 외 ' . (count($recipient_names) - 2) . '명';
                         }

                        $actor_icon = '<i class="bi bi-people-fill me-1"></i>'; // 받는 사람 아이콘 변경
                        $read_status = "{$row['read_recipients']} / {$row['total_recipients']} 확인";
                        $badge = '';
                    }
            ?>
            <a href="<?php echo $link; ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center <?php echo $item_class; ?>">
                <div style="flex-grow: 1; min-width: 0;"> <div class="d-flex w-100 justify-content-between mb-1">
                        <span class="message-actor">
                            <?php echo $actor_icon; ?>
                            <?php echo $actor_name; ?>
                        </span>
                        <small class="message-date text-nowrap"><?php echo $sent_at; ?></small>
                    </div>
                    <span class="message-subject">
                        <?php echo $subject; ?>
                         <?php echo $badge; ?>
                    </span>
                    <?php if ($box === 'out'): ?>
                        <small class="message-read-status"><?php echo $read_status; ?></small>
                    <?php endif; ?>
                </div>
                </a>
            <?php
                endwhile;
            endif; ?>
        </div><?php if ($total_page > 1) : ?>
            <div class="card-footer bg-light border-top-0 pt-3 pb-2">
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm justify-content-center mb-0">
                        <?php if ($page > 1) : ?>
                            <li class="page-item"><a class="page-link" href="?box=<?php echo $box; ?>&page=1" aria-label="First"><i class="bi bi-chevron-double-left"></i></a></li>
                            <li class="page-item"><a class="page-link" href="?box=<?php echo $box; ?>&page=<?php echo $page - 1; ?>" aria-label="Previous"><i class="bi bi-chevron-left"></i></a></li>
                        <?php endif; ?>

                        <?php
                        // 페이지네이션 범위 설정 (예: 현재 페이지 기준 앞뒤 2개씩)
                        $start_page = max(1, $page - 2);
                        $end_page = min($total_page, $page + 2);

                        // 시작 페이지 보정 (항상 5개 표시 시도)
                         if ($end_page - $start_page < 4) {
                             if ($start_page == 1) {
                                 $end_page = min($total_page, $start_page + 4);
                             } elseif ($end_page == $total_page) {
                                 $start_page = max(1, $end_page - 4);
                             }
                         }

                        if ($start_page > 1) {
                            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        }

                        for ($p = $start_page; $p <= $end_page; $p++) : ?>
                            <li class="page-item <?php echo $p == $page ? 'active' : ''; ?>">
                                <a class="page-link" href="?box=<?php echo $box; ?>&page=<?php echo $p; ?>"><?php echo $p; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($end_page < $total_page) : ?>
                             <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>

                        <?php if ($page < $total_page) : ?>
                            <li class="page-item"><a class="page-link" href="?box=<?php echo $box; ?>&page=<?php echo $page + 1; ?>" aria-label="Next"><i class="bi bi-chevron-right"></i></a></li>
                            <li class="page-item"><a class="page-link" href="?box=<?php echo $box; ?>&page=<?php echo $total_page; ?>" aria-label="Last"><i class="bi bi-chevron-double-right"></i></a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        <?php endif; ?>
    </div></div><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Optional: Add tooltips for recipient lists or other elements if needed
    // const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    // const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>
</body>
</html>