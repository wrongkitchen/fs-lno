define(function(){
    // SectionManager START
    SectionManager = function(options) {
        this.defaults = { 
            sectionList:{
                landingSection:"",
                popup:""
            }
        };
        this.options = $.extend(this.defaults, options);
        this.currentSection = null;
        this.currentPopup = null;
        this.animating = false;
    };
    SectionManager.fn = SectionManager.prototype;
    SectionManager.fn.init = function(){
        var _this = this;
        var hashString = "landingSection";
        if(window.location.hash){
            if(_this.getSection(window.location.hash.replace("#", "")))
                hashString = window.location.hash.replace("#", "");
        }
        _this.changeSection(hashString);
    };
    SectionManager.fn.getSection = function(pName){
        if(this.options.sectionList[pName])
            return this.options.sectionList[pName];
        return false;
    };
    SectionManager.fn.changeSection = function(pToSection, pTime, pCallback){
        var _this = this;
        var fromSection = _this.currentSection;
        var toSection = _this.getSection(pToSection);
        var transiteToSection = function(){
            if(fromSection) fromSection.dispose();
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
                // window.location = window.location.href.replace(window.location.hash, "")+"#"+pToSection;
            }
        }
    };
    SectionManager.fn.callPopup = function(pToSection, pTime, pCallback){
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
    };
    SectionManager.fn.closePopup = function(pTime, pCallback){
        var _this = this;
        if(_this.currentPopup){
            _this.currentPopup.fadeOut(pTime, pCallback);
            _this.currentPopup = null;
        }
    };
    SectionManager.fn.showPreloader = function(){
        var _this = this;
        _this.currentSection.showPreloader();
    };
    SectionManager.fn.hidePreloader = function(){
        var _this = this;
        _this.currentSection.hidePreloader();
    };
    // SectionManager END

    // SectionBase START
    SectionBase = function(pEl, pPath){ 
        this.el = pEl; 
        this.inScene = false;
        this.preloadPath = pPath;
        this.preloaded = false;
    };
    SectionBase.fn = SectionBase.prototype;
    SectionBase.fn.preload = function(pCallback){
        var _this = this;
        if(_this.preloadPath && !_this.preloaded){
            $.ajax({
                url         : _this.preloadPath,
                dataType    : "html",
                type        : 'get',
                cache       : true,
                success: function(data) {
                    var imgArray = [];
                    $(data).find("img").each(function(){
                        imgArray.push($(this).attr("src"));
                    });
                    if(imgArray.length>0){
                        window.ImageUtils.preloadImageArray(imgArray, function(){
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
    };
    SectionBase.fn.fadeIn = function(pTime, pCallback){ 
        var _this = this;
        _this.preload(function(){
            _this.el.fadeIn(pTime, function(){ if(pCallback) pCallback(); }); 
            _this.inScene = true; 
        });
    };
    SectionBase.fn.fadeOut = function(pTime, pCallback){ 
        this.el.fadeOut(pTime, function(){ if(pCallback) pCallback(); }); 
        this.inScene = false; 
    };
    SectionBase.fn.hide = function(){ this.el.hide(); };
    SectionBase.fn.show = function(){ this.el.show(); };
    SectionBase.fn.showPreloader = function(){ 
        $.fancybox.showLoading(); 
    };
    SectionBase.fn.hidePreloader = function(){ 
        $.fancybox.hideLoading(); 
    };
    SectionBase.fn.dispose = function(){ 
        var _this = this;
        if(_this.preloadPath){
            _this.el.empty();
            _this.preloaded = false;
        }
    };
    // SectionBase END

    //SectionPopup START
    SectionPopup = function(pEl, pPath){ 
        this.el = pEl; 
        this.inScene = false; 
        this.preloadPath = pPath;
        this.preloaded = false;
    };
    ClassUtils.classExtend(SectionPopup, SectionBase); 
    SectionPopup.fn = SectionPopup.prototype;
    SectionPopup.fn.fadeIn = function(pTime, pCallback){
        var _this = this;
        _this.preload(function(){
            if(_this.el.height() <= $(document).height()){
                _this.el.css("top", "-"+$(document).height()+"px");
                _this.el.height($(document).height());
            } else {
               _this.el.height("auto");
            }
            _this.el.stop().animate({ top:"0px" }, function(){
                if(pCallback) pCallback();
            });
            this.inScene = true;
        });
    };
    SectionPopup.fn.fadeOut = function(pTime, pCallback){ 
        var _this = this;
        _this.el.stop().animate({ top:_this.el.height()*-1+"px" }, function(){
            if(pCallback) pCallback();
        });
        this.inScene = false; 
    };
    //SectionPopup END

    return { manager:SectionManager, base:SectionBase, popup:SectionPopup };
});