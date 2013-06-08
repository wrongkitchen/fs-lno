<div class="container">
	
	<div class="leftRightContent">
		<div class="leftContent">
			<div class="leftTitle">AWARDS //</div>
			<div id="awardLeftBtnWrap"></div>
		</div>
		<div id="awardRightContent" class="rightContent">

			<div id="awardNode">
				<div class="listing">
					<div class="yearTitle"></div>
					<div id="awardWrap"></div>
				</div>
				<div class="preview"></div>
			</div>

		</div>
		<div class="clearfix"></div>
	</div>

</div>
<script type="template" id="awardTemplate">
	<div class="award">
		<div class="img"><img src="<%=img%>" alt=""></div>
		<div class="title"><%=title%></div>
		<div class="content"><%=content%></div>
		<div class="location"><%=location%></div>
		<div class="clearfix"></div>
	</div>
</script>
<script type="template" id="awardPreviewTemplate">
	<a href="javascript:void(0)" onclick="lno.award.closePreview()"><div class="closeBtn"></div></a>
	<div class="img"><img src="<%=img%>" alt=""></div>
	<div class="desc">
		<div class="pull-left">
			
			<div class="title"><%=title%></div>
			<div class="location"><%=location%></div>
		</div>
		<div class="awardViewProjectDetail" class="pull-right">
			<table width="220" height="79">
				<tbody>
					<tr>
						<td align="right" valign="bottom"><span class="cursorPointer">VIEW PROJECT DETAILS >></span></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="clearfix"></div>
		<div class="content"><%=content%></div>
	</div>
</script>
<script type="text/javascript">
	window.lno = (window.lno) ? window.lno : {};
	window.lno.award = {};
	window.lno.award.scrollPane = $('#awardRightContent').jScrollPane({ mouseWheelSpeed : 10 });
	window.lno.award.refreshPane = function(){
		window.lno.award.scrollPane.data('jsp').reinitialise();
	};
	window.lno.award.loadAward = function(){
		$.ajax({
			url: 'json/award.json',
			type: 'get',
			dataType: "json",
			success: function (data) {
				$("#awardLeftBtnWrap").empty();
				_.each(data, function(pYear, pIndex){
					var activeClass = "";
					if(pIndex == 0){
						activeClass = " active";
						$("#awardNode>.listing>.yearTitle").html(" / "+pYear.year);
						_.each(pYear.awards, function(pValue){
							$("#awardWrap").append(_.template($("#awardTemplate").html(), pValue));
						});
					}
					$("#awardLeftBtnWrap").append('<div class="leftBtn'+activeClass+'"> / '+pYear.year+'</div>');
				});
				window.lno.award.refreshPane();
			}
		});
	};
	$("#awardWrap>.award").live("click", function(){
		var dataObj = {};
			dataObj.location = $(this).children(".location").html();
			dataObj.content = $(this).children(".content").html();
			dataObj.title = $(this).children(".title").html();
			dataObj.img = $(this).children(".img").children("img").attr("src");
		
		$("#awardNode>.preview").html(_.template($("#awardPreviewTemplate").html(), dataObj));
		$("#awardNode>.listing").hide();
		$("#awardNode>.preview").show();
		window.lno.award.refreshPane();
	});
	window.lno.award.closePreview = function(){
		$("#awardNode>.listing").show();
		$("#awardNode>.preview").hide();
		$("#awardNode>.preview").empty();
		window.lno.award.refreshPane();
	};
	window.lno.award.loadAward();
	$(".awardViewProjectDetail").live("click", function(){
		if($(this).parent().children(".content").css("display") == "block"){
			$(this).parent().children(".content").hide();
		} else {
			$(this).parent().children(".content").show();
		}
	});
</script>