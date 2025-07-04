<<<<<<< HEAD
<?php
// 공통 코드/테이블 헬퍼
function table(string $key): ?string
{
    global $none;                     // _common.php에서 선언된 테이블 맵
    return $none[$key] ?? null;       // 예) table('sign_draft2') → 실제 테이블명
}

// 예시: 모든 전자결재 테이블 목록 반환
function approval_tables(): array
{
    return [
        table('sign_draft'),  // 기안서
        table('sign_draft2'), // 지출결의서
        table('sign_draft3'), // 설계변경
        table('sign_draft4'), // 무상처리
        table('sign_draft6')  // 사고경위서
    ];                        // 실제 테이블명들은 _common.php에서 정의 :contentReference[oaicite:4]{index=4}
}
?>
=======
<?php
// 공통 코드/테이블 헬퍼
function table(string $key): ?string
{
    global $none;                     // _common.php에서 선언된 테이블 맵
    return $none[$key] ?? null;       // 예) table('sign_draft2') → 실제 테이블명
}

// 예시: 모든 전자결재 테이블 목록 반환
function approval_tables(): array
{
    return [
        table('sign_draft'),  // 기안서
        table('sign_draft2'), // 지출결의서
        table('sign_draft3'), // 설계변경
        table('sign_draft4'), // 무상처리
        table('sign_draft6')  // 사고경위서
    ];                        // 실제 테이블명들은 _common.php에서 정의 :contentReference[oaicite:4]{index=4}
}
?>
>>>>>>> 69f791cde02b16cc5a8feee16c1c289d9e9d0fcf
