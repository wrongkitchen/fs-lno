<div class="container">
	
	<div class="leftRightContent">
		<div class="leftContent">
			<div class="leftTitleDisable">PROJECTS //</div>
			<a class="textdecoNone" href="javascript:void(0)" onclick="window.lno.project.loadFeature()">
				<div id="projectFeatureBtn" class="leftBtn active">/ FEATURED PROJECTS</div>
			</a>
			<div class="leftBtnDisable">/ CATEGORY</div>
				<div id="projectCateWrap"></div>
      		<div class="locationLeftBtn">REGIONS</div>
				<div id="projectRegionsWrap">
					<a class="textdecoNone" href="javascript:void(0)" onclick="window.lno.project.filterProject('all')"><div class="leftBtnInner">/ All</div></a>
				</div>
		</div>
		<div id="projectRightContent" class="rightContent">
			
			<div id="projectFeatured">
				<div class="preview">
					<div class="img"><img src="img/project/project-00.png" alt=""></div>
					<div class="thumbGroup">
						<div class="projectFeatThumb active">
							/ 2010<br />AL SHAQAB EQUESTRIAN <br />PERFORMANCE ARENA<br /><br />View Details >>
						</div>
						<div class="projectFeatThumb">
							/ 2007<br />HONG KONG <br />Science Park PHASE II<br /><br />View Details >>
						</div>
						<div class="projectFeatThumb">
							/ 2011<br />RUN RUN SHAW <br />CREATIVE MEDIA CENTRE CITY U<br /><br />View Details >>
						</div>
						<div class="projectFeatThumb">
							/ 2012<br />XIAN NAHUN RESIDENTIAL <br />DEVELOPMENT<br /><br />View Details >>
						</div>
						<div class="projectFeatThumb end">
							/ 2012<br />L’AVENUE <br />SHANGHAI<br /><br />View Details >>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>

			<div id="projectCategory">
				<div class="listing"></div>
				<div class="preview" style="display:none"></div>
			</div>

		</div>
		<div class="clearfix"></div>
	</div>

</div>
<script type="template" id="projectThumbTemplate">
	<a class="textdecoNone" href="javascript:void(0)" onclick="lno.project.loadProjectPreview('<%=cateName%>','<%=index%>')">
		<div class="projectThumbNode">
			<div class="overlay">
				<table>
					<tr>
						<td align="center" valign="middle">
							<div class="year"><%=year%></div>
							<div class="title"><%=name%></div>
						</td>
					</tr>
				</table>
			</div>
			<img src="<%=thumbnail%>" alt="">
		</div>
	</a>
</script>
<script type="template" id="projectPreviewTemplate">
	<a class="textdecoNone" href="javascript:void(0)" onclick="lno.project.closePreview()"><div class="closeBtn"></div></a>
	<div class="img"><img src="<%=imgs.lr%>" alt=""></div>
	<div class="desc">
		<div class="year"><%=year%></div>
		<div class="title"><%=name%></div>
		<div class="pull-left">
			<div class="location"><%=location%></div>
		</div>
		<div class="pull-right">
			<div class="viewBtn">View Details >></div>
			<div class="backBtn" style="display:none"><< BACK</div>
		</div>
		<div class="clearfix"></div>
		<div class="projectPreviewThumbs">
			<div class="thumb"><img src="<%=imgs.sm%>" alt=""></div>
			<div class="clearfix"></div>
		</div>
		<div class="content" style="display:none;"><%=content%></div>
	</div>
</script>
<script type="template" id="projectDefaultThumb">
	<div class="projectThumbNode"><img src="img/project/default.jpg" alt=""></div>
