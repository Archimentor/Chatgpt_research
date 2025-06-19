<?php
// header.php - 수정본 (호스트별 권한 로직 재정렬)

/* ───────────────────────────────────────────────
   공통 설정
─────────────────────────────────────────────── */
include_once $_SERVER['DOCUMENT_ROOT'] . '/_common.php';

/* ───────────────────────────────────────────────
   호스트 판별
─────────────────────────────────────────────── */
$host       = strtolower($_SERVER['HTTP_HOST']);
$is_gw_host = ($host === 'gw.n1con.com');        // 내부 그룹웨어
$is_home_host = !$is_gw_host;                    // 외부 홈페이지(n1con.com)

/* ───────────────────────────────────────────────
   내부 그룹웨어(gw.n1con.com) 전용 처리
─────────────────────────────────────────────── */
if ($is_gw_host) {

    // ① 로그인 필수
    if ($is_guest) {
        // 절대경로로 지정하여 도메인 혼동 방지
        goto_url('http://gw.n1con.com/member/login.php');
    }

    // ② 추가 권한(레벨) 체크
    if (empty($member['mb_level2'])) {
        alert('접근 권한이 없습니다.', 'http://n1con.com');
    }

/* ───────────────────────────────────────────────
   외부 홈페이지(n1con.com) 처리
─────────────────────────────────────────────── */
} else {

    /* ③ 외부 영역은 로그인·레벨 검사 없음   */
    /* ④ /homepage/ 경로 보장 (루트 또는 다른 경로 → /homepage/) */
    if (strpos($_SERVER['REQUEST_URI'], '/homepage/') !== 0) {
        // 이미 /homepage/ 아래라면 재전송 없음
        goto_url('/homepage/');
    }

    /* ⑤ $member 변수와 메뉴 숨김용 변수 등이
          이 영역에서 사용되지 않도록 주의 (필요하면 초기화) */
}

/* 실행부 메뉴 숨김(특정 사번) - mb_2가 부서 코드 또는 특정 역할 관련 필드라고 가정 */
$menu_display = (isset($member['mb_2']) && $member['mb_2'] == 10) ? 'style="display:none"' : '';

/* 안읽은 쪽지 개수 (초기 로드 시) */
// $member['mb_id'] 가 현재 로그인한 사용자 ID라고 가정
$sql = "SELECT COUNT(*) AS cnt
        FROM none_member_message_recipient
        WHERE receiver_id = '" . sql_real_escape_string($member['mb_id']) . "'
          AND is_read = 0
          AND is_archived = 0";
$r = sql_fetch($sql); // GnuBoard 함수 사용 가정
$initial_unread = (int)($r['cnt'] ?? 0); // 초기 안읽은 개수

/* ─────────────────────────────────────────────────────────
   HTML 시작
───────────────────────────────────────────────────────── */
?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>㈜엔원종합건설</title> <? // 실제 회사명 또는 사이트명 ?>
<meta name="robots" content="noindex"> <? // 검색엔진 제외 ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> <? // IE 호환성 보기 ?>
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta name="description" content="아름다운 공간 창조, 모던 건축을 지향하는 엔원종합건설"> <? // 사이트 설명 ?>
<link rel="shortcut icon" href="<?=NONE_URL?>/common/images/favicon.ico"> <? // NONE_URL 상수는 _common.php 등에서 정의되어야 함 ?>

<link rel="stylesheet" href="<?=NONE_URL?>/common/n1/bootstrap/css/bootstrap.min.css"> <? // Bootstrap CSS 경로 ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> <? // Bootstrap Icons ?>
<? // G5_JS_URL 상수는 그누보드 사용 시 정의됨 ?>
<link rel="stylesheet" href="<?=NONE_URL?>/assets/css/main.css"> <? // 메인 테마 CSS ?>
<link rel="stylesheet" href="<?=NONE_URL?>/assets/css/color_skins.css"> <? // 테마 색상 CSS ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="<?=NONE_URL?>/common/n1/bootstrap/js/bootstrap.bundle.min.js"></script> <? // Bootstrap JS (Popper 포함) ?>
<script>
// IE Trident 엔진 감지 및 엣지 브라우저 전환 (선택 사항)
if (navigator.userAgent.indexOf('Trident') > 0) {
  location.href = "microsoft-edge:" + location.href;
  // alert('해당 브라우저는 더이상 지원되지 않습니다. Microsoft Edge 브라우저로 자동 전환됩니다.');
}

