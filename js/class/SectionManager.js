define(["backbone"], function(){

    // SectionBase START
    var SectionBase = Backbone.Model.extend({
        defaults : {
            el : "",
            preloadPath : ""
        },
        preloaded : false,
        inScene : false,
        fadeIn : function(pTime, pCallback){ 
            var _this = this;
            _this.preload(function(){
                _this.get("el").fadeIn(pTime, function(){ if(pCallback) pCallback(); }); 
                _this.inScene = true; 
            });
        },
        fadeOut : function(pTime, pCallback){ 
            this.get("el").fadeOut(pTime, function(){ if(pCallback) pCallback(); }); 
            this.inScene = false; 
        },
        hide : function(){ this.get("el").hide(); },
        show : function(){ this.get("el").show(); },
        showPreloader : function(){ 
            ($.fancybox) ? $.fancybox.showActivity() : console.log("Start Loading"); 
        },
        hidePreloader : function(){ 
            ($.fancybox) ? $.fancybox.hideActivity() : console.log("End Loading"); 
        },
        preload : function(pCallback){
            var _this = this;
            if(_this.preloadPath && !_this.preloaded){
                $.ajax({
                    url: _this.preloadPath,
                    dataType:"html",
                    type: 'post',
                    success: function(data) {
                        var imgArray = [];
                        $(data).find("img").each(function(){
                            imgArray.push($(this).attr("src"));
                        });
                        if(imgArray.length>0){
                            window.preloadImageArray(imgArray, function(){
                                _this.el.html(data);
                                _this.preloaded = true;
                                if(pCallback) pCallback();                        
                            });
                        } else {
                            _this.el.html(data);
                            _this.preloaded = true;
                            if(pCallback) pCallback();
                        }
                    },
                    error: function(err){ console.log(err); }
                });
            } else {
                if(pCallback) pCallback();
            }
        }
    });
    // SectionBase END

    //SectionPopup START
    var SectionPopup = SectionBase.extend({
        fadeIn : function(pTime, pCallback){
            var _this = this;
            _this.preload(function(){
                if(_this.get("el").height() <= $(document).height()){
                    _this.get("el").css("top", "-"+$(document).height()+"px");
                    _this.get("el").height($(document).height());
                } else {
                   _this.get("el").height("auto");
                }
                _this.get("el").stop().animate({ top:"0px" }, function(){
                    if(pCallback) pCallback();
                });
                this.inScene = true;
            });
        },
        fadeOut : function(pTime, pCallback){ 
            var _this = this;
            _this.get("el").stop().animate({ top:_this.get("el").height()*-1+"px" }, function(){
                if(pCallback) pCallback();
            });
            this.inScene = false; 
        }
    });
    //SectionPopup END

    // SectionManager START
    var SectionManager = Backbone.Model.extend({
        defaults:{ 
            sectionList:{
                landingSection:"",
                popup:"",
            },
            hashMode : true,
            defaultHash : "landingSection"
        },
        currentSection : null,
        currentPopup   : null,
        animating      : false,
        router         : null,

        initialize : function(){
            var _this = this;
            if(_this.get("hashMode") == true){
                var routerPrototype = Backbone.Router.extend({
                    routes : {
                        "*action" : "hashChangeHandler"
                    },
                    hashChangeHandler : function(action){
                        var hashString = _this.get("defaultHash");
                        if(action)
                            hashString = action;
                        if(_this.get("sectionList")[hashString])
                            _this.changeSection(hashString);
                    }
                });
                _this.router = new routerPrototype();
                
                Backbone.history.start();

            } else {
                _this.changeSection(_this.get("defaultHash"));
            }
        },
        changeSection : function(pToSection, pTime, pCallback){
            var _this = this;
            var fromSection = _this.currentSection;
            var toSection = _this.get("sectionList")[pToSection];
            var transiteToSection = function(){
                if(toSection.inScene){
                    toSection.fadeOut(0, function(){
                        toSection.fadeIn(pTime, pCallback);
                    });
                } else {
                    toSection.fadeIn(pTime, pCallback);
                }
                if(_this.currentSection)
                    _this.currentSection.hidePreloader();
                _this.currentSection = toSection;
                _this.animating = false;
            }
            if(_this.animating == false){
                _this.animating = true;
                if(toSection){
                    if(_this.currentSection)
                        _this.currentSection.showPreloader();
                    (fromSection) ? fromSection.fadeOut(pTime, transiteToSection) : transiteToSection();
                }
            }
        },
        showPreloader : function(){
            var _this = this;
            _this.currentSection.showPreloader();
        },
        hidePreloader : function(){
            var _this = this;
            _this.currentSection.hidePreloader();
        },
        callPopup : function(pToSection, pTime, pCallback){
            var _this = this;
            var toSection = _this.getSection(pToSection);

            if(toSection){
                if(_this.currentSection)
                    _this.currentSection.showPreloader();

                if(toSection.inScene){
                    toSection.fadeOut(0, function(){
                        toSection.fadeIn(pTime, pCallback);
                    });
                } else {
                    toSection.fadeIn(pTime, function(){
                        if(_this.currentSection)
                            _this.currentSection.hidePreloader();
                        if(pCallback)
                            pCallback();
                    });
                }
                _this.currentPopup = toSection;
            }            
        },
        closePopup : function(pTime, pCallback){
            var _this = this;
            if(_this.currentPopup){
                _this.currentPopup.fadeOut(pTime, pCallback);
                _this.currentPopup = null;
            }
        }
    });
    // SectionManager END

    return { manager:SectionManager, base:SectionBase, popup:SectionPopup };
});