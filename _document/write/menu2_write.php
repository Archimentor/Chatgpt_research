<?php 
include_once('../../_common.php');
define('menu_document', true);
include_once(NONE_PATH.'/header.php'); 

if($w == 'u') {
    $row = sql_fetch("SELECT * FROM {$none['subcontract']} WHERE seq = '$seq'");
    if(!$row) alert('데이터가 삭제되었거나 이동되었습니다.');
}

// 추가 차수 목록 추출 (수정 모드 시)
if($w == 'u') {
    $max_addnum = sql_fetch("SELECT MAX(ns_num) AS num FROM {$none['subcontract_add']} WHERE sb_id = '$seq'");
    $sql2 = "SELECT * FROM {$none['subcontract_add']} WHERE sb_id = '$seq' ORDER BY ns_num ASC";
    $rst2 = sql_query($sql2);
    $sub_rows = array();
    while($r2=sql_fetch_array($rst2)) {
        $sub_rows[] = $r2;
    }
}

?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2 { width:100% !important; }
.select2-container .select2-selection--single {  height:36px; }
.select2-container--default .select2-selection--single { border:1px solid #ced4da; }
.select2-container--default .select2-selection--single .select2-selection__rendered { line-height:34px; }
.select2-container--default .select2-selection--single .select2-selection__arrow { height:34px; }
.price_txt { font-size:13px; }
</style>

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2>
                        <a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                            <i class="fa fa-arrow-left"></i>
                        </a> 문서관리
                    </h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">하도급계약총괄표</li>
                        <li class="breadcrumb-item active">
                            하도급계약 정보 <?php echo ($w=='u'?'수정':'등록');?>
                        </li>
                    </ul>
                </div>            
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <!-- 폼 전송 시 콤마 제거 -->
                        <form name="frm" action="./menu2_update.php" 
                              enctype="multipart/form-data" 
                              method="post" 
                              onsubmit="removeAllComma();">
                              
                            <input type="hidden" name="uid" id="uid" value="<?php echo get_uniqid()?>">
                            <input type="hidden" name="w" value="<?php echo $w?>">
                            <input type="hidden" name="seq" value="<?php echo $seq?>">

                            <!-- 기본정보 -->
                            <div class="card border mb-3">
                                <div class="card-header" style="font-weight:500">
                                    기본정보
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>계약종류</label>
                                            <select name="ns_type" class="form-control">
                                                <option value="">계약종류를 선택하세요.</option>
                                                <option value="공사계약" <?php echo get_selected($row['ns_type'], '공사계약')?>>공사계약</option>
                                                <option value="자재계약" <?php echo get_selected($row['ns_type'], '자재계약')?>>자재계약</option>
                                                <option value="기타계약" <?php echo get_selected($row['ns_type'], '기타계약')?>>기타계약</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>계약구분</label>
                                            <select name="ns_type2" class="form-control">
                                                <option value="">계약구분을 선택하세요.</option>
                                                <option value="하도급계약" <?php echo get_selected($row['ns_type2'], '하도급계약')?>>하도급계약</option>
                                                <option value="약정계약"   <?php echo get_selected($row['ns_type2'], '약정계약')?>>약정계약</option>
                                                <option value="시공참여"   <?php echo get_selected($row['ns_type2'], '시공참여')?>>시공참여</option>
                                                <option value="직영처리"   <?php echo get_selected($row['ns_type2'], '직영처리')?>>직영처리</option>
                                                <option value="계약안함"   <?php echo get_selected($row['ns_type2'], '계약안함')?>>계약안함</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>현장명</label>
                                            <select name="work_id" class="form-control select2" required>
                                                <option value="">현장을 선택하세요.</option>
                                                <?php 
                                                $sql = "SELECT nw_code, nw_subject 
                                                          FROM {$none['worksite']} 
                                                      ORDER BY nw_code DESC";
                                                $rst = sql_query($sql);
                                                while($nw=sql_fetch_array($rst)) {
                                                    echo '<option value="'.$nw['nw_code'].'" '.get_selected($nw['nw_code'], $row['work_id']).'>['.$nw['nw_code'].'] '.$nw['nw_subject'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>기안서</label>
                                            <select name="ns_gian" class="form-control select2">
                                                <option value="">검색 된 기안서가 없습니다.</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 업체정보 -->
                            <div class="card border mb-3">
                                <div class="card-header" style="font-weight:500">
                                    업체정보
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                        <label>공종명</label>
											<select name="ns_gongjong"  class="form-control select2">
												<option value="">선택하세요</option>
												<option value="가설공사" <?php echo get_selected($row['ns_gongjong'], '가설공사')?>>가설공사</option>
												<option value="가시설공사" <?php echo get_selected($row['ns_gongjong'], '가시설공사')?>>가시설공사</option>
												<option value="토공사" <?php echo get_selected($row['ns_gongjong'], '토공사')?>>토공사</option>
												<option value="철근콘크리트공사" <?php echo get_selected($row['ns_gongjong'], '철근콘크리트공사')?>>철근콘크리트공사</option>
												<option value="철골공사" <?php echo get_selected($row['ns_gongjong'], '철골공사')?>>철골공사</option>
												<option value="조적공사" <?php echo get_selected($row['ns_gongjong'], '조적공사')?>>조적공사</option>
												<option value="방수공사" <?php echo get_selected($row['ns_gongjong'], '방수공사')?>>방수공사</option>
												<option value="타일공사" <?php echo get_selected($row['ns_gongjong'], '타일공사')?>>타일공사</option>
												<option value="석공사" <?php echo get_selected($row['ns_gongjong'], '석공사')?>>석공사</option>
												<option value="목공사" <?php echo get_selected($row['ns_gongjong'], '목공사')?>>목공사</option>
												<option value="금속공사" <?php echo get_selected($row['ns_gongjong'], '금속공사')?>>금속공사</option>
												<option value="미장공사" <?php echo get_selected($row['ns_gongjong'], '미장공사')?>>미장공사</option>
												<option value="창호공사" <?php echo get_selected($row['ns_gongjong'], '창호공사')?>>창호공사</option>
												<option value="유리공사" <?php echo get_selected($row['ns_gongjong'], '유리공사')?>>유리공사</option>
												<option value="도장공사" <?php echo get_selected($row['ns_gongjong'], '도장공사')?>>도장공사</option>
												<option value="수장공사" <?php echo get_selected($row['ns_gongjong'], '수장공사')?>>수장공사</option>
												<option value="지붕및홈통공사" <?php echo get_selected($row['ns_gongjong'], '지붕및홈통공사')?>>지붕및홈통공사</option>
												<option value="판넬공사" <?php echo get_selected($row['ns_gongjong'], '판넬공사')?>>판넬공사</option>
												<option value="기타공사" <?php echo get_selected($row['ns_gongjong'], '기타공사')?>>기타공사</option>
												<option value="부대공사" <?php echo get_selected($row['ns_gongjong'], '부대공사')?>>부대공사</option>
												<option value="조경공사" <?php echo get_selected($row['ns_gongjong'], '조경공사')?>>조경공사</option>
												<option value="철거공사" <?php echo get_selected($row['ns_gongjong'], '철거공사')?>>철거공사</option>
												<option value="인테리어공사" <?php echo get_selected($row['ns_gongjong'], '인테리어공사')?>>인테리어공사</option>
												<option value="설비공사" <?php echo get_selected($row['ns_gongjong'], '설비공사')?>>설비공사</option>
												<option value="전기공사" <?php echo get_selected($row['ns_gongjong'], '전기공사')?>>전기공사</option>
												<option value="폐기물처리" <?php echo get_selected($row['ns_gongjong'], '폐기물처리')?>>폐기물처리</option>
												<option value="엘리베이터" <?php echo get_selected($row['ns_gongjong'], '엘리베이터')?>>엘리베이터</option>
												<option value="철근" <?php echo get_selected($row['ns_gongjong'], '철근')?>>철근</option>
												<option value="레미콘" <?php echo get_selected($row['ns_gongjong'], '레미콘')?>>레미콘</option>
												<option value="단열재" <?php echo get_selected($row['ns_gongjong'], '단열재')?>>단열재</option>
												<option value="운반" <?php echo get_selected($row['ns_gongjong'], '운반')?>>운반</option>
												<option value="장비업체" <?php echo get_selected($row['ns_gongjong'], '장비업체')?>>장비업체</option>
												<option value="용역업체" <?php echo get_selected($row['ns_gongjong'], '용역업체')?>>용역업체</option>
												<option value="건축사사무소" <?php echo get_selected($row['ns_gongjong'], '건축사사무소')?>>건축사사무소</option>
												<option value="철자재" <?php echo get_selected($row['ns_gongjong'], '철자재')?>>철자재</option>
												<option value="잡자재" <?php echo get_selected($row['ns_gongjong'], '잡자재')?>>잡자재</option>
												<option value="조명" <?php echo get_selected($row['ns_gongjong'], '조명')?>>조명</option>
												<option value="가구공사" <?php echo get_selected($row['ns_gongjong'], '가구공사')?>>가구공사</option>
												<option value="기술지도" <?php echo get_selected($row['ns_gongjong'], '기술지도')?>>기술지도</option>
											</select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>업체명</label>
                                            <select name="ns_bname" id="ns_banme" class="form-control select2" required>
                                                <option value="">업체를 선택하세요.</option>
                                                <?php echo get_enterprise_all_select($row['ns_bname'])?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>대표전화</label>
                                            <input type="text" name="ns_btel" id="ns_btel"
                                                   value="<?php echo $row['ns_btel']?>" 
                                                   class="form-control" 
                                                   placeholder="대표전화">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>현장소장</label>
                                            <input type="text" name="ns_manager" id="ns_manager"
                                                   value="<?php echo $row['ns_manager']?>" 
                                                   class="form-control" 
                                                   placeholder="현장소장">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>현장소장 연락처</label>
                                            <input type="text" name="ns_manager_tel" id="ns_manager_tel"
                                                   value="<?php echo $row['ns_manager_tel']?>" 
                                                   class="form-control" 
                                                   placeholder="현장소장 연락처">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- (1차) 공사기간 및 금액 -->
                            <div class="card border mb-3">
                                <div class="card-header" style="font-weight:500">
                                    (<span class="chasu">1</span>차) 공사기간 및 금액 
                                    <span class="badge badge-danger" onclick="add_box()" style="cursor:pointer">
                                        +차수 추가
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>공사기간</label>
                                            <div class="input-group">
                                                <input type="date" name="ns_sdate[]" 
                                                       value="<?php echo $row['ns_sdate']?>" 
                                                       class="form-control datePicker" 
                                                       placeholder="시작일">
                                                <input type="date" name="ns_edate[]" 
                                                       value="<?php echo $row['ns_edate']?>" 
                                                       class="form-control datePicker" 
                                                       placeholder="종료일">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>계약일</label>
                                            <input type="date" name="ns_contract_date[]" 
                                                   value="<?php echo $row['ns_contract_date']?>" 
                                                   class="form-control datePicker" 
                                                   placeholder="계약일">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>공급가액 <small class="text-muted">(숫자만 입력)</small></label>
                                            <div class="input-group">
                                                <input type="text" name="ns_price[]"
                                                       value="<?php echo number_format($row['ns_price'])?>"
                                                       class="pi1 form-control"
                                                       onkeyup="calcPrice(this)"
                                                       style="width:50%">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">원</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>부가세 <small class="text-muted">(숫자만 입력)</small></label>
                                            <div class="input-group">
                                                <input type="text" name="ns_vat[]"
                                                       value="<?php echo number_format($row['ns_vat'])?>"
                                                       class="pi2 form-control"
                                                       onkeyup="calcPrice(this)"
                                                       style="width:50%">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">원</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>총 공사금액 <small class="text-muted">(숫자만 입력/자동입력)</small></label>
                                            <div class="input-group">
                                                <input type="text" name="ns_total_price[]"
                                                       value="<?php echo number_format($row['ns_total_price'])?>"
                                                       class="pi5 form-control"
                                                       onkeyup="calcPrice(this)"
                                                       style="width:50%">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">원</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 2차 이상(추가 차수) - 수정 모드에서 불러오기 -->
                            <?php 
                            if($w == 'u') {
                                // addBoxNum 초기값 세팅
                                $addBoxNum = $max_addnum['num'] ? $max_addnum['num'] : 1;
                                foreach($sub_rows as $row2) {
                            ?>
                            <div class="card border mb-3" id="add_box_<?php echo $row2['ns_num']?>">
                                <div class="card-header" style="font-weight:500">
                                    (<span class="chasu"><?php echo $row2['ns_num']?></span>차) 공사기간 및 금액 
                                    <input type="hidden" name="ns_price_num[]" value="<?php echo $row2['ns_num']?>">
                                    <span class="badge badge-danger" 
                                          style="cursor:pointer"
                                          onclick="delete_box(<?php echo $row2['ns_num']?>)">
                                          삭제하기
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>공사기간</label>
                                            <div class="input-group">
                                                <input type="date" name="ns_sdate[]" 
                                                       value="<?php echo $row2['ns_sdate']?>" 
                                                       class="form-control datePicker" 
                                                       placeholder="시작일">
                                                <input type="date" name="ns_edate[]" 
                                                       value="<?php echo $row2['ns_edate']?>" 
                                                       class="form-control datePicker" 
                                                       placeholder="종료일">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>계약일</label>
                                            <input type="date" name="ns_contract_date[]" 
                                                   value="<?php echo $row2['ns_contract_date']?>" 
                                                   class="form-control datePicker" 
                                                   placeholder="계약일">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>공급가액</label>
                                            <div class="input-group">
                                                <input type="text" name="ns_price[]"
                                                       value="<?php echo number_format($row2['ns_price'])?>"
                                                       class="pi1 form-control"
                                                       onkeyup="calcPrice(this)"
                                                       style="width:50%">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">원</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>부가세</label>
                                            <div class="input-group">
                                                <input type="text" name="ns_vat[]"
                                                       value="<?php echo number_format($row2['ns_vat'])?>"
                                                       class="pi2 form-control"
                                                       onkeyup="calcPrice(this)"
                                                       style="width:50%">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">원</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>총 공사금액</label>
                                            <div class="input-group">
                                                <input type="text" name="ns_total_price[]"
                                                       value="<?php echo number_format($row2['ns_total_price'])?>"
                                                       class="pi5 form-control"
                                                       onkeyup="calcPrice(this)"
                                                       style="width:50%">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">원</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php 
                                } // end foreach
                            } // end if($w=='u')
                            ?>

                            <!-- 추가 차수가 새로 생길 영역 -->
                            <div id="add_box_result"></div>

                            <!-- 기타 정보 -->
                            <div class="card border mb-3">
                                <div class="card-header" style="font-weight:500">
                                    기타 정보
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>메모</label>
                                            <textarea name="ns_memo" class="form-control" rows="3">
                                                <?php echo $row['ns_memo']?>
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>하수급인 관리번호</label>
                                            <input type="text" name="ns_num" 
                                                   value="<?php echo $row['ns_num']?>"  
                                                   class="form-control">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>키스콘 신고</label><br>
                                            <input type="checkbox" name="ns_kiscon" value="1" 
                                                   id="exampleCheck1"
                                                   <?php echo get_checked($row['ns_kiscon'], 1)?>>
                                            <label class="form-check-label" for="exampleCheck1">
                                                예
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 첨부 서류 -->
                            <div class="card border mb-3">
                                <div class="card-header" style="font-weight:500">
                                    서류 첨부
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-auto">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="category">파일 분류</label>
                                                </div>
                                                <select name="category" id="category" class="custom-select">
                                                    <option value="계약서">계약서</option>
                                                    <option value="내역서">내역서</option>
                                                    <option value="현장대리인계">현장대리인계</option>
                                                    <option value="계약보증서">계약보증서</option>
                                                    <option value="근로자재해증권">근로자재해증권</option>
                                                    <option value="선급금보증서">선급금보증서</option>
                                                    <option value="기타서류">기타서류</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="form-group">
                                                <input id="fileInput" type="file"
                                                       style="position:absolute; clip:rect(0px,0px,0px,0px);" 
                                                       class="form-control"
                                                       name="files[]" multiple>
                                                <input type="text" id="userfile" 
                                                       class="form-control" 
                                                       name="userfile" 
                                                       disabled>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <span class="group-span-filestyle input-group-btn" tabindex="0">
                                                <label for="fileInput" class="btn btn-default">
                                                    <span class="glyphicon fa fa-upload"></span>
                                                    찾기
                                                </label>
                                            </span>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" id="file_upload_btn" 
                                                    onclick="file_upload()" 
                                                    class="btn btn-primary mb-2">
                                                업로드
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <table class="table table-striped">
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
                                                <tr>
                                                    <td colspan="5">등록 된 첨부파일이 없습니다.</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- 등록/취소 -->
                            <div class="m-t-30 align-right">
                                <button type="submit" class="btn btn-primary" style="margin-left:20px">
                                    <?php echo ($w=='u'?'수정':'등록')?>(F8)
                                </button>
                                <a href="../list/menu2_list.php" class="btn btn-outline-secondary">취소</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once(NONE_PATH.'/footer.php');?>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
// ---------------------------- 숫자 포맷 함수 -----------------------------
function comma(str) {
    return str.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
function uncomma(str) {
    return str.replace(/[^\d]+/g, "");
}

// ---------------------------- 금액 계산 -----------------------------
function calcPrice(obj) {
    var $body   = $(obj).closest('.card-body'); 
    var $supply = $body.find('.pi1');  // 공급가액
    var $vat    = $body.find('.pi2');  // 부가세
    var $total  = $body.find('.pi5');  // 총공사금액

    var supply = uncomma($supply.val())*1 || 0;
    var vat    = uncomma($vat.val())*1 || 0;
    var total  = uncomma($total.val())*1 || 0;

    if(obj === $supply[0]) {
        // 공급가액 바뀌면 부가세=10% 자동, 총공사금액=공급가액+부가세
        vat   = Math.round(supply * 0.1);
        total = supply + vat;
        $vat.val(comma(vat.toString()));
        $total.val(comma(total.toString()));
    }
    else if(obj === $vat[0]) {
        // 부가세 직접 수정 → 총공사금액=공급가액+부가세
        total = supply + vat;
        $total.val(comma(total.toString()));
    }
    else if(obj === $total[0]) {
        // 총공사금액 직접 수정 → 부가세=총공사금액-공급가액
        if(total < supply) total = supply;
        vat = total - supply;
        $vat.val(comma(vat.toString()));
    }

    obj.value = comma(uncomma(obj.value));
}

// ---------------------------- 폼 전송 시 콤마 제거 -----------------------------
function removeAllComma() {
    document.querySelectorAll('input[name="ns_price[]"]').forEach(function(el){
        el.value = uncomma(el.value);
    });
    document.querySelectorAll('input[name="ns_vat[]"]').forEach(function(el){
        el.value = uncomma(el.value);
    });
    document.querySelectorAll('input[name="ns_total_price[]"]').forEach(function(el){
        el.value = uncomma(el.value);
    });
}

// ---------------------------- 차수 추가 -----------------------------
<?php if($w=='u') { ?>
var addBoxNum = <?php echo ($addBoxNum>1?$addBoxNum:1)?>;
<?php } else { ?>
var addBoxNum = 1;
<?php }?>

function add_box() {
    addBoxNum += 1;
    var last_sdate = $('input[name="ns_sdate[]"]').last().val() || '';

    var html = '';
    html += '<div class="card border mb-3" id="add_box_'+addBoxNum+'">';
    html += '  <input type="hidden" name="ns_price_num[]" value="'+addBoxNum+'">';
    html += '  <div class="card-header" style="font-weight:500">';
    html += '      (<span class="chasu">'+addBoxNum+'</span>차) 공사기간 및 금액 ';
    html += '      <span class="badge badge-danger" style="cursor:pointer"';
    html += '            onclick="delete_box('+addBoxNum+')">삭제하기</span>';
    html += '  </div>';
    html += '  <div class="card-body">';
    html += '      <div class="form-row">';
    html += '          <div class="form-group col-md-6">';
    html += '              <label>공사기간</label>';
    html += '              <div class="input-group">';
    html += '                  <input type="date" name="ns_sdate[]" value="'+last_sdate+'"';
    html += '                         class="form-control datePicker">';
    html += '                  <input type="date" name="ns_edate[]" class="form-control datePicker">';
    html += '              </div>';
    html += '          </div>';
    html += '          <div class="form-group col-md-6">';
    html += '              <label>계약일</label>';
    html += '              <input type="date" name="ns_contract_date[]" class="form-control">';
    html += '          </div>';
    html += '      </div>';
    html += '      <div class="form-row">';
    html += '          <div class="form-group col-md-6">';
    html += '              <label>공급가액</label>';
    html += '              <div class="input-group">';
    html += '                  <input type="text" name="ns_price[]" class="pi1 form-control"';
    html += '                         onkeyup="calcPrice(this)" style="width:50%">';
    html += '                  <div class="input-group-append">';
    html += '                      <span class="input-group-text">원</span>';
    html += '                  </div>';
    html += '              </div>';
    html += '          </div>';
    html += '          <div class="form-group col-md-6">';
    html += '              <label>부가세</label>';
    html += '              <div class="input-group">';
    html += '                  <input type="text" name="ns_vat[]" class="pi2 form-control"';
    html += '                         onkeyup="calcPrice(this)" style="width:50%">';
    html += '                  <div class="input-group-append">';
    html += '                      <span class="input-group-text">원</span>';
    html += '                  </div>';
    html += '              </div>';
    html += '          </div>';
    html += '      </div>';
    html += '      <div class="form-row">';
    html += '          <div class="form-group col-md-6">';
    html += '              <label>총 공사금액</label>';
    html += '              <div class="input-group">';
    html += '                  <input type="text" name="ns_total_price[]" class="pi5 form-control"';
    html += '                         onkeyup="calcPrice(this)" style="width:50%">';
    html += '                  <div class="input-group-append">';
    html += '                      <span class="input-group-text">원</span>';
    html += '                  </div>';
    html += '              </div>';
    html += '          </div>';
    html += '      </div>';
    html += '  </div>';
    html += '</div>';

    $('#add_box_result').append(html);
}

// ---------------------------- 즉시 삭제 (AJAX) -----------------------------
// 메인 계약 seq는 <?php echo $seq?> 로 가정
function delete_box(ns_num) {
    if(!confirm('정말 삭제하시겠습니까?\n삭제 후 복구가 불가능합니다.')) {
        return;
    }
    // AJAX로 DB 삭제
    $.post('./menu2_update.php', 
           {
             w: 'del_sub_add',
             sb_id: <?php echo (int)$seq?>,  // 메인계약 PK
             ns_num: ns_num
           },
           function(res) {
               // 서버 측에서 성공 시 "OK"
               if(res.trim() === 'OK') {
                   // DOM 제거
                   $('#add_box_'+ns_num).remove();
                   // 차수 재정렬
                   var i=1;
                   $('.chasu').each(function(){
                       $(this).text(i++);
                   });
               } else {
                   alert('삭제 실패: ' + res);
               }
           }
    );
}

// ---------------------------- 파일업로드 관련 -----------------------------
var filesTempArr = [];

function addFiles(e) {
    var files = e.target.files;
    var filesArr = Array.prototype.slice.call(files);
    for(var i=0; i<filesArr.length; i++) {
        filesTempArr.push(filesArr[i]);
    }
    $('#userfile').val(filesArr.length+'개 파일 첨부됨');
    $(this).val('');
}

function file_upload() {
    var formData = new FormData();
    for(var i=0; i<filesTempArr.length; i++) {
        formData.append("files[]", filesTempArr[i]);
    }
    <?php if($w=='u'){ ?>
    formData.append("uid", <?php echo $seq?>);
    <?php } else { ?>
    formData.append("uid", $('#uid').val());
    <?php } ?>
    formData.append("category", $('#category').val());
    
    $('#file_upload_btn').html('업로드 처리중..');
    $.ajax({
        type : "POST",
        url  : "/_ajax/file_upload2.php",
        data : formData,
        processData: false,
        contentType: false,
        success : function(data) {
            if(data == "no") {
                alert('업로드에 실패하였습니다.\n파일이 없거나 업로드 불가능한 확장자/용량.');
            } else {
                $('#userfile').val('');
                filesTempArr = [];
                file_list();
            }
            $('#file_upload_btn').html('업로드');
        },
        error : function(err) {
            alert(err.status);
        }
    });
}

function file_list() {
    var id = <?php echo ($w=='u'?$seq:'$("#uid").val()')?>; 
    // 문자열 치환 주의 → 실제로는 if문 써서 깔끔하게 처리 가능
    $.post('/_ajax/file_listup2.php', 
           { id:id, w:'<?php echo $w?>' },
           function(data) {
               $('#file_list').html(data);
           }
    );
}

function file_del(seq) {
    if(confirm('정말 삭제하시겠습니까?\n삭제 된 파일은 복구가 불가능합니다.')) {
        location.href = '/_ajax/file_delete2.php?w=d&seq='+seq;
    }
}

$(function(){
    // F8 저장
    document.onkeyup = function(e) {
        if(e.which == 119) {
            if(confirm('저장하시겠습니까?')) {
                removeAllComma();
                document.frm.submit();
            }
        }
    };

    // select2
    $('.select2').select2({
        language: {
            noResults: function () { return "검색 결과가 없습니다."; }
        }
    });
    
    // 업체명 변경 시 대표전화 자동 입력
    $('#ns_banme').on('change', function() {
        var tel = $(this).find(':selected').attr('data');
        $('#ns_btel').val(tel);
    });

    // (수정모드) 파일목록 불러오기
    <?php if($w=='u'){ ?>
        file_list();
    <?php }?>

    $("#fileInput").on('change', addFiles);
});
</script>
