$(function() {
	
	$('#loading_box').fadeOut(1200);
	
	
	$(document).on('keyup', '#ne_price', function() {
	
		var p_price = $('#ne_prev_price').val();//전회기성
		var c_price = $('#ne_contract_price').val();//계약금액
		var mic_price = $('#month_input_cost_total').val();//현장투입금액
		
		
		var pp = parseInt(p_price.replace(/,/g, "")); //전회
		var p = parseInt($(this).val());
		
		var total = p+pp;
		
		var cp = parseInt(c_price.replace(/,/g, ""));//ㅇ
		
		var total2 = cp-total;
		
		$('#ne_total_price').val(number_format(total));
		$('#ne_etc_price').val(number_format(total2));
		
		//현장기성잔고
		var micp =  parseInt(mic_price.replace(/,/g, ""));
		var total3 = p-micp;
		$('#jango').val(number_format(total3));
		
		//명원잔고 예상금액 
		var jango = total3; //현장기성잔고
		var yst_price1 = parseInt($('#ne_price2').val());
		var yst_price2 = parseInt($('#ne_price3').val());
		
		var total4 = total3 + yst_price1 - yst_price2;
		
		
		$('#yester_jango').val(number_format(total4));
		
	})
	
	$(document).on('keyup', '#ne_price2, #ne_price3', function() {
	
	
		//명원잔고 예상금액 
		var mic_price = $('#jango').val();//현장투입금액
		var micp =  parseInt(mic_price.replace(/,/g, ""));

		var yst_price1 = parseInt($('#ne_price2').val());
		var yst_price2 = parseInt($('#ne_price3').val());
		
		var total4 = micp + yst_price1 - yst_price2;
		
		
		$('#yester_jango').val(number_format(total4));
		
	})
})