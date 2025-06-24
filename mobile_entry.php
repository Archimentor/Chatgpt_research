<?php
include_once('./_common.php');

/* ─────────────────────────────────────────────
   내 현장 목록: nw_code(공사코드)를 work_id 별칭으로 가져옴
   ───────────────────────────────────────────── */
$work_sql = "
    SELECT  seq,
            nw_code AS work_id,   /* ← 공사코드를 work_id 별칭으로 */
            nw_subject
      FROM  {$none['worksite']}
     WHERE  1
";
if ($member['mb_level2'] == 2) { // 현장소장 본인 현장만
    $mb = $member['mb_id'];
    $work_sql .= " AND (
        nw_ptype1_1 = '$mb' OR nw_ptype1_2 = '$mb' OR nw_ptype1_3 = '$mb' OR
        nw_ptype1_4 = '$mb' OR nw_ptype1_5 = '$mb' OR nw_ptype1_6 = '$mb' OR
        nw_ptype2_1 = '$mb' OR nw_ptype2_2 = '$mb' OR nw_ptype2_3 = '$mb' OR
        nw_ptype2_4 = '$mb' OR nw_ptype2_5 = '$mb' OR nw_ptype2_6 = '$mb'
    )";
}
$work_sql .= " ORDER BY work_id DESC";
$work_res  = sql_query($work_sql);
?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>모바일 메뉴</title>
<link rel="stylesheet" href="<?=NONE_URL?>/common/n1/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?=NONE_URL?>/assets/css/main.css">
<link rel="stylesheet" href="<?=NONE_URL?>/assets/css/color_skins.css">
</head>
<body class="theme-blue">
<div class="container py-4">

  <!-- 로고 -->
  <div class="text-center mb-4">
    <img src="<?=NONE_URL?>/common/images/logo.png" alt="회사 로고" style="height:50px">
  </div>

  <!-- 현장 선택 -->
  <div class="mb-3">
    <select id="worksite-select" class="form-select">
      <option value="" data-code="">내 현장 선택</option>
      <?php while ($row = sql_fetch_array($work_res)) { ?>
      <option value="<?=htmlspecialchars($row['seq'])?>"
              data-code="<?=htmlspecialchars($row['work_id'])?>">
        [<?=htmlspecialchars($row['work_id'])?>] <?=htmlspecialchars($row['nw_subject'])?>
      </option>
      <?php } ?>
    </select>
  </div>

  <div class="row g-3">
    <!-- 스마트일보 -->
    <div class="col-12">
      <div class="card shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
          <span class="fw-bold">스마트일보</span>
          <div>
            <a href="/_worksite/list/menu3_list.php" class="btn btn-sm btn-primary me-1">보기</a>
            <a href="/_worksite/write/menu3_write.php" id="diary-write-link"
               class="btn btn-sm btn-outline-primary">작성</a>
          </div>
        </div>
      </div>
    </div>

    <!-- 기안서 -->
    <div class="col-12">
      <div class="card shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
          <span class="fw-bold">기안서</span>
          <div>
            <a href="/_sign/list/menu1_list.php" class="btn btn-sm btn-primary me-1">보기</a>
            <a href="/_sign/write/menu1_write.php" class="btn btn-sm btn-outline-primary">작성</a>
          </div>
        </div>
      </div>
    </div>

    <!-- 지출결의서 -->
    <div class="col-12">
      <div class="card shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
          <span class="fw-bold">지출결의서</span>
          <div>
            <a href="/_sign/list/menu2_list.php" class="btn btn-sm btn-primary me-1">보기</a>
            <a href="/_sign/write/menu2_write.php" class="btn btn-sm btn-outline-primary">작성</a>
          </div>
        </div>
      </div>
    </div>

    <!-- 기성청구서 -->
    <div class="col-12">
      <div class="card shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
          <span class="fw-bold">기성청구서</span>
          <div>
            <a href="/_establishment/list/menu1_list.php" id="claim-view-link"
               class="btn btn-sm btn-primary me-1">보기</a>
            <a href="/_establishment/write/menu1_write.php" id="claim-write-link"
               class="btn btn-sm btn-outline-primary">작성</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 홈 -->
  <div class="d-grid mt-4">
    <a href="/" class="btn btn-secondary btn-lg">홈으로</a>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="<?=NONE_URL?>/common/n1/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
$(function () {
  /* 오늘 날짜 */
  const todayStr = () => new Date().toISOString().slice(0,10);      // YYYY-MM-DD
  const ymStr    = () => todayStr().slice(0,7);                     // YYYY-MM

  /* 링크 갱신 함수들 */
  function setDiaryLink(code){
    const base = '/_worksite/write/menu3_write.php';
    $('#diary-write-link').attr('href',
      code ? `${base}?work_id=${code}&date=${todayStr()}`
           : `${base}?date=${todayStr()}`);
  }
  function setClaimLinks(seq){
    const viewBase  = '/_establishment/list/menu1_list.php';
    const writeBase = '/_establishment/write/menu1_write.php';
    $('#claim-view-link').attr('href',
      seq ? `${viewBase}?seq=${seq}` : viewBase);
    $('#claim-write-link').attr('href',
      seq ? `${writeBase}?w=&seq=${seq}&date=${ymStr()}&index=1`
           : `${writeBase}?date=${ymStr()}&index=1`);
  }

  /* 드롭다운 변경 시 */
  $('#worksite-select').on('change', function(){
    const seq  = this.value;
    const code = $(this).find('option:selected').data('code');
    setDiaryLink(code);
    setClaimLinks(seq);
  })
  .trigger('change');   // 페이지 최초 1회 실행
});
</script>
</body>
</html>
