<div class="container">
	
	<div class="leftRightContent">
		<div class="leftContent">
			<div class="leftTitleDisable">CONTACTS //</div>
		    <a class="textdecoNone" href="javascript:void(0)" onclick="window.lno.career.toggleView('.careerInner', '#careerExperience')"><div class="careerLeftBtn leftBtn active">/ Work Environment</div></a>
    		<a class="textdecoNone" href="javascript:void(0)" onclick="window.lno.career.toggleView('.careerInner', '#careerOpening')"><div class="careerLeftBtn leftBtn">/ Openings</div></a>
		</div>
		<div id="careerRightContent" class="rightContent">
			
			<div class="careerInner" id="careerExperience">
				<div class="preview">
					<div class="img"><img src="img/career/career-00.png" alt=""></div>
					<div class="desc">
						<div class="title">
							Our people are our greatest asset. L&O believes that the skills, knowledge and competence of our staff are key to our success and therefore we encourage our employees to develop to their fullest potential. <br /><br />
							L&O places emphasis on diversity - particularly in relation to the development of our staff.<br /><br />
							We believe that to motivate our staff, we need to provide opportunities for them to advance and excel, and we consciously try to balance the business needs of the group with the career goals of our staff.
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>

			<div class="careerInner" id="careerOpening" style="display:none">
				<div class="listing">
					<div class="opening">
						<div class="year">2013.03.08/</div>
						<div class="title">
							Senior Interior Designers / Interior Designers<br /><br />
							Requirements:<br /><br />
							• Minimum 8 / 5 years years experience<br /><br />
							• Hotel/ Entertainment projects experience is preferred
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="opening">
						<div class="year">2013.03.08/</div>
						<div class="title">
							Senior Architects / Architects<br /><br />
							Requirements:<br /><br />
							• Minimum 8 / 5 years years experience<br /><br />
							• Hotel/ Entertainment projects experience is preferred
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="opening">
						<div class="year">2013.03.07/</div>
						<div class="title">
							Senior Resident Architect (Station in Guangzhou)<br /><br />
							Requirements:<br /><br />
							• Minimum 8 / 5 years years experience<br /><br />
							• Hotel/ Entertainment projects experience is preferred
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>

</div>

<script type="text/javascript">
	window.lno = (window.lno) ? window.lno : {};
	window.lno.career = {};
	window.lno.career.toggleView = function(pHide, pShow, pCallback){
		$("#careerRightContent").animate({ left:"-20px", opacity: 0 }, function(){
			$(pHide).hide();
			$(pShow).show();
			$("#careerRightContent").animate({ left:"0", opacity: 1 }, function(){
        		if(pCallback) pCallback();
			});
		});
	};
	$(".careerLeftBtn").click(function(){
		$(".careerLeftBtn").removeClass("active");
		$(this).addClass("active");
	});
	$("#careerOpening>.listing>.opening").click(function(){
		if($(this).hasClass("active")){
			$(this).animate({ height:"20px" });
			$(this).removeClass("active");
		} else {
			$(this).animate({ height:$(this).children(".title").height()+"px" });
			$(this).addClass("active");
		}
	});
</script>