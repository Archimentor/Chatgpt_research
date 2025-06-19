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


 function comma(str) {
     str = String(str);
     return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
 }

 function uncomma(str) {
     str = String(str);
     return str.replace(/[^\d]+/g, '');
 }