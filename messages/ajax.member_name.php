<?php
/* 사원 id → 이름 반환 (답장 모드에서 Ajax로 호출) */
require_once $_SERVER['DOCUMENT_ROOT'].'/_common.php';

$id = addslashes($_POST['id'] ?? '');
$row = sql_fetch("SELECT mb_name FROM g5_member WHERE mb_id='{$id}'");
echo $row['mb_name'] ?? $id;