// 쪽지 목록 팝업 함수
function msgList() {
  window.open('<?=NONE_URL?>/messages/messages_list.php?box=in', // 쪽지 목록 경로 확인
    'msgList','width=900,height=600,scrollbars=yes,resizable=yes');
  return false;
}

// 쪽지 보내기 팝업 함수
function msgSend() {
  window.open('<?=NONE_URL?>/messages/messages_send.php', // 쪽지 쓰기 경로 확인
    'msgSend','width=700,height=600,scrollbars=yes,resizable=yes');
  return false;
}

// 로그아웃 확인 함수 (GnuBoard 기본 함수 사용 가정, 없다면 직접 구현 필요)
function logout_msg(href) {
    if (confirm("로그아웃 하시겠습니까?")) {
        location.href = href;
        return true;
    }
    return false;
}
</script>
<style>
/* 알림 뱃지 스타일 (Bootstrap .badge 활용) */
.navbar .nav-link .badge {
  position: absolute;
  top: 0px; /* 아이콘 상단에 맞춤 */
  right: -5px; /* 아이콘 오른쪽에 살짝 걸치게 */
  font-size: 0.7em; /* 글자 크기 작게 */
  padding: 0.25em 0.5em; /* 뱃지 내부 여백 */
  line-height: 1; /* 줄 높이 */
  /* 애니메이션 효과 대비 */
  transition: transform 0.2s ease-out, background-color 0.2s ease;
}

/* 새 메시지 도착 시 반짝이는 애니메이션 효과 */
@keyframes pulse {
  0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); } /* 시작: 원래 크기, 그림자 없음 */
  70% { transform: scale(1.1); box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); } /* 중간: 약간 커지고 그림자 퍼짐 */
  100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); } /* 끝: 원래 크기, 그림자 사라짐 */
}

.notify-pulse {
  animation: pulse 1s 1; /* 정의된 pulse 애니메이션을 1초 동안 1번 실행 */
}

/* Navbar 아이콘 정렬을 위한 CSS */
.navbar-right .navbar-nav {
  display: flex; /* Flexbox 레이아웃 활성화 */
  align-items: center; /* 아이템들을 세로 중앙에 정렬 */
  width: 100%; /* 너비 100% (필요시 조정) */
  list-style: none; /* ul 태그의 기본 점 제거 */
  padding-left: 0; /* ul 태그의 기본 왼쪽 패딩 제거 */
  margin-bottom: 0; /* ul 태그의 기본 하단 마진 제거 */
}

/* ★ 로그아웃 아이템 오른쪽 정렬 CSS 수정 ★ */
nav.navbar .navbar-right > ul.nav.navbar-nav > li.logout-item { /* 선택자 구체성 증가 */
  margin-left: auto !important; /* 테마 오버라이드를 위해 !important 추가 */
  /* 다른 li 와의 간격을 위해 약간의 왼쪽 마진 추가 (선택 사항) */
  /* margin-left: 1rem; */
}

/* (선택사항) 아이콘들 사이의 간격 조정 */
.navbar-right .navbar-nav > li:not(.logout-item) {
   margin-right: 0.5rem; /* 로그아웃 버튼을 제외한 나머지 아이템들의 오른쪽에 간격 추가 */
}

</style>
</head>
<body class="theme-blue"> <? // 테마 클래스 유지 ?>
<div id="wrapper">

<nav class="navbar navbar-fixed-top"> <? // 클래스명은 테마에 따라 다를 수 있음 ?>
  <div class="container-fluid">
    <div class="navbar-btn">
      <button type="button" class="btn-toggle-offcanvas">
        <i class="lnr lnr-menu fa fa-bars"></i> <? // 테마 아이콘 + Font Awesome 혼용 중 ?>
      </button>
    </div>
    <div class="navbar-brand">
      <a href="/"><img src="/common/images/logo.png" alt="Logo" class="img-responsive logo"></a> <? // 로고 경로 확인 ?>
    </div>

    <div class="navbar-right">
      <ul class="nav navbar-nav"> <? // Flexbox 스타일 적용됨 ?>
        <li> <a href="http://n1con.com/homepage/" target="_blank" class="icon-menu">
            <i class="icon-home"></i> <? // 테마 아이콘 ?>
          </a>
        </li>
        <li class="nav-item"> <a id="message-noti-link" href="#" onclick="return msgList();" class="nav-link icon-menu position-relative">
            <i class="icon-envelope"></i> <? // 테마 아이콘 ?>
            <span id="unread-count-badge" class="badge bg-danger rounded-pill text-white" <? // ★ text-white 클래스 추가 ?>
            style="display: <?php echo $initial_unread > 0 ? 'inline-block' : 'none'; ?>;">
                <?php echo $initial_unread; // 초기 안읽은 개수 표시 ?>
            </span>
          </a>
        </li>
        <li> <a href="#" onclick="return msgSend();" class="icon-menu">
             <i class="fa fa-pencil-square"></i> <? // Font Awesome 아이콘 ?>
          </a>
        </li>
        <li class="logout-item"> <a href="<?=G5_BBS_URL?>/logout.php" onclick="return logout_msg(this.href)" class="icon-menu"> <? // G5_BBS_URL은 그누보드 사용 시 정의됨 ?>
            <i class="icon-login"></i> <? // 테마 아이콘 ?>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div id="left-sidebar" class="sidebar">
