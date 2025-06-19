<?php 
include_once('../_common.php');

if($is_guest)
	alert('로그인 후 이용바랍니다.');


if(!isset($_POST['id'])) die('no');
if(!isset($_POST['w'])) die('no');

$bo_table = "repair";

if($w == 'u')
	$sql = "select * from {$g5['board_file_table']} where bo_table = '{$bo_table}' and ( wr_id = '{$id}' or  bf_change_id = '{$id}' ) order by bf_category asc";
else 
	$sql = "select * from {$g5['board_file_table']} where bo_table = '{$bo_table}' and bf_change_id = '{$id}' order by bf_category asc";

$rst = sql_query($sql);
for($i=0; $row=sql_fetch_array($rst); $i++) {


?>
<tr>
	<td><input type="hidden" name="file_list[]" value="<?php echo $row['bf_no']?>"><?php echo $row['bf_source']?></td>
	<td><?php echo byteFormat($row['bf_filesize'], 'MB')?></td>
	
	<td><?php if($w == 'u') {?><a href="/_data/repair/<?php echo $row['bf_file']?>" data-group="2" class="js-smartPhoto"><img src="/_data/repair/<?php echo $row['bf_file']?>" width="50" height="50"></a><?php }?></td>
	<td><?php if($w == 'u') {?><button type="button" class="btn btn-secondary btn-sm" onclick="file_del(<?php echo $row['seq']?>)">삭제</button><?php }?></td>
</tr>

<?php }

if($i == 0) echo '<tr><td colspan="5">등록 된 첨부파일이 없습니다.</td></tr>';
?>

<script>
new SmartPhoto(".js-smartPhoto");
//파일삭제 
function file_del(seq) {
	
	if(confirm('정말 삭제하시겠습니까?\n삭제 된 파일은 복구가 불가능합니다.')) {
		location.href = '/_ajax/file_delete11.php?w=d&seq='+seq;
	} else {
		return false;
	}
	
}
</script>