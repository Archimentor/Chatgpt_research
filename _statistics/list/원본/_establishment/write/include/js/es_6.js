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
	
if(confirm('즉시 삭제되며 복구하실 수 없습니다.\n\n삭제 후 페이지가 새로고침 됩니다.')) {
	$.post('/_establishment/write/ajax.inc6.delrow.php', { seq : seq }, function(data){ 
	
		if(data == 'y') {
			//$('.dataRow_'+seq).remove();
			location.reload();
			/*
			var vv = $(el).parent().index();
			var html = "";
			console.log(vv);
			if( vv == 1) {
				var rowCnt = $('#s'+sort+'_add_line tr').length;
				
				switch(sort) {
					case 1 :
					html = '<td class="column0 style36 s style80" rowspan="'+rowCnt+'" id="s1_add_tit">외<br><br>주<br><br>비<br><i class="fa fa-plus-square" id="s1_add_row" aria-hidden="true"></i></td>';
					break;
					case 2 :
					html = '<td class="column0 style36 s style104"rowspan="'+rowCnt+'" id="s2_add_tit">자<br><br>재<br><br>비<br><i class="fa fa-plus-square" id="s2_add_row" aria-hidden="true"></i></td>';
					break;
				}
				
				$('#s'+sort+'_add_line tr').eq(0).prepend(html);
			}*/
		} else {
			alert('처리 중 오류가 발생했습니다.');
			return false;
		}
		
	})
	
} else {
	return false;
}

}