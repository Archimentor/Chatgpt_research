var util = {
	init : function() {
	},
	alertWsize : function() {
		alert( $(window).width() + " / " + $(window).height() );
		// 媛ㅽ꺆 768 * 896
	},
	isPC : function() {
		var filter = "win16|win32|win64|mac|macintel";
		if ( navigator.platform ) {
			if ( filter.indexOf( navigator.platform.toLowerCase() ) < 0 ) {
				return false;
			} else {
				return true;
			}
		}
	},
	isIOS : function() {
		var varUA = navigator.userAgent.toLowerCase();
		if (varUA.indexOf("iphone")>-1||varUA.indexOf("ipad")>-1||varUA.indexOf("ipod")>-1) {
			return true;
		} else {
			return false;
		}
	},
	isAND : function() {
		var varUA = navigator.userAgent.toLowerCase();
		if (varUA.match('android') != null) {
			return true;
		} else {
			return false;
		}
	},
	isNull : function( $obj ) {
		if ( typeof $obj != "undefined" && $obj != null && $obj != "" ) {
			return false;
		} else {
			return true;
		}
	},
	Eraser : function( $obj, type ) {
		if ( type == "hide" ) {
			$obj.hide();
		} else if ( type != "hide" ) {
			$obj.addClass( type );
		}
	},
	conBottomEraser : function( $obj ) {
		$obj.css({ "padding-bottom":0, "margin-bottom":0 });
	},
	getQueryStr : function( paramName ) {
		var _tempUrl = window.location.search.substring(1);	// ** url�먯꽌 泥섏쓬遺��� ? �쒖쇅 uri
		var returnVal = "";
		if ( _tempUrl == "" ) {
			returnVal = "fail";
		} else if ( _tempUrl.indexOf("&") >= 0 || _tempUrl.indexOf("?") >= 0 ) {
			var _tempArray = _tempUrl.split("&");
			for ( var i=0; i<_tempArray.length; i++ ) {
				var _keyValuePair = _tempArray[i].split("=");
				if ( _keyValuePair[0] == paramName ) {
					returnVal = _keyValuePair[1];
				}
			}
		} else {
			var _tempArray = _tempUrl.split("=");
			if ( _tempArray[0] == paramName )	returnVal = _tempArray[1];
		}
		return returnVal;
	},
	isLang : function() {
		$pageUri = location.href;
		if ( $pageUri.indexOf("/kor/") > 0 ) return "kor";
		else if ( $pageUri.indexOf("/eng/") > 0 ) return "eng";
	},
	getNumberOnly : function(str_txt) {
		val = new String(str_txt);
		var regex = /[^0-9]/g;
		val = val.replace(regex, '');
		return val;
	},
	getHash : function() {
		if (window.location.hash) {
			var hashVal = "";
			var hash = window.location.hash.substring(1);
			if (hash.length === 0) {
				return false;
			} else {
				if ( hash.indexOf("&") >=0 ) {
					hashVal = hash.split("&")[0];
				} else {
					hashVal = hash;
				}
				return hashVal;
			}
		} else {
			return false;
		}
	},
	frontEndTrimming : function( s ) {
		s += ''; // �レ옄�쇰룄 臾몄옄�대줈 蹂���
		return s.replace(/^\s*|\s*$/g, '');
	},
	convertTimestamp : function( $obj ) {	// ** ���꾩뒪�ы봽 �뺤떇�쇰줈 蹂�寃�.
		var dateTmp;
		var convertTimeStamp;
		if ( typeof $obj == "object" ) {
			var cArrayIdx = 0;
			var convertResult = new Array();
			$.each( $obj, function( index, item ) {
				if(item != null){
					dateTmp = item.split("-");
					convertTimeStamp = dateTmp[1] + "/" + dateTmp[2] + "/" + dateTmp[0];
					convertResult[cArrayIdx] = new Date( convertTimeStamp ).getTime();
					cArrayIdx++;
				}
			});
		} else if ( typeof $obj == "string" ) {
			var convertResult = "";
			dateTmp = $obj.split("-");
			convertTimeStamp = dateTmp[1] + "/" + dateTmp[2] + "/" + dateTmp[0];
			convertResult = new Date( convertTimeStamp ).getTime();
		}
		return convertResult;
	},
	convertDatestring : function( $str ) {	// ** 2019-10-21 �뺤떇�쇰줈 蹂�寃�.
		var d = new Date( $str );
		var s = util.leadingZeros(d.getFullYear(), 4) + "-" + util.leadingZeros(d.getMonth() + 1, 2) + "-" + util.leadingZeros(d.getDate(), 2);
		return s;
	},
	leadingZeros : function( n, digits ) {	// ** 由щ뵫�쒕줈 �뺤떇�쇰줈 蹂�寃�.
		var zero = '';
		n = n.toString();
		if ( n.length < digits ) {
			for ( i=0; i<digits-n.length; i++ )	zero += '0';
		}
		return zero + n;
	}
}


