function logout_msg(href) {
	
	if(confirm('로그아웃 하시겠습니까?')) {
		locaton.href = href;
	} else {
		return false;
	}
	
}