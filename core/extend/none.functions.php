<?php 

// 한페이지에 보여줄 행, 현재페이지, 총페이지수, URL
function get_paging_none($write_pages, $cur_page, $total_page, $url, $add="")
{
    //$url = preg_replace('#&amp;page=[0-9]*(&amp;page=)$#', '$1', $url);
    $url = preg_replace('#(&amp;)?page=[0-9]*#', '', $url);
	$url .= substr($url, -1) === '?' ? 'page=' : '&amp;page=';

    $str = '';
    if ($cur_page > 1) {
        $str .= '<li><a href="'.$url.'1'.$add.'" class="page-link pg_page pg_start">처음</a></li>'.PHP_EOL;
    }

    $start_page = ( ( (int)( ($cur_page - 1 ) / $write_pages ) ) * $write_pages ) + 1;
    $end_page = $start_page + $write_pages - 1;

    if ($end_page >= $total_page) $end_page = $total_page;

    if ($start_page > 1) $str .= '<li><a href="'.$url.($start_page-1).$add.'" class="page-link pg_page pg_prev">이전</a></li>'.PHP_EOL;

    if ($total_page > 1) {
        for ($k=$start_page;$k<=$end_page;$k++) {
            if ($cur_page != $k)
                $str .= '<li  class="page-item"><a href="'.$url.$k.$add.'" class="page-link pg_page">'.$k.'</a>'.PHP_EOL;
            else
                $str .= '<li class="page-item active"><a href="" class="page-link">'.$k.'<span class="sr-only">(current)</span></a></li>'.PHP_EOL;
        }
    }

    if ($total_page > $end_page) $str .= '<li><a href="'.$url.($end_page+1).$add.'" class="page-link pg_page pg_next">다음</a></li>'.PHP_EOL;

    if ($cur_page < $total_page) {
        $str .= '<li><a href="'.$url.$total_page.$add.'" class="pg_page pg_end page-link">맨끝</a></li>'.PHP_EOL;
    }

    if ($str)
        return "<nav aria-label=\"Page navigation example\"><ul class=\"pagination justify-content-center\">{$str}</ul></nav>";
    else
        return "";
}

// 한페이지에 보여줄 행, 현재페이지, 총페이지수, URL
function get_paging_home ($write_pages, $cur_page, $total_page, $url, $add="")
{
	
	
     
    //$url = preg_replace('#&amp;page=[0-9]*(&amp;page=)$#', '$1', $url);
    $url = preg_replace('#(&amp;)?page=[0-9]*#', '', $url);
	$url .= substr($url, -1) === '?' ? 'page=' : '&amp;page=';

    $str = '';
    if ($cur_page > 1) {
       // $str .= '<li><a href="'.$url.'1'.$add.'" class="page-link pg_page pg_start">처음</a></li>'.PHP_EOL;
    }

    $start_page = ( ( (int)( ($cur_page - 1 ) / $write_pages ) ) * $write_pages ) + 1;
    $end_page = $start_page + $write_pages - 1;

    if ($end_page >= $total_page) $end_page = $total_page;

    if ($start_page > 1) $str .= '<li  class="first_page"><a href="'.$url.($start_page-1).$add.'" ><i class="fa fa-arrow-alt-circle-left"></i></a></li>'.PHP_EOL;

    if ($total_page > 1) {
        for ($k=$start_page;$k<=$end_page;$k++) {
            if ($cur_page != $k)
                $str .= '<li ><a href="'.$url.$k.$add.'">'.$k.'</a>'.PHP_EOL;
            else
                $str .= '<li class="active"><a href="">'.$k.'</a></li>'.PHP_EOL;
        }
    }

    if ($total_page > $end_page) $str .= '<li class="last_page"><a href="'.$url.($end_page+1).$add.'"><i class="fa fa-arrow-alt-circle-right"></i></a></li>'.PHP_EOL;

    if ($cur_page < $total_page) {
        //$str .= '<li><a href="'.$url.$total_page.$add.'" class="pg_page pg_end page-link">맨끝</a></li>'.PHP_EOL;
    }

    if ($str)
        return "<ul class=\"pagination\">{$str}</ul>";
    else
        return "";
}

function byteFormat($bytes, $unit = "", $decimals = 2) {

	$units = array('B' => 0, 'KB' => 1, 'MB' => 2, 'GB' => 3, 'TB' => 4, 'PB' => 5, 'EB' => 6, 'ZB' => 7, 'YB' => 8);
	$value = 0;
	if ($bytes > 0) {

		if (!array_key_exists($unit, $units)) {
			$pow = floor(log($bytes)/log(1024));
			$unit = array_search($pow, $units);
		}

		$value = ($bytes/pow(1024,floor($units[$unit])));

	}
	if (!is_numeric($decimals) || $decimals < 0) {
		$decimals = 2;
	}
	
	// Format output
	return sprintf('%.' . $decimals . 'f '.$unit, $value);
}

