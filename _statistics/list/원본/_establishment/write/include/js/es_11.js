$(function() {
	$('#add_tables').bind('click', function() {
		
		var clone = $('#copybox').clone();
		
		clone.show();
		$('#add_tb_box').append(clone);
	})
	
	//콤마처리
	$(document).on('keyup', '.numb', function() {
	 
		var v = comma(uncomma($(this).val()));

		$(this).val(v);
	})
	
	$(document).on('keyup', '.ne_detail_price1,.ne_detail_price2,.ne_detail_price3,.ne_detail_price4,.ne_detail_price5,.ne_detail_price6,.ne_detail_price7', function() {
		var price1 = uncomma($(this).closest('tr').find('.ne_detail_price1').val()); //노무비금액
		var price2 = uncomma($(this).closest('tr').find('.ne_detail_price2').val()); //국민연금
		var price3 = uncomma($(this).closest('tr').find('.ne_detail_price3').val()); //건강보험
		var price4 = uncomma($(this).closest('tr').find('.ne_detail_price4').val()); //장기요양
		var price5 = uncomma($(this).closest('tr').find('.ne_detail_price5').val()); //고용보험
		var price6 = uncomma($(this).closest('tr').find('.ne_detail_price6').val()); //소득세
		var price7 = uncomma($(this).closest('tr').find('.ne_detail_price7').val()); //지방소득세
		
		var total1 = 0; //차감계
		var total2 = 0; //차감 후 금액
		
		price1 = price1 ? price1 : 0;
		price2 = price2 ? price2 : 0;
		price3 = price3 ? price3 : 0;
		price4 = price4 ? price4 : 0;
		price5 = price5 ? price5 : 0;
		price6 = price6 ? price6 : 0;
		price7 = price7 ? price7 : 0;
		
		
		
		total1 = price2 +price3 +price4 +price5 +price6 +price7;
		total2 = price1 - total1;
		
		$(this).closest('tr').find('.ne_detail_price8').val(comma(total1));
		$(this).closest('tr').find('.ne_detail_price9').val(comma(total2));
		
		
		
	})
})

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