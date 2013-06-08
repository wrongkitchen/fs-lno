window.lno = {};
window.lno.news = {};
window.lno.news.init = function(){
    window.lno.news.scrollPane = $("#newsRightContent").jScrollPane({ mouseWheelSpeed : 10 });
};
window.lno.news.refreshPane = function(){
    window.lno.news.scrollPane.data('jsp').reinitialise();
    $("#newsNode>.listing>.news").live("click", function(){
        var dataObj = {};
            dataObj.title = $(this).children(".title").html();
            dataObj.year = $(this).children(".year").html();
            dataObj.img = $(this).children(".img").children("img").attr("src");
            dataObj.content = $(this).children(".content").html();
        
        if(dataObj.img){
            $("#newsNode>.preview").html(_.template($("#newsImageType").html(), dataObj));
            $("#newsNode>.listing").hide();
            $("#newsNode>.preview").show();
        } else {
            $("#newsNode>.preview").html(_.template($("#newsTextType").html(), dataObj));
            $("#newsNode>.listing").hide();
            $("#newsNode>.preview").show();
        }
        window.lno.news.refreshPane();
    });
};
window.lno.news.closePreview = function(){
    $("#newsNode>.listing").show();
    $("#newsNode>.preview").hide();
    $("#newsNode>.preview").empty();
    window.lno.news.refreshPane();
};
