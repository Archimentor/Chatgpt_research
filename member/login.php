<?php 
include_once('../_common.php');

// 이미 로그인 중이라면
if ($is_member) {
    if ($url)
        goto_url($url);
    else
        goto_url(NONE_URL);
}

if(!$url)
	$url = NONE_URL.'/?';

$login_url        = login_url($url);
$login_action_url = G5_HTTPS_BBS_URL."/login_check.php";

?>
<!doctype html>
<html lang="ko">
<head>
<title>㈜엔원종합건설</title>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="아름다운 공간 창조, 모던 건축을 지향하는 엔원종합건설">
<meta property="og:title" content="㈜엔원종합건설">
<meta property="og:description" content="아름다운 공간 창조, 모던 건축을 지향하는 엔원종합건설">
<link rel="shortcut icon" href="<?php echo NONE_URL?>/common/images/favicon.ico">

<!-- VENDOR CSS -->
<link rel="stylesheet" href="<?php echo NONE_URL?>/common/n1/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo NONE_URL?>/common/n1/font-awesome/css/font-awesome.min.css">

<!-- MAIN CSS -->
<link rel="stylesheet" href="<?php echo NONE_URL?>/assets/css/main.css">
<link rel="stylesheet" href="<?php echo NONE_URL?>/assets/css/color_skins.css">
<script>
	  if(navigator.userAgent.indexOf('Trident') > 0){
		location.href = "microsoft-edge:" + location.href;
		alert('해당 브라우저는 더이상 지원하지 않습니다.\nMicrosoft Edge 브라우저가 자동으로 열립니다.\n만약 Edge브라우저가 없으신 고객님들은 타 브라우저(크롬,사파리 등)을 이용해주시기 바랍니다.');
		setTimeout(close);
	  }
</script> 

</head>

<body class="theme-blue">
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle auth-main">
				<div class="auth-box">
                    <div class="top">
                      <img src="<?php echo NONE_URL?>/common/images/logo.png" alt="Logo" class="img-responsive logo">
                    </div>
					<div class="card">
                        <div class="header">
                            <p class="lead">로그인</p>
                        </div>
                        <div class="body">
                            <form class="form-auth-small" action="<?php echo $login_action_url?>" method="post">
							<input type="hidden" name="url" value="<?php echo $login_url ?>">
        
							
								
                                <div class="form-group">
                                    <label for="signin-email" class="control-label sr-only">ID</label>
                                    <input type="text" name="mb_id" id="login_id" required class="form-control" id="signin-email" value="" placeholder="ID">
                                </div>
                                <div class="form-group">
                                    <label for="signin-password" class="control-label sr-only">Password</label>
                                    <input type="password"  name="mb_password" id="login_pw" class="form-control" required id="signin-password" value="" placeholder="Password">
                                </div>
                                <div class="form-group clearfix">
                                    <label class="fancy-checkbox element-left">
                                        <input type="checkbox">
                                        <span>아이디 기억하기</span>
                                    </label>								
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">로그인</button>
                                <div class="bottom">
                                    <span class="helper-text m-b-10"><i class="fa fa-lock"></i> <a href="<?php echo G5_BBS_URL ?>/password_lost.php" target="_blank" id="login_password_lost">회원정보찾기</a>  | <a href="#">회원가입</a></span>
                                </div>
                            </form>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
	<script src="<?php echo G5_JS_URL?>/jquery-1.12.4.min.js"></script>
	<script src="<?php echo G5_JS_URL?>/common.js"></script>
</body>

</html>