</script>
<script type="text/javascript">
	window.lno = (window.lno) ? window.lno : {};
	window.lno.project = {};
	window.lno.projectsArray = [];
	window.lno.project.scrollPane = $('#projectRightContent').jScrollPane({ mouseWheelSpeed : 10 });
	window.lno.project.currentProject = "";
	window.lno.project.refreshPane = function(){
		window.lno.project.scrollPane.data('jsp').reinitialise();
	};
	lno.project.closePreview = function(){
		$("#projectCategory>.listing").show();
		$("#projectCategory>.preview").hide();
		$("#projectCategory>.preview").empty();
		window.lno.project.refreshPane();
	};
	window.lno.project.loadProjectPreview = function(pCateName, pIndex){
		var projectsArray = window.lno.projectsArray;
		var targetObj = {};
		for(var i=0; i<projectsArray.length; i++){
			if(projectsArray[i].cateName == pCateName){
				if(projectsArray[i].projects[pIndex])
					targetObj = projectsArray[i].projects[pIndex];
				break;
			}
		}
		if(targetObj === {}){
			console.log("No such project");
		} else {
			$("#projectCategory>.preview").html(_.template($("#projectPreviewTemplate").html(), targetObj));
			$("#projectCategory>.listing").hide();
			$("#projectCategory>.preview").show();
		}
		window.lno.project.refreshPane();
	};
	window.lno.project.loadProjectListing = function(pCateName, pFilterName){
		var projectsArray = window.lno.projectsArray;
		var targetCateProjects = [];
		$("#projectFeatured").hide();
		$("#projectCategory").show();
		$("#projectCategory>.listing").show();
		$("#projectCategory>.preview").show();
		$("#projectCategory>.preview").empty();
		$.fancybox.showLoading();
		for(var i=0; i<projectsArray.length; i++){
			if(projectsArray[i].cateName == pCateName){
				targetCateProjects = projectsArray[i].projects;
				break;
			}
		}
		if(targetCateProjects.length == 0){
			$.fancybox.hideLoading();
			console.log("No Project");
		} else {
			$("#projectCategory>.listing").empty();
			window.lno.project.currentProject = pCateName;
			var addCounter = 0;
			_.each(targetCateProjects, function(pObj){
				if(pFilterName && pFilterName != "all"){
					if(pFilterName === pObj.regions){
						$("#projectCategory>.listing").append(_.template($("#projectThumbTemplate").html(), pObj));
						addCounter += 1;
					}
				} else {
					$("#projectCategory>.listing").append(_.template($("#projectThumbTemplate").html(), pObj));
					addCounter += 1;
				}
			});
			if(addCounter < 9){
				var fillNum = 9 - addCounter;
				for(var i=0; i<fillNum; i++){
					$("#projectCategory>.listing").append($("#projectDefaultThumb").html());
				}
			} else if(addCounter%3){
				for(var j=0; j<3-(addCounter%3); j++){
					$("#projectCategory>.listing").append($("#projectDefaultThumb").html());
				}
			}
			window.lno.project.refreshPane();
			$.fancybox.hideLoading();
		}
	};
	window.lno.project.loadFeature = function(){
		$("#projectFeatured").show();
		$("#projectCategory").hide();
		window.lno.project.refreshPane();
	};
	window.lno.project.loadProjects = function(){
		$.ajax({
			url: 'json/project.json',
			type: 'get',
			dataType: "json",
			success: function (data) {
				$("#projectCateWrap").empty();
				window.lno.projectsArray = data;
				var regions = [];
				_.each(data, function(pObj){
					var cateName = pObj.cateName;
					$("#projectCateWrap").append('<a class="textdecoNone" href="javascript:void(0)" onclick="window.lno.project.loadProjectListing(\''+cateName+'\')"><div class="leftBtnInner">/ '+cateName+'</div></a>');
					_.each(pObj.projects, function(pObjProject, pIndex){
						pObjProject.cateName = cateName;
						pObjProject.index = pIndex;
						regions.push(pObjProject.regions);
					});
				});
				regions = _.uniq(regions);
				_.each(regions, function(pRegions){
					$("#projectRegionsWrap").append('<a class="textdecoNone" href="javascript:void(0)" onclick="window.lno.project.filterProject(\''+pRegions+'\')"><div class="leftBtnInner">/ '+pRegions+'</div></a>');
				});
			}
		});
	};
	window.lno.project.filterProject = function(pFilterName){
		window.lno.project.loadProjectListing(window.lno.project.currentProject, pFilterName);
	};
	window.lno.getProjectsByName = function(){
		var projectsArray = window.lno.projectsArray;
		var currentProjectName = window.lno.project.currentProject;
		for(var i=0; i<projectsArray.length; i++){
			if(projectsArray[i].cateName == currentProjectName){
				return projectsArray[i].projects;
			}
		}
		return false;
	};
	window.lno.project.loadProjects();
	$("#projectFeatureBtn").live("click", function(){
		$("#projectRegionsWrap>a>.leftBtnInner").removeClass("active");
		$("#projectCateWrap>a>.leftBtnInner").removeClass("active");
	});
	$("#projectRegionsWrap>a>.leftBtnInner").live("click", function(){
		$("#projectRegionsWrap>a>.leftBtnInner").removeClass("active");
		$(this).addClass("active");
		$("#projectFeatureBtn").removeClass("active");
	});
	$("#projectCateWrap>a>.leftBtnInner").live("click", function(){
		$("#projectCateWrap>a>.leftBtnInner").removeClass("active");
		$(this).addClass("active");
		$("#projectFeatureBtn").removeClass("active");
	});
	$(".viewBtn").live("click", function(){
		$(this).hide();
		$(this).parent().children(".backBtn").show();
		$(this).parent().parent().children(".content").show();
	});
	$(".backBtn").live("click", function(){
		$(this).hide();
		$(this).parent().children(".viewBtn").show();
		$(this).parent().parent().children(".content").hide();
	});
</script>