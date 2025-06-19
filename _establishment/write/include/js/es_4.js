$(function() {
	
	$(document).on('keyup', '.name', function() {
	$( this ).autocomplete({
			source : function( request, response ) {
				 $.ajax({
						type: 'post',
						url: "/_establishment/write/ajax.inc4.name.php",
						dataType: "json",
						data: { value : request.term, type : 'search', code : $('#nw_code').val(), date : $('#ne_date').val() },
						success: function(data) {
							response(
								$.map(data, function(item) {
									return {
										label: item.name,
										value: item.rname,
										num : item.num,
										addr1 : item.addr1,
										addr2 : item.addr2,
										hp : item.hp,
									
										account : item.account,
										bank : item.bank,
										accname : item.accname,
										gongjong : item.gongjong
										
									}
								})
							);
						}
				   });
				},
			//조회를 위한 최소글자수
			minLength: 2,
			select: function( event, ui ) {
				
				//$(this).closest('tr').find('.price1').val(ui.item.price);
				$(this).closest('tr').find('.gongjong').val(ui.item.gongjong);
				$(this).closest('tr').find('.numb').val(ui.item.num);
				$(this).closest('tr').find('.addr1').val(ui.item.addr1);
				$(this).closest('tr').next().find('.addr2').val(ui.item.addr2);
				$(this).closest('tr').find('.hp').val(ui.item.hp);
				$(this).closest('tr').find('.bank').val(ui.item.bank);
				$(this).closest('tr').find('.account').val(ui.item.account);
				$(this).closest('tr').find('.accname').val(ui.item.accname);
				
				
			}
		});
    });
	
	
	//업체선택시 결제정보를 업체로 변경
	$(document).on('change','.ne_company', function( event, ui) {
		
		
		var bank = "";
		$.ajax({
			type: 'post',
			url: "/_establishment/write/ajax.inc4.name.php",
			dataType: "json",
			async : false,
			data: { type : 'company', seq : $(this).val() },
			success: function(data) {
				
				
				account = data.account;
				bank = data.bank;
				accname = data.accname;
				
				
			}
			
		})
		
		$(this).closest('tr').find('.bank').val(bank);
		$(this).closest('tr').find('.account').val(account);
		$(this).closest('tr').find('.accname').val(accname);

	})
	
	
	$(document).on('keyup blur', '.dayinput', function(){
		let dayCnt = 0;
		let dayGongsu = 0;
		var total = 0;
		var jumin = $(this).closest('tr').find('.numb').val();
		var birth = jumin.split('-');
		var age = calcAge("19"+birth[0]);
		var tax3 = 0;
		//출력일수, 공수 자동입력
		
		$($(this).closest('tr').find('.dayinput')).each(function() {
			
			if($(this).val() > 0) {
				dayCnt++;
				
				dayGongsu += parseFloat($(this).val());
				
				
				if(isPositive((parseInt($(this).closest('tr').find('.ne_danga').val()) *  parseFloat($(this).val())) -150000) == "음수") {
					tax3 += 0;
				} else {
				
					tax3 += percent2( (parseInt($(this).closest('tr').find('.ne_danga').val()) *  parseFloat($(this).val())) -150000, $('#tax5_val').val());
				}
				
				
			}
			
			
		})
		
		$($(this).closest('tr').next().find('.dayinput2')).each(function() {
			
			if($(this).val() > 0) {
				dayCnt++;
				
				dayGongsu += parseFloat($(this).val());
				
				if(isPositive((parseInt($(this).closest('tr').prev().find('.ne_danga').val()) *  parseFloat($(this).val())) -150000) == "음수") {
					tax3 += 0;
				} else {
				tax3 += percent2( (parseInt($(this).closest('tr').prev().find('.ne_danga').val()) *  parseFloat($(this).val())) -150000, $('#tax5_val').val());
				}
			}
			
		})
	
		$(this).closest('tr').find('.ne_day_total').val(dayCnt);
		$(this).closest('tr').find('.ne_gongsu').val(dayGongsu.toFixed(1));
		
		//총액계산
		var total = dayGongsu * parseInt($(this).closest('tr').find('.ne_danga').val());
		if(isNaN(total)) { total = 0 };
		
		$(this).closest('tr').find('.ne_mny_total').val(parseInt(total));
		
		
		//8일 이상일경우 기산일 자동체크 및 공제 계산
		if(dayCnt >= 8) {
			$(this).closest('tr').find('.ne_gisan').attr('checked', true);
			
			//국민연금
			if(age >= 60) {
				tax1 = 0;
			} else {
				tax1 = percent2(total, $('#tax1_val').val());
				
				if($('#tax9_val').val() >= total) { //하한액 이하 계산x
					tax1 = 0
				} else if($('#tax10_val').val() <= total) { //상한액 이상일경우 상한액 고정
					tax1 = percent2($('#tax10_val').val(), $('#tax1_val').val());
				} 
				
			}
			$(this).closest('tr').find('.ne_tax1').val(tax1);
			
			//건강보험
			tax4 = percent2(total, $('#tax2_val').val());
			console.log(tax4);
			if($('#tax11_val').val() >= total) { //하한액 이하 계산x
				tax4 = 0
			} else if($('#tax12_val').val() <= total) { //상한액 이상일경우 상한액 고정
				tax4 = percent2($('#tax12_val').val(), $('#tax2_val').val());
			} 
			
			$(this).closest('tr').next().find('.ne_tax4').val(tax4);
			
			//장기요양보험 
			tax2 = percent2(tax4, $('#tax3_val').val());
			$(this).closest('tr').find('.ne_tax2').val(tax2);
			
		} else {
			tax1 = 0;
			tax2 = 0;
			tax4 = 0;
			
			$(this).closest('tr').find('.ne_tax1').val(tax1);
			$(this).closest('tr').next().find('.ne_tax4').val(tax4);
			$(this).closest('tr').find('.ne_tax2').val(tax2);
			
			$(this).closest('tr').find('.ne_gisan').attr('checked', false);
			
		}
		
		//소득세
		
		if(tax3 <= 1000) { //천원 이하일경우 공제x
			tax3 = 0;
		}
		if(isNaN(tax3)) { tax3 = 0 };
		$(this).closest('tr').find('.ne_tax3').val(tax3);
		
		//고용보험
		var tax5 = percent2(total, $('#tax4_val').val());
		
		if(age >= 65) {
			tax5 = 0;
		} 			
			
		$(this).closest('tr').next().find('.ne_tax5').val(tax5);
		
		//지방소득세
		var tax6 = percent2(tax3, $('#tax6_val').val());
		$(this).closest('tr').next().find('.ne_tax6').val(tax6);
		
		
		//공제금액 토탈
		var tax_total = parseInt(tax1)+parseInt(tax2)+parseInt(tax3)+parseInt(tax4)+parseInt(tax5)+parseInt(tax6);
		$(this).closest('tr').find('.ne_tax_total').val(tax_total);
		
		//차인지급액
		$(this).closest('tr').find('.ne_mny_last').val(parseInt(total)-parseInt(tax_total));
		
		
		
	})
	
	$(document).on('keyup blur', '.dayinput2', function(){
		let dayCnt = 0;
		let dayGongsu = 0;
		var total = 0;
		var jumin = $(this).closest('tr').prev().find('.numb').val();
		var birth = jumin.split('-');
		var age = calcAge("19"+birth[0]);
		var tax3 = 0;
		
		//출력일수, 공수 자동입력
		$($(this).closest('tr').find('.dayinput2')).each(function() {
			
			if($(this).val() > 0) {
				dayCnt++;
				
				dayGongsu += parseFloat($(this).val());
				
				if(isPositive((parseInt($(this).closest('tr').prev().find('.ne_danga').val()) *  parseFloat($(this).val())) -150000) == "음수") {
					tax3 += 0;
				} else {
					tax3 += percent2( (parseInt($(this).closest('tr').prev().find('.ne_danga').val()) *  parseFloat($(this).val())) -150000, $('#tax5_val').val());
				}
			}
			
		})
		
		$($(this).closest('tr').prev().find('.dayinput')).each(function() {
			
			if($(this).val() > 0) {
				dayCnt++;
				
				dayGongsu += parseFloat($(this).val());
				
				if(isPositive((parseInt($(this).closest('tr').find('.ne_danga').val()) *  parseFloat($(this).val())) -150000) == "음수") {
					tax3 += 0;
				} else {
					tax3 += percent2( (parseInt($(this).closest('tr').find('.ne_danga').val()) *  parseFloat($(this).val())) -150000, $('#tax5_val').val());
				}
			}
			
		})
		
		$(this).closest('tr').prev().find('.ne_day_total').val(dayCnt);
		$(this).closest('tr').prev().find('.ne_gongsu').val(dayGongsu.toFixed(1));
		
		//총액계산
		var total = dayGongsu * parseInt($(this).closest('tr').prev().find('.ne_danga').val());
		
		if(isNaN(total)) { total = 0 };
		$(this).closest('tr').prev().find('.ne_mny_total').val(parseInt(total));
		
		//8일 이상일경우 기산일 자동체크
		if(dayCnt >= 8) {
			$(this).closest('tr').prev().find('.ne_gisan').attr('checked', true);
			
			//국민연금
			if(age >= 60) {
				tax1 = 0;
			} else {
				tax1 = percent2(total, $('#tax1_val').val());
				
				if($('#tax9_val').val() >= total) { //하한액 이하 계산x
					tax1 = 0
				} else if($('#tax10_val').val() <= total) { //상한액 이상일경우 상한액 고정
					tax1 = percent2($('#tax10_val').val(), $('#tax1_val').val());
				} 
				
			}
			$(this).closest('tr').prev().find('.ne_tax1').val(tax1);
			
			//건강보험
			tax4 = percent2(total, $('#tax2_val').val());
			console.log(tax4);
			if($('#tax11_val').val() >= total) { //하한액 이하 계산x
				tax4 = 0
			} else if($('#tax12_val').val() <= total) { //상한액 이상일경우 상한액 고정
				tax4 = percent2($('#tax12_val').val(), $('#tax2_val').val());
			} 
			
			$(this).closest('tr').find('.ne_tax4').val(tax4);
			
			//장기요양보험 
			tax2 = percent2(tax4, $('#tax3_val').val());
			$(this).closest('tr').prev().find('.ne_tax2').val(tax2);
			
		} else {
			tax1 = 0;
			tax2 = 0;
			tax4 = 0;
			
			$(this).closest('tr').prev().find('.ne_tax2').val(tax2);
			$(this).closest('tr').find('.ne_tax4').val(tax4);
			$(this).closest('tr').prev().find('.ne_tax1').val(tax1);
			
			$(this).closest('tr').prev().find('.ne_gisan').attr('checked', false);
		}
		
		
		//소득세
		if(tax3 <= 1000) { //천원 이하일경우 공제x
			tax3 = 0;
		}
		if(isNaN(tax3)) { tax3 = 0 };
		$(this).closest('tr').prev().find('.ne_tax3').val(tax3);
		
		//고용보험
		var tax5 = percent2(total, $('#tax4_val').val());
		
		if(age >= 65) {
			tax5 = 0;
		} 			
			
		$(this).closest('tr').find('.ne_tax5').val(tax5);
		
		//지방소득세
		var tax6 = percent2(tax3, $('#tax6_val').val());
		$(this).closest('tr').find('.ne_tax6').val(tax6);
		
		
		//공제금액 토탈
		var tax_total = tax1+tax2+tax3+tax4+tax5+tax6;
		$(this).closest('tr').prev().find('.ne_tax_total').val(tax_total);
		
		//차인지급액
		$(this).closest('tr').prev().find('.ne_mny_last').val(parseInt(total)-parseInt(tax_total));
		
		
		
		
	})
	
	
	
	$(document).on('keyup blur', '.ne_danga', function(){
		let dayCnt = 0 //출력일수 
		let dayGongsu = 0 //공수 
		var total = 0;
		var jumin = $(this).closest('tr').find('.numb').val();
		var birth = jumin.split('-');
		var age = calcAge("19"+birth[0]);
		var tax3 = 0;
		
		
			
		//총액계산
		
		var gongsu = parseFloat($(this).closest('tr').find('.ne_gongsu').val());
		
		var total = gongsu * parseInt($(this).val());
		if(isNaN(total)) { total = 0 };
		$(this).closest('tr').find('.ne_mny_total').val(parseInt(total));
		
		
		$($(this).closest('tr').find('.dayinput')).each(function() {
			
			if($(this).val() > 0) {
				dayCnt++;
				
				dayGongsu += parseFloat($(this).val());
				
				
				if(isPositive((parseInt($(this).closest('tr').find('.ne_danga').val()) *  parseFloat($(this).val())) -150000) == "음수") {
					tax3 += 0;
				} else {
				
					tax3 += percent2( (parseInt($(this).closest('tr').find('.ne_danga').val()) *  parseFloat($(this).val())) -150000, $('#tax5_val').val());
				}
				
				
			}
			
			
		})
		
		$($(this).closest('tr').next().find('.dayinput2')).each(function() {
			
			if($(this).val() > 0) {
				dayCnt++;
				
				dayGongsu += parseFloat($(this).val());
				
				if(isPositive((parseInt($(this).closest('tr').prev().find('.ne_danga').val()) *  parseFloat($(this).val())) -150000) == "음수") {
					tax3 += 0;
				} else {
				tax3 += percent2( (parseInt($(this).closest('tr').prev().find('.ne_danga').val()) *  parseFloat($(this).val())) -150000, $('#tax5_val').val());
				}
			}
			
		})
		
		
		//8일 이상일경우 기산일 자동체크 및 공제 계산
		if(dayCnt >= 8) {
			$(this).closest('tr').find('.ne_gisan').attr('checked', true);
			
			//국민연금
			if(age >= 60) {
				tax1 = 0;
			} else {
				tax1 = percent2(total, $('#tax1_val').val());
				
				if($('#tax9_val').val() >= total) { //하한액 이하 계산x
					tax1 = 0
				} else if($('#tax10_val').val() <= total) { //상한액 이상일경우 상한액 고정
					tax1 = percent2($('#tax10_val').val(), $('#tax1_val').val());
				} 
				
			}
			$(this).closest('tr').find('.ne_tax1').val(tax1);
			
			//건강보험
			tax4 = percent2(total, $('#tax2_val').val());
			console.log(tax4);
			if($('#tax11_val').val() >= total) { //하한액 이하 계산x
				tax4 = 0
			} else if($('#tax12_val').val() <= total) { //상한액 이상일경우 상한액 고정
				tax4 = percent2($('#tax12_val').val(), $('#tax2_val').val());
			} 
			
			$(this).closest('tr').next().find('.ne_tax4').val(tax4);
			
			//장기요양보험 
			tax2 = percent2(tax4, $('#tax3_val').val());
			$(this).closest('tr').find('.ne_tax2').val(tax2);
			
		} else {
			tax1 = 0;
			tax2 = 0;
			tax4 = 0;
			
			$(this).closest('tr').find('.ne_tax1').val(tax1);
			$(this).closest('tr').next().find('.ne_tax4').val(tax4);
			$(this).closest('tr').find('.ne_tax2').val(tax2);
			
			$(this).closest('tr').find('.ne_gisan').attr('checked', false);
			
		}
		
		//소득세
		
		if(tax3 <= 1000) { //천원 이하일경우 공제x
			tax3 = 0;
		}
		if(isNaN(tax3)) { tax3 = 0 };
		$(this).closest('tr').find('.ne_tax3').val(tax3);
		
		//고용보험
		var tax5 = percent2(total, $('#tax4_val').val());
		
		if(age >= 65) {
			tax5 = 0;
		} 			
			
		$(this).closest('tr').next().find('.ne_tax5').val(tax5);
		
		//지방소득세
		var tax6 = percent2(tax3, $('#tax6_val').val());
		$(this).closest('tr').next().find('.ne_tax6').val(tax6);
		
		
		//공제금액 토탈
		var tax_total = parseInt(tax1)+parseInt(tax2)+parseInt(tax3)+parseInt(tax4)+parseInt(tax5)+parseInt(tax6);
		$(this).closest('tr').find('.ne_tax_total').val(tax_total);
		
		//차인지급액
		$(this).closest('tr').find('.ne_mny_last').val(parseInt(total)-parseInt(tax_total));
	
		
		
		
	})
	var no = $('.no').last().html();
	//표추가 
	$('#add_tables').bind('click', function() {
		
		var clone = $('#copybox').clone();
		
		clone.find(".no").each(function() {
			no++;
			$(this).html(no);
			
		})
		
			
		clone.find(".total_row").hide();   
		clone.find(".row8 input").val("");    
		clone.find(".row9 input").val("");    
		clone.find(".ne_gisan").attr("checked", false);    
		clone.find(".ne_company").val("");    
		clone.removeAttr('id');    
		
		$('#add_tb_box').append(clone);
	})
	
})

//퍼센트계산
function percent2(par, total) {
    var v = ( total * par ) / 100
	
	return  Math.floor(v/10) * 10;
}
//만나이
function calcAge(birth) {
    var date = new Date();
    var year = date.getFullYear();
    var month = (date.getMonth() + 1);
    var day = date.getDate();       
    if (month < 10) month = '0' + month;
    if (day < 10) day = '0' + day;
    var monthDay = month + day;
    birth = birth.replace('-', '').replace('-', '');
    var birthdayy = birth.substr(0, 4);
    var birthdaymd = birth.substr(4, 4); 
    var age = monthDay < birthdaymd ? year - birthdayy - 1 : year - birthdayy;
    return age;
} 

function isPositive(num) {
	
  const result = num >= 0 ? '양수' : '음수';

  return result;
};

//초기화 
function init() {
	
	if(confirm('정말 해당 월 노임대장을 초기화 하시겠습니까?\n초기화 후 데이터복구는 불가능합니다.')) {
		var code = $('#nw_code').val();
		var date = $('#ne_date').val();
		
		location.href = '/_establishment/write/update/inc/menu4_update.php?mode=d&nw_code='+code+'&ne_date='+date;
		return false;
	} else {
		return false;
	}
	
}