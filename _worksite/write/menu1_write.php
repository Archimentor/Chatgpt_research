<?php
include_once('../../_common.php');
define('menu_worksite', true);
include_once(NONE_PATH.'/header.php'); // 실제 header.php 경로 확인 필요

// GnuBoard 기본 함수 로드 가정

// 수정 모드 데이터 조회
$worksite_add_data = []; // 배열 초기화
$max_addnum = 1; // 기본값
$row = []; // 기본값

if($w == 'u' && isset($seq)) { // $seq 변수가 있는지 확인
    $_row = sql_fetch("select * from {$none['worksite']} where seq = '".sql_real_escape_string($seq)."'");
    if(!$_row) {
        alert('데이터가 삭제되었거나 이동되었습니다.');
    } else {
        $row = $_row; // 조회된 데이터를 $row에 할당

        // 추가 차수 정보 조회
        $max_addnum_row = sql_fetch("select MAX(nw_num) as num from {$none['worksite_add']} where nw_id = '".sql_real_escape_string($seq)."'");
        $max_addnum = $max_addnum_row['num'] ?? 1; // 최대 차수 번호, 없으면 1

        $sql2 = "select * from {$none['worksite_add']} where nw_id = '".sql_real_escape_string($seq)."' order by nw_num asc";
        $rst2 = sql_query($sql2);
        while($row2 = sql_fetch_array($rst2)) {
            $worksite_add_data[] = $row2;
        }
    }
} else if ($w == '') {
    // 등록 모드 기본값 (위에서 초기화됨)
}

// -- 안전한 값 처리를 위한 직접적인 코드 사용 --
function _safe_value($array, $key, $default = '') {
    if (!is_array($array)) {
        return $default;
    }
    return isset($array[$key]) ? htmlspecialchars((string)$array[$key], ENT_QUOTES, 'UTF-8') : $default;
}

// -- 숫자 포맷 함수 --
function _number_format($number, $default = '0') {
     $num_str = isset($number) ? str_replace(',', '', (string)$number) : '';
     if ($num_str === '' || !is_numeric($num_str)) {
         $num_str_default = str_replace(',', '', (string)$default);
         $num = is_numeric($num_str_default) ? (float)$num_str_default : 0;
     } else {
         $num = (float)$num_str;
     }
     return number_format($num);
}

