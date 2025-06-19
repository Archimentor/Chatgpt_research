<?php 
include_once('../../_common.php');

if(!$_POST['department']) exit;

$sql = " select mb_id, mb_name from g5_member where mb_2 = '{$department}' and mb_level2 != 4 and mb_id !='admin'  order by mb_name asc";
$rst = sql_query($sql);

if(is_mobile()) echo '<option value="">선택하세요</option>';

for($i=0; $row=sql_fetch_array($rst); $i++) {
?>
<option value="<?php echo $row['mb_id']?>"><?php echo $row['mb_name']?></option>

<?php }?>	

	
	