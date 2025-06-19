							<div class="row clearfix">
    <div class="col-lg-12">
      <div class="card">
        <div class="body">
          <div class="body table-responsive">
            <table class="table text-a-c">
              <thead>
               <col width="34" />
               <col width="30" span="7" />
               <col width="39" span="2" />
               <col width="30" span="2" />
               <col width="41" span="2" />
               <col width="43" span="2" />
               <col width="30" span="10" />
               <col width="32" span="2" />
              <tr>
                <td colspan="15" ><h1>공&nbsp;&nbsp;&nbsp;&nbsp;사&nbsp;&nbsp;&nbsp;&nbsp;일&nbsp;&nbsp;&nbsp;&nbsp;보</h1></td>
                <td rowspan="2" >결재</td>
                <td colspan="3"><button type="button" class="btn btn-secondary btn-sm">선택</button></td>
                <td colspan="3"><button type="button" class="btn btn-secondary btn-sm">선택</button></td>
                <td colspan="3"><button type="button" class="btn btn-secondary btn-sm">선택</button></td>
                <td colspan="3"><button type="button" class="btn btn-secondary btn-sm">선택</button></td>
              </tr>
              <tr>
                <td colspan="2" class="text-a-l"> ■  현 장 명  :</td>
                <td colspan="13" class="text-a-l"><?php echo $work['nw_subject']?></td>
                <td colspan="3" ></td>
                <td colspan="3" ></td>
                <td colspan="3" ></td>
                <td colspan="3" ></td>
              </tr>
              <tr>
                <td colspan="2" class="text-a-l">일 자 : </td>
                <td colspan="9" class="text-a-l"><?php echo date('Y년 m월 d일', strtotime($date))?> <?php echo get_yoil($date)?>요일  </td>
                <td colspan="2" class="text-a-l"> 날      씨 : 
				<select name="">
					<option value="맑음">맑음</option>
					<option value="흐림">흐림</option>
					<option value="비">비</option>
				</select>
				
				</td>
                <td colspan="2" class="text-a-l"> 공정률: <input type="text" name="" class="num">%</td>
                
                <td colspan="3" class="text-a-l">작성자 : <?php echo get_manager_txt($work['nw_ptype1_1'])?></td>
                <td colspan="10" class="text-a-r" style="text-align:right"></td>
              </tr>
                
              
         
                <tr class="xl-turquoise ">
                  <td colspan="19"  class="text-a-l"><b>⊙ 작 업 현 황</b></td>
                  <td colspan="9"  class="text-a-l"><b>⊙ 인 원 투 입 현 황 <span class="badge badge-danger">역순으로 입력하세요.</span></b> <a href="#defaultModal" data-toggle="modal" data-target="#defaultModal" class=" btn-primary btn-sm">공종추가</a></td>
                </tr>
                <tr class="xl-slategray">
                  <td colspan="12"><b>금 일  실 시  현 황</b></td>
                  <td colspan="7"><b>명일주요작업내용</b></td>
                  <td colspan="3"><b>공   종</b></td>
                  <td colspan="2"><b>전일</b></td>
                  <td colspan="2"><b>금일</b></td>
                  <td colspan="2"><b>누계</b></td>
                </tr>
                </thead>
                <tbody>
                <tr id="add_gongjong_box">
                  <td rowspan="2" class="rowspan" ></td>
                  <td colspan="11" rowspan="2" class="text-a-l today_box rowspan" style="vertical-align:top">
					<textarea name="today" id="today" class="textarea" placeholder="여기에 작성하세요."></textarea>
				  </td>
                  <td colspan="7" rowspan="2" class="rowspan" style="vertical-align:top"><textarea name="tomorrow" id="tomorrow" class="textarea" placeholder="여기에 작성하세요."></textarea></td>
                
                </tr>
				
               
                <tr >
                  <td colspan="3"><strong>계</strong></td>
                  <td colspan="2"><input type="text" name="yday_total[]" class="yday_total num2" value="0"></td>
                  <td colspan="2"><input type="text" name="tday_total[]" class="tday_total num2" value="0"></td>
                  <td colspan="2"><input type="text" name="total[]" class="total num2" value="0"></td>
                </tr>
                 <tr class="xl-turquoise ">
                  <td colspan="16" class="text-a-l"><b>⊙ 전일 자재 반입 현황</b> <a href="#defaultModal2" data-toggle="modal" data-target="#defaultModal2" class=" btn-primary btn-sm">자재추가</a></td>
                  <td colspan="12" class="text-a-l"><b>⊙ 장비 반입 현황</b> <a href="#defaultModal3" data-toggle="modal" data-target="#defaultModal3" class=" btn-primary btn-sm">장비추가</a></td>
                </tr>
                <tr >
                  <td colspan="3" rowspan="2"><b>품   명</b></td>
                  <td colspan="3" rowspan="2"><b>규  격</b></td>
                  <td colspan="2" rowspan="2"><b>단  위</b></td>
                  <td colspan="6"><b>수      량</b></td>
                  <td colspan="2" rowspan="2"><b>비    고</b></td>
                  <td colspan="4" rowspan="2"><b>장 비 명</b></td>
                  <td colspan="2" rowspan="2"><b>규 격</b></td>
                  <td colspan="6"><b>수     량</b></td>
                </tr>
                 <tr >
                  <td colspan="2"><b>전일</b></td>
                  <td colspan="2"><b>금일</b></td>
                  <td colspan="2"><b>누계</b></td>
                  <td colspan="2"><b>전일</b></td>
                  <td colspan="2"><b>금일</b></td>
                  <td colspan="2"><b>누계</b></td>
                </tr>
                <tr>
                  <td colspan="3" rowspan="4" >콘크리트</td>
                  <td colspan="3">25-240-15</td>
                  <td colspan="2" rowspan="4">M3</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> 329 </td>
                  <td>　</td>
                  <td>　</td>
                  <td colspan="4" >크레인</td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> 10.0 </td>
                </tr>
                <tr>
                  <td colspan="3">25-180-12</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td>　</td>
                  <td></td>
                  <td colspan="4" >지게차</td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> 16.0 </td>
                </tr>
                <tr>
                  <td colspan="3" > 몰   탈</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td>　</td>
                  <td></td>
                  <td colspan="4">펌프카</td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> 5.0 </td>
                </tr>
                <tr>
                  <td colspan="3">　</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td>　</td>
                  <td>　</td>
                  <td colspan="4">사다리차</td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td colspan="2"> 1.0 </td>
                  <td colspan="2"> 7.0 </td>
                </tr>
                <tr>
                  <td colspan="3" rowspan="6" >철  근</td>
                  <td colspan="2">HD</td>
                  <td>10</td>
                  <td colspan="2" rowspan="5">TON</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td>　</td>
                  <td>ton</td>
                  <td colspan="4">D/T</td>
                  <td colspan="2">폐기물</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> 9.0 </td>
                </tr>
                <tr>
                  <td colspan="2">HD</td>
                  <td>13</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td>　</td>
                  <td>ton</td>
                  <td colspan="4">B/H</td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> 6.0 </td>
                </tr>
                <tr>
                  <td colspan="2">HD</td>
                  <td>16</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td>　</td>
                  <td>ton</td>
                  <td colspan="4">　</td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                </tr>
                <tr>
                  <td colspan="2">HD</td>
                  <td>19</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td>　</td>
                  <td>ton</td>
                  <td colspan="4">　</td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                </tr>
                <tr>
                  <td colspan="2">HD</td>
                  <td>22</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td>　</td>
                  <td>ton</td>
                  <td colspan="4">　</td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                </tr>
                <tr>
                  <td colspan="3">계</td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td></td>
                  <td>　</td>
                  <td colspan="4">　</td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                </tr>
                <tr>
                  <td colspan="3" >시멘트벽돌</td>
                  <td colspan="3">190*90*57</td>
                  <td colspan="2">매</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td>　</td>
                  <td>　</td>
                  <td colspan="4">　</td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                </tr>
                <tr>
                  <td colspan="3" >시 멘 트</td>
                  <td colspan="3">40KG/포</td>
                  <td colspan="2">포</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td>　</td>
                  <td>　</td>
                  <td colspan="4">　</td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                </tr>
                <tr>
                  <td colspan="3" >모  래</td>
                  <td colspan="3">　</td>
                  <td colspan="2">ton</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td>　</td>
                  <td>　</td>
                  <td colspan="4">　</td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                </tr>
                <tr>
                  <td colspan="3" >4인치블럭</td>
                  <td colspan="3">　</td>
                  <td colspan="2">매</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td>　</td>
                  <td>　</td>
                  <td colspan="6"><strong>계</strong></td>
                  <td colspan="2"> - </td>
                  <td colspan="2"> 1.0 </td>
                  <td colspan="2"> 53.0 </td>
                </tr>
                <tr>
                  <td colspan="3" >6인치블럭</td>
                  <td colspan="3">　</td>
                  <td colspan="2">매</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td colspan="2" rowspan="3" >특이사항</td>
                  <td colspan="12" rowspan="3">　</td>
                </tr>
                <tr>
                  <td colspan="3" >8인치블럭</td>
                  <td colspan="3">　</td>
                  <td colspan="2">매</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                </tr>
                <tr>
                  <td colspan="3">　</td>
                  <td colspan="3">　</td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                  <td colspan="2">　</td>
                  <td colspan="2"> - </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
								