/*
// *** 드롭다운 생성 함수들은 GnuBoard 환경에 이미 정의되어 있다고 가정 ***
// 예: function get_manager_select($selected_value = '') { ... }
//     function get_owner_select($selected_value = '') { ... }
//     function get_enterprise_select($selected_value = '') { ... }
//     function get_admin_select($selected_value = '') { ... }
*/
?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2 { width:100% !important }
.select2-container .select2-selection--single { height:36px }
.select2-container--default .select2-selection--single { border:1px solid #ced4da; }
.select2-container--default .select2-selection--single .select2-selection__rendered { line-height:34px }
.select2-container--default .select2-selection--single .select2-selection__arrow { height:34px }
.select-col-padding { padding-left: 5px; padding-right: 5px; }
.btn-file { position: relative; overflow: hidden; }
.btn-file input[type=file] {
    position: absolute;
    top: 0; right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}
</style>

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">
                    <h2>
                        <a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>
                        시공현장
                    </h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item">현장관리</li>
                        <li class="breadcrumb-item active">시공현황 <?php echo ($w == 'u') ? '수정' : '등록'; ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <form name="frm" id="worksiteForm" action="./menu1_update.php" enctype="multipart/form-data" method="post" onsubmit="return removeCommasBeforeSubmit()">
                            <input type="hidden" name="uid" id="uid" value="<?php echo ($w == 'u' && isset($row['seq'])) ? _safe_value($row, 'seq') : uniqid('nw_'); ?>">
                            <input type="hidden" name="w" value="<?php echo htmlspecialchars($w ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                            <?php if ($w == 'u' && isset($seq)): ?>
                                <input type="hidden" name="seq" value="<?php echo htmlspecialchars($seq, ENT_QUOTES, 'UTF-8'); ?>">
                            <?php endif; ?>

                            <!-- 기본 설정 -->
                            <div class="card border mb-3">
                                <div class="card-header" style="font-weight:500">기본 설정</div>
                                <div class="card-body ">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="nw_status">진행상태</label>
                                            <select name="nw_status" id="nw_status" class="form-control">
                                                <option value="0" <?php echo (_safe_value($row, 'nw_status', '0') == '0') ? ' selected="selected"' : ''; ?>>진행중</option>
                                                <option value="1" <?php echo (_safe_value($row, 'nw_status', '0') == '1') ? ' selected="selected"' : ''; ?>>완료</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="nw_code">현장코드</label>
                                            <input type="text" name="nw_code" id="nw_code" class="form-control" value="<?php echo _safe_value($row, 'nw_code'); ?>" placeholder="현장코드">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 인원 설정 -->
                            <div class="card border mb-3">
                                <div class="card-header " style="font-weight:500">인원 설정</div>
                                <div class="card-body ">
                                    <!-- 현장소장 / 실제투입소장 -->
                                    <div class="form-row ">
                                        <div class="form-group col-md-6">
                                            <label>현장소장</label>
                                            <div class="form-row">
                                                <?php for ($i = 1; $i <= 6; $i++): ?>
                                                <div class="col-2 mb-2 select-col-padding">
                                                    <select name="nw_ptype1_<?php echo $i; ?>" class="form-control select2">
                                                        <option value="">현장소장<?php echo $i; ?></option>
                                                        <?php
                                                        if(function_exists('get_manager_select')) {
                                                            echo get_manager_select(_safe_value($row, "nw_ptype1_{$i}"));
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>실제투입소장</label>
                                            <div class="form-row">
                                                <?php for ($i = 1; $i <= 6; $i++): ?>
                                                <div class="col-2 mb-2 select-col-padding">
                                                    <select name="nw_ptype2_<?php echo $i; ?>" class="form-control select2">
                                                        <option value="">실투소장<?php echo $i; ?></option>
                                                        <?php
                                                        if(function_exists('get_manager_select')) {
                                                            echo get_manager_select(_safe_value($row, "nw_ptype2_{$i}"));
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- 건축주 / 건축사 -->
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>건축주</label>
                                            <div class="form-row">
                                                <div class="col select-col-padding">
                                                    <select name="nw_ptype3_1" class="form-control select2">
                                                        <option value="">건축주1 선택</option>
                                                        <?php
                                                        if(function_exists('get_owner_select')) {
                                                            echo get_owner_select(_safe_value($row, 'nw_ptype3_1'));
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col select-col-padding">
                                                    <select name="nw_ptype3_2" class="form-control select2">
                                                        <option value="">건축주2 선택</option>
                                                        <?php
                                                        if(function_exists('get_owner_select')) {
                                                            echo get_owner_select(_safe_value($row, 'nw_ptype3_2'));
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col select-col-padding">
                                                    <select name="nw_ptype3_3" class="form-control select2">
                                                        <option value="">건축주3 선택</option>
                                                        <?php
                                                        if(function_exists('get_owner_select')) {
                                                            echo get_owner_select(_safe_value($row, 'nw_ptype3_3'));
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>건축사</label>
                                            <div class="form-row">
                                                <div class="col select-col-padding">
                                                    <select name="nw_ptype4_1" class="form-control select2">
                                                        <option value="">건축사1 선택</option>
                                                        <?php
                                                        if(function_exists('get_enterprise_select')) {
                                                            echo get_enterprise_select(_safe_value($row, 'nw_ptype4_1'));
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col select-col-padding">
                                                    <select name="nw_ptype4_2" class="form-control select2">
                                                        <option value="">건축사2 선택</option>
                                                        <?php
                                                        if(function_exists('get_enterprise_select')) {
                                                            echo get_enterprise_select(_safe_value($row, 'nw_ptype4_2'));
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col select-col-padding">
                                                    <select name="nw_ptype4_3" class="form-control select2">
                                                        <option value="">건축사3 선택</option>
                                                        <?php
                                                        if(function_exists('get_enterprise_select')) {
                                                            echo get_enterprise_select(_safe_value($row, 'nw_ptype4_3'));
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 품질관리자 / 안전관리자 -->
                                    <div class="form-row">
                                        <!-- 품질관리자자 -->
                                        <div class="form-group col-md-6">
                                            <label>품질관리자</label>
                                            <div class="form-row">
                                                 <div class="col select-col-padding">
                                                     <select name="nw_ptype5_1" class="form-control select2">
                                                         <option value="">품질관리자1 선택</option>
                                                         <?php
                                                         if(function_exists('get_admin_select')) {
                                                             echo get_admin_select(_safe_value($row, 'nw_ptype5_1'));
                                                         }
                                                         ?>
                                                     </select>
                                                 </div>
                                                 <div class="col select-col-padding">
                                                     <select name="nw_ptype5_2" class="form-control select2">
                                                         <option value="">품질관리자2 선택</option>
                                                         <?php
                                                         if(function_exists('get_admin_select')) {
                                                             echo get_admin_select(_safe_value($row, 'nw_ptype5_2'));
                                                         }
                                                         ?>
                                                     </select>
                                                 </div>
                                                 <div class="col select-col-padding">
                                                     <select name="nw_ptype5_3" class="form-control select2">
                                                         <option value="">품질관리자3 선택</option>
                                                         <?php
                                                         if(function_exists('get_admin_select')) {
                                                             echo get_admin_select(_safe_value($row, 'nw_ptype5_3'));
                                                         }
                                                         ?>
                                                     </select>
                                                 </div>
                                            </div>
                                        </div>

                                        <!-- 안전관리자 (신규 추가) -->
                                        <div class="form-group col-md-6">
                                            <label>안전관리자</label>
                                            <div class="form-row">
                                                 <div class="col select-col-padding">
                                                     <select name="nw_ptype6_1" class="form-control select2">
                                                         <option value="">안전관리자1 선택</option>
                                                         <?php
                                                         // 필요에 따라 다른 셀렉트 함수 사용 가능
                                                         if(function_exists('get_admin_select')) {
                                                             echo get_admin_select(_safe_value($row, 'nw_ptype6_1'));
                                                         }
                                                         ?>
                                                     </select>
                                                 </div>
                                                 <div class="col select-col-padding">
                                                     <select name="nw_ptype6_2" class="form-control select2">
                                                         <option value="">안전관리자2 선택</option>
                                                         <?php
                                                         if(function_exists('get_admin_select')) {
                                                             echo get_admin_select(_safe_value($row, 'nw_ptype6_2'));
                                                         }
                                                         ?>
                                                     </select>
                                                 </div>
                                                 <div class="col select-col-padding">
                                                     <select name="nw_ptype6_3" class="form-control select2">
                                                         <option value="">안전관리자3 선택</option>
                                                         <?php
                                                         if(function_exists('get_admin_select')) {
                                                             echo get_admin_select(_safe_value($row, 'nw_ptype6_3'));
                                                         }
                                                         ?>
                                                     </select>
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 공사 기본정보 -->
                            <div class="card border mb-3">
                                <div class="card-header " style="font-weight:500">공사 기본정보</div>
                                <div class="card-body ">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="nw_subject">현장명</label>
                                            <input type="text" name="nw_subject" id="nw_subject" value="<?php echo _safe_value($row, 'nw_subject'); ?>" class="form-control" placeholder="현장명">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="nw_addr">주소</label>
                                            <input type="text" name="nw_addr" id="nw_addr" class="form-control" value="<?php echo _safe_value($row, 'nw_addr'); ?>" placeholder="주소">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6 ">
                                            <label for="nw_type">공사종류</label>
                                            <select name="nw_type" id="nw_type" class="form-control">
                                                <option value="">선택하세요</option>
                                                <option value="건축" <?php echo (_safe_value($row, 'nw_type') == '건축') ? ' selected="selected"' : ''; ?>>건축</option>
                                                <option value="토목" <?php echo (_safe_value($row, 'nw_type') == '토목') ? ' selected="selected"' : ''; ?>>토목</option>
                                                <option value="건축+토목" <?php echo (_safe_value($row, 'nw_type') == '건축+토목') ? ' selected="selected"' : ''; ?>>건축+토목</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="nw_structure">공사구조</label>
                                            <select name="nw_structure" id="nw_structure" class="form-control">
                                                <option value="">선택하세요</option>
                                                <option value="목구조" <?php echo (_safe_value($row, 'nw_structure') == '목구조') ? ' selected="selected"' : ''; ?>>목구조</option>
                                                <option value="조적조" <?php echo (_safe_value($row, 'nw_structure') == '조적조') ? ' selected="selected"' : ''; ?>>조적조</option>
                                                <option value="철골조" <?php echo (_safe_value($row, 'nw_structure') == '철골조') ? ' selected="selected"' : ''; ?>>철골조</option>
                                                <option value="철근콘크리트조" <?php echo (_safe_value($row, 'nw_structure') == '철근콘크리트조') ? ' selected="selected"' : ''; ?>>철근콘크리트조</option>
                                                <option value="철골철근콘크리트조" <?php echo (_safe_value($row, 'nw_structure') == '철골철근콘크리트조') ? ' selected="selected"' : ''; ?>>철골철근콘크리트조</option>
                                                <option value="철근콘크리트+목구조" <?php echo (_safe_value($row, 'nw_structure') == '철근콘크리트+목구조') ? ' selected="selected"' : ''; ?>>철근콘크리트+목구조</option>
                                                <option value="철근콘크리트+조적조" <?php echo (_safe_value($row, 'nw_structure') == '철근콘크리트+조적조') ? ' selected="selected"' : ''; ?>>철근콘크리트+조적조</option>
                                                <option value="기타구조" <?php echo (_safe_value($row, 'nw_structure') == '기타구조') ? ' selected="selected"' : ''; ?>>기타구조</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6 ">
                                            <label>규모 <small class="text-muted">(지하/지상 순)</small></label>
                                            <div class="col-sm-4 my-1" style="padding:0">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">층수</div>
                                                    </div>
                                                    <input type="number" name="nw_floor2" class="form-control" value="<?php echo _safe_value($row, 'nw_floor2'); ?>" placeholder="지하">
                                                    <input type="number" name="nw_floor1" class="form-control" value="<?php echo _safe_value($row, 'nw_floor1'); ?>" placeholder="지상">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>면적 <small class="text-muted">(대지/건축/연면적 순)</small></label>
                                            <div class="col-sm-8 my-1" style="padding:0">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">㎡</div>
                                                    </div>
                                                    <input type="text" name="nw_area1" class="form-control" value="<?php echo _safe_value($row, 'nw_area1'); ?>" placeholder="대지면적">
                                                    <input type="text" name="nw_area2" class="form-control" value="<?php echo _safe_value($row, 'nw_area2'); ?>" placeholder="건축면적">
                                                    <input type="text" name="nw_area3" class="form-control" value="<?php echo _safe_value($row, 'nw_area3'); ?>" placeholder="연면적">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- (1차) 공사기간 및 금액 -->
                            <div class="card border mb-3">
                                <div class="card-header " style="font-weight:500">
                                    (<span class="chasu">1</span>차) 공사기간 및 금액
                                    <span class="badge badge-danger" onclick="add_box()" style="cursor:pointer; margin-left: 10px;">+차수 추가</span>
                                </div>
                                <div class="card-body price-card-body">
                                    <input type="hidden" name="nw_price_num[]" value="1">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>공사기간</label>
                                            <div class="input-group">
                                                <input type="date" name="nw_sdate[]" value="<?php echo _safe_value($row, 'nw_sdate'); ?>" class="form-control datePicker" placeholder="시작일">
                                                <input type="date" name="nw_edate[]" value="<?php echo _safe_value($row, 'nw_edate'); ?>" class="form-control datePicker" placeholder="종료일">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>계약일</label>
                                            <input type="date" name="nw_contract_date[]" value="<?php echo _safe_value($row, 'nw_contract_date'); ?>" class="form-control datePicker" placeholder="계약일">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>공급가액 <small class="text-muted">(숫자만 입력)</small></label>
                                            <div class="input-group">
                                                <input type="text" name="nw_price1[]" value="<?php echo _number_format(_safe_value($row, 'nw_price1')); ?>" class="pi1 form-control price-input" style="width:50%">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">원</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>부가세 <small class="text-muted">(자동입력/수정가능)</small></label>
                                            <div class="input-group">
                                                <input type="text" name="nw_vat[]" value="<?php echo _number_format(_safe_value($row, 'nw_vat')); ?>" class="pi2 form-control price-input" style="width:50%">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">원</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>계약금액 <small class="text-muted">(자동계산)</small></label>
                                            <div class="input-group">
                                                <input type="text" name="nw_contract_price[]" value="<?php echo _number_format(_safe_value($row, 'nw_contract_price')); ?>" class="pi3 form-control price-input" style="width:50%" readonly>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">원</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>현금 계약금액 <small class="text-muted">(숫자만 입력)</small></label>
                                            <div class="input-group">
                                                <input type="text" name="nw_price2[]" value="<?php echo _number_format(_safe_value($row, 'nw_price2')); ?>" class="pi4 form-control price-input" style="width:50%">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">원</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>총 공사금액 <small class="text-muted">(자동계산)</small></label>
                                            <div class="input-group">
                                                <input type="text" name="nw_total_price[]" value="<?php echo _number_format(_safe_value($row, 'nw_total_price')); ?>" class="pi5 form-control price-input" style="width:50%" readonly>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">원</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 추가 차수 (수정 모드) -->
                            <?php if ($w == 'u' && !empty($worksite_add_data)): ?>
                                <?php foreach ($worksite_add_data as $row2): ?>
                                    <div class="card border mb-3" id="add_box_<?php echo _safe_value($row2, 'nw_num'); ?>">
                                        <div class="card-header " style="font-weight:500">
                                            (<span class="chasu"><?php echo _safe_value($row2, 'nw_num'); ?></span>차) 공사기간 및 금액
                                            <input type="hidden" name="nw_price_num[]" value="<?php echo _safe_value($row2, 'nw_num'); ?>">
                                            <input type="hidden" name="nw_price_seq[]" value="<?php echo _safe_value($row2, 'seq'); ?>">
                                            <span class="badge badge-danger" onclick="del_box('<?php echo _safe_value($row2, 'seq'); ?>', '<?php echo _safe_value($row2, 'nw_num'); ?>')" style="cursor:pointer; margin-left: 10px;">DB삭제</span>
                                        </div>
                                        <div class="card-body price-card-body">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>공사기간</label>
                                                    <div class="input-group">
                                                        <input type="date" name="nw_sdate[]" value="<?php echo _safe_value($row2, 'nw_sdate'); ?>" class="form-control datePicker" placeholder="시작일">
                                                        <input type="date" name="nw_edate[]" value="<?php echo _safe_value($row2, 'nw_edate'); ?>" class="form-control datePicker" placeholder="종료일">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>계약일</label>
                                                    <input type="date" name="nw_contract_date[]" value="<?php echo _safe_value($row2, 'nw_contract_date'); ?>" class="form-control datePicker" placeholder="계약일">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>공급가액 <small class="text-muted">(숫자만 입력)</small></label>
                                                    <div class="input-group">
                                                        <input type="text" name="nw_price1[]" value="<?php echo _number_format(_safe_value($row2, 'nw_price1')); ?>" class="pi1 form-control price-input" style="width:50%">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">원</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>부가세 <small class="text-muted">(자동입력/수정가능)</small></label>
                                                    <div class="input-group">
                                                        <input type="text" name="nw_vat[]" value="<?php echo _number_format(_safe_value($row2, 'nw_vat')); ?>" class="pi2 form-control price-input" style="width:50%">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">원</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>계약금액 <small class="text-muted">(자동계산)</small></label>
                                                    <div class="input-group">
                                                        <input type="text" name="nw_contract_price[]" value="<?php echo _number_format(_safe_value($row2, 'nw_contract_price')); ?>" class="pi3 form-control price-input" style="width:50%" readonly>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">원</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>현금 계약금액 <small class="text-muted">(숫자만 입력)</small></label>
                                                    <div class="input-group">
                                                        <input type="text" name="nw_price2[]" value="<?php echo _number_format(_safe_value($row2, 'nw_price2')); ?>" class="pi4 form-control price-input" style="width:50%">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">원</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>총 공사금액 <small class="text-muted">(자동계산)</small></label>
                                                    <div class="input-group">
                                                        <input type="text" name="nw_total_price[]" value="<?php echo _number_format(_safe_value($row2, 'nw_total_price')); ?>" class="pi5 form-control price-input" style="width:50%" readonly>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">원</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <div id="add_box_result"></div>

                            <!-- 기타 정보 -->
                            <div class="card border mb-3">
                                <div class="card-header " style="font-weight:500">기타 정보</div>
                                <div class="card-body ">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="nw_insurance_num1">고용-산재 사업개시번호</label>
                                            <input type="text" name="nw_insurance_num1" id="nw_insurance_num1" value="<?php echo _safe_value($row, 'nw_insurance_num1'); ?>" class="form-control" placeholder="고용-산재 사업개시번호">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="nw_insurance_num2">건강-연금 사업장관리번호</label>
                                            <input type="text" name="nw_insurance_num2" id="nw_insurance_num2" value="<?php echo _safe_value($row, 'nw_insurance_num2'); ?>" class="form-control" placeholder="건강-연금 사업장관리번호">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="nw_insurance_id">건강보험 아이디</label>
                                            <input type="text" name="nw_insurance_id" id="nw_insurance_id" value="<?php echo _safe_value($row, 'nw_insurance_id'); ?>" class="form-control" placeholder="건강보험 아이디">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>건강-연금 공사기간</label>
                                            <div class="input-group">
                                                <input type="date" name="nw_insurance_sdate" value="<?php echo _safe_value($row, 'nw_insurance_sdate'); ?>" class="form-control datePicker" placeholder="시작일">
                                                <input type="date" name="nw_insurance_edate" value="<?php echo _safe_value($row, 'nw_insurance_edate'); ?>" class="form-control datePicker" placeholder="종료일">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="nw_use_date">사용승인일</label>
                                            <div class="form-group ">
                                                <input type="date" name="nw_use_date" id="nw_use_date" value="<?php echo _safe_value($row, 'nw_use_date'); ?>" class="form-control datePicker" placeholder="사용승인일">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="nw_insurance_etc">비고</label>
                                            <input type="text" name="nw_insurance_etc" id="nw_insurance_etc" value="<?php echo _safe_value($row, 'nw_insurance_etc'); ?>" class="form-control" placeholder="비고">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>키스콘 신고현황</label>
                                            <div class="form-group form-check">
                                                <input type="checkbox" name="nw_kiscon" value="1" class="form-check-input" id="nw_kiscon_check" <?php echo (_safe_value($row, 'nw_kiscon') == '1') ? ' checked="checked"' : ''; ?>>
                                                <label class="form-check-label" for="nw_kiscon_check">예</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>일괄도급 </label>
                                            <div class="col" style="padding-left:0;">
                                                <div class="form-check" style="display: inline-block; margin-right: 10px;">
                                                    <input type="checkbox" class="form-check-input" id="batch_contract_check">
                                                    <label class="form-check-label" for="batch_contract_check">선택</label>
                                                </div>
                                                <select class="form-control" style="display: inline-block; width: auto;">
                                                    <option selected>선택하세요</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="nw_memo">메모</label>
                                            <textarea name="nw_memo" id="nw_memo" class="form-control" rows="3"><?php echo _safe_value($row, 'nw_memo'); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 도급서류 첨부 -->
                            <div class="card border mb-3">
                                <div class="card-header" style="font-weight:500">도급서류 첨부</div>
                                <div class="card-body ">
                                    <div class="form-row align-items-center">
                                        <div class="col-auto">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="category">파일 분류</label>
                                                </div>
                                                <select name="category" id="category" class="custom-select">
                                                    <option value="현장사진">현장사진</option>
                                                    <option value="도급계약서">도급계약서</option>
                                                    <option value="계약내역서">계약내역서</option>
                                                    <option value="건축허가서">건축허가서</option>
                                                    <option value="착공계서류">착공계서류</option>
                                                    <option value="건강연금">건강연금</option>
                                                    <option value="고용산재">고용산재</option>
                                                    <option value="퇴직공제">퇴직공제</option>
                                                    <option value="근재영업배상">근재영업배상</option>
                                                    <option value="폐기물신고">폐기물신고</option>
                                                    <option value="계약보증서">계약보증서</option>
                                                    <option value="하자보증서">하자보증서</option>
                                                    <option value="선급금보증서">선급금보증서</option>
                                                    <option value="기타보증서">기타보증서</option>
                                                    <option value="기타서류">기타서류</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <input type="file" id="fileInput" name="files[]" multiple style="display: none;">
                                            <input type="text" id="userfile" class="form-control mb-2" placeholder="선택된 파일 없음" readonly>
                                        </div>
                                        <div class="col-auto">
                                            <label for="fileInput" class="btn btn-secondary mb-2 btn-file">
                                                <i class="fa fa-upload"></i> 찾기
                                            </label>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" id="file_upload_btn" onclick="file_upload()" class="btn btn-primary mb-2">업로드</button>
                                        </div>
                                    </div>
                                    <div class="form-row ">
                                        <table class="table table-striped mt-3">
                                            <thead>
                                                <tr>
                                                    <th scope="col">파일분류</th>
                                                    <th scope="col">파일명</th>
                                                    <th scope="col">용량</th>
                                                    <th scope="col">다운</th>
                                                    <th scope="col">관리</th>
                                                </tr>
                                            </thead>
                                            <tbody id="file_list">
                                                <tr><td colspan="5" class="text-center">등록된 첨부파일이 없습니다.</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- 프로젝트 정보 (선택) -->
                            <div class="card border mb-3">
                                <div class="card-header " style="font-weight:500">프로젝트 정보 (선택)</div>
                                <div class="card-body ">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="pj_title_kr">현장명(한글)</label>
                                            <input type="text" name="pj_title_kr" id="pj_title_kr" value="<?php echo _safe_value($row, 'pj_title_kr'); ?>" class="form-control" placeholder="현장명(한글)">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="pj_title_en">현장명(영문)</label>
                                            <input type="text" name="pj_title_en" id="pj_title_en" value="<?php echo _safe_value($row, 'pj_title_en'); ?>" class="form-control" placeholder="현장명(영문)">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="pj_year">준공연도</label>
                                            <input type="text" name="pj_year" id="pj_year" value="<?php echo _safe_value($row, 'pj_year'); ?>" class="form-control" placeholder="준공연도">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="pj_upche">건축사</label>
                                            <input type="text" name="pj_upche" id="pj_upche" value="<?php echo _safe_value($row, 'pj_upche'); ?>" class="form-control" placeholder="건축사">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="pj_addr">주소</label>
                                            <input type="text" name="pj_addr" id="pj_addr" value="<?php echo _safe_value($row, 'pj_addr'); ?>" class="form-control" placeholder="주소">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="pj_person">현장소장</label>
                                            <input type="text" name="pj_person" id="pj_person" value="<?php echo _safe_value($row, 'pj_person'); ?>" class="form-control" placeholder="현장소장">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="pj_type">용도</label>
                                            <input type="text" name="pj_type" id="pj_type" value="<?php echo _safe_value($row, 'pj_type'); ?>" class="form-control" placeholder="용도">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="pj_photo">사진작가</label>
                                            <input type="text" name="pj_photo" id="pj_photo" value="<?php echo _safe_value($row, 'pj_photo'); ?>" class="form-control" placeholder="사진작가">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="m-t-30 text-right">
                                <label class="mr-3">
                                    <input type="checkbox" name="nw_main_open" value="1" <?php echo (_safe_value($row, 'nw_main_open') == '1') ? ' checked="checked"' : ''; ?>>
                                    메인노출
                                </label>
                                <button type="button" class="btn btn-info" id="download_btn" onclick="zip_download('<?php echo _safe_value($row, 'nw_code'); ?>')">스마트일보 첨부사진 일괄다운로드</button>
                                <button type="submit" class="btn btn-primary ml-2">
                                    <?php echo ($w == 'u') ? '수정' : '등록'; ?> (F8)
                                </button>
                                <a href="../list/menu1_list.php" class="btn btn-outline-secondary ml-2">목록</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<!-- Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
// --- 전역 변수 ---
var addBoxNum = <?php echo (int)$max_addnum; ?>;
var filesTempArr = [];
var isSubmitting = false;

// --- 키보드 이벤트 (F8: 등록/수정) ---
document.onkeyup = function(e) {
    if (e.which == 119) { // F8
        if (isSubmitting) {
            alert("처리 중입니다.");
            return false;
        }
        if (confirm('<?php echo ($w == "u") ? "수정" : "등록"; ?>하시겠습니까?')) {
            if (typeof removeCommasBeforeSubmit === 'function' && !removeCommasBeforeSubmit()) {
                isSubmitting = false;
                return false;
            }
            isSubmitting = true;
            $('#worksiteForm').find('button[type=submit]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> 저장 중...');
            document.frm.submit();
        } else {
            return false;
        }
    }
}

// --- 공사기간 등 차수 추가 ---
function add_box() {
    // 1) 폼 안에서 "첫 번째" 차수(card)의 시작일(nw_sdate[]) 값을 읽어옴
    var firstSdate = $('#worksiteForm .price-card-body:first')
        .find('input[name="nw_sdate[]"]')
        .val() || '';  // 혹시 값이 없으면 빈 문자열

    addBoxNum += 1;

    // 2) 새로운 차수 HTML 생성 시, 시작일 부분에 firstSdate 를 value로 세팅
    var newCardHtml = `
    <div class="card border mb-3" id="add_box_${addBoxNum}">
      <div class="card-header" style="font-weight:500">
        <input type="hidden" name="nw_price_num[]" value="${addBoxNum}">
        (<span class="chasu">${addBoxNum}</span>차) 공사기간 및 금액
        <span class="badge badge-danger" onclick="delete_added_box(${addBoxNum})" style="cursor:pointer; margin-left: 10px;">삭제하기</span>
      </div>
      <div class="card-body price-card-body">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>공사기간</label>
            <div class="input-group">
              <input type="date" name="nw_sdate[]" value="${firstSdate}" class="form-control datePicker" placeholder="시작일">
              <input type="date" name="nw_edate[]" value="" class="form-control datePicker" placeholder="종료일">
            </div>
          </div>
          <div class="form-group col-md-6">
            <label>계약일</label>
            <input type="date" name="nw_contract_date[]" value="" class="form-control datePicker" placeholder="계약일">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>공급가액 <small class="text-muted">(숫자만 입력)</small></label>
            <div class="input-group">
              <input type="text" name="nw_price1[]" value="0" class="pi1 form-control price-input" style="width:50%">
              <div class="input-group-append"><span class="input-group-text">원</span></div>
            </div>
          </div>
          <div class="form-group col-md-6">
            <label>부가세 <small class="text-muted">(자동입력/수정가능)</small></label>
            <div class="input-group">
              <input type="text" name="nw_vat[]" value="0" class="pi2 form-control price-input" style="width:50%">
              <div class="input-group-append"><span class="input-group-text">원</span></div>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>계약금액 <small class="text-muted">(자동계산)</small></label>
            <div class="input-group">
              <input type="text" name="nw_contract_price[]" value="0" class="pi3 form-control price-input" style="width:50%" readonly>
              <div class="input-group-append"><span class="input-group-text">원</span></div>
            </div>
          </div>
          <div class="form-group col-md-6">
            <label>현금 계약금액 <small class="text-muted">(숫자만 입력)</small></label>
            <div class="input-group">
              <input type="text" name="nw_price2[]" value="0" class="pi4 form-control price-input" style="width:50%">
              <div class="input-group-append"><span class="input-group-text">원</span></div>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>총 공사금액 <small class="text-muted">(자동계산)</small></label>
            <div class="input-group">
              <input type="text" name="nw_total_price[]" value="0" class="pi5 form-control price-input" style="width:50%" readonly>
              <div class="input-group-append"><span class="input-group-text">원</span></div>
            </div>
          </div>
        </div>
      </div>
    </div>`;
    $('#add_box_result').append(newCardHtml);

    var newCard = $('#add_box_'+addBoxNum);
    bindPriceHandlers(newCard.find('.price-card-body'));
    calculateTotalPrice(newCard.find('.price-card-body'), null);
    reorderChasu();
}
function delete_added_box(boxNum) {
    if(confirm('해당 차수 정보를 삭제하시겠습니까? (저장해야 최종 반영됩니다.)')) {
        $('#add_box_'+boxNum).remove();
        reorderChasu();
    }
}
function del_box(seq, boxNum) {
    var cleanSeq = String(seq).trim();
    if (!cleanSeq) {
        alert('삭제할 데이터 정보(seq)가 올바르지 않습니다.');
        return;
    }
    if(confirm('DB에 저장된 해당 차수 정보를 삭제하시겠습니까?\n(즉시 삭제되며 복구할 수 없습니다.)')) {
        $.post('/_ajax/worksite_add.del.php', { seq : cleanSeq }, function(data) {
            if(String(data).trim() === "success") {
                $('#add_box_'+boxNum).remove();
                reorderChasu();
                alert('차수 정보가 DB에서 삭제되었습니다.');
            } else {
                alert('차수 정보 삭제 중 오류 발생: ' + data);
            }
        }).fail(function() {
            alert('서버 통신 오류로 차수 정보를 삭제하지 못했습니다.');
        });
    }
}
function reorderChasu() {
    var currentChasu = 1;
    $('#worksiteForm .price-card-body').each(function() {
        var $card = $(this).closest('.card');
        $card.find('.card-header .chasu').text(currentChasu);
        currentChasu++;
    });
    addBoxNum = currentChasu -1;
}

// --- 파일 업로드 ---
function file_upload() {
    var formData = new FormData();
    var files = $('#fileInput')[0].files;
    if (files.length === 0) {
        alert('업로드할 파일을 선택해주세요.');
        return;
    }
    for (var i = 0; i < files.length; i++) {
        formData.append("files[]", files[i]);
    }
    formData.append("uid", $('#uid').val());
    formData.append("category", $('#category').val());
    formData.append("w", '<?php echo $w; ?>');

    var uploadBtn = $('#file_upload_btn');
    uploadBtn.html('<i class="fa fa-spinner fa-spin"></i> 업로드 중').prop('disabled', true);

    $.ajax({
        type : "POST",
        url : "/_ajax/file_upload.php",
        data : formData,
        processData: false,
        contentType: false,
        dataType: "text",
        success : function(data) {
            console.log("File upload response:", data);
            $('#userfile').val('');
            $('#fileInput').val('');
            file_list();
        },
        error : function(jqXHR, textStatus, errorThrown) {
            console.error("File upload error:", textStatus, errorThrown, jqXHR.responseText);
            alert('파일 업로드 요청 중 오류 발생:\n' + textStatus + ': ' + errorThrown);
        },
        complete : function() {
            uploadBtn.html('업로드').prop('disabled', false);
        }
    });
}
$('#fileInput').on('change', function(e) {
    var files = e.target.files;
    if (files.length > 0) {
        var fileNames = Array.from(files).map(f => f.name).join(', ');
        $('#userfile').val(files.length + '개 파일 선택됨' + (fileNames.length > 50 ? ': ' + fileNames.substring(0, 50) + '...' : ': ' + fileNames));
    } else {
        $('#userfile').val('선택된 파일 없음');
    }
});

function file_list() {
    var id = $('#uid').val();
    var w_mode = '<?php echo $w; ?>';
    if (!id || id.startsWith('nw_')) {
        console.warn("파일 목록 조회 불가: ID 없음 또는 임시 ID.");
        $('#file_list').html('<tr><td colspan="5" class="text-center">현장 정보 저장 후 파일 목록 조회가 가능합니다.</td></tr>');
        return;
    }
    $('#file_list').html('<tr><td colspan="5" class="text-center"><i class="fa fa-spinner fa-spin"></i> 목록 로딩 중...</td></tr>');
    $.post('/_ajax/file_listup.php', { id : id, w : w_mode }, function(data) {
        if (!data || data.trim() === "" || data.includes('등록된 첨부파일이 없습니다')) {
            $('#file_list').html('<tr><td colspan="5" class="text-center">등록된 첨부파일이 없습니다.</td></tr>');
        } else {
            $('#file_list').html(data);
        }
    }).fail(function(jqXHR, textStatus, errorThrown) {
        $('#file_list').html('<tr><td colspan="5" class="text-center">파일 목록 로딩 중 오류 발생.</td></tr>');
        console.error("파일 목록 조회 실패:", textStatus, errorThrown, jqXHR.responseText);
    });
}
function file_del(seq) {
    if(confirm('정말 삭제하시겠습니까?\n삭제된 파일은 복구가 불가능하며, 서버에서도 즉시 삭제됩니다.')) {
        $.post('/_ajax/file_delete.php', { seq: seq, w: 'd' }, function(data) {
            if (String(data).trim() === 'success') {
                alert('첨부파일이 성공적으로 삭제되었습니다.');
                file_list();
            } else {
                alert(data || '파일 삭제 중 오류 발생.');
            }
        }, 'text').fail(function(jqXHR, textStatus, errorThrown) {
            console.error("File delete error:", textStatus, errorThrown, jqXHR.responseText);
            alert('파일 삭제 요청 중 오류 발생:\n' + textStatus + ': ' + errorThrown);
        });
    }
}

// --- 금액 포맷 및 계산 ---
function formatNumberWithCommas(x) {
    if (x === null || x === undefined || x === '') return '';
    var numStr = String(x).replace(/[^0-9]/g, '');
    if (numStr === '') return '';
    return numStr.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
function calculateTotalPrice(context, triggerElement) {
    var p1Input = $(context).find('input.pi1');
    var p2Input = $(context).find('input.pi2');
    var p3Input = $(context).find('input.pi3');
    var p4Input = $(context).find('input.pi4');
    var p5Input = $(context).find('input.pi5');

    var p1 = parseInt(p1Input.val().replace(/,/g, '')) || 0; // 공급가액
    var p2 = parseInt(p2Input.val().replace(/,/g, '')) || 0; // 부가세
    var p4 = parseInt(p4Input.val().replace(/,/g, '')) || 0; // 현금 계약금액

    // 부가세 자동계산 (공급가액 * 0.1)
    if (triggerElement && $(triggerElement).hasClass('pi1')) {
        p2 = Math.round(p1 * 0.1);
        p2Input.val(formatNumberWithCommas(p2));
    }

    // 계약금액(공급가액 + 부가세)
    var contractPrice = p1 + p2;
    p3Input.val(formatNumberWithCommas(contractPrice));

    // 총 공사금액(공급가액 + 현금 계약금액) 예시
    var totalPrice = p1 + p4;
    p5Input.val(formatNumberWithCommas(totalPrice));
}
function removeCommasBeforeSubmit() {
    var success = true;
    try {
        $('#worksiteForm').find('input.price-input').each(function() {
            if ($(this).val()) {
                var valWithoutCommas = $(this).val().replace(/,/g, '');
                if (isNaN(valWithoutCommas) && valWithoutCommas.trim() !== '') {
                    console.warn("Warning: Non-numeric value submitted:", $(this).attr('name'), $(this).val());
                }
                $(this).val(valWithoutCommas);
            } else {
                $(this).val('0');
            }
        });
    } catch(e) {
        console.error("Error removing commas:", e);
        alert("저장 처리 중 오류 발생 (콤마 제거 실패).");
        success = false;
    }
    return success;
}
function bindPriceHandlers(context) {
    // 공급가액(pi1), 부가세(pi2), 현금계약금액(pi4)
    $(context).find('input.pi1, input.pi2, input.pi4').off('.priceFormat').on('keyup.priceFormat input.priceFormat', function(event) {
        var $input = $(this);
        var value = $input.val();
        var selectionStart = $input[0].selectionStart;
        var originalLength = value.length;
        var numValue = value.replace(/[^0-9]/g, '');
        var formattedValue = formatNumberWithCommas(numValue);
        $input.val(formattedValue);

        var newLength = formattedValue.length;
        var cursorPosition = selectionStart + (newLength - originalLength);
        try {
            $input[0].setSelectionRange(cursorPosition, cursorPosition);
        } catch (e) {
            console.warn("Could not set selection range", e);
        }
        calculateTotalPrice($(this).closest('.price-card-body'), this);
    }).on('blur.priceFormat', function() {
        var $input = $(this);
        var numValue = $input.val().replace(/[^0-9]/g, '');
        $input.val(formatNumberWithCommas(numValue));
        calculateTotalPrice($(this).closest('.price-card-body'), null);
    });

    // 계약금액(pi3), 총공사금액(pi5)은 직접 입력 불가(자동계산)
    $(context).find('input.pi3, input.pi5').off('.priceFormat');
}

// --- 페이지 로드 시 실행 ---
$(function() {
    $('#worksiteForm').on('submit', function(e) {
        if (isSubmitting) {
            alert("처리 중입니다...");
            e.preventDefault();
            return false;
        }
        if (!removeCommasBeforeSubmit()) {
            isSubmitting = false;
            $(this).find('button[type=submit]').prop('disabled', false).html('<?php echo ($w == "u") ? "수정" : "등록"; ?> (F8)');
            e.preventDefault();
            return false;
        }
        isSubmitting = true;
        $(this).find('button[type=submit]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> 저장 중...');
    });

    // 기존 카드들 바인딩
    $('.price-card-body').each(function() {
        bindPriceHandlers(this);
        calculateTotalPrice(this, null);
    });

    // 파일 목록 불러오기
    if ($('#uid').val() && !$('#uid').val().startsWith('nw_')) {
        file_list();
    }

    // Select2 초기화
    $('.select2').select2({
        language: {
            noResults: function () { return "검색 결과가 없습니다."; }
        },
        width: 'resolve'
    });
});

// --- 스마트일보 첨부사진 일괄다운로드 ---
function zip_download(code) {
    var cleanCode = String(code).trim();
    if (!cleanCode) {
        alert('현장 코드가 없어 다운로드할 수 없습니다.\n먼저 현장 정보를 저장하고 현장코드를 입력하세요.');
        return false;
    }
    var downloadBtn = $('#download_btn');
    downloadBtn.html('<i class="fa fa-spinner fa-spin"></i> 다운로드 중').prop('disabled', true);
    location.href = '/file_zip.php?code=' + encodeURIComponent(cleanCode);

    setTimeout(function() {
        downloadBtn.html('스마트일보 첨부사진 일괄다운로드').prop('disabled', false);
    }, 5000);
    return false;
}
</script>

<?php
// include_once(NONE_PATH.'/footer.php'); // 실제 Footer 경로 확인 필요
?>
</body>
</html>