function get_worksite_name($val=null) {
	
	global $none;
	
	$row = sql_fetch("select seq, nw_subject from {$none['worksite']}  where nw_code = '$val' ");

	$str = $row['nw_subject'];

	return $str;
}

function get_worksite_id($val=null) {
	
	global $none;
	
	$row = sql_fetch("select seq, nw_subject from {$none['worksite']}  where nw_subject LIKE '%$val%' ");

	$str = $row['nw_id'];

	return $str;
}

//건축주 셀렉박스 
function get_owner_select($val=null) {
	
	global $none;
	
	$sql = "select seq, no_company, no_name from {$none['owner_list']} order by seq desc ";
	$rst = sql_query($sql);
	while($row = sql_fetch_array($rst)) {
		
		if(!$row['no_company'])
			$str .= '<option value="'.$row['seq'].'" '.get_selected($val, $row['seq']).'>['.$row['seq'].'] '.$row['no_name'].'</option>';
		else
			$str .= '<option value="'.$row['seq'].'" '.get_selected($val, $row['seq']).'>['.$row['seq'].'] '.$row['no_company'].'('.$row['no_name'].')</option>';
		
	}
	
	return $str;
	
}
//건축주 출력 
function get_owner_txt($val=null) {
	
	global $none;
	
	$row = sql_fetch("select no_company, no_name from {$none['owner_list']} where seq = '$val' ");
	
	if($row['no_company'])
		$str = $row['no_company']."(".$row['no_name'].")";
	else 
		$str = $row['no_name'];
	
	return $str;
	
	
}

//건축사 셀렉박스 (건축사만)
function get_enterprise_select($val=null) {
	
	global $none;
	
	$sql = "select seq, no_company, no_bname, no_btel from {$none['enterprise_list']} where no_category = '건축사사무소' order by seq desc ";
	$rst = sql_query($sql);
	while($row = sql_fetch_array($rst)) {
		
		if(!$row['no_company'])
			$str .= '<option value="'.$row['seq'].'" data="'.$row['no_btel'].'" '.get_selected($val, $row['seq']).'>['.$row['seq'].'] '.$row['no_bname'].'</option>';
		else
			$str .= '<option value="'.$row['seq'].'" data="'.$row['no_btel'].'" '.get_selected($val, $row['seq']).'>['.$row['seq'].'] '.$row['no_company'].'('.$row['no_bname'].')</option>';
		
	}
	
	return $str;
}

//건축사 셀렉박스 (모두)
function get_enterprise_all_select($val=null) {
	
	global $none;
	
	$sql = "select seq, no_company, no_bname, no_btel from {$none['enterprise_list']}  order by seq desc ";
	$rst = sql_query($sql);
	while($row = sql_fetch_array($rst)) {
		
		if(!$row['no_company'])
			$str .= '<option value="'.$row['seq'].'" data="'.$row['no_btel'].'" '.get_selected($val, $row['seq']).'>['.$row['seq'].'] '.$row['no_bname'].'</option>';
		else
			$str .= '<option value="'.$row['seq'].'" data="'.$row['no_btel'].'" '.get_selected($val, $row['seq']).'>['.$row['seq'].'] '.$row['no_company'].'('.$row['no_bname'].')</option>';
		
	}
	
	return $str;
}


//건축사 출력 
function get_enterprise_txt($val=null) {
	
	global $none;
	
	$row = sql_fetch("select seq, no_company, no_bname from {$none['enterprise_list']}  where seq = '$val' ");
	
	if($row['no_company'])
		$str = $row['no_company']."(".$row['no_bname'].")";
	else 
		$str = $row['no_bname'];
	
	return $str;
}

//건축사 출력 
function get_enterprise_txt2($val=null) {
	
	global $none;
	
	$row = sql_fetch("select seq, no_company, no_bname from {$none['enterprise_list']}  where no_company = '$val' ");
	
	$str = $row['seq'];
	
	return $str;
}

//현장소장, 실제투입소장 셀렉박스 
function get_manager_select($val=null) {
	
	global $g5;
	
	$sql = "select mb_id, mb_name, mb_3 from {$g5['member_table']} where mb_level = 10 order by mb_name desc ";
	$rst = sql_query($sql);
	while($row = sql_fetch_array($rst)) {
		
			$str .= '<option value="'.$row['mb_id'].'" '.get_selected($val, $row['mb_id']).'>'.$row['mb_name'].'</option>';
		
	}
	return $str;

}

//현장소장, 실제투입소장 출력
function get_manager_txt($val=null) {
	
	global $g5;
	
	$row = sql_fetch("select mb_id, mb_name, mb_3 from {$g5['member_table']} where mb_id = '$val' ");

	return $row['mb_name'];
}

//품질관리자 셀렉박스 
function get_admin_select($val=null) {
	
	global $g5;
	
	$sql = "select mb_id, mb_name, mb_3 from {$g5['member_table']} where  mb_level = 10 and mb_id != 'admin' order by mb_name desc ";
	$rst = sql_query($sql);
	while($row = sql_fetch_array($rst)) {
		
			$str .= '<option value="'.$row['mb_id'].'" '.get_selected($val, $row['mb_id']).'>'.$row['mb_name'].'('.get_mposition_txt($row['mb_3']).')</option>';
		
	}
	return $str;
}

