$(function() {
	//콤마처리
	$(document).on('keyup', '.numb', function() {
		 
		var v = comma(uncomma($(this).val()));
	
		$(this).val(v);
	})
	
	$(document).on('keyup', 'input[name="ne_cash[]"], input[name="ne_card[]"]', function() {
		
		var cash = parseInt(uncomma($(this).closest('tr').find('input[name="ne_cash[]"]').val()));
		var card = parseInt(uncomma($(this).closest('tr').find('input[name="ne_card[]"]').val()));
		var total = 0;
		
		cash = cash ? cash : 0;
		card = card ? card : 0;
		
		total = cash+card;
		
		
		
		$(this).closest('tr').find('input[name="ne_total[]"]').val(comma(total));
		
		total_calc();
		
	})
})

$('input[name=ne_deposit]').bind('keyup', function(data) {
		total_calc();
})

function total_calc(){
	
	let pbalance = parseInt(uncomma($('input[name="ne_prev_deposit"]').val())); //전월잔액 
	let deposit = parseInt(uncomma($('input[name="ne_deposit"]').val())); //금월입금 
	let expenses = 0; //금월지출
	let cash = 0; //현금사용
	let card = 0; //카드사용
	
	pbalance = pbalance ? pbalance : 0;
	deposit = deposit ? deposit : 0;
	
	cash = cash ? cash : 0;
	card = card ? card : 0;
		
		
	
	//금월지출 계산
	$('input[name="ne_total[]"]').each(function() {
		
		if($(this).val()) {
			expenses += parseInt(uncomma($(this).val()));
		} else {
			expenses += 0;
		}
	})
	
	$('input[name=ne_expenses]').val(comma(expenses));
	$('.all_total').html(comma(expenses));
	
	//현금사용 총 계산
	$('input[name="ne_cash[]"]').each(function() {
		
		if($(this).val()) {
			cash += parseInt(uncomma($(this).val()));
		} else {
			cash += 0;
		}
	})
	
	$('.cash_total').html(number_format(cash));
	
	//카드사용 총 계산
	$('input[name="ne_card[]"]').each(function() {
		
		if($(this).val()) {
			card += parseInt(uncomma($(this).val()));
		} else {
			card += 0;
		}
	})
	
	$('.card_total').html(number_format(card));


	//전도금 잔액 ( 전월잔액 + 금월입금 - 금월지출 )
	$('input[name=ne_balance]').val(comma(pbalance+deposit - expenses));
	
}


 function comma(str) {
     str = String(str);
     return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
 }

 function uncomma(str) {
     str = String(str);
     return str.replace(/[^\d]+/g, '');
 }
 
 function delete_row(seq) {
    if (confirm('즉시 삭제되며 복구하실 수 없습니다.\n\n삭제 후 페이지가 새로고침 됩니다.')) {

        console.log("delete_row (Fetch) 호출됨, seq:", seq); // 디버깅용 로그

        const delete_url = '/_establishment/write/ajax.inc6.delrow.php'; // 백엔드 URL 확인!

        // FormData 객체를 사용하여 POST 데이터 준비
        const formData = new FormData();
        formData.append('seq', seq);

        // Fetch API를 사용하여 서버에 요청
        fetch(delete_url, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            // 서버 응답 상태 확인 (예: 404, 500 오류 체크)
            if (!response.ok) {
                // 응답 상태가 정상이 아니면 에러 발생시킴
                throw new Error(`HTTP 오류! 상태: ${response.status}`);
            }
            // 응답 내용을 텍스트로 변환하여 반환
            return response.text();
        })
        .then(data => {
            // 서버로부터 받은 텍스트 데이터 처리
            console.log("서버 응답 텍스트:", data); // 디버깅용 로그

            // 응답 앞뒤의 공백 제거 후 'y'와 비교
            if (data && data.trim() === 'y') {
                // 성공 시 페이지 새로고침
                location.reload();
            } else {
                // 실패 시 서버가 보낸 메시지(있다면) 또는 기본 메시지 표시
                const errorMessage = (data && data.trim()) ? data.trim() : '처리 중 오류가 발생했습니다.';
                alert(errorMessage);
            }
        })
        .catch(error => {
            // 네트워크 오류 또는 위 .then 블록에서 발생한 에러 처리
            console.error('Fetch 요청 오류:', error);
            alert('삭제 요청 중 오류가 발생했습니다. (네트워크 또는 서버 응답 오류)');
        });

    } else {
        // 사용자가 '취소'를 누른 경우
        return false;
    }
}

// --- total_calc, comma, uncomma 등 다른 함수들은 그대로 둡니다 ---
// $(function() { ... }); 부분과 다른 함수들은 변경하지 마세요.

$(function() {
    //콤마처리
    $(document).on('keyup', '.numb', function() {
        var v = comma(uncomma($(this).val()));
        $(this).val(v);
    })

    $(document).on('keyup', 'input[name="ne_cash[]"], input[name="ne_card[]"]', function() {
        var cash = parseInt(uncomma($(this).closest('tr').find('input[name="ne_cash[]"]').val()));
        var card = parseInt(uncomma($(this).closest('tr').find('input[name="ne_card[]"]').val()));
        var total = 0;
        cash = cash ? cash : 0;
        card = card ? card : 0;
        total = cash+card;
        $(this).closest('tr').find('input[name="ne_total[]"]').val(comma(total));
        total_calc();
    })
})

$('input[name=ne_deposit]').bind('keyup', function(data) {
        total_calc();
})

function total_calc(){
    let pbalance = parseInt(uncomma($('input[name="ne_prev_deposit"]').val()));
    let deposit = parseInt(uncomma($('input[name="ne_deposit"]').val()));
    let expenses = 0;
    let cash = 0;
    let card = 0;
    pbalance = pbalance ? pbalance : 0;
    deposit = deposit ? deposit : 0;
    cash = cash ? cash : 0;
    card = card ? card : 0;

    $('input[name="ne_total[]"]').each(function() {
        if($(this).val()) { expenses += parseInt(uncomma($(this).val())); }
        else { expenses += 0; }
    })
    $('input[name=ne_expenses]').val(comma(expenses));
    $('.all_total').html(comma(expenses));

    $('input[name="ne_cash[]"]').each(function() {
        if($(this).val()) { cash += parseInt(uncomma($(this).val())); }
        else { cash += 0; }
    })
    $('.cash_total').html(number_format(cash)); // number_format 함수 정의 필요 시 추가

    $('input[name="ne_card[]"]').each(function() {
        if($(this).val()) { card += parseInt(uncomma($(this).val())); }
        else { card += 0; }
    })
    $('.card_total').html(number_format(card)); // number_format 함수 정의 필요 시 추가

    $('input[name=ne_balance]').val(comma(pbalance+deposit - expenses));
}

 function comma(str) {
      str = String(str);
      return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
 }

 function uncomma(str) {
      str = String(str);
      return str.replace(/[^\d]+/g, '');
 }

 // number_format 함수 (PHP의 number_format과 유사, 필요 시 추가)
 function number_format (number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
 }