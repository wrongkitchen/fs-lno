require.config({
    baseUrl : "",
    paths: {
        jquery         : 'components/jquery/jquery.min',
        underscore     : 'components/underscore/underscore-min',
        fancybox       : 'components/fancybox/source/jquery.fancybox',
        divSlider      : 'components/div-slider/div-slider-1.0.3',
        bootstrap      : 'components/bootstrap/js/bootstrap.min',
        vegas 		   : "components/jaysalvat-vegas/jquery.vegas",
        CommonFunction : "js/class/CommonFunction",
        SectionManager : "js/class/SectionManager-amd",
        jscrollpane    : "components/jscrollpane/script/jquery.jscrollpane.min",
        mousewheel     : "components/jscrollpane/script/jquery.mousewheel",
        common         : "js/common"
    },
    shim: {
        "underscore"    : { deps: ["jquery"], exports:"_" },
        "fancybox"      : { deps: ["jquery"] },
        "divSlider"     : { deps: ["jquery"] },
        "bootstrap"     : { deps: ["jquery"] },
        "jscrollpane"   : { deps: ["jquery"] },
        "mousewheel"    : { deps: ["jquery", "jscrollpane"] },
        "vegas"     	: { deps: ["jquery"] },
        "CommonFunction": { deps: ["jquery"] },
        "SectionManager": { deps: ['jquery', 'CommonFunction', "fancybox"] },
        "common"        : { deps: ['jquery'] } 
    }
});

require(["jquery", "underscore", "SectionManager", "CommonFunction", "fancybox", "vegas", "jscrollpane", "mousewheel", "common"], function($, _, SM){

    $(document).ready(function(){

        var gObj = window.lno;
            gObj.lang = (gObj.lang) ? gObj.lang : "en";

        window.sectionManager = new SM.manager({
            sectionList:{
                landingSection  : new SM.base($("#homeContent")),
                aboutSection    : new SM.base($("#aboutContent"), gObj.lang+"/about.php"),
                projectSection  : new SM.base($("#projectContent"), gObj.lang+"/project.php"),
                newsSection     : new SM.base($("#newsContent"), gObj.lang+"/news.php"),
                awardSection    : new SM.base($("#awardContent"), gObj.lang+"/award.php"),
                susSection      : new SM.base($("#susContent"), gObj.lang+"/sus.php"),
                careerSection   : new SM.base($("#careerContent"), gObj.lang+"/career.php"),
                contactSection  : new SM.base($("#contactContent"), gObj.lang+"/contact.php"),
            },
            hashChangeCallback: function(pHash){
                console.log(pHash);
            }
        });

        window.sectionManager.init(function(){
            sectionChangeHandler();
        });

        var sectionChangeHandler = function(){
            var curSectionID = window.sectionManager.currentSection.el.attr("id");
            if(curSectionID == "newsContent"){
                window.lno.news.init();
            }
        };

        var animateNavLine = function(){
            $(".sectionChange>.navButton").removeClass("active");
            $("a[href="+window.location.hash+"]>.navButton").addClass("active");
            var curActiveBtn = $(".sectionChange>.navButton.active");
            if(curActiveBtn.length)
                $(".navigator>.bottomLine").animate({ left:curActiveBtn.position().left+"px", width: curActiveBtn.width()+"px" });
        };

        if ("onhashchange" in window) {
            $(window).bind('hashchange',function(e) {
                var targetSection = window.location.hash.replace("#","");
                    targetSection = (targetSection) ? targetSection : "landingSection";
                animateNavLine();
                window.sectionManager.changeSection(targetSection, null, sectionChangeHandler);
            });
        } else {
            var prevHash = window.location.hash;
            window.setInterval(function () {
               if (window.location.hash != prevHash) {
                    prevHash = window.location.hash;
                    var targetSection = window.location.hash.replace("#","");
                        targetSection = (targetSection) ? targetSection : "landingSection";
                    animateNavLine();
                    window.sectionManager.changeSection(targetSection, null, sectionChangeHandler);
               }
            }, 100);
        }

        window.toggleView = function(pHide, pShow, pCallback){
            $(pHide).hide();
            $(pShow).show();
            if(pCallback) pCallback();
        };

    	$.vegas('slideshow', {
    		fade : 1000,
    		delay: 10000,
    		backgrounds:[
    			{ src:'img/bg/01.jpg' },
    			{ src:'img/bg/02.jpg' },
    			{ src:'img/bg/03.jpg' },
    			{ src:'img/bg/04.jpg' },
    			{ src:'img/bg/05.jpg' },
    			{ src:'img/bg/06.jpg' },
    			{ src:'img/bg/07.jpg' },
    			{ src:'img/bg/08.jpg' },
    			{ src:'img/bg/09.jpg' },
    			{ src:'img/bg/10.jpg' }
    		]
    	});

        animateNavLine();

    });

});