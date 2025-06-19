$(function() {
	$('.num').each(function() {
		
			
		$(this).val(comma($(this).val()));
		
	})
	
	$(document).on('keyup', '.num', function() {
		 
		var v = comma(uncomma($(this).val()));
	
		$(this).val(v);
	})
	
	
	$(document).on('keyup', 'input[name="s1_price3[]"]', function() {
		
		var vat = 0 ;
		var p = parseInt(uncomma($(this).closest('tr').find('input[name="s1_price3[]"]').val()));
		var total = 0;
		
		vat   = (p*0.1);    // 부가세(VAT)
		vat   = Math.round(vat);
		
		total = p+vat;
		
		vat = vat ? vat : 0;
		total = total ? total : 0;
		
		$(this).closest('tr').find('input[name="s1_price4[]"]').val(comma(vat));
		$(this).closest('tr').find('input[name="s1_price5[]"]').val(comma(total));
		
		
	})
	
	
	$(document).on('keyup', 'input[name="s1_price4[]"]', function() {
		
		var vat = parseInt(uncomma($(this).closest('tr').find('input[name="s1_price4[]"]').val()));
		var p = parseInt(uncomma($(this).closest('tr').find('input[name="s1_price3[]"]').val()));
		var total = 0;
		
		
		total = p+vat;
		
		vat = vat ? vat : 0;
		total = total ? total : 0;
		
		$(this).closest('tr').find('input[name="s1_price5[]"]').val(comma(total));
		
		
	})
	$(document).on('keyup', 'input[name="s3_price3[]"]', function() {
		
		var vat = 0 ;
		var p = parseInt(uncomma($(this).closest('tr').find('input[name="s3_price3[]"]').val()));
		var total = 0;
		
		vat   = (p*0.1);    // 부가세(VAT)
		vat   = Math.round(vat);
		
		total = p+vat;
		
		vat = vat ? vat : 0;
		total = total ? total : 0;
		
		$(this).closest('tr').find('input[name="s3_price4[]"]').val(comma(vat));
		$(this).closest('tr').find('input[name="s3_price5[]"]').val(comma(total));
		
		
	})
	$(document).on('keyup', 'input[name="s3_price4[]"]', function() {
		
		var vat = parseInt(uncomma($(this).closest('tr').find('input[name="s3_price4[]"]').val()));
		var p = parseInt(uncomma($(this).closest('tr').find('input[name="s3_price3[]"]').val()));
		var total = 0;
		
		
		total = p+vat;
		
		vat = vat ? vat : 0;
		total = total ? total : 0;
		
		$(this).closest('tr').find('input[name="s3_price5[]"]').val(comma(total));
		
		
	})
	
	$(document).on('keyup', 'input[name="s4_price3[]"]', function() {
		
		var vat = 0 ;
		var p = parseInt(uncomma($(this).closest('tr').find('input[name="s4_price3[]"]').val()));
		var total = 0;
		
		vat   = (p*0.1);    // 부가세(VAT)
		vat   = Math.round(vat);
		
		total = p+vat;
		
		vat = vat ? vat : 0;
		total = total ? total : 0;
		
		$(this).closest('tr').find('input[name="s4_price4[]"]').val(comma(vat));
		$(this).closest('tr').find('input[name="s4_price5[]"]').val(comma(total));
		
		
	})
	$(document).on('keyup', 'input[name="s4_price4[]"]', function() {
		
		var vat = parseInt(uncomma($(this).closest('tr').find('input[name="s4_price4[]"]').val()));
		var p = parseInt(uncomma($(this).closest('tr').find('input[name="s4_price3[]"]').val()));
		var total = 0;
		
		
		total = p+vat;
		
		vat = vat ? vat : 0;
		total = total ? total : 0;
		
		$(this).closest('tr').find('input[name="s4_price5[]"]').val(comma(total));
		
		
	})
	$(document).on('keyup', 'input[name="s5_price3[]"]', function() {
		
		var vat = 0 ;
		var p = parseInt(uncomma($(this).closest('tr').find('input[name="s5_price3[]"]').val()));
		var total = 0;
		
		vat   = (p*0.1);    // 부가세(VAT)
		vat   = Math.round(vat);
		
		total = p+vat;
		
		vat = vat ? vat : 0;
		total = total ? total : 0;
		
		$(this).closest('tr').find('input[name="s5_price4[]"]').val(comma(vat));
		$(this).closest('tr').find('input[name="s5_price5[]"]').val(comma(total));
		
		
	})
	$(document).on('keyup', 'input[name="s5_price4[]"]', function() {
		
		var vat = parseInt(uncomma($(this).closest('tr').find('input[name="s5_price4[]"]').val()));
		var p = parseInt(uncomma($(this).closest('tr').find('input[name="s5_price3[]"]').val()));
		var total = 0;
		
		
		total = p+vat;
		
		vat = vat ? vat : 0;
		total = total ? total : 0;
		
		$(this).closest('tr').find('input[name="s5_price5[]"]').val(comma(total));
		
		
	})
	$(document).on('keyup', 'input[name="s2_price3[]"]', function() {
		
		var vat = 0 ;
		var p = parseInt(uncomma($(this).closest('tr').find('input[name="s2_price3[]"]').val()));
		var total = 0;
		
		vat   = (p*0.1);    // 부가세(VAT)
		vat   = Math.round(vat);
		
		total = p+vat;
		
		vat = vat ? vat : 0;
		total = total ? total : 0;
		
		$(this).closest('tr').find('input[name="s2_price4[]"]').val(comma(vat));
		$(this).closest('tr').find('input[name="s2_price5[]"]').val(comma(total));
		
		
	})
	$(document).on('keyup', 'input[name="s2_price4[]"]', function() {
		
		var vat = parseInt(uncomma($(this).closest('tr').find('input[name="s2_price4[]"]').val()));
		var p = parseInt(uncomma($(this).closest('tr').find('input[name="s2_price3[]"]').val()));
		var total = 0;
		
		
		total = p+vat;
		
		vat = vat ? vat : 0;
		total = total ? total : 0;
		
		$(this).closest('tr').find('input[name="s2_price5[]"]').val(comma(total));
		
		
	})
	
	$(document).on('keyup', 'input[name="s1_price9[]"]', function() {
		
		var vat = 0 ;
		var p = parseInt(uncomma($(this).closest('tr').find('input[name="s1_price9[]"]').val()));
		var total = 0;
		
		vat   = (p*0.1);    // 부가세(VAT)
		vat   = Math.round(vat);
		
		total = p+vat;
		
		vat = vat ? vat : 0;
		total = total ? total : 0;
		
		$(this).closest('tr').find('input[name="s1_price10[]"]').val(comma(vat));
		$(this).closest('tr').find('input[name="s1_price11[]"]').val(comma(total));
		$(this).closest('tr').find('input[name="s1_price14[]"]').val(comma(total));
		
		//전회 + 금회
		var pp = parseInt(uncomma($(this).closest('tr').find('input[name="s1_price6[]"]').val())); //전회 공급가액
		var ppv = parseInt(uncomma($(this).closest('tr').find('input[name="s1_price7[]"]').val())); //전회 부가세
		var ppt = parseInt(uncomma($(this).closest('tr').find('input[name="s1_price8[]"]').val())); //전회 합계
		
		$(this).closest('tr').find('input[name="s1_price15[]"]').val(comma(p+pp));
		$(this).closest('tr').find('input[name="s1_price16[]"]').val(comma(vat+ppv));
		$(this).closest('tr').find('input[name="s1_price17[]"]').val(comma(total+ppt));
		
		
	})
	$(document).on('keyup', 'input[name="s1_price10[]"]', function() {
		
		var vat = parseInt(uncomma($(this).closest('tr').find('input[name="s1_price10[]"]').val()));
		var p = parseInt(uncomma($(this).closest('tr').find('input[name="s1_price9[]"]').val()));
		var total = 0;
		
		
		total = p+vat;
		
		vat = vat ? vat : 0;
		total = total ? total : 0;
		
		$(this).closest('tr').find('input[name="s1_price11[]"]').val(comma(total));
		
		//전회 + 금회
		var pp = parseInt(uncomma($(this).closest('tr').find('input[name="s1_price6[]"]').val())); //전회 공급가액
		var ppv = parseInt(uncomma($(this).closest('tr').find('input[name="s1_price7[]"]').val())); //전회 부가세
		var ppt = parseInt(uncomma($(this).closest('tr').find('input[name="s1_price8[]"]').val())); //전회 합계
		
		$(this).closest('tr').find('input[name="s1_price15[]"]').val(comma(p+pp));
		$(this).closest('tr').find('input[name="s1_price16[]"]').val(comma(vat+ppv));
		$(this).closest('tr').find('input[name="s1_price17[]"]').val(comma(total+ppt));
		
	})
	
	$(document).on('keyup', 'input[name="s1_price12[]"], input[name="s1_price13[]"]', function() {
		
		var p1 = parseInt(uncomma($(this).closest('tr').find('input[name="s1_price12[]"]').val()));
		var p2 = parseInt(uncomma($(this).closest('tr').find('input[name="s1_price13[]"]').val()));
		var p3 = parseInt(uncomma($(this).closest('tr').find('input[name="s1_price11[]"]').val()));
		
		var total = 0;
		
		
		total = p3 - p1 -p2;
		
		p1 = p1 ? p1 : 0;
		p2 = p2 ? p2 : 0;
		
		$(this).closest('tr').find('input[name="s1_price14[]"]').val(comma(total));
		
		//전회 + 금회
		var pp = parseInt(uncomma($(this).closest('tr').find('input[name="s1_price6[]"]').val())); //전회 공급가액
		var ppv = parseInt(uncomma($(this).closest('tr').find('input[name="s1_price7[]"]').val())); //전회 부가세
		var ppt = parseInt(uncomma($(this).closest('tr').find('input[name="s1_price8[]"]').val())); //전회 합계
		
		$(this).closest('tr').find('input[name="s1_price15[]"]').val(comma(p+pp));
		$(this).closest('tr').find('input[name="s1_price16[]"]').val(comma(vat+ppv));
		$(this).closest('tr').find('input[name="s1_price17[]"]').val(comma(total+ppt));

	})
	
	$(document).on('keyup', 'input[name="s2_price9[]"]', function() {
		
		var vat = 0 ;
		var p = parseInt(uncomma($(this).closest('tr').find('input[name="s2_price9[]"]').val()));
		var total = 0;
		
		vat   = (p*0.1);    // 부가세(VAT)
		vat   = Math.round(vat);
		
		total = p+vat;
		
		vat = vat ? vat : 0;
		total = total ? total : 0;
		
		$(this).closest('tr').find('input[name="s2_price10[]"]').val(comma(vat));
		$(this).closest('tr').find('input[name="s2_price11[]"]').val(comma(total));
		$(this).closest('tr').find('input[name="s2_price14[]"]').val(comma(total));
		
		//전회 + 금회
		var pp = parseInt(uncomma($(this).closest('tr').find('input[name="s2_price6[]"]').val())); //전회 공급가액
		var ppv = parseInt(uncomma($(this).closest('tr').find('input[name="s2_price7[]"]').val())); //전회 부가세
		var ppt = parseInt(uncomma($(this).closest('tr').find('input[name="s2_price8[]"]').val())); //전회 합계
		
		$(this).closest('tr').find('input[name="s2_price15[]"]').val(comma(p+pp));
		$(this).closest('tr').find('input[name="s2_price16[]"]').val(comma(vat+ppv));
		$(this).closest('tr').find('input[name="s2_price17[]"]').val(comma(total+ppt));
		
		$(this).closest('tr').find('input[name="s2_price3[]"]').val(comma(p+pp));
		$(this).closest('tr').find('input[name="s2_price4[]"]').val(comma(vat+ppv));
		$(this).closest('tr').find('input[name="s2_price5[]"]').val(comma(total+ppt));
		
	})
	$(document).on('keyup', 'input[name="s2_price10[]"]', function() {
		
		var vat = parseInt(uncomma($(this).closest('tr').find('input[name="s2_price10[]"]').val()));
		var p = parseInt(uncomma($(this).closest('tr').find('input[name="s2_price9[]"]').val()));
		var total = 0;
		
		
		total = p+vat;
		
		vat = vat ? vat : 0;
		total = total ? total : 0;
		
		$(this).closest('tr').find('input[name="s2_price11[]"]').val(comma(total));
		
		//전회 + 금회
		var pp = parseInt(uncomma($(this).closest('tr').find('input[name="s2_price6[]"]').val())); //전회 공급가액
		var ppv = parseInt(uncomma($(this).closest('tr').find('input[name="s2_price7[]"]').val())); //전회 부가세
		var ppt = parseInt(uncomma($(this).closest('tr').find('input[name="s2_price8[]"]').val())); //전회 합계
		
		$(this).closest('tr').find('input[name="s2_price15[]"]').val(comma(p+pp));
		$(this).closest('tr').find('input[name="s2_price16[]"]').val(comma(vat+ppv));
		$(this).closest('tr').find('input[name="s2_price17[]"]').val(comma(total+ppt));
		
		
		$(this).closest('tr').find('input[name="s2_price3[]"]').val(comma(p+pp));
		$(this).closest('tr').find('input[name="s2_price4[]"]').val(comma(vat+ppv));
		$(this).closest('tr').find('input[name="s2_price5[]"]').val(comma(total+ppt));
		
	})
	
	$(document).on('keyup', 'input[name="s2_price12[]"], input[name="s2_price13[]"]', function() {
		
		var p1 = parseInt(uncomma($(this).closest('tr').find('input[name="s2_price12[]"]').val()));
		var p2 = parseInt(uncomma($(this).closest('tr').find('input[name="s2_price13[]"]').val()));
		var p3 = parseInt(uncomma($(this).closest('tr').find('input[name="s2_price11[]"]').val()));
		
		var total = 0;
		
		
		total = p3 - p1 -p2;
		
		p1 = p1 ? p1 : 0;
		p2 = p2 ? p2 : 0;
		
		$(this).closest('tr').find('input[name="s2_price14[]"]').val(comma(total));

	})
	
	$(document).on('keyup', 'input[name="s3_price9[]"]', function() {
		
		var vat = 0 ;
		var p = parseInt(uncomma($(this).closest('tr').find('input[name="s3_price9[]"]').val()));
		var total = 0;
		
		vat   = (p*0.1);    // 부가세(VAT)
		vat   = Math.round(vat);
		
		total = p+vat;
		
		vat = vat ? vat : 0;
		total = total ? total : 0;
		
		$(this).closest('tr').find('input[name="s3_price10[]"]').val(comma(vat));
		$(this).closest('tr').find('input[name="s3_price11[]"]').val(comma(total));
		$(this).closest('tr').find('input[name="s3_price14[]"]').val(comma(total));
		
		//전회 + 금회
		var pp = parseInt(uncomma($(this).closest('tr').find('input[name="s3_price6[]"]').val())); //전회 공급가액
		var ppv = parseInt(uncomma($(this).closest('tr').find('input[name="s3_price7[]"]').val())); //전회 부가세
		var ppt = parseInt(uncomma($(this).closest('tr').find('input[name="s3_price8[]"]').val())); //전회 합계
		
		$(this).closest('tr').find('input[name="s3_price15[]"]').val(comma(p+pp));
		$(this).closest('tr').find('input[name="s3_price16[]"]').val(comma(vat+ppv));
		$(this).closest('tr').find('input[name="s3_price17[]"]').val(comma(total+ppt));
		
		$(this).closest('tr').find('input[name="s3_price3[]"]').val(comma(p+pp));
		$(this).closest('tr').find('input[name="s3_price4[]"]').val(comma(vat+ppv));
		$(this).closest('tr').find('input[name="s3_price5[]"]').val(comma(total+ppt));
		
		
	})
	$(document).on('keyup', 'input[name="s3_price10[]"]', function() {
		
		var vat = parseInt(uncomma($(this).closest('tr').find('input[name="s3_price10[]"]').val()));
		var p = parseInt(uncomma($(this).closest('tr').find('input[name="s3_price9[]"]').val()));
		var total = 0;
		
		
		total = p+vat;
		
		vat = vat ? vat : 0;
		total = total ? total : 0;
		
		$(this).closest('tr').find('input[name="s3_price11[]"]').val(comma(total));
		//전회 + 금회
		var pp = parseInt(uncomma($(this).closest('tr').find('input[name="s3_price6[]"]').val())); //전회 공급가액
		var ppv = parseInt(uncomma($(this).closest('tr').find('input[name="s3_price7[]"]').val())); //전회 부가세
		var ppt = parseInt(uncomma($(this).closest('tr').find('input[name="s3_price8[]"]').val())); //전회 합계
		
		$(this).closest('tr').find('input[name="s3_price15[]"]').val(comma(p+pp));
		$(this).closest('tr').find('input[name="s3_price16[]"]').val(comma(vat+ppv));
		$(this).closest('tr').find('input[name="s3_price17[]"]').val(comma(total+ppt));
		
		$(this).closest('tr').find('input[name="s3_price3[]"]').val(comma(p+pp));
		$(this).closest('tr').find('input[name="s3_price4[]"]').val(comma(vat+ppv));
		$(this).closest('tr').find('input[name="s3_price5[]"]').val(comma(total+ppt));
		
	})
	
	$(document).on('keyup', 'input[name="s3_price12[]"], input[name="s3_price13[]"]', function() {
		
		var p1 = parseInt(uncomma($(this).closest('tr').find('input[name="s3_price12[]"]').val()));
		var p2 = parseInt(uncomma($(this).closest('tr').find('input[name="s3_price13[]"]').val()));
		var p3 = parseInt(uncomma($(this).closest('tr').find('input[name="s3_price11[]"]').val()));
		
		var total = 0;
		
		
		total = p3 - p1 -p2;
		
		p1 = p1 ? p1 : 0;
		p2 = p2 ? p2 : 0;
		
		$(this).closest('tr').find('input[name="s3_price14[]"]').val(comma(total));

	})
	
	$(document).on('keyup', 'input[name="s4_price9[]"]', function() {
		
		var vat = 0 ;
		var p = parseInt(uncomma($(this).closest('tr').find('input[name="s4_price9[]"]').val()));
		var total = 0;
		
		vat   = (p*0.1);    // 부가세(VAT)
		vat   = Math.round(vat);
		
		total = p+vat;
		
		vat = vat ? vat : 0;
		total = total ? total : 0;
		
		$(this).closest('tr').find('input[name="s4_price10[]"]').val(comma(vat));
		$(this).closest('tr').find('input[name="s4_price11[]"]').val(comma(total));
		$(this).closest('tr').find('input[name="s4_price14[]"]').val(comma(total));
		
		//전회 + 금회
		var pp = parseInt(uncomma($(this).closest('tr').find('input[name="s4_price6[]"]').val())); //전회 공급가액
		var ppv = parseInt(uncomma($(this).closest('tr').find('input[name="s4_price7[]"]').val())); //전회 부가세
		var ppt = parseInt(uncomma($(this).closest('tr').find('input[name="s4_price8[]"]').val())); //전회 합계
		
		$(this).closest('tr').find('input[name="s4_price15[]"]').val(comma(p+pp));
		$(this).closest('tr').find('input[name="s4_price16[]"]').val(comma(vat+ppv));
		$(this).closest('tr').find('input[name="s4_price17[]"]').val(comma(total+ppt));
		
		$(this).closest('tr').find('input[name="s4_price3[]"]').val(comma(p+pp));
		$(this).closest('tr').find('input[name="s4_price4[]"]').val(comma(vat+ppv));
		$(this).closest('tr').find('input[name="s4_price5[]"]').val(comma(total+ppt));
		
		
	})
	$(document).on('keyup', 'input[name="s4_price10[]"]', function() {
		
		var vat = parseInt(uncomma($(this).closest('tr').find('input[name="s4_price10[]"]').val()));
		var p = parseInt(uncomma($(this).closest('tr').find('input[name="s4_price9[]"]').val()));
		var total = 0;
		
		
		total = p+vat;
		
		vat = vat ? vat : 0;
		total = total ? total : 0;
		
		$(this).closest('tr').find('input[name="s4_price11[]"]').val(comma(total));
		
		//전회 + 금회
		var pp = parseInt(uncomma($(this).closest('tr').find('input[name="s4_price6[]"]').val())); //전회 공급가액
		var ppv = parseInt(uncomma($(this).closest('tr').find('input[name="s4_price7[]"]').val())); //전회 부가세
		var ppt = parseInt(uncomma($(this).closest('tr').find('input[name="s4_price8[]"]').val())); //전회 합계
		
		$(this).closest('tr').find('input[name="s4_price15[]"]').val(comma(p+pp));
		$(this).closest('tr').find('input[name="s4_price16[]"]').val(comma(vat+ppv));
		$(this).closest('tr').find('input[name="s4_price17[]"]').val(comma(total+ppt));
		
		$(this).closest('tr').find('input[name="s4_price3[]"]').val(comma(p+pp));
		$(this).closest('tr').find('input[name="s4_price4[]"]').val(comma(vat+ppv));
		$(this).closest('tr').find('input[name="s4_price5[]"]').val(comma(total+ppt));
		
		
	})
	
	$(document).on('keyup', 'input[name="s4_price12[]"], input[name="s4_price13[]"]', function() {
		
		var p1 = parseInt(uncomma($(this).closest('tr').find('input[name="s4_price12[]"]').val()));
		var p2 = parseInt(uncomma($(this).closest('tr').find('input[name="s4_price13[]"]').val()));
		var p3 = parseInt(uncomma($(this).closest('tr').find('input[name="s4_price11[]"]').val()));
		
		var total = 0;
		
		
		total = p3 - p1 -p2;
		
		p1 = p1 ? p1 : 0;
		p2 = p2 ? p2 : 0;
		
		$(this).closest('tr').find('input[name="s4_price14[]"]').val(total);

	})
	
	$(document).on('keyup', 'input[name="s5_price9[]"]', function() {
		
		var vat = 0 ;
		var p = parseInt(uncomma($(this).closest('tr').find('input[name="s5_price9[]"]').val()));
		var total = 0;
		
		vat   = (p*0.1);    // 부가세(VAT)
		vat   = Math.round(vat);
		
		total = p+vat;
		
		vat = vat ? vat : 0;
		total = total ? total : 0;
		
		$(this).closest('tr').find('input[name="s5_price10[]"]').val(comma(vat));
		$(this).closest('tr').find('input[name="s5_price11[]"]').val(comma(total));
		$(this).closest('tr').find('input[name="s5_price14[]"]').val(comma(total));
		//전회 + 금회
		var pp = parseInt(uncomma($(this).closest('tr').find('input[name="s5_price6[]"]').val())); //전회 공급가액
		var ppv = parseInt(uncomma($(this).closest('tr').find('input[name="s5_price7[]"]').val())); //전회 부가세
		var ppt = parseInt(uncomma($(this).closest('tr').find('input[name="s5_price8[]"]').val())); //전회 합계
		
		$(this).closest('tr').find('input[name="s5_price15[]"]').val(comma(p+pp));
		$(this).closest('tr').find('input[name="s5_price16[]"]').val(comma(vat+ppv));
		$(this).closest('tr').find('input[name="s5_price17[]"]').val(comma(total+ppt));
		
		$(this).closest('tr').find('input[name="s5_price3[]"]').val(comma(p+pp));
		$(this).closest('tr').find('input[name="s5_price4[]"]').val(comma(vat+ppv));
		$(this).closest('tr').find('input[name="s5_price5[]"]').val(comma(total+ppt));
		
		
	})
	$(document).on('keyup', 'input[name="s5_price10[]"]', function() {
		
		var vat = parseInt(uncomma($(this).closest('tr').find('input[name="s5_price10[]"]').val()));
		var p = parseInt(uncomma($(this).closest('tr').find('input[name="s5_price9[]"]').val()));
		var total = 0;
		
		
		total = p+vat;
		
		vat = vat ? vat : 0;
		total = total ? total : 0;
		
		$(this).closest('tr').find('input[name="s5_price11[]"]').val(comma(total));
		
		//전회 + 금회
		var pp = parseInt(uncomma($(this).closest('tr').find('input[name="s5_price6[]"]').val())); //전회 공급가액
		var ppv = parseInt(uncomma($(this).closest('tr').find('input[name="s5_price7[]"]').val())); //전회 부가세
		var ppt = parseInt(uncomma($(this).closest('tr').find('input[name="s5_price8[]"]').val())); //전회 합계
		
		$(this).closest('tr').find('input[name="s5_price15[]"]').val(comma(p+pp));
		$(this).closest('tr').find('input[name="s5_price16[]"]').val(comma(vat+ppv));
		$(this).closest('tr').find('input[name="s5_price17[]"]').val(comma(total+ppt));
		
		$(this).closest('tr').find('input[name="s5_price3[]"]').val(comma(p+pp));
		$(this).closest('tr').find('input[name="s5_price4[]"]').val(comma(vat+ppv));
		$(this).closest('tr').find('input[name="s5_price5[]"]').val(comma(total+ppt));
	})
	
	$(document).on('keyup', 'input[name="s5_price12[]"], input[name="s5_price13[]"]', function() {
		
		var p1 = parseInt(uncomma($(this).closest('tr').find('input[name="s5_price12[]"]').val()));
		var p2 = parseInt(uncomma($(this).closest('tr').find('input[name="s5_price13[]"]').val()));
		var p3 = parseInt(uncomma($(this).closest('tr').find('input[name="s5_price11[]"]').val()));
		
		var total = 0;
		
		
		total = p3 - p1 -p2;
		
		p1 = p1 ? p1 : 0;
		p2 = p2 ? p2 : 0;
		
		$(this).closest('tr').find('input[name="s5_price14[]"]').val(comma(total));

	})
	
	$(document).on('keyup', '.name1', function() {
	$( this ).autocomplete({
			source : function( request, response ) {
				 $.ajax({
						type: 'post',
						url: "/_establishment/write/ajax.inc2.subcontract.php",
						dataType: "json",
						data: { value : request.term, type : 'search', code : $('#nw_code').val() },
						success: function(data) {
							response(
								$.map(data, function(item) {
									return {
										label: item.name,
										value: item.name,
										tel: item.tel,
										name: item.person_name,
										sdate : item.sdate,
										edate : item.edate,
										price : item.price,
										vat : item.vat,
										total_price : item.total_price,
										account : item.account,
										bank : item.bank,
										accname : item.accname,
										gongjong : item.gongjong,
										ceo : item.bname
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
				$(this).closest('tr').find('.price3').val(ui.item.price);
				$(this).closest('tr').find('.price4').val(ui.item.vat);
				$(this).closest('tr').find('.price5').val(ui.item.total_price);
				$(this).closest('tr').find('.sdate').val(ui.item.sdate);
				$(this).closest('tr').find('.edate').val(ui.item.edate);
				$(this).closest('tr').find('.gongjong').val(ui.item.gongjong);
				$(this).closest('tr').find('.bank').val(ui.item.bank);
				$(this).closest('tr').find('.account').val(ui.item.account);
				$(this).closest('tr').find('.accname').val(ui.item.accname);
				$(this).closest('tr').find('.ceo').val(ui.item.ceo);
				
			}
		});
    });
	
	
	$('#s1_add_row').bind('click', function() {
		var s = $('.row6').length + 1;
		
		
		
		var html ="";
		html += '<tr class="row6">';
		html += '<td class="column1 style37 null style38" colspan="2"><input type="text" name="s1_name[]" class="name1 input"></td>';
		html += '<td class="column3 style39 null"><input type="text" name="s1_gongjong[]" class="gongjong input"></td>';
		html += '<td class="column4 style40 null"><input type="text" name="s1_sdate[]" class="sdate input"></td>';
		html += '<td class="column5 style41 null"><input type="text" name="s1_edate[]" class="edate input"></td>';
		html += '<td class="column6 style42 null"><input type="text" name="s1_price1[]" class="price1 num input text-right" value="0"></td>';
		html += '<td class="column7 style43 null"><input type="text" name="s1_price2[]" class="price2 input num text-right"></td>';
		html += '<td class="column8 style44 null"><input type="text" name="s1_price3[]" class="price3 num input text-right" value="0"></td>';
		html += '<td class="column9 style45 null"><input type="text" name="s1_price4[]" class="price4 num input text-right" value="0"></td>';
		html += '<td class="column10 style46 null"><input type="text" name="s1_price5[]" class="price5 num input text-right" value="0"></td>';
		html += '<td class="column11 style47 null"><input type="text" name="s1_price6[]" class="price6 num input text-right"></td>';
		html += '<td class="column12 style45 null"><input type="text" name="s1_price7[]" class="price7 num input text-right" value="0"></td>';
		html += '<td class="column13 style48 null"><input type="text" name="s1_price8[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column14 style49 null"><input type="text" name="s1_price9[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column15 style50 null"><input type="text" name="s1_price10[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column16 style45 null"><input type="text" name="s1_price11[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column17 style45 null"><input type="text" name="s1_price12[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column18 style45 null"><input type="text" name="s1_price13[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column19 style51 null"><input type="text" name="s1_price14[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column20 style47 null"><input type="text" name="s1_price15[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column21 style45 null"><input type="text" name="s1_price16[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column22 style46 null"><input type="text" name="s1_price17[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column23 style52 null"><input type="text" name="s1_price18[]" class="price18 num input text-right" value="0"></td>';
		html += '<td class="column24 style53 null"><input type="text" name="s1_bank[]" class="bank input "></td>';
		html += '<td class="column25 style54 null"><input type="text" name="s1_account[]" class="account input "></td>';
		html += '<td class="column26 style55 null"><input type="text" name="s1_accname[]" class="accname input "></td>';
		html += '<td class="column26 style55 null"><input type="text" name="s1_ceo[]" class="ceo input "></td>';
		html += '<td class="column27 style56 null"><input type="text" name="s1_etc[]" class="input "></td>';
		html += '</tr>';
		
		$('#s1_add_line').append(html);
		$('#s1_add_tit').attr('rowspan', s);
	})
	
	$('#s2_add_row').bind('click', function() {
		var s = $('.row20').length + 1;
		
		
		
		var html ="";
		html += '<tr class="row20">';
		html += '<td class="column1 style37 null style38" colspan="2"><input type="text" name="s2_name[]" class="name1 input"></td>';
		html += '<td class="column3 style39 null"><input type="text" name="s2_gongjong[]" class="gongjong input"></td>';
		html += '<td class="column4 style40 null"><input type="text" name="s2_sdate[]" class="sdate input"></td>';
		html += '<td class="column5 style41 null"><input type="text" name="s2_edate[]" class="edate input"></td>';
		html += '<td class="column6 style42 null"><input type="text" name="s2_price1[]" class="price1 num input text-right" value="0"></td>';
		html += '<td class="column7 style43 null"><input type="text" name="s2_price2[]" class="price2 input num text-right" value="0"></td>';
		html += '<td class="column8 style44 null"><input type="text" name="s2_price3[]" class="price3 num input text-right" value="0"></td>';
		html += '<td class="column9 style45 null"><input type="text" name="s2_price4[]" class="price4 num input text-right" value="0"></td>';
		html += '<td class="column10 style46 null"><input type="text" name="s2_price5[]" class="price5 num input text-right" value="0"></td>';
		html += '<td class="column11 style47 null"><input type="text" name="s2_price6[]" class="price6 num input text-right" value="0"></td>';
		html += '<td class="column12 style45 null"><input type="text" name="s2_price7[]" class="price7 num input text-right" value="0"></td>';
		html += '<td class="column13 style48 null"><input type="text" name="s2_price8[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column14 style49 null"><input type="text" name="s2_price9[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column15 style50 null"><input type="text" name="s2_price10[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column16 style45 null"><input type="text" name="s2_price11[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column17 style45 null"><input type="text" name="s2_price12[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column18 style45 null"><input type="text" name="s2_price13[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column19 style51 null"><input type="text" name="s2_price14[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column20 style47 null"><input type="text" name="s2_price15[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column21 style45 null"><input type="text" name="s2_price16[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column22 style46 null"><input type="text" name="s2_price17[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column23 style52 null"><input type="text" name="s2_price18[]" class="price18 num input text-right" value="0"></td>';
		html += '<td class="column24 style53 null"><input type="text" name="s2_bank[]" class="bank input "></td>';
		html += '<td class="column25 style54 null"><input type="text" name="s2_account[]" class="account input "></td>';
		html += '<td class="column26 style55 null"><input type="text" name="s2_accname[]" class="accname input "></td>';
		html += '<td class="column26 style55 null"><input type="text" name="s2_ceo[]" class="ceo input "></td>';
		html += '<td class="column27 style56 null"><input type="text" name="s2_etc[]" class="input "></td>';
		html += '</tr>';
		
		$('#s2_add_line').append(html);
		$('#s2_add_tit').attr('rowspan', s);
	})
	
	$('#s3_add_row').bind('click', function() {
		var s = $('.row36').length + 1;
		
		
		
		var html ="";
		html += '<tr class="row36">';
		html += '<td class="column1 style37 null style38" colspan="2"><input type="text" name="s3_name[]" class="name1 input"></td>';
		html += '<td class="column3 style39 null"><input type="text" name="s3_gongjong[]" class="gongjong input"></td>';
		html += '<td class="column4 style40 null"><input type="text" name="s3_sdate[]" class="sdate input"></td>';
		html += '<td class="column5 style41 null"><input type="text" name="s3_edate[]" class="edate input"></td>';
		html += '<td class="column6 style42 null"><input type="text" name="s3_price1[]" class="price1 num input text-right" value="0"></td>';
		html += '<td class="column7 style43 null"><input type="text" name="s3_price2[]" class="price2 input num text-right" value="0"></td>';
		html += '<td class="column8 style44 null"><input type="text" name="s3_price3[]" class="price3 num input text-right" value="0"></td>';
		html += '<td class="column9 style45 null"><input type="text" name="s3_price4[]" class="price4 num input text-right" value="0"></td>';
		html += '<td class="column10 style46 null"><input type="text" name="s3_price5[]" class="price5 num input text-right" value="0"></td>';
		html += '<td class="column11 style47 null"><input type="text" name="s3_price6[]" class="price6 num input text-right" value="0"></td>';
		html += '<td class="column12 style45 null"><input type="text" name="s3_price7[]" class="price7 num input text-right" value="0"></td>';
		html += '<td class="column13 style48 null"><input type="text" name="s3_price8[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column14 style49 null"><input type="text" name="s3_price9[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column15 style50 null"><input type="text" name="s3_price10[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column16 style45 null"><input type="text" name="s3_price11[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column17 style45 null"><input type="text" name="s3_price12[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column18 style45 null"><input type="text" name="s3_price13[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column19 style51 null"><input type="text" name="s3_price14[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column20 style47 null"><input type="text" name="s3_price15[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column21 style45 null"><input type="text" name="s3_price16[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column22 style46 null"><input type="text" name="s3_price17[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column23 style52 null"><input type="text" name="s3_price18[]" class="price18 num input text-right" value="0"></td>';
		html += '<td class="column24 style53 null"><input type="text" name="s3_bank[]" class="bank input "></td>';
		html += '<td class="column25 style54 null"><input type="text" name="s3_account[]" class="account input "></td>';
		html += '<td class="column26 style55 null"><input type="text" name="s3_accname[]" class="accname input "></td>';
		html += '<td class="column26 style55 null"><input type="text" name="s3_ceo[]" class="ceo input "></td>';
		html += '<td class="column27 style56 null"><input type="text" name="s3_etc[]" class="input "></td>';
		html += '</tr>';
		
		$('#s3_add_line').append(html);
		$('#s3_add_tit').attr('rowspan', s);
	})
	
	$('#s4_add_row').bind('click', function() {
		var s = $('.row51').length + 1;
		
		
		
		var html ="";
		html += '<tr class="row51">';
		html += '<td class="column1 style37 null style38" colspan="2"><input type="text" name="s4_name[]" class="name1 input"></td>';
		html += '<td class="column3 style39 null"><input type="text" name="s4_gongjong[]" class="gongjong input"></td>';
		html += '<td class="column4 style40 null"><input type="text" name="s4_sdate[]" class="sdate input"></td>';
		html += '<td class="column5 style41 null"><input type="text" name="s4_edate[]" class="edate input"></td>';
		html += '<td class="column6 style42 null"><input type="text" name="s4_price1[]" class="price1 num input text-right" value="0"></td>';
		html += '<td class="column7 style43 null"><input type="text" name="s4_price2[]" class="price2 input num text-right" value="0"></td>';
		html += '<td class="column8 style44 null"><input type="text" name="s4_price3[]" class="price3 num input text-right" value="0"></td>';
		html += '<td class="column9 style45 null"><input type="text" name="s4_price4[]" class="price4 num input text-right" value="0"></td>';
		html += '<td class="column10 style46 null"><input type="text" name="s4_price5[]" class="price5 num input text-right" value="0"></td>';
		html += '<td class="column11 style47 null"><input type="text" name="s4_price6[]" class="price6 num input text-right" value="0"></td>';
		html += '<td class="column12 style45 null"><input type="text" name="s4_price7[]" class="price7 num input text-right" value="0"></td>';
		html += '<td class="column13 style48 null"><input type="text" name="s4_price8[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column14 style49 null"><input type="text" name="s4_price9[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column15 style50 null"><input type="text" name="s4_price10[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column16 style45 null"><input type="text" name="s4_price11[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column17 style45 null"><input type="text" name="s4_price12[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column18 style45 null"><input type="text" name="s4_price13[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column19 style51 null"><input type="text" name="s4_price14[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column20 style47 null"><input type="text" name="s4_price15[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column21 style45 null"><input type="text" name="s4_price16[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column22 style46 null"><input type="text" name="s4_price17[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column23 style52 null"><input type="text" name="s4_price18[]" class="price18 num input text-right" value="0"></td>';
		html += '<td class="column24 style53 null"><input type="text" name="s4_bank[]" class="bank input "></td>';
		html += '<td class="column25 style54 null"><input type="text" name="s4_account[]" class="account input "></td>';
		html += '<td class="column26 style55 null"><input type="text" name="s4_accname[]" class="accname input "></td>';
		html += '<td class="column26 style55 null"><input type="text" name="s4_ceo[]" class="ceo input "></td>';
		html += '<td class="column27 style56 null"><input type="text" name="s4_etc[]" class="input "></td>';
		html += '</tr>';
		
		$('#s4_add_line').append(html);
		$('#s4_add_tit').attr('rowspan', s);
	})
	
	$('#s5_add_row').bind('click', function() {
		var s = $('.row82').length + 1;
		
		
		
		var html ="";
		html += '<tr class="row82">';
		html += '<td class="column1 style37 null style38" colspan="2"><input type="text" name="s5_name[]" class="name1 input"></td>';
		html += '<td class="column3 style39 null"><input type="text" name="s5_gongjong[]" class="gongjong input"></td>';
		html += '<td class="column4 style40 null"><input type="text" name="s5_sdate[]" class="sdate input"></td>';
		html += '<td class="column5 style41 null"><input type="text" name="s5_edate[]" class="edate input"></td>';
		html += '<td class="column6 style42 null"><input type="text" name="s5_price1[]" class="price1 num input text-right" value="0"></td>';
		html += '<td class="column7 style43 null"><input type="text" name="s5_price2[]" class="price2 input num text-right" value="0"></td>';
		html += '<td class="column8 style44 null"><input type="text" name="s5_price3[]" class="price3 num input text-right" value="0"></td>';
		html += '<td class="column9 style45 null"><input type="text" name="s5_price4[]" class="price4 num input text-right" value="0"></td>';
		html += '<td class="column10 style46 null"><input type="text" name="s5_price5[]" class="price5 num input text-right" value="0"></td>';
		html += '<td class="column11 style47 null"><input type="text" name="s5_price6[]" class="price6 num input text-right" value="0"></td>';
		html += '<td class="column12 style45 null"><input type="text" name="s5_price7[]" class="price7 num input text-right" value="0"></td>';
		html += '<td class="column13 style48 null"><input type="text" name="s5_price8[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column14 style49 null"><input type="text" name="s5_price9[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column15 style50 null"><input type="text" name="s5_price10[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column16 style45 null"><input type="text" name="s5_price11[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column17 style45 null"><input type="text" name="s5_price12[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column18 style45 null"><input type="text" name="s5_price13[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column19 style51 null"><input type="text" name="s5_price14[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column20 style47 null"><input type="text" name="s5_price15[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column21 style45 null"><input type="text" name="s5_price16[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column22 style46 null"><input type="text" name="s5_price17[]" class="price8 num input text-right" value="0"></td>';
		html += '<td class="column23 style52 null"><input type="text" name="s5_price18[]" class="price18 num input text-right"></td>';
		html += '<td class="column24 style53 null"><input type="text" name="s5_bank[]" class="bank input "></td>';
		html += '<td class="column25 style54 null"><input type="text" name="s5_account[]" class="account input "></td>';
		html += '<td class="column26 style55 null"><input type="text" name="s5_accname[]" class="accname input "></td>';
		html += '<td class="column26 style55 null"><input type="text" name="s5_ceo[]" class="ceo input "></td>';
		html += '<td class="column27 style56 null"><input type="text" name="s5_etc[]" class="input "></td>';
		html += '</tr>';
		
		$('#s5_add_line').append(html);
		$('#s5_add_tit').attr('rowspan', s);
	})
});


 function comma(str) {
     str = String(str);
     return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
 }

 function uncomma(str) {
     str = String(str);
     return str.replace(/[^\d]+/g, '');
 }
 
 function removeComma() {
	$('.num').each(function() {
		$(this).val(uncomma($(this).val()));
		
	})
	
 }
 
 
function delete_row(seq, sort, el) {
	
if(confirm('즉시 삭제되며 복구하실 수 없습니다.\n\n삭제 후 페이지가 새로고침 됩니다.')) {
	$.post('/_establishment/write/ajax.inc2.delrow.php', { seq : seq }, function(data){ 
	
		if(data == 'y') {
			$('.dataRow_'+seq).remove();
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