<div class="sidebar-scroll">

  <div class="user-account">
    <?php // get_member_profile_img 함수는 GnuBoard 확장 기능 또는 커스텀 함수 가정
        // 함수가 없다면 기본 이미지 또는 다른 방식으로 처리 필요
        // 예시: <img src="/path/to/default/profile.png" alt="Profile" class="img-thumbnail rounded-circle user-photo">
        echo function_exists('get_member_profile_img') ? get_member_profile_img($member['mb_id']) : '<i class="bi bi-person-circle fs-1 text-secondary"></i>';
    ?>
    <div class="dropdown">
      <span>Welcome,</span>
      <a href="#" class="dropdown-toggle user-name" data-bs-toggle="dropdown"> <? // Bootstrap 5 data attribute ?>
        <strong><?=htmlspecialchars($member['mb_name'])?></strong>
      </a>
      <ul class="dropdown-menu dropdown-menu-right account">
        <li>
          <a class="dropdown-item" href="#" onclick="return msgList();">
            <i class="icon-envelope-open"></i> 쪽지 보기 <? // 테마 아이콘 ?>
          </a>
        </li>
        <li>
          <a class="dropdown-item" href="#" onclick="return msgSend();">
            <i class="fa fa-pencil-square"></i> 쪽지 보내기 <? // Font Awesome 아이콘 ?>
          </a>
        </li>
        <li><hr class="dropdown-divider"></li> <? // Bootstrap 5 구분선 ?>
        <li>
          <a class="dropdown-item" href="<?=G5_BBS_URL?>/logout.php" onclick="return logout_msg(this.href)">
            <i class="icon-power"></i> 로그아웃 <? // 테마 아이콘 ?>
          </a>
        </li>
      </ul>
    </div>
    <hr>
  </div>

  <nav id="left-sidebar-nav" class="sidebar-nav">
  <ul id="main-menu" class="metismenu"> <? // metismenu 라이브러리 사용 가정 ?>

    <li <?=defined('menu_worksite')?'class="active"':''?>>
      <a href="#" class="has-arrow"><i class="icon-home"></i><span>현장관리</span></a>
      <ul>
        <?php if ($member['mb_level2'] == 2): // 레벨에 따른 메뉴 분기 (예시) ?>
          <li><a href="/_worksite/list/menu1_list.php">시공현장</a></li>
          <li><a href="/_worksite/list/menu3_list.php">스마트일보</a></li>
          <li <?=$menu_display?>><a href="#">현장현황</a></li> <? // 특정 부서 메뉴 숨김 처리 ?>
          <li><a href="/_worksite/list/menu5_list.php">공정별 현장사진</a></li>
          <li><a href="/_worksite/list/menu6_list.php">건축주협의게시판</a></li>
          <li><a href="/_worksite/list/menu7_list.php">하자보수</a></li>
          <li><a href="/_worksite/list/menu8_list.php">하자보증서 발급현황</a></li>
        <?php else: ?>
          <li><a href="/_worksite/list/menu1_list.php">시공현장</a></li>
          <li <?=$menu_display?>><a href="/_worksite/list/menu2_list.php">시공현장 관리(관리부)</a></li>
          <li <?=$menu_display?>><a href="/_worksite/list/menu2_1_list.php">시공현장 관리(연구부)</a></li>
          <li><a href="/_worksite/list/menu3_list.php">스마트일보</a></li>
          <li><a href="/_worksite/list/menu3_1_list.php">스마트일보(작성유무)</a></li>
          <li><a href="/_worksite/list/menu4_list.php">현장현황</a></li>
          <li><a href="/_worksite/list/menu5_list.php">공정별 현장사진</a></li>
          <li><a href="/_worksite/list/menu6_list.php">건축주협의게시판</a></li>
          <li><a href="/_worksite/list/menu7_list.php">하자보수</a></li>
          <li><a href="/_worksite/list/menu8_list.php">하자보증서 발급현황</a></li>
        <?php endif; ?>
      </ul>
    </li>

    <li <?=defined('menu_document')?'class="active"':''?> <?=$menu_display?>>
      <a href="#" class="has-arrow"><i class="icon-docs"></i><span>문서관리</span></a>
      <ul>
        <?php if ($member['mb_level2'] == 2): ?>
          <li><a href="/_document/list/menu2_list.php">하도급계약총괄표</a></li>
          <li><a href="/_document/list/menu3_list.php">하도급계약서류</a></li>
          <li><a href="/_document/list/menu4_list.php">공지사항</a></li>
          <li><a href="/_document/list/menu5_list.php">사내자료실</a></li>
        <?php else: ?>
          <li><a href="/_document/list/menu1_list.php">도급계약총괄표</a></li>
          <li><a href="/_document/list/menu2_list.php">하도급계약총괄표</a></li>
          <li><a href="/_document/list/menu3_list.php">하도급계약서류</a></li>
          <li><a href="/_document/list/menu4_list.php">공지사항</a></li>
          <li><a href="/_document/list/menu5_list.php">사내자료실</a></li>
        <?php endif; ?>
      </ul>
    </li>

    <li <?=defined('menu_sign')?'class="active"':''?>>
      <a href="#" class="has-arrow"><i class="icon-pencil"></i><span>전자결재</span></a>
      <ul>
        <li><a href="/_sign/list/menu1_list.php">기안서</a></li>
        <li><a href="/_sign/list/menu2_list.php">지출결의서</a></li>
        <li><a href="/_sign/list/menu3_list.php">설계변경</a></li>
        <li><a href="/_sign/list/menu4_list.php">무상처리</a></li>
        <li><a href="/_sign/list/menu6_list.php">사고경위서</a></li>
        <li <?=$menu_display?>><a href="/_sign/list/menu5_list.php">결재라인 설정</a></li>
      </ul>
    </li>

    <li <?=defined('menu_establishment')?'class="active"':''?>>
      <a href="#" class="has-arrow"><i class="icon-tag"></i><span>기성청구서</span></a>
      <ul>
        <li><a href="/_establishment/list/menu1_list.php">기성청구서</a></li>
        <li <?=$menu_display?>><a href="/_establishment/list/menu4_list.php">기본공제요율 설정</a></li>
      </ul>
    </li>

    <?php if ($member['mb_level2'] != 2): ?>
    <li <?=defined('menu_statistics')?'class="active"':''?> <?=$menu_display?>>
      <a href="#" class="has-arrow"><i class="icon-bar-chart"></i><span>통계</span></a>
      <ul>
        <li><a href="/_statistics/list/menu1_list.php">수주현황</a></li>
        <li><a href="/_statistics/list/menu2_list.php">매출현황</a></li>
        <li><a href="/_statistics/list/menu8_list.php">잔금현황</a></li>
        <li><a href="/_statistics/list/menu3_list.php">현장별매출현황</a></li>
        <li><a href="/_statistics/list/menu5_list.php">현장진행총괄표</a></li>
        <li><a href="/_statistics/list/menu4_list.php">현장별기성집계표</a></li>
        <li><a href="/_statistics/list/menu7_list.php">현장소장현황</a></li>
      </ul>
    </li>
    <?php endif; ?>

    <li <?=defined('menu_employee')?'class="active"':''?>>
      <a href="#" class="has-arrow"><i class="icon-lock"></i><span>회사관리</span></a>
      <ul>
        <?php // 레벨별 직원 관리 메뉴 분기 (예시)
            if ($member['mb_level2'] == 2) {
                echo '<li><a href="/_employee/list/menu1_list_con.php">직원관리(현장)</a></li>';
            } elseif ($member['mb_level2'] == 3) {
                echo '<li><a href="/_employee/list/menu1_list.php">직원관리</a></li>';
                echo '<li><a href="/_employee/list/menu1_list_con.php">직원관리(현장)</a></li>';
                echo '<li><a href="/_employee/list/menu1_list_manage.php">직원관리(관리)</a></li>';
                echo '<li><a href="/_employee/list/menu2_list.php">지사관리</a></li>';
                echo '<li><a href="/_employee/list/menu3_list.php">부서관리</a></li>';
                echo '<li><a href="/_employee/list/menu4_list.php">직급관리</a></li>';
                echo '<li><a href="/_employee/list/menu5_list.php">은행목록관리</a></li>';
            } else {
                echo '<li><a href="/_employee/list/menu1_list.php">직원관리</a></li>';
                echo '<li><a href="/_employee/list/menu1_list_con.php">직원관리(현장)</a></li>';
                echo '<li><a href="/_employee/list/menu2_list.php">지사관리</a></li>';
                echo '<li><a href="/_employee/list/menu3_list.php">부서관리</a></li>';
                echo '<li><a href="/_employee/list/menu4_list.php">직급관리</a></li>';
                echo '<li><a href="/_employee/list/menu5_list.php">은행목록관리</a></li>';
            }
        ?>
      </ul>
    </li>

    <li <?=defined('menu_owner')?'class="active"':''?> <?=$menu_display?>>
      <a href="/_owner/list/menu1_list.php"><i class="icon-globe"></i><span>건축주</span></a>
    </li>

    <li <?=defined('menu_enterprise')?'class="active"':''?> <?=$menu_display?>>
      <a href="/_enterprise/list/menu1_list.php"><i class="icon-diamond"></i><span>업체관리</span></a>
    </li>

    <?php if ($member['mb_level2'] != 2): ?>
    <li <?=defined('menu_homepage')?'class="active"':''?>>
      <a href="#" class="has-arrow"><i class="icon-grid"></i><span>홈페이지관리</span></a>
      <ul>
        <li><a href="/_homepage/list/menu1_list.php">회원관리</a></li>
        <li><a href="/_homepage/list/menu2_list.php">일별 방문자 수 및 통계</a></li>
        <li><a href="/_homepage/list/menu3_list.php">게시판 카테고리 관리</a></li>
        <li><a href="/_homepage/list/menu4_list.php">입사지원서 관리</a></li>
      </ul>
    </li>
    <?php endif; ?>

  </ul>
  </nav>