$(function() {
	tabMenu.getTabState();
	tabMenu.mTabCast();
	//tabMenu.mTabAbtnCast();
});
var cWidth = $(window).width();
$(window).resize(function() {
	if ( cWidth != $(window).width() ) {
		tabMenu.getTabState();
		cWidth = $(window).width();
	}
});
var tabMenu = {
	init : function() {
	},
	getTabState : function() {
		var thiss = this;
		if ( $(window).width() <= 800 ) {
			if ( $("body .c-tab01").length >= 1 ) {
				$("body .c-tab01").each(function() {
					thiss.setMtab( $(this), "set" );
				});
			} else {
				$("body .c-tab01").addClass("mSpredCtab");
			}


			if ( $("body .c-tab02").length >= 1 ) {
				$("body .c-tab02").each(function() {
					// thiss.setMtab( $(this), "set" );
				});
			} else {
				// $("body .c-tab02").addClass("mSpredCtab");
			}

			if ( $("body .hasManualTab1 > ul > li").length > 4 ) {
				$("body .hasManualTab1").each(function() {
					// thiss.setMtab( $(this), "set" );
				});
			} else {
				// $("body .hasManualTab1").addClass("mSpredCtab");
			}
		} else if ( $(window).width() > 800 ) {
			$("body .c-tab01").each(function() {
				thiss.setMtab( $(this), "release" );
			});
			$("body .c-tab02").each(function() {
				// thiss.setMtab( $(this), "release" );
			});
			$("body .hasManualTab1").each(function() {
				// thiss.setMtab( $(this), "release" );
			});
		}
	},
	setMtab : function( $obj, action ) {
		var cTabType = $obj.attr("class").split(" ")[0];
		var num = util.getNumberOnly( cTabType );

		var txt = $("> ul > li.over > a span", $obj ).text();

		if ( action == "set" ) {
			$obj.addClass("mSet");
			if ( $obj.find(".ctab" + num + "Ctrl").length <= 0 ) {
				$obj.prepend("<button class='ctab" + num + "Ctrl'><span>" + txt + "</span></button>");
			} else {
				$obj.find(".ctab" + num + "Ctrl").removeClass("over");
			}
			$("ul", $obj).hide();
		} else if ( action == "release" ) {
			$obj.removeClass("mSet mSpredCtab");
			if ( $obj.find(".ctab" + num + "Ctrl").length >= 1 ) {
				$obj.find(".ctab" + num + "Ctrl").remove();
			}
			$("ul", $obj).show();
		}
	},
	mTabCast : function() {
		$(document).on("click", ".mSet > button", function( e ) {
			if ( e.which ) {
				var thisb = $(this);
				$tabUL = $(this).next();
				if ( $(this).hasClass("over") ) {
					$(this).removeClass("over");
					$tabUL.slideUp();
				} else {
					$(this).addClass("over");
					$tabUL.slideDown();
				}
				$(".mSet").each(function() {
					$notThisb = $(".mSet > button").not( thisb );
					if ( $notThisb.hasClass("over") ) {
						$notThisb.removeClass("over");
						$notThisb.next().slideUp();
					}
				});
			}
		});
		$(document).on("click", ".mSet > ul > li > a", function() {
			console.log( "1" );
			$txtMsg = $("span", $(this) ).text();
			$(this).closest("ul").prev().find("span").text( $txtMsg );
			$(this).closest("ul").slideUp();
			$(this).closest("ul").prev().removeClass("over");
		});
	},
	mTabAbtnCast : function(){
		var mTabAbtn = $(".mSet > ul > li > a");
		mTabAbtn.on("click", function() {
			console.log( "2" );
			$(this).closest("ul").prev().removeClass("over");
			$(this).closest("ul").slideUp();
		});
	}
}


