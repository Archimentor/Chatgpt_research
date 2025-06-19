<?php 
include_once('../_common.php');

if($is_guest)
	alert('로그인 후 이용바랍니다.');


if(!isset($_POST['id'])) die('no');
if(!isset($_POST['w'])) die('no');

$bo_table = "draft4";

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
	
	<td><?php if($w == 'u') {?><a href="/_ajax/file_download.php?bo_table=<?php echo $bo_table?>&seq=<?php echo $row['seq']?>&wr_id=<?php echo $row['wr_id']?>" target="_blank"><span class="glyphicon fa fa-download"></span></a><?php }?></td>
	<td><button type="button" class="btn btn-secondary btn-sm">삭제</button></td>
</tr>

<?php }

if($i == 0) echo '<tr><td colspan="5">등록 된 첨부파일이 없습니다.</td></tr>';