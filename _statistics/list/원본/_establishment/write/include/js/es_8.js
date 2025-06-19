$(function() {

	
	//콤마처리
	$(document).on('keyup', '.numb', function() {
		 
		var v = comma($(this).val());
	
		$(this).val(v);
	})
	
	//도급현황
	$(document).on('keyup', '.ne_qty1, .ne_danga1', function() {
		
		var qty = uncomma($(this).closest('tr').find('.ne_qty1').val()); 
		var price = uncomma($(this).closest('tr').find('.ne_danga1').val()); 
		qty = qty ? qty : 0;
		price = price ? price : 0;
		
		var total = qty*price;
		
		$(this).closest('tr').find('.ne_price1').val(comma(total));
		
		
		//잔량현황
		var pqty = uncomma($(this).closest('tr').find('.ne_qty3').val()); 
		var pprice = parseInt(uncomma($(this).closest('tr').find('.ne_price3').val())) ; 
		pqty = pqty ? pqty : 0;
		pprice = pprice ? pprice : 0;
		
		$(this).closest('tr').find('.ne_qty4').val(comma(qty - pqty));
		$(this).closest('tr').find('.ne_price4').val(comma(total - pprice));
		
		
	})
	
	//금회입고
	$(document).on('keyup', '.ne_qty2, .ne_danga2', function() {
		
		var qty = uncomma($(this).closest('tr').find('.ne_qty2').val()); 
		var price = uncomma($(this).closest('tr').find('.ne_danga2').val()); 
		qty = qty ? qty : 0;
		price = price ? price : 0;
		
		
		var total = qty*price;
		
		$(this).closest('tr').find('.ne_price2').val(comma(total));
		
		//누계입고
		var pqty = uncomma($(this).closest('tr').find('.prev_qty').val()); 
		var pprice = uncomma($(this).closest('tr').find('.prev_price').val()); 
		pqty = pqty ? pqty : 0;
		pprice = pprice ? pprice : 0;
		
		$(this).closest('tr').find('.ne_qty3').val(comma(pqty+ qty));
		$(this).closest('tr').find('.ne_price3').val(comma(pprice+total));
		
		//도급현황으로 잔량현황
		var qty2 = uncomma($(this).closest('tr').find('.ne_qty1').val()); 
		var price2 = uncomma($(this).closest('tr').find('.ne_price1').val()) ; 
		qty2 = qty2 ? qty2 : 0;
		price2 = price2 ? price2 : 0;
		
		$(this).closest('tr').find('.ne_qty4').val(comma(qty2 - (pqty+ qty)));
		$(this).closest('tr').find('.ne_price4').val(comma(price2 - (pprice+total)));
		
		
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