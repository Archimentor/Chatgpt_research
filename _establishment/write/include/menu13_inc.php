<?php if(!defined('menu_establishment')) exit;
/*
$sql = "select * from {$none['est_material']} where nw_code = '{$work['nw_code']}' and  ne_date = '{$date}' order by seq asc";
$rst = sql_query($sql);
$chk = sql_fetch($sql);
*/

include('./include/a_update_table.php');
include('./include/file_upload_table.php');
?>

<style>
.numb { text-align:right; padding-right:5px }
.bg_grey { background:#f2f2f2 !important}
.text-right {  padding-right:5px !important}
</style>
<form name="frm" action="./update/inc/menu13_update.php" enctype="multipart/form-data" method="post">
<input type="hidden" name="mode" value="<?php echo $mode?>">
<input type="hidden" name="nw_code" id="nw_code" value="<?php echo $work['nw_code']?>">
<input type="hidden" name="ne_date" value="<?php echo $date?>">


<div class="print_frm">
<table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines" style="width:1300px;margin-top:30px">
        <col class="col0">
        <col class="col1">
        <col class="col2">
        <col class="col3">
        <tbody>
          <tr class="row0">
            <td class="column0 style17 s style17" colspan="6">특  기  사  항</td>
            
          </tr>
          <tr class="row1">
            <td class="column0 style9 s" colspan="6">현장명 : <?php echo $work['nw_subject']?> </td>
        
            
          </tr>
          <tr class="row2">
            <td class="column0 style19 s style19" colspan="6">■원도급 특기사항</td>
            
          </tr>
          <tr class="row3">
            <td class="column0 style12 s style12 bg_grey" colspan="2">구   분</td>
            <td class="column2 style12 s style12 bg_grey" colspan="3">특기사항</td>
            <td class="column5 style16 s bg_grey">비고</td>
            
          </tr>
          <tr class="row4">
            <td class="column0 style12 s style12 bg_grey" colspan="2" rowspan="4">내   용</td>
            <td class="column2 style15 null style15" colspan="3"><input type="text" name="ne_won_detail[]" class="input"></td>
            <td class="column5 style14 null" style="width:100px"><input type="text" name="ne_won_etc[]" class="input" ></td>
    
          </tr>
          <tr class="row5">
            <td class="column2 style15 null style15" colspan="3"><input type="text" name="ne_won_detail[]" class="input"></td>
            <td class="column5 style14 null" style="width:100px"><input type="text" name="ne_won_etc[]" class="input" ></td>
         
          </tr>
          <tr class="row6">
          <td class="column2 style15 null style15" colspan="3"><input type="text" name="ne_won_detail[]" class="input"></td>
            <td class="column5 style14 null" style="width:100px"><input type="text" name="ne_won_etc[]" class="input" ></td>
            
          </tr>
          <tr class="row7">
           <td class="column2 style15 null style15" colspan="3"><input type="text" name="ne_won_detail[]" class="input"></td>
            <td class="column5 style14 null" style="width:100px"><input type="text" name="ne_won_etc[]" class="input" ></td>
            
          </tr>
          <tr class="row8">
            <td class="column0 style20 s style20" colspan="6">■투입내역 특기사항</td>
            
          </tr>
          <tr class="row9">
            <td class="column0 style1 s bg_grey">구 분</td>
            <td class="column1 style1 s bg_grey">업 체 명</td>
            <td class="column2 style1 s bg_grey">공  종</td>
            <td class="column3 style1 s bg_grey">금액<small>(부가세포함)</small></td>
            <td class="column4 style1 s bg_grey">특   기   사   항</td>
            <td class="column5 style1 s bg_grey">비 고</td>
            
          </tr>
          <tr class="row10">
            <td class="column0 style6 s style4 bg_grey" rowspan="5">외주비</td>
            <td class="column1 style8 null"><input type="text" name="ne_info1_upche[]" class="input"></td>
            <td class="column2 style8 null"><input type="text" name="ne_info1_gongjong[]" class="input"></td>
            <td class="column3 style7 null"><input type="text" name="ne_info1_price[]" class="input"></td>
            <td class="column4 style2 null"><input type="text" name="ne_info1_detail[]" class="input"></td>
            <td class="column5 style1 null"><input type="text" name="ne_info1_etc[]" class="input"></td>
            
          </tr>
          <tr class="row11">
            <td class="column1 style8 null"><input type="text" name="ne_info1_upche[]" class="input"></td>
            <td class="column2 style8 null"><input type="text" name="ne_info1_gongjong[]" class="input"></td>
            <td class="column3 style7 null"><input type="text" name="ne_info1_price[]" class="input"></td>
            <td class="column4 style2 null"><input type="text" name="ne_info1_detail[]" class="input"></td>
            <td class="column5 style1 null"><input type="text" name="ne_info1_etc[]" class="input"></td>
            
          </tr>
          <tr class="row12">
            <td class="column1 style8 null"><input type="text" name="ne_info1_upche[]" class="input"></td>
            <td class="column2 style8 null"><input type="text" name="ne_info1_gongjong[]" class="input"></td>
            <td class="column3 style7 null"><input type="text" name="ne_info1_price[]" class="input"></td>
            <td class="column4 style2 null"><input type="text" name="ne_info1_detail[]" class="input"></td>
            <td class="column5 style1 null"><input type="text" name="ne_info1_etc[]" class="input"></td>
            
          </tr>
          <tr class="row13">
            <td class="column1 style8 null"><input type="text" name="ne_info1_upche[]" class="input"></td>
            <td class="column2 style8 null"><input type="text" name="ne_info1_gongjong[]" class="input"></td>
            <td class="column3 style7 null"><input type="text" name="ne_info1_price[]" class="input"></td>
            <td class="column4 style2 null"><input type="text" name="ne_info1_detail[]" class="input"></td>
            <td class="column5 style1 null"><input type="text" name="ne_info1_etc[]" class="input"></td>
            
          </tr>
          <tr class="row14">
            <td class="column1 style8 null"><input type="text" name="ne_info1_upche[]" class="input"></td>
            <td class="column2 style8 null"><input type="text" name="ne_info1_gongjong[]" class="input"></td>
            <td class="column3 style7 null"><input type="text" name="ne_info1_price[]" class="input"></td>
            <td class="column4 style2 null"><input type="text" name="ne_info1_detail[]" class="input"></td>
            <td class="column5 style1 null"><input type="text" name="ne_info1_etc[]" class="input"></td>
            
          </tr>
          <tr class="row15">
            <td class="column0 style6 s style4 bg_grey" rowspan="4">자재비</td>
            <td class="column1 style8 null"><input type="text" name="ne_info2_upche[]" class="input"></td>
            <td class="column2 style8 null"><input type="text" name="ne_info2_gongjong[]" class="input"></td>
            <td class="column3 style7 null"><input type="text" name="ne_info2_price[]" class="input"></td>
            <td class="column4 style2 null"><input type="text" name="ne_info2_detail[]" class="input"></td>
            <td class="column5 style1 null"><input type="text" name="ne_info2_etc[]" class="input"></td>
            
          </tr>
          <tr class="row16">
             <td class="column1 style8 null"><input type="text" name="ne_info2_upche[]" class="input"></td>
            <td class="column2 style8 null"><input type="text" name="ne_info2_gongjong[]" class="input"></td>
            <td class="column3 style7 null"><input type="text" name="ne_info2_price[]" class="input"></td>
            <td class="column4 style2 null"><input type="text" name="ne_info2_detail[]" class="input"></td>
            <td class="column5 style1 null"><input type="text" name="ne_info2_etc[]" class="input"></td>
            
          </tr>
          <tr class="row17">
             <td class="column1 style8 null"><input type="text" name="ne_info2_upche[]" class="input"></td>
            <td class="column2 style8 null"><input type="text" name="ne_info2_gongjong[]" class="input"></td>
            <td class="column3 style7 null"><input type="text" name="ne_info2_price[]" class="input"></td>
            <td class="column4 style2 null"><input type="text" name="ne_info2_detail[]" class="input"></td>
            <td class="column5 style1 null"><input type="text" name="ne_info2_etc[]" class="input"></td>
            
          </tr>
          <tr class="row18">
            <td class="column1 style8 null"><input type="text" name="ne_info2_upche[]" class="input"></td>
            <td class="column2 style8 null"><input type="text" name="ne_info2_gongjong[]" class="input"></td>
            <td class="column3 style7 null"><input type="text" name="ne_info2_price[]" class="input"></td>
            <td class="column4 style2 null"><input type="text" name="ne_info2_detail[]" class="input"></td>
            <td class="column5 style1 null"><input type="text" name="ne_info2_etc[]" class="input"></td>
            
          </tr>
          <tr class="row19">
            <td class="column0 style6 s style4 bg_grey" rowspan="3">장비비</td>
            <td class="column1 style8 null"><input type="text" name="ne_info3_upche[]" class="input"></td>
            <td class="column2 style8 null"><input type="text" name="ne_info3_gongjong[]" class="input"></td>
            <td class="column3 style7 null"><input type="text" name="ne_info3_price[]" class="input"></td>
            <td class="column4 style2 null"><input type="text" name="ne_info3_detail[]" class="input"></td>
            <td class="column5 style1 null"><input type="text" name="ne_info3_etc[]" class="input"></td>
            
          </tr>
          <tr class="row20">
            <td class="column1 style8 null"><input type="text" name="ne_info3_upche[]" class="input"></td>
            <td class="column2 style8 null"><input type="text" name="ne_info3_gongjong[]" class="input"></td>
            <td class="column3 style7 null"><input type="text" name="ne_info3_price[]" class="input"></td>
            <td class="column4 style2 null"><input type="text" name="ne_info3_detail[]" class="input"></td>
            <td class="column5 style1 null"><input type="text" name="ne_info3_etc[]" class="input"></td>
            
          </tr>
          <tr class="row21">
            <td class="column1 style8 null"><input type="text" name="ne_info3_upche[]" class="input"></td>
            <td class="column2 style8 null"><input type="text" name="ne_info3_gongjong[]" class="input"></td>
            <td class="column3 style7 null"><input type="text" name="ne_info3_price[]" class="input"></td>
            <td class="column4 style2 null"><input type="text" name="ne_info3_detail[]" class="input"></td>
            <td class="column5 style1 null"><input type="text" name="ne_info3_etc[]" class="input"></td>
            
          </tr>
          <tr class="row22">
            <td class="column0 style6 s style4 bg_grey" rowspan="2">노무비</td>
            <td class="column1 style8 null"><input type="text" name="ne_info3_upche[]" class="input"></td>
            <td class="column2 style8 null"><input type="text" name="ne_info3_gongjong[]" class="input"></td>
            <td class="column3 style7 null"><input type="text" name="ne_info3_price[]" class="input"></td>
            <td class="column4 style2 null"><input type="text" name="ne_info3_detail[]" class="input"></td>
            <td class="column5 style1 null"><input type="text" name="ne_info3_etc[]" class="input"></td>
            
          </tr>
          <tr class="row23">
             <td class="column1 style8 null"><input type="text" name="ne_info3_upche[]" class="input"></td>
            <td class="column2 style8 null"><input type="text" name="ne_info3_gongjong[]" class="input"></td>
            <td class="column3 style7 null"><input type="text" name="ne_info3_price[]" class="input"></td>
            <td class="column4 style2 null"><input type="text" name="ne_info3_detail[]" class="input"></td>
            <td class="column5 style1 null"><input type="text" name="ne_info3_etc[]" class="input"></td>
            
          </tr>
          <tr class="row24">
            <td class="column0 style6 s style4 bg_grey" rowspan="3">기타<br>경비</td>
             <td class="column1 style8 null"><input type="text" name="ne_info4_upche[]" class="input"></td>
            <td class="column2 style8 null"><input type="text" name="ne_info4_gongjong[]" class="input"></td>
            <td class="column3 style7 null"><input type="text" name="ne_info4_price[]" class="input"></td>
            <td class="column4 style2 null"><input type="text" name="ne_info4_detail[]" class="input"></td>
            <td class="column5 style1 null"><input type="text" name="ne_info4_etc[]" class="input"></td>
            
          </tr>
          <tr class="row25">
            <td class="column1 style8 null"><input type="text" name="ne_info4_upche[]" class="input"></td>
            <td class="column2 style8 null"><input type="text" name="ne_info4_gongjong[]" class="input"></td>
            <td class="column3 style7 null"><input type="text" name="ne_info4_price[]" class="input"></td>
            <td class="column4 style2 null"><input type="text" name="ne_info4_detail[]" class="input"></td>
            <td class="column5 style1 null"><input type="text" name="ne_info4_etc[]" class="input"></td>
            
          </tr>
          <tr class="row26">
            <td class="column1 style8 null"><input type="text" name="ne_info4_upche[]" class="input"></td>
            <td class="column2 style8 null"><input type="text" name="ne_info4_gongjong[]" class="input"></td>
            <td class="column3 style7 null"><input type="text" name="ne_info4_price[]" class="input"></td>
            <td class="column4 style2 null"><input type="text" name="ne_info4_detail[]" class="input"></td>
            <td class="column5 style1 null"><input type="text" name="ne_info4_etc[]" class="input"></td>
            
          </tr>
        </tbody>
    </table>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" onclick="onPrint()" data-dismiss="modal">인쇄</button>
		<button type="submit" class="btn btn-primary"data-dismiss="modal">업데이트</button>
		<button type="button" class="btn btn-danger" data-dismiss="modal">목록</button>
	</div>
	</form>