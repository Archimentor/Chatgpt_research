<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>


    <?php for ($i=0; $i<$list_count; $i++) { 

			if($bo_table == "notice")
				$menu_num = 4;
			else 
				$menu_num = 5;

	?>
		<li>
          <div class="feeds-body">
            <h4 class="title text-danger"><a href="/_document/list/menu<?php echo $menu_num?>_list.php?wr_id=<?php echo $list[$i]['wr_id']?>"><?php echo $list[$i]['subject']?> <small class="float-right text-muted"><?php echo $list[$i]['datetime']?></small></a></h4>
         </div>
        </li>
	
    <?php }  ?>
    <?php if ($list_count == 0) { //게시물이 없을 때  ?>
    <li class="empty_li">게시물이 없습니다.</li>
    <?php }  ?>
 