//품질관리자 셀렉박스 
function get_admin_txt($val=null) {
	
	global $g5;
	
	$str = get_member($val, 'mb_name');
	
	return $str['mb_name'];
}


//지사 셀렉박스 
function get_branch_select($val=null) {
	
	global $none;
	
	$sql = "select * from {$none['branch_list']} order by nb_order asc ";
	$rst = sql_query($sql);
	while($row = sql_fetch_array($rst)) {
		
			$str .= '<option value="'.$row['seq'].'" '.get_selected($val, $row['seq']).'>'.$row['nb_name'].'</option>';
		
	}
	
	return $str;
}


//부서 셀렉박스 
function get_department_select($val=null) {
	
	global $none;
	
	$sql = "select * from {$none['department_list']} order by nd_order asc ";
	$rst = sql_query($sql);
	while($row = sql_fetch_array($rst)) {
		
			$str .= '<option value="'.$row['seq'].'" '.get_selected($val, $row['seq']).'>'.$row['nd_name'].'</option>';
		
	}
	
	return $str;
}

//부서 셀렉박스2
function get_department_select2($val=null) {
	
	global $none;
	
	$sql = "select * from {$none['department_list']} where nd_name != '공사부' order by nd_order asc ";
	$rst = sql_query($sql);
	while($row = sql_fetch_array($rst)) {
		
			$str .= '<option value="'.$row['nd_name'].'" '.get_selected($val, $row['nd_name']).'>'.$row['nd_name'].'</option>';
		
	}
	
	return $str;
}

//직급 셀렉박스 
function get_mposition_select($val=null) {
	
	global $none;
	
	$sql = "select * from {$none['member_position_list']} order by nm_order asc ";
	$rst = sql_query($sql);
	while($row = sql_fetch_array($rst)) {
		
			$str .= '<option value="'.$row['seq'].'" '.get_selected($val, $row['seq']).'>'.$row['nm_name'].'</option>';
		
	}
	
	return $str;
}

//직급출력
function get_mposition_txt($val=null) {
	
	global $none;
	
	$row = sql_fetch("select nm_name from {$none['member_position_list']} where seq = '$val' ");
	
	return $row['nm_name'];
}



//등급 셀렉박스 
function get_mlevel_select($val=null) {
	
	global $none;
	
	$sql = "select * from {$none['member_level_list']} order by nm_order asc ";
	$rst = sql_query($sql);
	while($row = sql_fetch_array($rst)) {
		
			$str .= '<option value="'.$row['seq'].'" '.get_selected($val, $row['seq']).'>'.$row['nm_name'].'</option>';
		
	}
	
	return $str;
}


//은행 셀렉박스 
function get_bank_select($val=null) {
	
	global $none;
	
	$sql = "select * from {$none['bank_list']} order by nb_order asc ";
	$rst = sql_query($sql);
	while($row = sql_fetch_array($rst)) {
		//이미 해당 DB만들기전에 등록 된 텍스트데이터 때문에 seq사용안함.
		$str .= '<option value="'.$row['nb_name'].'" '.get_selected($val, $row['nb_name']).'>'.$row['nb_name'].'</option>';
		
	}
	
	return $str;
}

/*************************************************/
/*************메인화면 관련 함수******************/
/*************************************************/

//진행중인 공사현장
function get_worksite_count($type) {
	
	global $none;
	
	$row = sql_fetch("select count(*) as cnt from {$none['worksite']}  where nw_status = '$type' ");

	return $row['cnt'];
	
}
//총 공사금액 공사현장
function get_worksite_tprice() {
	
	global $none;
	
	$row = sql_fetch("select SUM(nw_total_price) as total from {$none['worksite']}  where nw_status = '$type' ");

	return $row['total'];
	
}

//이름출력
function get_mb_name($mb_id) {
	
	$row = get_member($mb_id, 'mb_name');
	
	return $row['mb_name'];
}

/*************************************************/
/**********외부공간(홈페이지) 함수 **************/
/*************************************************/
function get_editor_image2($contents, $view=true)
{
    if(!$contents)
        return false;

    // $contents 중 img 태그 추출
    if ($view)
        $pattern = "/<img([^>]*)>/iS";
    else
        $pattern = "/<img[^>]*src=[\'\"]?([^>\'\"]+[^>\'\"]+)[\'\"]?[^>]*>/i";
    preg_match_all($pattern, $contents, $matchs);

    return $matchs;
}



function owner_check($mb_id) {
	
	global $none;
	$row = sql_fetch("select * from {$none['owner_list']}  where no_id_1 = '$mb_id' or no_id_2 = '$mb_id' or no_id_3 = '$mb_id' ");
	
	if($row)
		return $row['seq'];
	else 
		return false;
	
	
}
