<?php 
include_once('../../_common.php');
define('menu_homepage', true);

if(!isset($_POST['seq'])) exit;

if($is_guest || $member['mb_level2'] == 2) exit;

$row = sql_fetch("select * from {$none['home_recruit']} where seq = '$seq'");

if(!$row) echo '<p>정보가 없습니다.</p>';

set_session('ss1_veiw_'.$row['seq'], true);
?>
<style>
.table th { background:#f2f2f2;border-bottom:1px solid #ccc; border-left:1px solid #ccc }
</style>
<table  class="table" >
  <tbody >
	<tr>
	  <th style="width:15%">이름</th>
	  <td style="width:35%;background:#fff"><?php echo $row['wr_name']?></td>
	  <th style="width:15%">생년월일</th>
	  <td style="width:35%;background:#fff"><?php echo $row['wr_birth']?> (<?php echo $row['wr_age']?>세)</td>
	</tr>
	<tr>
	  <th style="width:15%">휴대전화</th>
	  <td style="width:35%;background:#fff"><?php echo $row['wr_tel']?></td>
	  <th style="width:15%">통화가능시간</th>
	  <td style="width:35%;background:#fff"><?php if($row['wr_time_aways'] == 1) echo '언제나'; else echo $row['wr_time'].'시';?></td>
	</tr>
	<tr>
	  <th style="width:15%">이메일</th>
	  <td style="width:35%;background:#fff"><?php echo $row['wr_email']?></td>
	  <th style="width:15%">주소</th>
	  <td style="width:35%;background:#fff"><?php echo $row['wr_addr']?></td>
	</tr>
	
	<tr>
	  <th style="width:15%">희망연봉</th>
	  <td style="width:35%;background:#fff"><?php if($row['wr_pay_option'] == 1) echo '회사내규따름'; else echo $row['wr_pay'].'만원';?></td>
	  
	  <th style="width:15%">희망근무지</th>
	  <td style="width:35%;background:#fff"><?php echo $row['wr_area']?></td>
	</tr>
	<tr>
	  <th style="width:15%">이력서</th>
	  <td style="width:35%;background:#fff">
	    <?php if($row['wr_file1']) { ?>
			<a href="/homepage/update/recruit_download.php?seq=<?php echo $row['seq']?>&sort=1"><?php echo $row['wr_file1_name']?></a>
	    <?php } else { 
			echo '첨부없음'; 
		} ?>	  
		</td>
	  
	  <th style="width:15%">경력증명서</th>
	  <td style="width:35%;background:#fff">
	    <?php if($row['wr_file2']) { ?>
			<a href="/homepage/update/recruit_download.php?seq=<?php echo $row['seq']?>&sort=2"><?php echo $row['wr_file2_name']?></a>
	    <?php } else { 
			echo '첨부없음'; 
		} ?>	  
		</td>
	  
	</tr>
	<tr>
	  <th style="width:15%">기타1</th>
	  <td style="width:35%;background:#fff">
	    <?php if($row['wr_file3']) { ?>
			<a href="/homepage/update/recruit_download.php?seq=<?php echo $row['seq']?>&sort=3"><?php echo $row['wr_file3_name']?></a>
	    <?php } else { 
			echo '첨부없음'; 
		} ?>	  
		</td>
	  
	  <th style="width:15%">기타2</th>
	  <td style="width:35%;background:#fff">
	    <?php if($row['wr_file4']) { ?>
			<a href="/homepage/update/recruit_download.php?seq=<?php echo $row['seq']?>&sort=4"><?php echo $row['wr_file4_name']?></a>
	    <?php } else { 
			echo '첨부없음'; 
		} ?>	  
		</td>
	  
	</tr>
	<tr>
	  <th style="width:15%">기타3</th>
	  <td style="width:35%;background:#fff" >
	    <?php if($row['wr_file5']) { ?>
			<a href="/homepage/update/recruit_download.php?seq=<?php echo $row['seq']?>&sort=5"><?php echo $row['wr_file5_name']?></a>
	    <?php } else { 
			echo '첨부없음'; 
		} ?>	  
		</td>
	  <th style="width:15%">접수일시</th>
	  <td style="width:35%;background:#fff" ><?php echo $row['wr_datetime']?>
		</td>
	  
	  
	</tr>
	<tr>
	  <th style="width:15%">접수IP</th>
	  <td style="width:35%;background:#fff" ><?php echo $row['wr_ip'] ?></td>
	  <th style="width:15%">상태</th>
	  <td style="width:35%;background:#fff"><?php echo $row['wr_state'] ?></td>
	</tr>
	
  </tbody>
</table>