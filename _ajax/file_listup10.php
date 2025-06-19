<?php 
include_once('../_common.php');

if($is_guest)
	alert('로그인 후 이용바랍니다.');


if(!isset($_POST['id'])) die('no');
if(!isset($_POST['w'])) die('no');

$bo_table = "enterprise";

if($w == 'u')
	$sql = "select * from {$g5['board_file_table']} where bo_table = '{$bo_table}' and ( wr_id = '{$id}' or  bf_change_id = '{$id}' ) order by bf_category asc";
else 
	$sql = "select * from {$g5['board_file_table']} where bo_table = '{$bo_table}' and bf_change_id = '{$id}' order by bf_category asc";

$rst = sql_query($sql);
for($i=0; $row=sql_fetch_array($rst); $i++) {
	switch($row['bf_category']) {
		case 1 : $dirName = "사업자등록증"; break;
		case 2 : $dirName = "통장사본";break;
		case 3 : $dirName = "면허수첩";break;
		case 4 : $dirName = "건설업면허증"; break;
		case 5 : $dirName = "국세";break;
		case 6 : $dirName = "지방세"; break;
		case 7 : $dirName = "법인인감증명서";break;
		case 8 : $dirName = "사용인감계"; break;
		case 9 : $dirName = "등기부등본";break;
		case 10 : $dirName = "기타서류"; break;
	}
	
?>
<tr>
	<td><input type="hidden" name="file_list[]" value="<?php echo $row['bf_no']?>"><?php echo $dirName?></td>
	<td><?php echo $row['bf_source']?></td>
	<td><?php echo byteFormat($row['bf_filesize'], 'MB')?></td>
	
	<td><?php if($w == 'u') {?><a href="/_ajax/file_download.php?bo_table=<?php echo $bo_table?>&seq=<?php echo $row['seq']?>&wr_id=<?php echo $row['wr_id']?>" target="_blank"><span class="glyphicon fa fa-download"></span></a><?php }?></td>
	<td><button type="button" class="btn btn-secondary btn-sm" onclick="file_del(<?php echo $row['seq']?>)">삭제</button></td>
</tr>

<?php }

if($i == 0) echo '<tr><td colspan="5">등록 된 첨부파일이 없습니다.</td></tr>';
?>
<script>
//파일삭제 
function file_del(seq) {
	
	if(confirm('정말 삭제하시겠습니까?\n삭제 된 파일은 복구가 불가능합니다.')) {
		location.href = '/_ajax/file_delete10.php?w=d&seq='+seq;
	} else {
		return false;
	}
	
}
</script>