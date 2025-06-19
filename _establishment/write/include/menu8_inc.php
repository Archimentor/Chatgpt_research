<?php if(!defined('menu_establishment')) exit;

include('./include/a_update_table.php');

$sql = "select * from {$none['est_concrete']} where nw_code = '{$work['nw_code']}' and  ne_date <= '{$date}' order by seq asc";
$rst = sql_query($sql);
$chk = sql_fetch($sql);
?>
<style>
.numb { text-align:right; padding-right:5px }
.bg_grey { background:#f2f2f2 !important}

.input-with-button {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
}
.input-with-button .input {
    flex-grow: 1;
    width: auto;
    min-width: 0;
}
.input-with-button .delete-icon {
    margin-left: 5px;
    flex-shrink: 0;
}
.deleted-row input { text-decoration: line-through; background-color: #fcecec !important; }

.delete-icon {
  cursor: pointer;
  color: #dc3545; /* 빨간색 */
  font-size: 14px;
}

/* --- 수정된 부분 --- */
/* ★★★ 인쇄 스타일 ★★★ */
@media print {
  /* 기존 삭제 버튼 숨기기 */
  .delete-icon {
    display: none !important;
  }

  /* 테이블 전체 폰트 크기 축소 및 줄바꿈 설정 */
  table.gridlines th,
  table.gridlines td {
    font-size: 10px !important; /* 글자 크기 줄이기 */
    padding: 3px 2px !important; /* 셀 내부 여백도 살짝 줄여 공간 확보 */
    white-space: normal !important; /* 내용이 길면 자동 줄바꿈 허용 */
    word-wrap: break-word !important;
  }

  /* Input 필드를 일반 텍스트처럼 보이게 처리 */
  td input[type="text"] {
    border: none !important;
    background-color: transparent !important;
    box-shadow: none !important;
    width: 100% !important;
    padding: 0 !important;
    margin: 0 !important;
    font-size: inherit !important; /* 셀의 폰트 크기를 상속받음 */
    text-align: right; /* 숫자 정렬 유지 */
    color: #000 !important; /* 글자색 검은색으로 고정 */
  }

  /* 첫번째 열(품명)의 input은 좌측 정렬 */
  td.column0 input[type="text"] {
    text-align: center;
  }
}
/* --- 여기까지 --- */
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


<form name="frm" action="./update/inc/menu8_update.php" enctype="multipart/form-data" method="post">
<input type="hidden" name="mode" value="<?php echo $mode?>">
<input type="hidden" name="nw_code" id="nw_code" value="<?php echo $work['nw_code']?>">
<input type="hidden" name="ne_date" value="<?php echo $date?>">
<div class="print_frm">
<table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines" style="width:100%; table-layout: fixed;">
        <col class="col0">
        <col class="col1">
        <col class="col2">
        <col class="col3">
        <col class="col4">
        <col class="col5">
        <col class="col6">
        <col class="col7">
        <col class="col8">
        <col class="col9">
        <col class="col10">
        <col class="col11">
        <col class="col12">
        <col class="col13">
        <col class="col14">
        <col class="col15">
        <tbody>
          <tr class="row0">
            <td class="column0 style1 s style1" colspan="16">철근 입고 현황</td>
          </tr>
          <tr class="row1">
            <td class="column0 style2 s">현장명 : </td>
            <td class="column1 style29 null style29" colspan="13"><?php echo $work['nw_subject']?></td>
            <td class="column14 style3 s style3" colspan="2">(부가세별도)</td>
          </tr>
          <tr class="row2">
            <td class="column0 style4 s style4 bg_grey" rowspan="2">품 명</td>
            <td class="column1 style4 s style4 bg_grey" rowspan="2">규 격</td>
            <td class="column2 style4 s style4 bg_grey" rowspan="2">단 위</td>
            <td class="column3 style4 s style4 bg_grey" colspan="3">도급현황</td>
            <td class="column6 style4 s style5 bg_grey" colspan="2">전회입고</td>
            <td class="column8 style6 s style8 bg_grey" colspan="3" style="border-left:2px solid #000 !important">금회입고</td>
            <td class="column11 style9 s style4 bg_grey" colspan="2">누계입고</td>
            <td class="column13 style4 s style4 bg_grey" colspan="2">잔량현황</td>
            <td class="column15 style4 s style4 bg_grey" rowspan="2">비 고</td>
          </tr>
          <tr class="row3">
            <td class="column3 style10 s bg_grey">수 량</td>
            <td class="column4 style10 s bg_grey">단 가</td>
            <td class="column5 style10 s bg_grey">금 액</td>
            <td class="column6 style10 s bg_grey">수 량 </td>
            <td class="column7 style11 s bg_grey">금 액</td>
            <td class="column8 style12 s bg_grey">수 량</td>
            <td class="column9 style10 s bg_grey">단 가</td>
            <td class="column10 style13 s bg_grey">금 액</td>
            <td class="column11 style14 s bg_grey">수 량</td>
            <td class="column12 style10 s bg_grey">금 액</td>
            <td class="column13 style10 s bg_grey">수 량</td>
            <td class="column14 style10 s bg_grey">금 액</td>
          </tr>

          <?php 
          for($i=0; $i<25; $i++) {
            $row = sql_fetch("select * from {$none['est_concrete']} where nw_code = '{$work['nw_code']}' and  ne_date <= '{$date}' and ne_type = '철근' order by ne_date asc limit $i, 1");
            $prev = sql_fetch("select * from {$none['est_concrete_price']} where concrete_id = '{$row['seq']}' and ne_date < '{$date}'");
            $row2 = sql_fetch("select * from {$none['est_concrete_price']} where concrete_id = '{$row['seq']}' and ne_date = '{$date}'");
            $ne_qty3_total = $prev['ne_qty3'] + $row2['ne_qty2'];
            $ne_price3_total = $prev['ne_price3'] + $row2['ne_price2'];
            $ne_qty4_total = $row['ne_qty1'] - $ne_qty3_total;
            $ne_price4_total = $row['ne_price1'] - $ne_price3_total;
          ?>
           <tr class="row4">
            <td class="column0 style10 null">
                <div class="input-with-button">
                    <input type="hidden" name="seq[]" value="<?php echo $row['seq']?>">
                    <input type="hidden" name="ne_type[]" value="철근">
                    <input type="hidden" name="delete_flag[]" value="0">
                    <input type="text" name="ne_name[]" class="input ne_name text-center" value="<?php echo $row['ne_name']?>">
                    <?php if ($row['seq']) { ?>
                    <span class="delete-icon" onclick="deleteRow(this)"><i class="fa fa-trash"></i></span>
                    <?php } ?>
                </div>
            </td>
            <td class="column1 style10 null"><input type="text" name="ne_standard[]" class="input ne_standard text-center" value="<?php echo $row['ne_standard']?>"></td>
            <td class="column2 style10 null"><input type="text" name="ne_unit[]" class="input ne_unit text-center" value="<?php echo $row['ne_unit']?>"></td>
            <td class="column3 style15 null"><input type="text" name="ne_qty1[]" class="input ne_qty1 text-right numb" value="<?php echo number_format($row['ne_qty1'])?>"></td>
            <td class="column4 style16 null"><input type="text" name="ne_danga1[]" class="input numb ne_danga1"  value="<?php echo number_format($row['ne_danga1'])?>"></td>
            <td class="column5 style16 null"><input type="text" name="ne_price1[]" class="input numb ne_price1"  value="<?php echo number_format($row['ne_price1'])?>"></td>
            <td class="column6 style15 null"><input type="text" name="prev_qty" readonly class="input prev_qty text-right" value="<?php echo number_format($prev['ne_qty3'])?>"></td>
            <td class="column7 style17 null"><input type="text" name="prev_price" readonly class="input numb prev_price" value="<?php echo number_format($prev['ne_price3'])?>"></td>
            <td class="column8 style18 null"><input type="text" name="ne_qty2[]" class="input  ne_qty2 text-right numb"  value="<?php echo number_format($row2['ne_qty2'])?>"></td>
            <td class="column9 style16 null"><input type="text" name="ne_danga2[]" class="input numb ne_danga2"  value="<?php echo number_format($row2['ne_danga2'])?>"></td>
            <td class="column10 style19 null"><input type="text" name="ne_price2[]" class="input numb ne_price2"  value="<?php echo number_format($row2['ne_price2'])?>"></td>
            <td class="column11 style20 null"><input type="text" name="ne_qty3[]" class="input ne_qty3 text-right numb" value="<?php echo number_format($ne_qty3_total) ?>"></td>
            <td class="column12 style16 null"><input type="text" name="ne_price3[]" class="input numb ne_price3" value="<?php echo number_format($ne_price3_total) ?>"></td>
            <td class="column13 style15 null"><input type="text" name="ne_qty4[]" class="input ne_qty4 text-right numb" value="<?php echo number_format($ne_qty4_total) ?>"></td>
            <td class="column14 style16 null"><input type="text" name="ne_price4[]" class="input numb ne_price4" value="<?php echo number_format($ne_price4_total) ?>"></td>
            <td class="column15 style10 null"><input type="text" name="ne_etc[]" class="input ne_etc"  value="<?php echo $row['ne_etc']?>"></td>
          </tr>
          <?php 
          }
          ?>
        </tbody>
</table>

<table border="0" cellpadding="0" cellspacing="0" id="sheet1" class="sheet0 gridlines" style="width:100%; margin-top: 40px; table-layout: fixed;">
    <col class="col0">
    <col class="col1">
    <col class="col2">
    <col class="col3">
    <col class="col4">
    <col class="col5">
    <col class="col6">
    <col class="col7">
    <col class="col8">
    <col class="col9">
    <col class="col10">
    <col class="col11">
    <col class="col12">
    <col class="col13">
    <col class="col14">
    <col class="col15">
    <tbody>
      <tr class="row0">
        <td class="column0 style1 s style1" colspan="16">레미콘 입고 현황</td>
      </tr>
      <tr class="row1">
        <td class="column0 style2 s">현장명 : </td>
        <td class="column1 style29 null style29" colspan="13"><?php echo $work['nw_subject']?></td>
        <td class="column14 style3 s style3" colspan="2">(부가세별도)</td>
      </tr>
      <tr class="row2">
        <td class="column0 style4 s style4 bg_grey" rowspan="2">품 명</td>
        <td class="column1 style4 s style4 bg_grey" rowspan="2">규 격</td>
        <td class="column2 style4 s style4 bg_grey" rowspan="2">단 위</td>
        <td class="column3 style4 s style4 bg_grey" colspan="3">도급현황</td>
        <td class="column6 style4 s style5 bg_grey" colspan="2">전회입고</td>
        <td class="column8 style6 s style8 bg_grey" colspan="3" style="border-left:2px solid #000 !important">금회입고</td>
        <td class="column11 style9 s style4 bg_grey" colspan="2">누계입고</td>
        <td class="column13 style4 s style4 bg_grey" colspan="2">잔량현황</td>
        <td class="column15 style4 s style4 bg_grey" rowspan="2">비 고</td>
      </tr>
      <tr class="row3">
        <td class="column3 style10 s bg_grey">수 량</td>
        <td class="column4 style10 s bg_grey">단 가</td>
        <td class="column5 style10 s bg_grey">금 액</td>
        <td class="column6 style10 s bg_grey">수 량 </td>
        <td class="column7 style11 s bg_grey">금 액</td>
        <td class="column8 style12 s bg_grey">수 량</td>
        <td class="column9 style10 s bg_grey">단 가</td>
        <td class="column10 style13 s bg_grey">금 액</td>
        <td class="column11 style14 s bg_grey">수 량</td>
        <td class="column12 style10 s bg_grey">금 액</td>
        <td class="column13 style10 s bg_grey">수 량</td>
        <td class="column14 style10 s bg_grey">금 액</td>
      </tr>

      <?php 
      for($i=0; $i<25; $i++) {
        $row = sql_fetch("select * from {$none['est_concrete']} where nw_code = '{$work['nw_code']}' and  ne_date <= '{$date}' and ne_type = '레미콘' order by ne_date asc limit $i, 1");
        $prev = sql_fetch("select * from {$none['est_concrete_price']} where concrete_id = '{$row['seq']}' and ne_date < '{$date}'");
        $row2 = sql_fetch("select * from {$none['est_concrete_price']} where concrete_id = '{$row['seq']}' and ne_date = '{$date}'");
        $ne_qty3_total = $prev['ne_qty3'] + $row2['ne_qty2'];
        $ne_price3_total = $prev['ne_price3'] + $row2['ne_price2'];
        $ne_qty4_total = $row['ne_qty1'] - $ne_qty3_total;
        $ne_price4_total = $row['ne_price1'] - $ne_price3_total;
      ?>
       <tr class="row4">
        <td class="column0 style10 null">
            <div class="input-with-button">
                <input type="hidden" name="seq[]" value="<?php echo $row['seq']?>">
                <input type="hidden" name="ne_type[]" value="레미콘">
                <input type="hidden" name="delete_flag[]" value="0">
                <input type="text" name="ne_name[]" class="input ne_name text-center" value="<?php echo $row['ne_name']?>">
                <?php if ($row['seq']) { ?>
                <span class="delete-icon" onclick="deleteRow(this)"><i class="fa fa-trash"></i></span>
                <?php } ?>
            </div>
        </td>
        <td class="column1 style10 null"><input type="text" name="ne_standard[]" class="input ne_standard text-center" value="<?php echo $row['ne_standard']?>"></td>
        <td class="column2 style10 null"><input type="text" name="ne_unit[]" class="input ne_unit text-center" value="<?php echo $row['ne_unit']?>"></td>
        <td class="column3 style15 null"><input type="text" name="ne_qty1[]" class="input ne_qty1 text-right numb" value="<?php echo number_format($row['ne_qty1'])?>"></td>
        <td class="column4 style16 null"><input type="text" name="ne_danga1[]" class="input numb ne_danga1"  value="<?php echo number_format($row['ne_danga1'])?>"></td>
        <td class="column5 style16 null"><input type="text" name="ne_price1[]" class="input numb ne_price1"  value="<?php echo number_format($row['ne_price1'])?>"></td>
        <td class="column6 style15 null"><input type="text" name="prev_qty" readonly class="input prev_qty text-right" value="<?php echo number_format($prev['ne_qty3'])?>"></td>
        <td class="column7 style17 null"><input type="text" name="prev_price" readonly class="input numb prev_price" value="<?php echo number_format($prev['ne_price3'])?>"></td>
        <td class="column8 style18 null"><input type="text" name="ne_qty2[]" class="input  ne_qty2 text-right numb"  value="<?php echo number_format($row2['ne_qty2'])?>"></td>
        <td class="column9 style16 null"><input type="text" name="ne_danga2[]" class="input numb ne_danga2"  value="<?php echo number_format($row2['ne_danga2'])?>"></td>
        <td class="column10 style19 null"><input type="text" name="ne_price2[]" class="input numb ne_price2"  value="<?php echo number_format($row2['ne_price2'])?>"></td>
        <td class="column11 style20 null"><input type="text" name="ne_qty3[]" class="input ne_qty3 text-right numb" value="<?php echo number_format($ne_qty3_total) ?>"></td>
        <td class="column12 style16 null"><input type="text" name="ne_price3[]" class="input numb ne_price3" value="<?php echo number_format($ne_price3_total) ?>"></td>
        <td class="column13 style15 null"><input type="text" name="ne_qty4[]" class="input ne_qty4 text-right numb" value="<?php echo number_format($ne_qty4_total) ?>"></td>
        <td class="column14 style16 null"><input type="text" name="ne_price4[]" class="input numb ne_price4" value="<?php echo number_format($ne_price4_total) ?>"></td>
        <td class="column15 style10 null"><input type="text" name="ne_etc[]" class="input ne_etc"  value="<?php echo $row['ne_etc']?>"></td>
      </tr>
      <?php 
      }
      ?>
    </tbody>
</table>

<script>
    function deleteRow(button) {
        const row = button.closest('tr');
        if (row) {
            const deleteFlagInput = row.querySelector('input[name="delete_flag[]"]');
            if(deleteFlagInput) {
                deleteFlagInput.value = '1';
            }
            row.classList.add('deleted-row');
            
            const iconSpan = button.closest('.delete-icon');
            if(iconSpan) {
                iconSpan.style.display = 'none';
            }
        }
    }

    document.forms['frm'].addEventListener('submit', function(event) {
        document.querySelectorAll('.numb, .ne_qty1, .ne_qty2, .ne_qty3, .ne_qty4').forEach(function(input) {
            if (input.value) {
                input.value = input.value.replace(/,/g, '');
            }
        });
    });

    document.querySelectorAll('.numb, .ne_qty1, .ne_qty2, .ne_qty3, .ne_qty4').forEach(function(input) {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/,/g, '');
            if (isNaN(value) || value.trim() === '') {
                e.target.value = '';
                return;
            }
            e.target.value = new Intl.NumberFormat().format(parseInt(value, 10));
        });
    });
</script>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" onclick="onPrint()" data-dismiss="modal">인쇄</button>
    <button type="submit" class="btn btn-primary" data-dismiss="modal">업데이트</button>
    <button type="button" class="btn btn-danger" data-dismiss="modal">목록</button>
</div>
</form>