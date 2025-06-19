<?php
include_once('../../_common.php');
define('menu_employee', true);
include_once(NONE_PATH.'/header.php'); 

// $w : 등록('') / 수정('u') 구분
if($w == 'u') {
    // 수정 모드에서 $mb_id로 회원정보 가져옴
    $row = get_member($mb_id);
} else {
    // 신규 등록 모드: 필요한 경우 $row 기본값 설정
    $row = array();
}
?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2 { width:100% !important }
.select2-container .select2-selection--single {  height:36px }
.select2-container--default .select2-selection--single { border:1px solid #ced4da; }
.select2-container--default .select2-selection--single .select2-selection__rendered { line-height:34px }
.select2-container--default .select2-selection--single .select2-selection__arrow { height:34px }
</style>

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                        <i class="fa fa-arrow-left"></i></a> 회사관리
                    </h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">회사관리</li>
                        <li class="breadcrumb-item active">직원 정보등록</li>
                    </ul>
                </div>            
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <form name="frm" action="./menu1_update.php" enctype="multipart/form-data" method="post">
                            
                            <input type="hidden" name="w" id="w" value="<?php echo $w; ?>">
                            
                            <!-- 로그인정보 관리 -->
                            <div class="card border mb-3">
                                <div class="card-header" style="font-weight:500">
                                    로그인정보 관리
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label>아이디</label>
                                            <input type="text" name="mb_id" required class="required form-control" 
                                                value="<?php echo $row['mb_id'] ?? ''; ?>" 
                                                placeholder=""
                                                <?php if($w == 'u') echo 'readonly'; ?>>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>패스워드</label>
                                            <input type="password" name="mb_password" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- 직원 개인정보 -->
                            <div class="card border mb-3">
                                <div class="card-header" style="font-weight:500">
                                    직원 개인정보
                                </div>
                                <div class="card-body">
                                    <!-- 성명 & 기술등급 -->
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>성명</label>
                                            <input type="text" name="mb_name"
                                                value="<?php echo $row['mb_name'] ?? ''; ?>" 
                                                class="form-control" 
                                                placeholder="성명">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>기술등급</label>
                                            <input type="text" name="mb_7"
                                                value="<?php echo $row['mb_7'] ?? ''; ?>"
                                                class="form-control" 
                                                placeholder="기술등급">
                                        </div>
                                    </div>
                                    <!-- 휴대전화 & 이메일 -->
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>휴대전화</label>
                                            <input type="text" name="mb_hp"
                                                value="<?php echo $row['mb_hp'] ?? ''; ?>"
                                                class="form-control"
                                                placeholder="휴대전화">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>이메일</label>
                                            <input type="email" name="mb_email"
                                                value="<?php echo $row['mb_email'] ?? ''; ?>"
                                                class="form-control"
                                                placeholder="sample@naver.com">
                                        </div>
                                    </div>

                                    <?php
                                    // 1) 신규 등록 모드: 항상 입사일/생년월일을 보여줌
                                    // 2) 수정 모드: mb_level2 == 3인 경우만 보여줌
                                    if ($w == '') {
                                        // [신규등록 모드]
                                    ?>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>입사일</label>
                                            <input type="date" name="mb_in_date"
                                                value="<?php echo $row['mb_in_date'] ?? ''; ?>"
                                                class="form-control"
                                                placeholder="입사일">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>생년월일</label>
                                            <input type="date" name="mb_birth"
                                                value="<?php echo $row['mb_birth'] ?? ''; ?>"
                                                class="form-control"
                                                placeholder="생년월일">
                                        </div>
                                    </div>
                                    <?php
                                    } else if ($w == 'u' && $member['mb_level2'] == 3) {
                                        // [수정 모드]이면서 등급=3
                                    ?>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>입사일</label>
                                            <input type="date" name="mb_in_date"
                                                value="<?php echo $row['mb_in_date'] ?? ''; ?>"
                                                class="form-control"
                                                placeholder="입사일">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>생년월일</label>
                                            <input type="date" name="mb_birth"
                                                value="<?php echo $row['mb_birth'] ?? ''; ?>"
                                                class="form-control"
                                                placeholder="생년월일">
                                        </div>
                                    </div>
                                    <?php
                                    } // end else if
                                    ?>

                                </div>
                            </div>
                            
                            <!-- 첨부파일 -->
                            <div class="card border mb-3">
                                <div class="card-header" style="font-weight:500">
                                    첨부파일
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>자격 증 및 자격번호</label>
                                            <input type="file" name="mb_img1" class="form-control">
                                            <?php
                                            if (!empty($row['mb_id'])) {
                                                $mb_dir = substr($row['mb_id'],0,2);
                                                $icon_file = G5_DATA_PATH.'/member/'.$mb_dir.'/'.$row['mb_id'].'_num.gif';
                                                if (file_exists($icon_file)) {
                                                    echo '<img src="'.G5_DATA_URL.'/member/'.$mb_dir.'/'.$row['mb_id'].'_num.gif" style="width:60px;height:60px">';
                                                    echo ' <label><input type="checkbox" name="del_mb_img1" value="1">삭제</label>';
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>사진</label>
                                            <input type="file" name="mb_img2" class="form-control">
                                            <?php
                                            if (!empty($row['mb_id'])) {
                                                $mb_dir = substr($row['mb_id'],0,2);
                                                $icon_file = G5_DATA_PATH.'/member_image/'.$mb_dir.'/'.get_mb_icon_name($row['mb_id']).'.gif';
                                                if (file_exists($icon_file)) {
                                                    echo '<img src="'.G5_DATA_URL.'/member_image/'.$mb_dir.'/'.get_mb_icon_name($row['mb_id']).'.gif" style="width:60px;height:60px">';
                                                    echo ' <label><input type="checkbox" name="del_mb_img2" value="1">삭제</label>';
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>서명파일</label>
                                            <input type="file" name="mb_img3" class="form-control">
                                            <?php
                                            if (!empty($row['mb_id'])) {
                                                $mb_dir = substr($row['mb_id'],0,2);
                                                $icon_file = G5_DATA_PATH.'/member/'.$mb_dir.'/'.$row['mb_id'].'_sign.gif';
                                                if (file_exists($icon_file)) {
                                                    echo '<img src="'.G5_DATA_URL.'/member/'.$mb_dir.'/'.$row['mb_id'].'_sign.gif" style="width:60px;height:60px">';
                                                    echo ' <label><input type="checkbox" name="del_mb_img3" value="1">삭제</label>';
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- 소속 및 근무정보 -->
                            <div class="card border mb-3">
                                <div class="card-header" style="font-weight:500">
                                    소속 및 근무정보
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>지사</label>
                                            <select name="mb_1" class="form-control">
                                                <?php echo get_branch_select($row['mb_1'] ?? ''); ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>부서</label>
                                            <select name="mb_2" class="form-control">
                                                <?php echo get_department_select($row['mb_2'] ?? ''); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>직급</label>
                                            <select name="mb_3" class="form-control">
                                                <?php echo get_mposition_select($row['mb_3'] ?? ''); ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>보안등급</label>
                                            <select name="mb_level2" class="form-control">
                                                <?php echo get_mlevel_select($row['mb_level2'] ?? ''); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>경력 및 이력</label>
                                            <textarea name="mb_memo" class="form-control" rows="10"><?php echo $row['mb_memo'] ?? ''; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="m-t-30 align-right">
                                <button type="submit" class="btn btn-primary" style="margin-left:20px">
                                    <?php echo ($w == 'u') ? '수정' : '등록'; ?>(F8)
                                </button>
                                <a href="../list/menu1_list.php" class="btn btn-outline-secondary">취소</a>
                            </div>
                        </form>
                    </div> <!-- .body -->
                </div> <!-- .card -->
            </div> <!-- .col-lg-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
</div> <!-- #main-content -->

<?php include_once(NONE_PATH.'/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.onkeyup = function(e) {
    if(e.which == 119) { // F8
        if(confirm('저장하시겠습니까?')) {
            document.frm.submit();
        } else {
            return false;
        }
    }
}
$(function() {
    $('.select2').select2({
        language: {
            noResults: function (params) {
                return "검색 결과가 없습니다.";
            }
        }
    });
});
</script>
