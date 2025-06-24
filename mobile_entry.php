<?php
include_once('./_common.php');

/*****************************************************
 * 모바일 메인 메뉴 (현장·스마트일보·기안서 등)
 * 2025‑06 UI 리뉴얼: 부트스트랩 5.x + 카드형 레이아웃
 *****************************************************/

/* ────────────── 현장 목록 조회 ────────────── */
$work_sql = "
    SELECT  seq,
            nw_code   AS work_id,       -- 공사코드
            nw_subject
      FROM  {$none['worksite']}
     WHERE  1";

if ($member['mb_level2'] == 2) {              // 현장소장 본인 현장 필터
    $mb = $member['mb_id'];
    $work_sql .= " AND (
        nw_ptype1_1 = '$mb' OR nw_ptype1_2 = '$mb' OR nw_ptype1_3 = '$mb' OR
        nw_ptype1_4 = '$mb' OR nw_ptype1_5 = '$mb' OR nw_ptype1_6 = '$mb' OR
        nw_ptype2_1 = '$mb' OR nw_ptype2_2 = '$mb' OR nw_ptype2_3 = '$mb' OR
        nw_ptype2_4 = '$mb' OR nw_ptype2_5 = '$mb' OR nw_ptype2_6 = '$mb')";
}
$work_sql .= " ORDER BY work_id DESC";
$work_res  = sql_query($work_sql);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title></title>
<link rel="stylesheet" href="<?=NONE_URL?>/common/n1/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?=NONE_URL?>/assets/css/color_skins.css">
<style>
    :root {
        --bs-primary: #006cbf;
        --bs-primary-rgb: 0,108,191;
    }
    body {background:#f8fafc;font-size:.93rem;}
    .brand-logo {height:48px;}
    .card-icon {font-size:1.3rem;margin-right:.4rem;opacity:.7;}
</style>
</head>
<body class="theme-blue">
<div class="container py-4">

    <!-- 헤더 -------------------------------------------------------- -->
    <header class="text-center mb-4">
        <img src="<?=NONE_URL?>/common/images/logo.png" alt="엔원종합건설" class="brand-logo mb-2">
        <h1 class="h5 fw-bold m-0"></h1>
    </header>

    <!-- 현장 선택 ---------------------------------------------------- -->
    <div class="mb-4">
        <label for="worksite-select" class="form-label fw-semibold">내 현장 선택</label>
        <select id="worksite-select" class="form-select w-100 form-select-lg">
            <option value="" data-code="">현장을 선택하세요</option>
            <?php while($row = sql_fetch_array($work_res)) { ?>
            <option value="<?=htmlspecialchars($row['seq'])?>" data-code="<?=htmlspecialchars($row['work_id'])?>">
                [<?=htmlspecialchars($row['work_id'])?>] <?=htmlspecialchars($row['nw_subject'])?>
            </option>
            <?php } ?>
        </select>
    </div>

    <!-- 기능 카드 ---------------------------------------------------- -->
    <div class="row g-3">
        <?php // 카드 정보 배열로 작성하여 반복 출력
        $cards = [
            [
                'title'=>'스마트일보',
                'icon'=>'bi-journal-text',
                'view'=>'/_worksite/list/menu3_list.php',
                'write'=>'/_worksite/write/menu3_write.php',
                'write_id'=>'diary-write-link'
            ],
            [
                'title'=>'기안서',
                'icon'=>'bi-pencil-square',
                'view'=>'/_sign/list/menu1_list.php',
                'write'=>'/_sign/write/menu1_write.php'
            ],
            [
                'title'=>'지출결의서',
                'icon'=>'bi-receipt-cutoff',
                'view'=>'/_sign/list/menu2_list.php',
                'write'=>'/_sign/write/menu2_write.php'
            ],
            [
                'title'=>'기성청구서',
                'icon'=>'bi-file-earmark-text',
                'view'=>'/_establishment/list/menu1_list.php',
                'write'=>'/_establishment/write/menu1_write.php',
                'view_id'=>'claim-view-link',
                'write_id'=>'claim-write-link'
            ]
        ];
        foreach($cards as $c){?>
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <i class="card-icon bi <?=$c['icon'] ?>"></i>
                        <span class="fw-semibold"><?=$c['title']?></span>
                    </div>
                    <div class="btn-group btn-group-sm">
                        <a href="<?=$c['view']?>" class="btn btn-primary<?=isset($c['view_id'])? '" id="'.$c['view_id']:''?>">보기</a>
                        <a href="<?=$c['write']?>" class="btn btn-outline-primary<?=isset($c['write_id'])? '" id="'.$c['write_id']:''?>">작성</a>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

    <!-- 안내 문구 ---------------------------------------------------- -->
    <p class="text-muted mt-3 small">* 스마트일보, 기성청구서는 현장을 먼저 선택 바랍니다.</p>

    <!-- 홈 링크 ------------------------------------------------------ -->
    <div class="d-grid mt-4">
        <a href="/" class="btn btn-secondary btn-lg fw-semibold">메인으로 돌아가기</a>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="<?=NONE_URL?>/common/n1/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- 부트스트랩 아이콘 CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
<script>
$(function(){
    /* 날짜 문자열 */
    const today = ()=> new Date().toISOString().slice(0,10);
    const ym    = ()=> today().slice(0,7);

    /* 현장 선택 시 링크 업데이트 */
    function refreshLinks(seq, code){
        // 스마트일보
        $('#diary-write-link').attr('href', code?
            `/_worksite/write/menu3_write.php?work_id=${code}&date=${today()}` :
            `/_worksite/write/menu3_write.php?date=${today()}`
        );
        // 기성청구서
        $('#claim-view-link').attr('href', seq?
            `/_establishment/list/menu1_list.php?seq=${seq}`:
            '/_establishment/list/menu1_list.php'
        );
        $('#claim-write-link').attr('href', seq?
            `/_establishment/write/menu1_write.php?w=&seq=${seq}&date=${ym()}&index=1`:
            `/_establishment/write/menu1_write.php?date=${ym()}&index=1`
        );
    }

    $('#worksite-select').on('change', function(){
        const seq  = this.value;
        const code = $(this).find('option:selected').data('code');
        refreshLinks(seq, code);
    }).trigger('change'); // 최초 1회
});
</script>
</body>
</html>
