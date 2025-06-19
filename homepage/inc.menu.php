<link rel="preconnect" href="https://fonts.gstatic.com" />
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&display=swap" rel="stylesheet" />

<style>
  .noto-font {
  font-family: 'Noto Sans KR', sans-serif !important;
  font-weight: 400;
  font-size: 14px;
}
</style>

 <div class="container">
      <div id="site-branding"> <a class="logo-brand" href="/?"> <img class="logo" src="assets/images/logo/logo.png" alt="Logo"> </a> </div>
      <!-- .site-branding -->
      <div class="gnav" style="z-index:9999">
        <ul>
		<?php if($is_member) {?>
			<li><a href="/core/bbs/logout.php">Logout</a></li>
          <li><a href="modify.html">Modify</a></li>
        
		<?php } else {?>
		  <li><a href="/homepage/login.html">Login</a></li>
          <li><a href="register.html#">Join</a></li>
		<?php }?>
        </ul>
      </div>
      <span id="ham-trigger-wrap"> <span class="ham-trigger"> <span></span> </span> </span>
      <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="Top Menu">
      <ul id="top-menu" class="menu">
        <li ><a href="about.html" class="noto-font">회사소개</a>
          <ul class="sub-menu" style="">
              <li><a href="about.html">회사개요</a></li>
                <li><a href="ceo.html">CEO인사말</a></li>
                <li><a href="sahoon.html">회사사훈</a></li>
                <li><a href="gongsa.html">공사지명원</a></li>
                <li><a href="awards.html">수상경력</a></li>
                <li><a href="organization.html">조직도</a></li>
                <li><a href="history.html">연혁</a></li>
                
          </ul>
        </li>
        <li ><a href="news.html" class="noto-font">뉴스</a></li>
        <li ><a href="project.html" class="noto-font">완료공사</a></li>
        <li ><a href="construction01.html" class="noto-font">진행공사</a>
          <ul class="sub-menu" style="">
            <li><a href="construction01.html">진행공사</a></li>
            <li><a href="#">완료공사</a></li>
            <li><a href="#">하자보수</a></li>
          </ul>
        </li>
        <li ><a href="architect.html" class="noto-font">건축사</a></li>
        <li ><a href="request.html" class="noto-font">공사의뢰</a></li>
        <li ><a href="board.html?bo_table=board1" class="noto-font">커뮤니티</a>
          <ul class="sub-menu" style="">
            <li><a href="board.html?bo_table=board1">건축</a></li>
            <li><a href="board.html?bo_table=board2">BIM</a></li>
            <li><a href="board.html?bo_table=board3">건축기행</a></li>
            <li><a href="board.html?bo_table=board4">자유게시판</a></li>
            <li><a href="board.html?bo_table=board5">질의응답</a></li>
            <li><a href="board.html?bo_table=board6">자료실</a></li>
          </ul>
        </li>
		    <li><a href="recruit.html" class="noto-font">입사지원</a></li>
        <li><a href="https://www.instagram.com/n1_architecture/" target="_blank" class="noto-font">SNS</a></li>

        </ul>
      </nav>
    </div>
    <!-- .wrap --> 