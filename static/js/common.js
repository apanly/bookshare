;
$(".thumbnail img").each(function(){
    $(this).bind("error",function(){
        this.src="static/img/bookerror.jpg";
    });
    $(this).click(function(){
       window.location.href=$(this).attr("hrefsrc");
    });
});
$(".row-fluid .span4 img").each(function(){
    $(this).bind("error",function(){
        this.src="static/img/bookerror.jpg";
    });
});

if(window && window.console!=undefined){
    window.console.log("一本书籍,要经历多少次阅读,才能让世人明白它的心?");
    window.console.log("一位新人,要经历多少时光,才能阅读世间好书?");
    window.console.log("分享你的书籍");
    window.console.log("体验助人的快乐");
    window.console.log("快使用ShareBook");
    window.console.log("人人为我,我为人人,我们,可以影响世界");
}
