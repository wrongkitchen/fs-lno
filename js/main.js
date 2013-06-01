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
        mousewheel     : "components/jscrollpane/script/jquery.mousewheel"
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
        "SectionManager": { deps: ['jquery', 'CommonFunction', "fancybox"] }
    }
});

require(["jquery", "underscore", "SectionManager", "CommonFunction", "fancybox", "vegas", "jscrollpane", "mousewheel"], function($, _, SM){

    $(document).ready(function(){


        window.sectionManager = new SM.manager({
            sectionList:{
                landingSection  : new SM.base($("#homeContent")),
                aboutSection    : new SM.base($("#aboutContent"), "about.php"),
                projectSection  : new SM.base($("#projectContent"), "project.php"),
                newsSection     : new SM.base($("#newsContent"), "news.php"),
                awardSection    : new SM.base($("#awardContent"), "award.php"),
                susSection      : new SM.base($("#susContent"), "sus.php"),
                careerSection   : new SM.base($("#careerContent"), "career.php"),
                contactSection  : new SM.base($("#contactContent"), "contact.php"),
            }
        });

        window.sectionManager.init();

        if (("onhashchange" in window) && !($.browser.msie)) {
            $(window).bind('hashchange',function(e) {
                var targetSection = window.location.hash.replace("#","");
                    targetSection = (targetSection) ? targetSection : "landingSection";
                window.sectionManager.changeSection(targetSection);
            });
        } else {
            var prevHash = window.location.hash;
            window.setInterval(function () {
               if (window.location.hash != prevHash) {
                    storedHash = window.location.hash;
                    var targetSection = window.location.hash.replace("#","");
                        targetSection = (targetSection) ? targetSection : "landingSection";
                    window.sectionManager.changeSection(targetSection);
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

    });

});