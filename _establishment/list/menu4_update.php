<?php 
include_once('../../_common.php');

if($is_guest) alert('로그인 후 이용바랍니다.');


sql_query("update g5_config set cf_1 = '$cf_1', cf_2 = '$cf_2', cf_3 = '$cf_3', cf_4 = '$cf_4', cf_5 = '$cf_5', cf_6 = '$cf_6', cf_7 = '$cf_7', cf_8 = '$cf_8', cf_1_subj = '$cf_1_subj', cf_2_subj = '$cf_2_subj', cf_3_subj = '$cf_3_subj', cf_4_subj = '$cf_4_subj'");

alert('기본공제요율이 업데이트 되었습니다.');