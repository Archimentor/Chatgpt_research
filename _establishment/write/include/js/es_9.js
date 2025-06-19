$(function() {
	
	$('#add_tables').bind('click', function() {
		
		var clone = $('#copybox').clone();
		
		clone.show();
		$('#add_tb_box').append(clone);
	})
	
	//콤마처리
	$(document).on('keyup', '.numb', function() {
	 
		var v = comma($(this).val());

		$(this).val(v);
	})

	$(document).on('keyup', '.ne_detail_qty, .ne_detail_danga ', function() {
		var qty = uncomma($(this).closest('tr').find('.ne_detail_qty').val()); 
		var price = uncomma($(this).closest('tr').find('.ne_detail_danga').val());
		var vat = 0;
		
		qty = qty ? qty : 0;
		price = price ? price : 0;
		
		var total = qty*price;
		
		vat   = (total*0.1);    // 부가세(VAT)
		vat   = Math.round(vat);
		
		vat = vat ? vat : 0;
		
		var total2 = total+vat;
		
		$(this).closest('tr').find('.ne_detail_price').val(comma(total));
		$(this).closest('tr').find('.ne_detail_vat').val(comma(vat));
		$(this).closest('tr').find('.ne_detail_total').val(comma(total2));
		
		
		
	})

	$(document).on('keyup', '.ne_detail_vat', function() {
		
		var vat = uncomma($(this).val()); 
		var price = uncomma($(this).closest('tr').find('.ne_detail_price').val());
		vat = vat ? vat : 0;
		price = price ? price : 0;
		
		var total = price + vat;
		
		
		$(this).closest('tr').find('.ne_detail_total').val(comma(total));
		
	})
	
});


function comma(obj) {
	console.log(obj);
	var regx = new RegExp(/(-?\d+)(\d{3})/);
	var bExists = obj.toString().indexOf(".", 0);//0번째부터 .을 찾는다.
	var strArr = obj.toString().split('.');
	while (regx.test(strArr[0])) {//문자열에 정규식 특수문자가 포함되어 있는지 체크
		//정수 부분에만 콤마 달기 
		strArr[0] = strArr[0].replace(regx, "$1,$2");//콤마추가하기
	}
	if (bExists > -1) {
		//. 소수점 문자열이 발견되지 않을 경우 -1 반환
		obj = strArr[0] + "." + strArr[1];
	} else { //정수만 있을경우 //소수점 문자열 존재하면 양수 반환 
		obj = strArr[0];
	}
	return obj;//문자열 반환
}

function uncomma(str) {
 str = "" + str.replace(/,/gi, ''); // 콤마 제거 
    str = str.replace(/(^\s*)|(\s*$)/g, ""); // trim()공백,문자열 제거 
    return (new Number(str));//문자열을 숫자로 반환
}