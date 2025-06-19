<?php if(!defined('menu_establishment')) exit; ?>

<!-- A 소스의 폼 태그 제거 -->

<!-- A 소스의 숨겨진 입력 필드들 (B 소스의 폼 내에 포함) -->
<form name="statusForm" method="post">
    <input type="hidden" name="bo_table" value="<?php echo htmlspecialchars($row['bo_table'], ENT_QUOTES, 'UTF-8') ?>">
    <input type="hidden" name="nw_code" id="nw_code_a" value="<?php echo htmlspecialchars($row['nw_code'], ENT_QUOTES, 'UTF-8') ?>">
    <input type="hidden" name="ne_date" value="<?php echo htmlspecialchars($date, ENT_QUOTES, 'UTF-8') ?>">
    <input type="hidden" name="seq" value="<?php echo htmlspecialchars($row['seq'], ENT_QUOTES, 'UTF-8') ?>">
    <input type="hidden" name="current_page" value="<?php echo htmlspecialchars($index, ENT_QUOTES, 'UTF-8') ?>">
    
    <table style="width:100%;border-bottom:1px solid #ddd">
        <tr>
            <td style="border-top:1px solid #ccc;padding:15px">
                <div class="form-row">
                    <!-- 모든 페이지에서 버튼이 표시되도록 조건문 제거 -->
                    <div class="col-auto" style="margin-left:30px">
                       
                        <!-- 새로운 [기성청구서 작성완료(현장)] 버튼 -->
                        <button type="button" class="btn btn-warning mb-2" style="margin-right:10px;" onclick="location.href='./ajax.inc11.status.php?step=3&code=<?php echo urlencode($work['nw_code']) ?>&date=<?php echo urlencode($date) ?>'">기성청구서 작성완료(현장)</button>
                        
                        <!-- 새로운 [기성청구서 작성확인(본사)] 버튼 -->
                        <button type="button" class="btn btn-secondary mb-2" onclick="location.href='./ajax.inc11.status.php?step=4&code=<?php echo urlencode($work['nw_code']) ?>&date=<?php echo urlencode($date) ?>'">기성청구서 작성완료(본사)</button>
                        
                    </div>
                </div>
            </td>
        </tr>
    </table>
</form>