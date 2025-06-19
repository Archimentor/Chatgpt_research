<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/core/common.php';
header('Content-Type:text/html; charset=utf-8');
if ($is_guest){echo '<option>로그인 필요</option>';exit;}

$dept = isset($_POST['department']) ? trim($_POST['department']) : '';
if($dept===''){echo '<option>부서를 선택하세요</option>';exit;}

/* menu1_list.php 와 동일 조건 */
$sql="
  SELECT mb_id AS member_id, mb_name
    FROM {$g5['member_table']}
   WHERE mb_level = 10
     AND mb_id   != 'admin'
     AND mb_level2 != 4
     AND mb_2 = '{$dept}'
   ORDER BY mb_name";
$r=sql_query($sql);
if(!sql_num_rows($r)){echo '<option>사원 없음</option>';exit;}

while($row=sql_fetch_array($r)){
  echo '<option value="'.$row['member_id'].'">'.htmlspecialchars($row['mb_name']).'</option>';
}