</div>
</div><?php
// 페이지의 메인 컨텐츠 영역 시작 부분 (예시)
// 이 헤더 파일을 include하는 각 페이지에서 이어서 컨텐츠를 작성합니다.
// echo '<div id="main-content">';
// echo '<div class="container-fluid">';
?>

<script>
$(function() {
    const $badge = $('#unread-count-badge');
    const $notiLink = $('#message-noti-link'); // 애니메이션 대상은 링크 자체나 아이콘이 더 적합할 수 있음
    let currentUnread = <?php echo $initial_unread; ?>;

    function checkUnreadMessages() {
        $.ajax({
            url: '<?=NONE_URL?>/messages/ajax_check_unread.php', // 실제 경로 확인
            type: 'GET',
            dataType: 'json',
            cache: false,
            success: function(data) {
                if (data && typeof data.unread !== 'undefined') {
                    const newUnread = parseInt(data.unread) || 0;

                    // console.log("Current: " + currentUnread + ", New: " + newUnread); // 디버깅용 로그

                    if (newUnread !== currentUnread) {
                        $badge.text(newUnread);

                        if (newUnread > 0) {
                            $badge.show();
                            // ★ 개수가 증가했을 때만 애니메이션 실행 ★
                            if (newUnread > currentUnread) {
                                console.log("New message arrived, applying pulse."); // 디버깅용 로그
                                // 기존 애니메이션 클래스 제거 후 다시 추가하여 애니메이션 재시작
                                $badge.removeClass('notify-pulse');
                                // 브라우저가 클래스 제거를 인지할 시간을 주기 위해 약간의 딜레이(0) 사용
                                setTimeout(function() {
                                     $badge.addClass('notify-pulse');
                                }, 0);
                                // 애니메이션 완료 후 클래스 제거 (CSS 애니메이션 시간에 맞춰)
                                setTimeout(function() {
                                    $badge.removeClass('notify-pulse');
                                    // console.log("Pulse class removed."); // 디버깅용 로그
                                }, 800); // CSS 애니메이션 시간(0.8s)과 일치
                            }
                        } else {
                            $badge.hide();
                        }
                        currentUnread = newUnread;
                    }
                } else {
                     console.warn("Invalid data from unread check:", data);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error checking unread messages:", textStatus, errorThrown);
            }
        });
    }

    const intervalId = setInterval(checkUnreadMessages, 10000); // 30초마다 확인

    // Bootstrap 5 드롭다운 초기화
    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
      return new bootstrap.Dropdown(dropdownToggleEl)
    })

});
</script>

<?php // </body>와 </html> 태그는 일반적으로 푸터(footer.php) 파일에서 닫습니다. ?>
<?php // 이 파일이 전체 페이지 구조의 시작이라면 여기에 두어도 됩니다. ?>
<?php // </div>는 푸터에서 닫는 것이 일반적입니다. ?>
<?php // </body> ?>
<?php // </html> ?>