;(function($) {


	$.fn.multiTab_fwidth=function(o){

		o = $.extend({wrap:null,height:30,line_limit:6}, o||{});


		return this.each(function(){
			var Timer = null;
			var $this = $(this),$wrap = $(".this-wrap",$this),$ul=$("ul",$this),$li = $("li",$this);
			var $a=$("a",$li);

			var vcount = 0 , vpage = 0, pg = 0;

			var btnNext = $(".btn-next",$this);var btnPrev = $(".btn-prev",$this);


			//wrap 사이즈, 전체 가로폭 (양 사이드 버튼 2개 크기 제외 : 30px로 초기화)
			//가로폭에따라 한페이지에 li 갯수, width 결정
			var wrap_width = $this.width();
			getPageCount();




			if($wrap.length<1){
				$ul.wrap("<div class='this-wrap'/>");
				$wrap = $(".this-wrap",$this);
			}
			$wrap.css({"position":"relative","top":0,"margin":"0 auto","overflow":"hidden","height":wrap_height});
			$wrap.width(wrap_width);

			$ul.css({"position":"absolute","left":0,"top":0,"overflow":"hidden","height":wrap_height});
			$ul.width(wrap_width);



			//페이지 수다시 계산
			getPages();
			if(vpage ==1 && $li.length < vcount) vcount = $li.length;

			var wrap_height =vpage *  o.height;
			$wrap.height(wrap_height);
			$ul.height(wrap_height);



			$ul.width(vpage * wrap_width);
			var li_w = Math.floor(wrap_width / vcount);
			var li_w2 = wrap_width - ( li_w * (vcount-1));


			if($this.attr("o_vpage")!=vpage || $this.attr("o_vcount")!=vcount || $this.attr("liw")!=li_w ){




				$li.each(function(){
					var i = $(this).index() +1 ;
					var this_pg = Math.ceil( i/ vcount) ;

					var totop = (this_pg-1) * o.height;			var toleft = $(this).index() * li_w - ((this_pg-1)*(vcount * li_w));
					var to_w = li_w ;if(i%vcount==0) to_w = li_w2;
					$(this).css({"position":"absolute",left:toleft,top:totop,"overflow":"hidden","float":"","height":o.height,"overflow":"hidden","width":to_w});

					//페이지별 첫번째 li 에는 배경 없애기
					if(i%vcount==1) {
						$(this).addClass("first");
					}else{
						$(this).removeClass("first");
					}

					if(this_pg==1) {
						$(this).addClass("first-row");
					}else{
						$(this).removeClass("first-row");
					}

					if(this_pg==vpage) {
						$(this).addClass("last-row");
					}else{
						$(this).removeClass("last-row");
					}
				});

				$this.attr("o_vpage",vpage);
				$this.attr("o_vcount",vcount);
				$this.attr("liw",li_w);

				var initOver =  ($("li.over",$this).length>0)? Math.ceil(($("li.over",$this).index() + 1)/vcount) : 1;
				goPage(initOver);

			}

			$a.unbind("focus");
			$a.bind("focus",function(){
				var n = $($(this).parents("li").get(0)).index();
				var this_pg = Math.ceil((n+1)/vcount);
				goPageFix(this_pg);

			});
			$(btnNext).unbind("click");
			$(btnPrev).unbind("click");
			$(btnNext).click(function(){	goNext();	});
			$(btnPrev).click(function(){	goPrev();	});

			function getPages(){
				vpage = Math.ceil($li.length / vcount);
			}
			function getPageCount(){
				vcount = o.line_limit;
			}

			function goPage(n){

				//if(pg!=n){

				pg = n;
				return;

			}
			function goPageFix(n){

				//if(pg!=n){
				pg = n;
				return;



			}
			function goNext(){
				var goPg = pg+1;
				if(goPg>vpage) goPg = 1;

				goPage(goPg);

			}
			function goPrev(){
				var goPg = pg-1;
				if(goPg<1) goPg = vpage;

				goPage(goPg);

			}


		});

	}
	$.fn.multiTab_auto=function(o){

		o = $.extend({wrap:null,height:30,line_limit:6,showCtrlBtns:false,btnNext:null,btnPrev:null,ctrlBtnWidth:30}, o||{});


		return this.each(function(){
			var Timer = null;
			var $this = $(this),$wrap = $(".this-wrap",$this),$ul=$("ul",$this),$li = $("li",$this);
			var $a=$("a",$li);

			var vcount = 0 , vpage = 0, pg = 0;

			var btnNext = $(".btn-next",$this);var btnPrev = $(".btn-prev",$this);

			if(o.showCtrlBtns){
				if(btnPrev.length<1){
					$this.append("<button class='btn-prev'><span class='blind'>이전</span></button>");
					 btnPrev = $(".btn-prev",$this);
				}

				if(btnNext.length<1){
					$this.append("<button class='btn-next'><span class='blind'>다음</span></button>");
					 btnNext = $(".btn-next",$this);
				}

				btnPrev.css({"position":"absolute","left":0,"top":0});
				btnNext.css({"position":"absolute","right":0,"top":0});
			}

			//wrap 사이즈, 전체 가로폭 (양 사이드 버튼 2개 크기 제외 : 30px로 초기화)
			//가로폭에따라 한페이지에 li 갯수, width 결정
			var wrap_width = $this.width();
			getPageCount();

			var wrap_height = o.height;

			if($wrap.length<1){
				$ul.wrap("<div class='this-wrap'/>");
				$wrap = $(".this-wrap",$this);
			}
			$wrap.css({"position":"relative","top":0,"margin":"0 auto","overflow":"hidden","height":wrap_height});
			$wrap.width(wrap_width);

			$ul.css({"position":"absolute","left":0,"top":0,"overflow":"hidden","height":wrap_height});
			$ul.width(wrap_width);



			//페이지 수다시 계산
			getPages();
			if(vpage ==1 && $li.length < vcount) vcount = $li.length;


			$ul.width(vpage * wrap_width);
			var li_w = Math.floor(wrap_width / vcount);


			if($this.attr("o_vpage")!=vpage || $this.attr("o_vcount")!=vcount || $this.attr("liw")!=li_w ){

				if (o.showCtrlBtns)
				{
					if(vpage==1){
						btnNext.hide();	btnPrev.hide();
					}else{
						btnNext.show();	btnPrev.show();
					}
				}


				$li.each(function(){
					var i = $(this).index() +1 ;
					var this_pg = Math.ceil( i/ vcount) ;


					var totop = 0;			var toleft = $(this).index() * li_w - ((this_pg-1)*(vcount * li_w));
					$(this).css({"position":"absolute",left:toleft,top:totop,"overflow":"hidden","float":"","height":o.height,"overflow":"hidden","width":li_w});

					//페이지별 첫번째 li 에는 배경 없애기
					if(i%vcount==1) {
						$(this).addClass("first");
					}else{
						$(this).removeClass("first");
					}
				});

				$this.attr("o_vpage",vpage);
				$this.attr("o_vcount",vcount);
				$this.attr("liw",li_w);

				var initOver =  ($("li.over",$this).length>0)? Math.ceil(($("li.over",$this).index() + 1)/vcount) : 1;
				goPage(initOver);

			}

			$a.unbind("focus");
			$a.bind("focus",function(){
				var n = $($(this).parents("li").get(0)).index();
				var this_pg = Math.ceil((n+1)/vcount);
				goPageFix(this_pg);

			});
			$(btnNext).unbind("click");
			$(btnPrev).unbind("click");
			$(btnNext).click(function(){	goNext();	});
			$(btnPrev).click(function(){	goPrev();	});

			function getPages(){
				vpage = Math.ceil($li.length / vcount);
			}
			function getPageCount(){
				vcount = o.line_limit;
				if($li.length > vcount  && o.showCtrlBtns ) wrap_width = $this.width() - (o.ctrlBtnWidth * 2);
			}

			function goPage(n){

				//if(pg!=n){
				pg = n;

				var s = (n-1 )*vcount, e = s+vcount -1;

				$li.each(function(){
					var this_n = $(this).index() ;

					var i = $(this).index() +1 ;
					var this_pg = Math.ceil( i/ vcount) ;
					var toleft = $(this).index() * li_w - ((this_pg-1)*(vcount * li_w));
					var toleft_off = toleft + wrap_width;


					//var toOffTop = wrap_height;
					var toOffTop = 0;
					if(this_n >=s && this_n <=e){
						//$(this).stop().css({"opacity":0}).animate({"opacity":1,"top":0,"left":toleft},300,function(){});
						$(this).stop().css({"opacity":0,"top":wrap_height,"width":li_w,"height":wrap_height}).animate({"opacity":1,"top":0},300,function(){});
					}else{
						//$(this).stop().animate({"opacity":0,"top":toOffTop,"left":toleft_off},300,function(){});
						$(this).stop().animate({"opacity":0,"top":wrap_height,"width":li_w,"height":wrap_height},300,function(){});
					}
				});

				//}



			}
			function goPageFix(n){

				//if(pg!=n){
				pg = n;

				var s = (n-1 )*vcount, e = s+vcount -1;

				$li.each(function(){
					var this_n = $(this).index() ;

					var i = $(this).index() +1 ;
					var this_pg = Math.ceil( i/ vcount) ;
					var toleft = $(this).index() * li_w - ((this_pg-1)*(vcount * li_w));
					var toleft_off = toleft + wrap_width;


					//var toOffTop = wrap_height;
					var toOffTop = 0;
					if(this_n >=s && this_n <=e){
						//$(this).stop().css({"opacity":0}).animate({"opacity":1,"top":0,"left":toleft},300,function(){});
						$(this).stop().css({"opacity":1,"top":0,left:toleft,"width":li_w,"height":wrap_height});
					}else{
						//$(this).stop().animate({"opacity":0,"top":toOffTop,"left":toleft_off},300,function(){});
						$(this).stop().css({"opacity":0,"top":0,left:toleft,"width":0,"height":0});
					}
				});


				//}



			}
			function goNext(){
				var goPg = pg+1;
				if(goPg>vpage) goPg = 1;

				goPage(goPg);

			}
			function goPrev(){
				var goPg = pg-1;
				if(goPg<1) goPg = vpage;

				goPage(goPg);

			}


		});

	}

		$.fn.rspnsvTab_fauto=function(o){

		o = $.extend({}, o||{});


		return this.each(function(){
			var Timer = null;
			var $this = $(this);

			if($(this).parent().hasClass("c-in-tab")){
			}else{
				$(this).wrap("<div class='c-in-tab'/>");
			}
			var $pthis = $this.parent();

			//var $pthis = $(this);
			//var $this = (o.intab!=undefined && o.intab!="")? $(o.intab,$pthis) : $(" > div:eq(0)",$pthis);
			var $wrap = $(".this-wrap",$this),$ul=$("ul",$this),$li = $("li",$this);
			var $a=$("a",$li);

			if($wrap.length<1){				$ul.wrap("<div class='this-wrap'/>");				$wrap = $(".this-wrap",$this);			}

			var org_vtype = $this.attr("vtype");


			var vcount = 0 , vpage = 0, pg = 0;

			var btnNext = $(".btn-next",$this);var btnPrev = $(".btn-prev",$this);

			var cfg = {line_limit:o.line_limit,li_h:o.height,"vtype":""};

			//가로폭에따라 한페이지에 li 갯수, width 결정
			var wrap_width = getWrapLimitWidth();

			//해상도에 따른 데이터 체크
			getWsizeData();

			//wrap 사이즈, 전체 가로폭 (양 사이드 버튼 2개 크기 제외 : 30px로 초기화)
			getPageCount();

			//라인수(페이지수)
			getPages();
			if(vpage ==1 && $li.length < vcount) vcount = $li.length;

			//view 형태 결정
			setViewType();

			if(org_vtype!=cfg.vtype && cfg.vtype==""){
							$(".sel-tab-list",$pthis).remove();
			}



			var initOver =  ($("li.over",$this).length>0)? Math.ceil(($("li.over",$this).index() )/vcount) : 0;

			//각 요소별 위치 정리
			setItemPosition();



			goDataFix(initOver);


			$a.unbind("focus");
			$a.bind("focus",function(){
				var n = $($(this).parents("li").get(0)).index();
				var this_pg = Math.ceil((n+1)/vcount);
				goDataFix(n);


			});
			$a.unbind("click");
			$a.bind("click",function(){

					if(cfg.vtype=="single"){
						//alert("vall");

						viewOtherSelList($(this).parent().index());
					}
					return false;
			});
			$(btnNext).unbind("click");
			$(btnPrev).unbind("click");
			$(btnNext).click(function(){	goNext();	});
			$(btnPrev).click(function(){	goPrev();	});

			function setViewType(){

				if(cfg.line_limit==1 ) {
					cfg.vtype="single";//|| vpage > 2
					$this.addClass("stype-s");
				}
				else {
					cfg.vtype="";
					$this.removeClass("stype-s");
				}

				$this.attr("vtype",cfg.vtype);

			}
			function getWrapLimitWidth(){

				if(_isLowBr_ ){
					return $this.width();
					//return		$this._width();
				}else{
					return $this.width();
				}
			}
			function getWsizeData(){

				var chkLimitW = getWrapLimitWidth();

				if(o.wsize_data.length>0){
					for(var i=(o.wsize_data.length-1);i>=0;i--){
						var chk_w = o.wsize_data[i].wsize;
						if(chkLimitW <= chk_w) {
							cfg.line_limit = o.wsize_data[i].list_mod;
							if(o.wsize_data[i].li_h!=undefined) cfg.li_h = o.wsize_data[i].li_h;
							break;
						}
					}
				}
			}

			function getPages(){				vpage = Math.ceil($li.length / vcount);			}
			function getPageCount(){				vcount = cfg.line_limit;							}
			function setItemPosition(){



				switch(cfg.vtype){
					case "single":
						var wr_h = cfg.li_h * 1;
						var wr_w = wrap_width;

						//if($li.length>vcount) wr_w = wrap_width - 30;

						break;
					case "":
						var wr_h = cfg.li_h * vpage;

						var wr_w  = wrap_width;
						break;
				}

				$wrap.css({"position":"relative","top":0,"margin-left":"0","overflow":"hidden","height":wr_h,"width":wr_w});
				$wrap.width(wr_w);

				$ul.css({"position":"absolute","left":0,"top":0,"overflow":"hidden","height":wr_h});
				$ul.width(wr_w);

				li_w = Math.floor(wr_w / vcount);
				li_h = cfg.li_h;

				$li.each(function(){
					var n = $(this).index() ;
					var wNum = n % vcount;
					var hNum = Math.floor( n / vcount) + 1;

					var this_pg = hNum ;// Math.ceil( n/ vcount) ;

					//페이지별 첫번째 li 에는 배경 없애기
					if(wNum==0) $(this).addClass("first");
					else $(this).removeClass("first");

					if(wNum==(vcount-1)) $(this).addClass("last");
					else  $(this).removeClass("last");

					if(this_pg==1) {
						$(this).addClass("first-row");
					}else{
						$(this).removeClass("first-row");
					}

					if(this_pg==vpage) {
						$(this).addClass("last-row");
					}else{
						$(this).removeClass("last-row");
					}

					var totop = (this_pg-1) * li_h;			var toleft = $(this).index() * li_w - ((this_pg-1)*(vcount * li_w));
					$(this).css({"position":"absolute",left:toleft,top:totop,"overflow":"hidden","float":"","height":o.height,"overflow":"hidden","width":li_w});


				});

			}
			function resetDatas(){
					var org_vcount = vcount;
					var org_vpage = vpage;
					getPageCount();

					//페이지 수다시 계산
					getPages();

					//ITEM 크기, 위치 초기화
					setItemPosition();


					//this.goPage(this.pg);
					//var resetFlag = false;
					 var resetFlag = true;
					//if(org_vcount!=this.vcount || org_vpage != this.vpage){ }
					goData(ndt,{effect:false,reset:true});
			}
			function goDataFix(n) {
				var wNum = n % vcount;
				var hNum = Math.floor(n/ vcount) + 1;

				goPage(hNum,{setDataNum:n});
				//$("#tabTest").html(hNum);

			}
			function goData  (n,opt) {

				var wNum = n % vcount;
				var hNum = Math.floor(n/ vcount) + 1;

				ndt = n;

				if(opt==undefined){		var opt = {effect:true};	}
				opt.setDataNum = n;
				goPage(hNum,opt);

			}
			function goPage(goPg,opt) {


				if(goPg<1) goPg = 1;
				var orgPg = pg;

				if(opt==undefined){
					var opt = {effect:true,reset:true};
				}

				if(orgPg!=goPg || opt.reset ==true ){

					//var wrapW = $wrap.width(); var wrapH =  $ul.height();
					//var this_li_w = Math.floor(wrapW / vcount);
					//var li_h = wrapH;


					if(cfg.vtype=="single"){

						$li.each(function(){

							var n = $(this).index() ;

							var wNum = n % vcount;
							var hNum = Math.floor( n / vcount) + 1;

							var toTop =0; var toLeft = 0; var zIndex = 1;
							toTop = li_h ;			toLeft = li_w * wNum;

							if(hNum==goPg){
								$(this).css({"width":li_w,"height":li_h,"top":0,"left":toLeft,"z-index":zIndex,"opacity":1});
							//	toTop = 0; zIndex = 10;
							}else{
								$(this).css({"width":0,"height":0,"top":0,"left":toLeft,"z-index":zIndex,"opacity":1});
							//	toTop = li_h; zIndex = 1;
							}


							//$(this).css({"width":li_w,"height":li_h,"top":toTop,"left":toLeft,"z-index":zIndex,"opacity":1});


						});
					}



					pg =  goPg;
					if(opt.setDataNum!=undefined) ndt = opt.setDataNum;
					else{
						ndt = (goPg -1 ) * vcount;
					}
				}

				viewOtherSelList =function(n){
					if($(".sel-tab-list",$pthis).length>0){
						$(".sel-tab-list",$pthis).remove();
						$("li.over a",$this).focus();
					}else{
						var newUL = $ul.clone();
						$("li",newUL).each(function(){
							$(this).attr("style","");

							if($(this).index()==n){
							}
						});

						$pthis.append("<div class='sel-tab-list'><ul>"+newUL.html()+"</ul><button type='button' class='close'>닫기</button></div>");
						$(".sel-tab-list",$pthis).css({"margin-top":parseInt($this.css("marginBottom")) * -1});
						$(".sel-tab-list button.close",$pthis).click(function(){viewOtherSelList();});
					}

				}


			}


		});

	}

	$.fn.rspnsvTab_fwidth=function(o){

		o = $.extend({wrap:null,height:30,line_limit:6}, o||{});


		return this.each(function(){
			var Timer = null;
			var $this = $(this),$wrap = $(".this-wrap",$this),$ul=$("ul",$this),$li = $("li",$this);
			var $a=$("a",$li);

			var vcount = 0 , vpage = 0, pg = 0;

			var btnNext = $(".btn-next",$this);var btnPrev = $(".btn-prev",$this);


			//wrap 사이즈, 전체 가로폭 (양 사이드 버튼 2개 크기 제외 : 30px로 초기화)
			//가로폭에따라 한페이지에 li 갯수, width 결정
			var wrap_width = $this.width();
			getPageCount();




			if($wrap.length<1){
				$ul.wrap("<div class='this-wrap'/>");
				$wrap = $(".this-wrap",$this);
			}
			$wrap.css({"position":"relative","top":0,"margin":"0 auto","overflow":"hidden","height":wrap_height});
			$wrap.width(wrap_width);

			$ul.css({"position":"absolute","left":0,"top":0,"overflow":"hidden","height":wrap_height});
			$ul.width(wrap_width);



			//페이지 수다시 계산
			getPages();
			if(vpage ==1 && $li.length < vcount) vcount = $li.length;

			var wrap_height =vpage *  o.height;
			$wrap.height(wrap_height);
			$ul.height(wrap_height);



			$ul.width(vpage * wrap_width);
			var li_w = Math.floor(wrap_width / vcount);
			var li_w2 = wrap_width - ( li_w * (vcount-1));


			if($this.attr("o_vpage")!=vpage || $this.attr("o_vcount")!=vcount || $this.attr("liw")!=li_w ){




				$li.each(function(){
					var i = $(this).index() +1 ;
					var this_pg = Math.ceil( i/ vcount) ;

					var totop = (this_pg-1) * o.height;			var toleft = $(this).index() * li_w - ((this_pg-1)*(vcount * li_w));
					var to_w = li_w ;if(i%vcount==0) to_w = li_w2;
					$(this).css({"position":"absolute",left:toleft,top:totop,"overflow":"hidden","float":"","height":o.height,"overflow":"hidden","width":to_w});

					//$(this).css({"position":"absolute",left:toleft,top:totop,"overflow":"hidden","float":"","height":o.height,"overflow":"hidden","width":li_w});

					//페이지별 첫번째 li 에는 배경 없애기
					if(i%vcount==1) {
						$(this).addClass("first");
					}else{
						$(this).removeClass("first");
					}

					if(this_pg==1) {
						$(this).addClass("first-row");
					}else{
						$(this).removeClass("first-row");
					}

					if(this_pg==vpage) {
						$(this).addClass("last-row");
					}else{
						$(this).removeClass("last-row");
					}
				});

				$this.attr("o_vpage",vpage);
				$this.attr("o_vcount",vcount);
				$this.attr("liw",li_w);

				var initOver =  ($("li.over",$this).length>0)? Math.ceil(($("li.over",$this).index() + 1)/vcount) : 1;
				goPage(initOver);

			}

			$a.unbind("focus");
			$a.bind("focus",function(){
				var n = $($(this).parents("li").get(0)).index();
				var this_pg = Math.ceil((n+1)/vcount);
				goPageFix(this_pg);

			});
			$(btnNext).unbind("click");
			$(btnPrev).unbind("click");
			$(btnNext).click(function(){	goNext();	});
			$(btnPrev).click(function(){	goPrev();	});

			function getPages(){
				vpage = Math.ceil($li.length / vcount);
			}
			function getPageCount(){
				//vcount = o.line_limit;

					if($this.width() > 640){
						vcount = o.line_limit;
					}else if($this.width() > 480){
						vcount = 3;
					}else{
						vcount = 2;
					}


			}

			function goPage(n){

				//if(pg!=n){

				pg = n;
				return;

			}
			function goPageFix(n){

				//if(pg!=n){
				pg = n;
				return;



			}
			function goNext(){
				var goPg = pg+1;
				if(goPg>vpage) goPg = 1;

				goPage(goPg);

			}
			function goPrev(){
				var goPg = pg-1;
				if(goPg<1) goPg = vpage;

				goPage(goPg);

			}


		});

	}
	$.fn.rspnsvTab_auto=function(o){

		o = $.extend({wrap:null,height:30,line_limit:6,showCtrlBtns:false,btnNext:null,btnPrev:null,ctrlBtnWidth:30}, o||{});


		return this.each(function(){
			var Timer = null;
			var $this = $(this),$wrap = $(".this-wrap",$this),$ul=$("ul",$this),$li = $("li",$this);
			var $a=$("a",$li);

			var vcount = 0 , vpage = 0, pg = 0;

			var btnNext = $(".btn-next",$this);var btnPrev = $(".btn-prev",$this);

			if(o.showCtrlBtns){
				if(btnPrev.length<1){
					$this.append("<button class='btn-prev'><span class='blind'>이전</span></button>");
					 btnPrev = $(".btn-prev",$this);
				}

				if(btnNext.length<1){
					$this.append("<button class='btn-next'><span class='blind'>다음</span></button>");
					 btnNext = $(".btn-next",$this);
				}

				btnPrev.css({"position":"absolute","left":0,"top":0});
				btnNext.css({"position":"absolute","right":0,"top":0});
			}

			//wrap 사이즈, 전체 가로폭 (양 사이드 버튼 2개 크기 제외 : 30px로 초기화)
			//가로폭에따라 한페이지에 li 갯수, width 결정
			var wrap_width = $this.width();
			getPageCount();

			var wrap_height = o.height;

			if($wrap.length<1){
				$ul.wrap("<div class='this-wrap'/>");
				$wrap = $(".this-wrap",$this);
			}
			$wrap.css({"position":"relative","top":0,"margin":"0 auto","overflow":"hidden","height":wrap_height});
			$wrap.width(wrap_width);

			$ul.css({"position":"absolute","left":0,"top":0,"overflow":"hidden","height":wrap_height});
			$ul.width(wrap_width);



			//페이지 수다시 계산
			getPages();
			if(vpage ==1 && $li.length < vcount) vcount = $li.length;


			$ul.width(vpage * wrap_width);
			var li_w = Math.floor(wrap_width / vcount);



			if($this.attr("o_vpage")!=vpage || $this.attr("o_vcount")!=vcount || $this.attr("liw")!=li_w ){

				if (o.showCtrlBtns)
				{
					if(vpage==1){
						btnNext.hide();	btnPrev.hide();
					}else{
						btnNext.show();	btnPrev.show();
					}
				}


				$li.each(function(){
					var i = $(this).index() +1 ;
					var this_pg = Math.ceil( i/ vcount) ;


					var totop = 0;			var toleft = $(this).index() * li_w - ((this_pg-1)*(vcount * li_w));

					$(this).css({"position":"absolute",left:toleft,top:totop,"overflow":"hidden","float":"","height":o.height,"overflow":"hidden","width":li_w});

					//페이지별 첫번째 li 에는 배경 없애기
					if(i%vcount==1) {
						$(this).addClass("first");
					}else{
						$(this).removeClass("first");
					}
				});

				$this.attr("o_vpage",vpage);
				$this.attr("o_vcount",vcount);
				$this.attr("liw",li_w);

				var initOver =  ($("li.over",$this).length>0)? Math.ceil(($("li.over",$this).index() + 1)/vcount) : 1;
				goPage(initOver);

			}

			$a.unbind("focus");
			$a.bind("focus",function(){
				var n = $($(this).parents("li").get(0)).index();
				var this_pg = Math.ceil((n+1)/vcount);
				goPageFix(this_pg);

			});
			$(btnNext).unbind("click");
			$(btnPrev).unbind("click");
			$(btnNext).click(function(){	goNext();	});
			$(btnPrev).click(function(){	goPrev();	});

			function getPages(){
				vpage = Math.ceil($li.length / vcount);
			}
			function getPageCount(){
			//	vcount = o.line_limit;

				if($this.width() > 640){
					vcount = o.line_limit;
				}else if($this.width() > 480){
					vcount = 3;
				}else{
					vcount = 2;
				}

				if($li.length > vcount  && o.showCtrlBtns ) wrap_width = $this.width() - (o.ctrlBtnWidth * 2);
			}

			function goPage(n){

				//if(pg!=n){
				pg = n;

				var s = (n-1 )*vcount, e = s+vcount -1;

				$li.each(function(){
					var this_n = $(this).index() ;

					var i = $(this).index() +1 ;
					var this_pg = Math.ceil( i/ vcount) ;
					var toleft = $(this).index() * li_w - ((this_pg-1)*(vcount * li_w));
					var toleft_off = toleft + wrap_width;


					//var toOffTop = wrap_height;
					var toOffTop = 0;
					if(this_n >=s && this_n <=e){
						//$(this).stop().css({"opacity":0}).animate({"opacity":1,"top":0,"left":toleft},300,function(){});
						$(this).stop().css({"opacity":0,"top":wrap_height,"width":li_w,"height":wrap_height}).animate({"opacity":1,"top":0},300,function(){});
					}else{
						//$(this).stop().animate({"opacity":0,"top":toOffTop,"left":toleft_off},300,function(){});
						$(this).stop().animate({"opacity":0,"top":wrap_height,"width":li_w,"height":wrap_height},300,function(){});
					}
				});

				//}



			}
			function goPageFix(n){

				//if(pg!=n){
				pg = n;

				var s = (n-1 )*vcount, e = s+vcount -1;

				$li.each(function(){
					var this_n = $(this).index() ;

					var i = $(this).index() +1 ;
					var this_pg = Math.ceil( i/ vcount) ;
					var toleft = $(this).index() * li_w - ((this_pg-1)*(vcount * li_w));
					var toleft_off = toleft + wrap_width;


					//var toOffTop = wrap_height;
					var toOffTop = 0;
					if(this_n >=s && this_n <=e){
						//$(this).stop().css({"opacity":0}).animate({"opacity":1,"top":0,"left":toleft},300,function(){});
						$(this).stop().css({"opacity":1,"top":0,left:toleft,"width":li_w,"height":wrap_height});
					}else{
						//$(this).stop().animate({"opacity":0,"top":toOffTop,"left":toleft_off},300,function(){});
						$(this).stop().css({"opacity":0,"top":0,left:toleft,"width":0,"height":0});
					}
				});


				//}



			}
			function goNext(){
				var goPg = pg+1;
				if(goPg>vpage) goPg = 1;

				goPage(goPg);

			}
			function goPrev(){
				var goPg = pg-1;
				if(goPg<1) goPg = vpage;

				goPage(goPg);

			}


		});

	}
})(jQuery);