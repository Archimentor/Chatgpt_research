$(function() {
	$('#add_tables').bind('click', function() {
		
		var clone = $('#copybox').clone();
		
		clone.show();
		clone.find('.ns_upche').show();
		clone.find('.upche_txt_box').hide();
		clone.find('input').val('');
		clone.find('.persent').html('0%');
		$('#add_tb_box').append(clone);
	})
	
	//콤마처리
	$(document).on('keyup', '.numb', function() {
		 
		var v = comma(uncomma($(this).val()));
	
		$(this).val(v);
	})
	
	
	$(document).on('change', '.ns_upche', function() {
		
		if($(this).val() == "add") {
			
			$(this).hide();
			$(this).closest('tbody').find('.upche_txt_box').show();
			$(this).closest('tbody').find('.ns_gongjong').val('');
			$(this).closest('tbody').find('.ne_price3').val('');
			$(this).closest('tbody').find('.ns_upche_txt').focus();
		} else {
		
			$.ajax({
					type: 'post',
					url: "/_establishment/write/ajax.inc7.enterprise.php",
					dataType: "json",
					async : false,
					data: {  nw_code : $('#nw_code').val(), id : $(this).val() },
					success: function(data) {
						gongjong = data.gongjong;
						price =  data.price;
					}
					
				})
				$(this).closest('tbody').find('.ns_gongjong').val( gongjong );
				$(this).closest('tbody').find('.ne_price3').val( comma(price) );
		}
	})
	
	$(document).on('click', '.fa-refresh', function() {
		//$(this).hide();
		$(this).closest('tbody').find('.upche_txt_box').hide();
		$(this).closest('tbody').find('.ns_upche').show();
	
		
	})
	
	
	$(document).on('keyup', '.dp', function() {
		
		var price1 = parseInt(uncomma($(this).closest('tr').find('.ne_detail_price1').val())); //업체 청구금액 
		var price2 = parseInt(uncomma($(this).closest('tr').find('.ne_detail_price2').val())); //사정금액 
		var price3 = parseInt(uncomma($(this).closest('tr').find('.ne_detail_price3').val())); //실지급액
		var vat =  0; //부가세 
		var total = 0; //기성합계
		var price1_total= 0;
		var price2_total= 0;
		var price3_total= 0;
		var vat_total= 0;
		var all_total= 0; //기성합계-소계
		
		price1 = price1 ? price1 : 0;
		price2 = price2 ? price2 : 0;
		price3 = price3 ? price3 : 0;
		all_total = all_total ? all_total : 0;
		
		total = price3;
		
		vat   = (price3*0.1);    // 부가세(VAT)
		vat   = Math.round(vat);
		
		vat = vat ? vat : 0;
		
		
		
		$(this).closest('tr').find('.ne_detail_price4').val(comma(vat)); 
		$(this).closest('tr').find('.ne_detail_price5').val(comma(total+vat));
		
		
		
		
		//업체 청구금액 소계
		$(this).closest('tbody').find('.ne_detail_price1').each(function() {
			
			p = parseInt(uncomma($(this).val()));
			
			if(isNaN(p)) {
				price1_total += 0
			} else {
				price1_total += p;
			}
			
		})
		$(this).closest('tbody').find('.detail_price1_total').val(number_format(price1_total));
		
		
		//사정금액 소계
		$(this).closest('tbody').find('.ne_detail_price2').each(function() {
			
			p2 = parseInt(uncomma($(this).val()));
			
			if(isNaN(p2)) {
				price2_total += 0
			} else {
				price2_total += p2;
			}
			
		})
		$(this).closest('tbody').find('.detail_price2_total').val(number_format(price2_total));
		
		//실지급액 소계
		$(this).closest('tbody').find('.ne_detail_price3').each(function() {
			
			p3 = parseInt(uncomma($(this).val()));
			
			if(isNaN(p3)) {
				price3_total += 0
			} else {
				price3_total += p3;
			}
			
		})
		$(this).closest('tbody').find('.detail_price3_total').val(number_format(price3_total));
		
		
		//부가세 소계
		$(this).closest('tbody').find('.ne_detail_price4').each(function() {
			
			p4 = parseInt(uncomma($(this).val()));
			
			if(isNaN(p4)) {
				vat_total += 0
			} else {
				vat_total += p4;
			}
			
		})
		$(this).closest('tbody').find('.detail_price4_total').val(number_format(vat_total));
		
		//기성합계
		$(this).closest('tbody').find('.ne_detail_price5').each(function() {
			
			p5 = parseInt(uncomma($(this).val()));
			
			if(isNaN(p5)) {
				all_total += 0
			} else {
				all_total += p5;
			}
		});
		
		
		$(this).closest('tbody').find('.detail_price5_total').val(comma(all_total));
		$(this).closest('tbody').find('.ne_price2').val(comma(price3_total));
		
	})
	
	//부가세 수정시 변경 
	$(document).on('keyup', '.ne_detail_price4', function() {
		
		var price1 = parseInt(uncomma($(this).closest('tr').find('.ne_detail_price1').val())); //업체 청구금액 
		var price2 = parseInt(uncomma($(this).closest('tr').find('.ne_detail_price2').val())); //사정금액 
		var price3 = parseInt(uncomma($(this).closest('tr').find('.ne_detail_price3').val())); //실지급액
		var vat = parseInt(uncomma($(this).val())); //입력 된 부가세
		var vat_total= 0; //부가세소계
		var all_total= 0; //기성합계
		
		price1 = price1 ? price1 : 0;
		price2 = price2 ? price2 : 0;
		price3 = price3 ? price3 : 0;
		all_total = all_total ? all_total : 0;
		
		total = price3;
		
		//부가세 소계
		$(this).closest('tbody').find('.ne_detail_price4').each(function() {
			
			p4 = parseInt(uncomma($(this).val()));
			
			if(isNaN(p4)) {
				vat_total += 0
			} else {
				vat_total += p4;
			}
			
		})
		$(this).closest('tbody').find('.detail_price4_total').val(number_format(vat_total));
		$(this).closest('tr').find('.ne_detail_price5').val(comma(total+vat));
		
		$(this).closest('tbody').find('.ne_detail_price5').each(function() {
			
			p5 = parseInt(uncomma($(this).val()));
			
			if(isNaN(p5)) {
				all_total += 0
			} else {
				all_total += p5;
			}
		});
		
		
		$(this).closest('tbody').find('.detail_price5_total').val(comma(all_total));
		$(this).closest('tbody').find('.ne_price2').val(comma(price3_total));
		
		
	})
	
	//원도급
	$(document).on('keyup', '.ne_price1, .ne_price4, .vat1', function() {
		
		var price1 = parseInt(uncomma($(this).closest('tbody').find('.ne_price1').val()));  //원도급금액
		var price2 = parseInt(uncomma($(this).closest('tbody').find('.ne_price4').val()));  //추가공사
		var vat = 0;  //부가세
		var total = 0; 
		var all_total = 0; 
		
		price1 = price1 ? price1 : 0;
		price2 = price2 ? price2 : 0;
		
		total = price1 + price2;
		
		vat   = (total*0.1);
		vat   = Math.round(vat);
		
		vat = vat ? vat : 0;
		
		all_total = total + vat;
		
		$(this).closest('tbody').find('.vat1').val(comma(vat));
		$(this).closest('tbody').find('.ne_total_price1').val(comma(all_total));
		
		
		
	})
	
	//실행금액
	$(document).on('keyup', '.ne_price2, .ne_price5, .vat2', function() {
		
		var price1 = parseInt(uncomma($(this).closest('tbody').find('.ne_price2').val()));
		var price2 = parseInt(uncomma($(this).closest('tbody').find('.ne_price5').val()));
		var vat = 0;  //부가세
		var total = 0; 
		var all_total = 0; 
		
		price1 = price1 ? price1 : 0;
		price2 = price2 ? price2 : 0;
		
		total = price1 + price2;
		
		vat   = (total*0.1);
		vat   = Math.round(vat);
		
		vat = vat ? vat : 0;
		
		all_total = total + vat;
		
		$(this).closest('tbody').find('.vat2').val(comma(vat));
		$(this).closest('tbody').find('.ne_total_price2').val(comma(all_total));
		
	
	})

	//외주계약금액
	$(document).on('keyup', '.ne_price3, .ne_price6, .vat3', function() {
		
		var price1 = parseInt(uncomma($(this).closest('tbody').find('.ne_price3').val()));
		var price2 = parseInt(uncomma($(this).closest('tbody').find('.ne_price6').val()));
		var vat = 0;  //부가세
		var total = 0; 
		var all_total = 0; 
		
		price1 = price1 ? price1 : 0;
		price2 = price2 ? price2 : 0;
		
		total = price1 + price2;
		
		vat   = (total*0.1);
		vat   = Math.round(vat);
		
		vat = vat ? vat : 0;
		
		all_total = total + vat;
		
		$(this).closest('tbody').find('.vat3').val(comma(vat));
		$(this).closest('tbody').find('.ne_total_price3').val(comma(all_total));
		
		
	})


	$(document).on('keyup', '.ne_price1, .ne_price3',  function() {
		
		persent_calc($(this), '.ne_price1', '.ne_price3');
		persent_calc($('.vat_persent'), '.vat1', '.vat3');
		persent_calc($('.total_persent'), '.ne_total_price1', '.ne_total_price3');
	})

	$(document).on('keyup', '.ne_price4, .ne_price6', function() {
		
		persent_calc($(this), '.ne_price4', '.ne_price6');
		
		persent_calc($('.vat_persent'), '.vat1', '.vat3');
		persent_calc($('.total_persent'), '.ne_total_price1', '.ne_total_price3');
		
	})
	


})


function persent_calc(el, p1, p2) {
	console.log(el);
	
	var price1 = parseInt(uncomma(el.closest('tr').find(p1).val()));
	var price2 = parseInt(uncomma(el.closest('tr').find(p2).val()));
	
	price1 = price1 ? price1 : 0;
	price2 = price2 ? price2 : 0;
		
	var result = Math.floor(price2 / price1 * 100);
	
	if(result == Infinity) {
		result = 0;
	}
	if(isNaN(result)) {
		result = 0;
	}
	
	el.closest('tr').find('.persent').html(comma(result)+"%");
}

 function comma(str) {
     str = String(str);
     return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
 }

function uncomma(str) {
    str = String(str).trim();
    var neg = str.charAt(0) === '-' ? '-' : '';
    str = str.replace(/[^\d]/g, '');
    return neg + str;
}
