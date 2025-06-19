<?php 
include_once('../../_common.php');
define('menu_homepage', true);
include_once(NONE_PATH.'/header.php'); 

$fr_date = isset($_REQUEST['fr_date']) ? preg_replace('/[^0-9 :\-]/i', '', $_REQUEST['fr_date']) : G5_TIME_YMD;
$to_date = isset($_REQUEST['to_date']) ? preg_replace('/[^0-9 :\-]/i', '', $_REQUEST['to_date']) : G5_TIME_YMD;

$g5['title'] = '접속자집계';
include_once('./visit.sub.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
$colspan = 6;

$sql_common = " from {$g5['visit_table']} ";
$sql_search = " where vi_date between '{$fr_date}' and '{$to_date}' ";
if (isset($domain))
    $sql_search .= " and vi_referer like '%{$domain}%' ";

$sql = " select count(*) as cnt
            {$sql_common}
            {$sql_search} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
            {$sql_common}
            {$sql_search}
            order by vi_id desc
            limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$qstr = "fr_date=".$fr_date."&amp;to_date=".$to_date;
$query_string = $qstr ? '?'.$qstr : '';
?>
<style>


/* 테이블 */
table {clear:both;width:100%;border-collapse:collapse;border-spacing:0;}
table caption {height:0;font-size:0;line-height:0;overflow:hidden}
table td{line-height: 22px;}
tfoot th, tfoot td {border:1px solid #d6dce7;background:#eee;padding:5px;text-align:center;font-weight:bold;}
tfoot th {}

.tbl_wrap {margin:0 0 10px;padding:0}

/* thead 한 줄 테이블 */
.tbl_head01 {}
.tbl_head01 table {clear:both;width:100%;border-collapse:collapse;border-spacing:0}
.tbl_head01 thead th {background:#6f809a;color:#fff;border:1px solid #60718b;font-weight:normal;text-align:center;padding:8px 5px;font-size:0.92em}
.tbl_head01 thead th a{color:#fff}
.tbl_head01 thead input {vertical-align:top} /* middle 로 하면 게시판 읽기에서 목록 사용시 체크박스 라인 깨짐 */
.tbl_head01 thead a {color:#383838;text-decoration:underline}
.tbl_head01 tbody th{border:1px solid #d6dce7;padding:5px;text-align:center}
.tbl_head01 tbody td{border:1px solid #d6dce7;padding:5px;text-align:center}
.tbl_head01 tbody tr:nth-child(even){background:#eff3f9}
.tbl_head01 tbody td .frm_input{width:100%;}
.tbl_head01 tbody td select{width:100%}
.tbl_head01 table .tbl_input{height:27px;line-height:25px;border:1px solid #d5d5d5;width:100%}
.tbl_head01 table select {height: 27px;line-height: 25px;width: 100%;}
</style>

<div id="main-content">
<div class="block-header">
	<div class="row">
		<div class="col-lg-5 col-md-8 col-sm-12">                        
			<h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>회사관리</h2>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
				<li class="breadcrumb-item">회사관리</li>
				<li class="breadcrumb-item active">직원관리 리스트</li>
			</ul>
		</div>            
	   
	</div>
</div>
<div class="row clearfix">
<div class="col-lg-12 col-md-12">

<div class="body">
	<form name="fvisit" id="fvisit" class="float-right" method="get">
		<div class="input-group">
			 <input type="date" name="fr_date" value="<?php echo $fr_date ?>" id="fr_date" class="form-control" size="11" maxlength="10">
			 <input type="date" name="to_date" value="<?php echo $to_date ?>" id="to_date" class="form-control" size="11" maxlength="10">
			<div class="input-group-append">
				<button class="input-group-text" id="search-mail"><i class="icon-magnifier"></i></button>
			</div>
		</div>
	</form>
</div>	
<div style="clear:both"></div>

<div class="tbl_head01 tbl_wrap" style="margin-top:15px">
    <table>
    <thead>
    <tr>
        <th scope="col">IP</th>
        <th scope="col">접속 경로</th>
        <th scope="col">브라우저</th>
        <th scope="col">OS</th>
        <th scope="col">접속기기</th>
        <th scope="col">일시</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $brow = $row['vi_browser'];
        if(!$brow)
            $brow = get_brow($row['vi_agent']);

        $os = $row['vi_os'];
        if(!$os)
            $os = get_os($row['vi_agent']);

        $device = $row['vi_device'];

        $link = '';
        $link2 = '';
        $referer = '';
        $title = '';
        if ($row['vi_referer']) {

            $referer = get_text(cut_str($row['vi_referer'], 255, ''));
            $referer = urldecode($referer);

            if (!is_utf8($referer)) {
                $referer = iconv_utf8($referer);
            }

            $title = str_replace(array('<', '>', '&'), array("&lt;", "&gt;", "&amp;"), $referer);
            $link = '<a href="'.get_text($row['vi_referer']).'" target="_blank">';
            $link = str_replace('&', "&amp;", $link);
            $link2 = '</a>';
        }

        if ($is_admin == 'super')
            $ip = $row['vi_ip'];
        else
            $ip = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", G5_IP_DISPLAY, $row['vi_ip']);

        if ($brow == '기타') { $brow = '<span title="'.get_text($row['vi_agent']).'">'.$brow.'</span>'; }
        if ($os == '기타') { $os = '<span title="'.get_text($row['vi_agent']).'">'.$os.'</span>'; }

        $bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>">
        <td class="td_category"><?php echo $ip ?></td>
        <td><?php echo $link ?><?php echo $title ?><?php echo $link2 ?></td>
        <td class="td_category td_category1"><?php echo $brow ?></td>
        <td class="td_category td_category3"><?php echo $os ?></td>
        <td class="td_category td_category2"><?php echo $device; ?></td>
        <td class="td_datetime"><?php echo $row['vi_date'] ?> <?php echo $row['vi_time'] ?></td>
    </tr>

    <?php
    }
    if ($i == 0)
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없거나 관리자에 의해 삭제되었습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>

<?php
if (isset($domain))
    $qstr .= "&amp;domain=$domain";
$qstr .= "&amp;page=";

$pagelist = get_paging_none($config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr");
echo $pagelist;

include_once(NONE_PATH.'/footer.php');?>