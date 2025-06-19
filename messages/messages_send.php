<?php
/* -------------------------------------------------------------
   쪽지 쓰기 & 답장 (reply_to 파라미터 지원) - 원본 기능 유지 + UI 개선 (직급 표시 수정)
------------------------------------------------------------- */
require_once $_SERVER['DOCUMENT_ROOT'] . '/_common.php';
if ($is_guest) {
    goto_url('/member/login.php');
}

$me = $member['mb_id'];
$reply_to = (int) ($_GET['reply_to'] ?? 0);
$parent_id = 0;
$prefill_recipients = []; // 답장용 수신자 정보 [id => name]
$prefill_subj = '';

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
    while ($row = sql_fetch_array($result)) {
        $name = trim($row['mb_name'] . ($row['mb_3'] ? ' ' . $row['mb_3'] : '')); // 숫자가 그대로 붙음
        $details[$row['mb_id']] = $name ?: $row['mb_id']; // 이름 없으면 ID 사용
    }
    return $details;
    */
}

/* ─ 답장 모드 처리 (이전과 동일) ─ */
if ($reply_to) {
    $orig = sql_fetch("SELECT * FROM none_member_message WHERE msg_id='{$reply_to}'");
    if (!$orig) {
        alert('원본 쪽지를 찾을 수 없습니다.', 'messages_list.php');
    }

    $is_sender = $orig['sender_id'] === $me;
    $is_receiver = sql_fetch("SELECT 1 FROM none_member_message_recipient
                              WHERE msg_id='{$reply_to}' AND receiver_id='{$me}'");
    if (!$is_sender && !$is_receiver) {
        alert('답장할 권한이 없습니다.', 'messages_list.php');
    }

    $parent_id = $orig['parent_id'] ?: $orig['msg_id'];

    $recipient_ids_to_fetch = [];
    if ($is_sender) { // 내가 보낸 쪽지: 모든 수신자 (나 제외)
        $q = sql_query("SELECT receiver_id FROM none_member_message_recipient
                        WHERE msg_id='{$reply_to}' AND receiver_id != '{$me}'");
        while ($r = sql_fetch_array($q)) {
            $recipient_ids_to_fetch[] = $r['receiver_id'];
        }
    } else { // 내가 받은 쪽지: 원본 보낸 사람 (내가 아니라면)
        if ($orig['sender_id'] !== $me) {
            $recipient_ids_to_fetch[] = $orig['sender_id'];
        }
    }

    // 한 번의 쿼리로 모든 수신자 정보 가져오기 (수정된 함수 사용)
    if (!empty($recipient_ids_to_fetch)) {
        $prefill_recipients = get_recipient_details($recipient_ids_to_fetch);
    }

    $prefill_subj = preg_match('/^Re:/i', $orig['subject'])
        ? $orig['subject']
        : 'Re: ' . $orig['subject'];
}

/* ─ 부서 목록 (고정) ─ */
$departments = [
    5 => '기획관리부', 3 => '관리부', 2 => '공무부',
    1 => '공사부',   4 => '연구부', 10 => '계약직'
];


/* ─ 전송 처리 (이전과 동일) ─ */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ids = array_unique(array_map('trim', $_POST['recipient_ids'] ?? []));
    if (empty($ids)) {
        alert('수신자를 선택하세요.');
    }

    // 실제 사용 시에는 Prepared Statements 사용 권장
    $subject = addslashes(trim($_POST['subject']));
    $content = addslashes(trim($_POST['content']));
    $parent = $_POST['parent_id'] ? (int)$_POST['parent_id'] : 'NULL';

    // 본문 저장
    sql_query("INSERT INTO none_member_message (sender_id, subject, content, parent_id)
               VALUES ('{$me}', '{$subject}', '{$content}', {$parent})");
    $msg_id = sql_insert_id();

    // 수신자 저장
    $values = [];
    foreach ($ids as $rid) {
        $rid_escaped = sql_real_escape_string(trim($rid));
        if ($rid_escaped) { // 빈 값 체크
            $values[] = "('{$msg_id}', '{$rid_escaped}')";
        }
    }
    if (!empty($values)) {
        sql_query("INSERT INTO none_member_message_recipient (msg_id, receiver_id) VALUES " . implode(',', $values));
    }

    // 성공 메시지 처리 개선 (예: 세션 플래시 메시지 또는 파라미터 전달)
    alert('쪽지를 보냈습니다.', 'messages_list.php?box=out&sent=1'); // sent=1 추가
    exit;
}
?>
<!doctype html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $reply_to ? '답장 쓰기' : '새 쪽지 작성'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* 개선된 UI 스타일 유지 */
        body { background-color: #f8f9fa; }
        .container { max-width: 960px; }
        .recipient-selector { border: 1px solid #dee2e6; border-radius: 0.375rem; height: 250px; overflow-y: auto; padding: 0.5rem; background-color: #fff; }
        .recipient-selector.bg-light { background-color: #f8f9fa !important; }
        #employee-list .list-group-item { cursor: pointer; padding: 0.5rem 0.75rem; font-size: 0.9rem; border: none; border-bottom: 1px solid #eee; }
        #employee-list .list-group-item:last-child { border-bottom: none; }
        #employee-list .list-group-item:hover { background-color: #e9ecef; }
        #employee-list .list-group-item.disabled { color: #6c757d; background-color: transparent; cursor: default; }
        #selected-recipients { list-style: none; padding: 0; margin: 0; }
        #selected-recipients .recipient-tag { display: inline-flex; align-items: center; background-color: #0d6efd; color: #fff; padding: 0.25rem 0.6rem; margin: 0.2rem; border-radius: 50rem; font-size: 0.85rem; line-height: 1; white-space: nowrap; cursor: default; }
        #selected-recipients .recipient-tag .remove-recipient { color: #fff; margin-left: 0.5rem; cursor: pointer; opacity: 0.7; transition: opacity 0.15s ease-in-out; }
        #selected-recipients .recipient-tag .remove-recipient:hover { opacity: 1; }
        .form-actions { margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 0.5rem; }
    </style>
</head>
<body class="p-3 p-md-4">
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-light">
             <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i><?php echo $reply_to ? '답장 쓰기' : '새 쪽지 작성'; ?></h4>
             <?php if ($reply_to && $orig): // 답장 시 원본 정보 요약 표시 (수정된 함수 사용) ?>
             <small class="text-muted d-block mt-1">
                 원본: <?php echo htmlspecialchars($orig['subject']); ?> (<?php echo htmlspecialchars(get_recipient_details([$orig['sender_id']])[$orig['sender_id']] ?? $orig['sender_id']); // 이제 직급 텍스트 포함 ?>, <?php echo date('y-m-d H:i', strtotime($orig['sent_at'])); ?>)
             </small>
             <?php endif; ?>
        </div>
        <div class="card-body">
            <form id="msgFrm" method="post" novalidate>
                <input type="hidden" name="parent_id" value="<?php echo $parent_id; ?>">

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label for="dept_sel" class="form-label fw-bold">1. 부서 선택</label>
                        <select id="dept_sel" class="form-select">
                            <option value="">-- 부서 선택 --</option>
                            <?php foreach ($departments as $k => $v) : ?>
                                <option value="<?php echo $k; ?>"><?php echo htmlspecialchars($v); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="employee-list" class="form-label fw-bold">2. 사원 선택 (클릭 시 추가)</label>
                        <div id="employee-list" class="recipient-selector list-group">
                            <span class="list-group-item disabled">부서를 선택해주세요.</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="selected-recipients" class="form-label fw-bold">3. 받는 사람</label>
                        <div id="selected-list-wrapper" class="recipient-selector bg-light">
                            <ul id="selected-recipients">
                                </ul>
                        </div>
                        <div id="recipient-hidden-inputs"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="subject" class="form-label fw-bold">제목</label>
                    <input type="text" id="subject" name="subject" class="form-control" required value="<?php echo htmlspecialchars($prefill_subj); ?>">
                    <div class="invalid-feedback">제목을 입력해주세요.</div>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label fw-bold">내용</label>
                    <textarea id="content" name="content" rows="8" class="form-control" required></textarea>
                    <div class="invalid-feedback">내용을 입력해주세요.</div>
                </div>

                <div class="form-actions">
                    <a href="messages_list.php?box=in" class="btn btn-secondary">
                        <i class="bi bi-list-ul me-1"></i> 목록
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send me-1"></i> 보내기
                    </button>
                </div>
            </form>
        </div> </div> </div> <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(function() {
    const $employeeList = $('#employee-list');
    const $selectedRecipients = $('#selected-recipients');
    const $recipientHiddenInputs = $('#recipient-hidden-inputs');
    const $form = $('#msgFrm');

    // 부서 변경 시 사원 목록 로드 (원본 기능 유지 - HTML 응답 처리)
    $('#dept_sel').on('change', function() {
        const deptId = $(this).val();
        $employeeList.html('<span class="list-group-item disabled"><div class="spinner-border spinner-border-sm me-2" role="status"></div> 로딩 중...</span>');

        if (!deptId) {
            $employeeList.html('<span class="list-group-item disabled">부서를 선택해주세요.</span>');
            return;
        }

        $.post('ajax.department.php', { department: deptId }, function(htmlResponse) {
            $employeeList.empty();
            let hasEmployees = false;

            if (htmlResponse && htmlResponse.trim() !== '') {
                 try {
                    const $options = $($.parseHTML(htmlResponse));
                    $options.each(function() {
                        if (this.tagName === 'OPTION') {
                            const $option = $(this);
                            const id = $option.val();
                            const name = $option.text(); // ★ ajax.department.php가 반환하는 이름 (직급 포함 여부 확인 필요)

                            if (!id) return true;
                            if (id === '<?php echo $me; ?>') return true;

                            hasEmployees = true;
                            const isSelected = $recipientHiddenInputs.find('input[value="' + id + '"]').length > 0;

                            // list-group-item 생성 시 data-name에도 이름 저장
                            const $item = $('<a href="#">')
                                .addClass('list-group-item list-group-item-action')
                                .attr('data-id', id)
                                .attr('data-name', name) // 여기서 저장된 이름이 addRecipient에 사용됨
                                .text(name);

                            if (isSelected) {
                                $item.addClass('disabled').css('text-decoration', 'line-through');
                            }
                            $employeeList.append($item);
                        }
                    });
                 } catch (e) {
                     console.error("Error parsing HTML response:", e);
                     $employeeList.html('<span class="list-group-item disabled text-danger">응답 처리 중 오류가 발생했습니다.</span>');
                     return;
                 }
            }

            if (!hasEmployees) {
                 $employeeList.html('<span class="list-group-item disabled">해당 부서에 사원이 없습니다.</span>');
            }

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX POST Error:", textStatus, errorThrown);
            $employeeList.html('<span class="list-group-item disabled text-danger">사원 목록을 불러오는데 실패했습니다. (서버 오류 확인)</span>');
        });
    });

    // 사원 목록에서 클릭 시 수신자 추가 (개선된 방식 유지)
    $employeeList.on('click', '.list-group-item-action:not(.disabled)', function(e) {
        e.preventDefault();
        const $item = $(this);
        const id = $item.data('id');
        const name = $item.data('name'); // ★ data-name에서 이름 가져오기

        if ($recipientHiddenInputs.find('input[value="' + id + '"]').length > 0) {
            return;
        }
        // ★ addRecipient 호출 시 사용되는 name 변수에 직급이 포함되어야 함 ★
        addRecipient(id, name);
        $item.addClass('disabled').css('text-decoration', 'line-through');
    });

    // 선택된 수신자 태그 제거 (개선된 방식 유지)
    $selectedRecipients.on('click', '.remove-recipient', function() {
        const $tag = $(this).closest('.recipient-tag');
        const id = $tag.data('id');
        removeRecipient(id);
    });

    // 수신자 추가 함수 (개선된 방식 유지)
    function addRecipient(id, name) {
        // ★ 이 함수에 전달되는 name 값에 직급 텍스트가 포함되어 있어야 함 ★
        if (!id || !name) return;
        const $tag = $('<li>').addClass('recipient-tag').attr('data-id', id).text(name + ' ').append('<i class="bi bi-x-lg remove-recipient" role="button" title="제거"></i>');
        $selectedRecipients.append($tag);
        const $hiddenInput = $('<input>').attr('type', 'hidden').attr('name', 'recipient_ids[]').val(id);
        $recipientHiddenInputs.append($hiddenInput);
        $employeeList.find('.list-group-item-action[data-id="' + id + '"]').addClass('disabled').css('text-decoration', 'line-through');
    }

    // 수신자 제거 함수 (개선된 방식 유지)
    function removeRecipient(id) {
        $selectedRecipients.find('.recipient-tag[data-id="' + id + '"]').remove();
        $recipientHiddenInputs.find('input[value="' + id + '"]').remove();
        $employeeList.find('.list-group-item-action[data-id="' + id + '"]').removeClass('disabled').css('text-decoration', 'none');
    }

    // 폼 제출 시 유효성 검사 (개선된 방식 유지)
    $form.on('submit', function(event) {
        // ... (이전과 동일) ...
         if ($recipientHiddenInputs.find('input').length === 0) {
            alert('받는 사람을 1명 이상 선택해주세요.');
            event.preventDefault();
            event.stopPropagation();
            $('#selected-list-wrapper').addClass('border-danger');
            setTimeout(() => $('#selected-list-wrapper').removeClass('border-danger'), 2000);
            return false;
        }
        if (!this.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        $(this).addClass('was-validated');
    });

    // 답장 모드: 수신자 미리 채우기 (개선된 방식 유지 - 수정된 get_recipient_details 사용)
    const prefillData = <?php echo json_encode(array_map(function($id, $name) { return ['id' => $id, 'name' => $name]; }, array_keys($prefill_recipients), $prefill_recipients)); // $name에 직급 텍스트 포함됨 ?>;
    if (prefillData && prefillData.length > 0) {
        prefillData.forEach(function(recipient) {
            addRecipient(recipient.id, recipient.name); // 직급 포함된 이름 전달
        });
        // 페이지 로드 시 미리 채워진 수신자를 사원 목록에서도 비활성화 (만약 목록이 이미 있다면)
        if ($employeeList.find('.list-group-item-action').length > 0) {
             prefillData.forEach(function(recipient) {
                  $employeeList.find('.list-group-item-action[data-id="' + recipient.id + '"]')
                     .addClass('disabled').css('text-decoration', 'line-through');
             });
        }
    }

});
</script>
</body>
</html>