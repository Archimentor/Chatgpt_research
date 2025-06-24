diff --git a/_sign/list/menu2_list.php b/_sign/list/menu2_list.php
index 8e28915b5835e23949194f80b5c5370c54e4c8aa..d2bfd7b1c392e059123b679f66be6c032acfce1a 100644
--- a/_sign/list/menu2_list.php
+++ b/_sign/list/menu2_list.php
@@ -260,51 +260,51 @@ foreach (['sfl','stx','sst','sod','team','state'] as $p)
                                     결제완료
                                 </option>
                                 <option value="전결" <?php echo get_selected($state, '전결')?>>
                                     전결
                                 </option>
                                 <option value="반려" <?php echo get_selected($state, '반려')?>>
                                     반려
                                 </option>
                             </select>
 
                             <!-- 검색어 입력 -->
                             <input type="text" name="stx" value="<?php echo $stx?>"
                                 class="form-control" placeholder="전체검색"  >
                             <div class="input-group-append">
                                 <span class="input-group-text" id="search-mail">
                                     <i class="icon-magnifier"></i>
                                 </span>
                             </div>
                         </div>
                     </form>
                 </div>  
 
     <!-- ──────────────── 목록 테이블 ──────────────── -->
     <div class="body project_report">
         <div class="table-responsive">
-            <table class="table m-b-0 table-hover">
+            <table class="table m-b-0 table-hover mobile-card">
                 <thead class="thead-light">
                     <tr>
                         <th class="th-num">번호</th>
                         <th class="th-date">기안일자</th>
                         <th class="th-team">기안부서/현장</th>
                         <th class="th-subject">문서명</th>
                         <th class="th-company">업체명</th>
                         <th class="th-amount">결제금액</th>
                         <th class="th-appr">결재현황</th>
                         <th class="th-state">처리상태</th> 
                     </tr>
                 </thead>
                 <tbody>
 <?php
 for ($i = 0; $row = sql_fetch_array($result); $i++):
     $num = $total_count - ($page - 1) * $rows - $i;
 
     /* 댓글 수 */
     $cm_q   = sql_fetch("
         SELECT COUNT(*) AS cnt
           FROM {$none['sign_draft_comment']}
          WHERE ns_type = 2 AND ns_id = '{$row['seq']}'");
 $cm_cnt = (int)($cm_q['cnt'] ?? 0);
 
     /* 기안자 정보 */
diff --git a/_sign/list/menu2_list.php b/_sign/list/menu2_list.php
index 8e28915b5835e23949194f80b5c5370c54e4c8aa..d2bfd7b1c392e059123b679f66be6c032acfce1a 100644
--- a/_sign/list/menu2_list.php
+++ b/_sign/list/menu2_list.php
@@ -420,28 +420,49 @@ if ($total_count == 0):?>
 <?php endif;?>
                 </tbody>
             </table>
         </div>
     </div>
 
     <!-- 페이징 -->
     <?php
     echo get_paging_none(
         G5_IS_MOBILE ? ($config['cf_mobile_pages'] ?? 5) : ($config['cf_write_pages'] ?? 10),
         $page, $total_page,
         $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='
     );
     ?>
 </div>
 </div>
 </div>
 </div><!-- /#main-content -->
 
 <script>
 function payment(seq){
     if (confirm('대금지급을 완료하시겠습니까?')){
         location.href='../write/state2_list_update.php?seq='+seq;
     }
 }
-</script>
-
-<?php include_once(NONE_PATH.'/footer.php'); ?>
+</script>
+<script>
+$(function(){
+    $('.mobile-card').each(function(){
+        var headers=[];
+        $(this).find('thead th').each(function(){headers.push($(this).text().trim());});
+        $(this).find('tbody tr').each(function(){
+            $(this).find('td').each(function(i){
+                $(this).attr('data-label', headers[i]);
+            });
+        });
+    });
+});
+</script>
+<style>
+@media (max-width:768px){
+    .mobile-card thead{display:none;}
+    .mobile-card tbody tr{display:block;border:1px solid #ddd;border-radius:4px;margin-bottom:1rem;padding:.5rem;}
+    .mobile-card tbody td{display:flex;justify-content:space-between;padding:.25rem 0;}
+    .mobile-card tbody td::before{content:attr(data-label);font-weight:bold;}
+}
+</style>
+
+<?php include_once(NONE_PATH.'/footer.php'); ?>
