<<<<<<< HEAD
<?php
// 로그인 여부 확인 및 유틸
function api_current_user(): ?array
{
    if (empty($_SESSION['ss_mb_id'])) {
        return null;
    }
    // get_member()는 기존 common.lib.php 내부 함수
    return get_member($_SESSION['ss_mb_id']);
}

function api_require_login(): void
{
    if (!api_current_user()) {
        http_response_code(401);
        echo json_encode(['error' => 'login_required'], JSON_UNESCAPED_UNICODE);
        exit;
    }
}
?>
=======
<?php
// 로그인 여부 확인 및 유틸
function api_current_user(): ?array
{
    if (empty($_SESSION['ss_mb_id'])) {
        return null;
    }
    // get_member()는 기존 common.lib.php 내부 함수
    return get_member($_SESSION['ss_mb_id']);
}

function api_require_login(): void
{
    if (!api_current_user()) {
        http_response_code(401);
        echo json_encode(['error' => 'login_required'], JSON_UNESCAPED_UNICODE);
        exit;
    }
}
?>
>>>>>>> 69f791cde02b16cc5a8feee16c1c289d9e9d0fcf
