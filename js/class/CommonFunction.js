// CommonFunction.js
// Author Kenji Wong
// Lastest Modification 30/1/2013

if(!window.console) window.console = { log: function(){ return; } };

window.ClassUtils = {
    classExtend : function(subClass, superClass) {
        var F = function() {};
        F.prototype = superClass.prototype;
        subClass.prototype = new F();
        subClass.prototype.constructor = subClass;
        subClass.superclass = superClass.prototype;
        if(superClass.prototype.constructor == Object.prototype.constructor) {
            superClass.prototype.constructor = superClass;
        }
    }
};

window.ImageUtils = {
    preloadImageArray : function(pImageArray, pCallback){
        if (document.images){
            var imageCount_num = pImageArray.length;
            var imageObj_array = [];
            var imageLoaded_num = 0;
            for(var i=0; i<imageCount_num; i++){
                var image_obj = new Image();
                image_obj.src = pImageArray[i];
                image_obj.onload = function(){
                    imageObj_array.push(this);
                    imageLoaded_num += 1;
                    if(imageLoaded_num == pImageArray.length)
                        pCallback(imageObj_array);
                };
            }
        }
    }
};

window.TmplUtils = {
    tableValignTmpl : function(pHTML){
        var html = "";
            html += "<table cellpadding='0' cellspacing='0' width='100%' height='100%'>";
            html += "<tr>"
            html += "<td align='center' valign='middle'>"
            html += pHTML;
            html += "</td>"
            html += "</tr>"
            html += "</table>";
        return html;
    }
};

window.BrowserUtils = {
    checkViewPort : function(pDocWidth){
        var docWidth = (pDocWidth) ? pDocWidth : 640;
        var navigateUA = navigator.userAgent;
        if ((navigateUA.indexOf('iPhone') == -1) && (navigateUA.indexOf('iPod') == -1) && (navigateUA.indexOf('iPad') == -1)){
            var e = window, a = 'inner';
            var viewport = document.querySelector("meta[name=viewport]");
            if (!('innerWidth' in window)){
                a = 'client';
                e = document.documentElement || document.body;
            }
            var initScale = new Number(e[a+"Width"] / docWidth);
                initScale = initScale.toFixed(1);
            viewport.setAttribute('content', 'width=device-width, minimum-scale=0.5, initial-scale='+initScale);
        }
    },
    isMobile : function(){
        return (/iphone|ipad|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));  
    }
};