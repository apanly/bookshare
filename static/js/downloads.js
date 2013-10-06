;
$(document).ready(function() {
    $(".imageRotation").each(function(){
        // 获取有关参数
        var imageRotation = this,  // 图片轮换容器
            imageBox = $(imageRotation).children(".imageBox")[0],  // 图片容器
            titleBox = $(imageRotation).children(".titleBox")[0],  // 标题容器
            titleArr = $(titleBox).children(),  // 所有标题（数组）
            icoBox = $(imageRotation).children(".icoBox")[0],  // 图标容器
            icoArr = $(icoBox).children(),  // 所有图标（数组）
            imageWidth = $(imageRotation).width(),  // 图片宽度
            imageNum = $(imageBox).children().size(),  // 图片数量
            imageReelWidth = imageWidth*imageNum,  // 图片容器宽度
            preBut = $(imageRotation).children(".pre")[0],  // 上一张图片
            nextBut = $(imageRotation).children(".next")[0],  // 上一张图片
            activeID = parseInt($($(icoBox).children(".active")[0]).attr("rel")),  // 当前图片ID
            nextID = 0,  // 下张图片ID
            setIntervalID,  // setInterval() 函数ID
            isEnd=1,  // 动画是否执行完毕（请勿修改）  1：完毕  0：正在执行
            intervalTime = 3000,  // 间隔时间
            imageSpeed =500,  // 图片动画执行速度
            titleSpeed =250;  // 标题动画执行速度
        // 设置 图片容器 的宽度
        $(imageBox).css({'width' : imageReelWidth + "px"});
        // 图片轮换函数
        var rotate=function(clickID){
            if(isEnd){
                isEnd=0;
                var imageSpeedLong=imageSpeed>=titleSpeed*2 ? true : false; // 判断图片动画执行时间长还是标题动画执行时间长
                if(clickID){ nextID = clickID; }
                else{ nextID=activeID<=6 ? activeID+1 : 1; }
                // 交换图标
                $(icoArr[activeID-1]).removeClass("active");
                $(icoArr[nextID-1]).addClass("active");
                // 交换标题
                $(titleArr[activeID-1]).animate(
                    {bottom:"-40px"},
                    titleSpeed,
                    function(){
                        $(titleArr[nextID-1]).animate(
                            {bottom:"0px"} ,
                            titleSpeed ,
                            function(){ !imageSpeedLong ? isEnd=1 : false; }
                        );
                    }
                );
                // 交换图片
                $(imageBox).animate(
                    {left:"-"+(nextID-1)*imageWidth+"px"} ,
                    imageSpeed ,
                    function(){ imageSpeedLong ? isEnd=1 : false; }
                );
                // 交换IP
                activeID = nextID;
            }
        }
        setIntervalID=setInterval(rotate,intervalTime);
        // 鼠标移动到 动画容器 时，结束动画
        $(imageRotation).hover(
            function(){ clearInterval(setIntervalID); },
            function(){ setIntervalID=setInterval(rotate,intervalTime); }
        );
        $(".preNext").hover(
            function(){ $(this).animate({opacity:1}); },
            function(){ $(this).animate({opacity:0}); }
        );
        $(icoArr).click(function(){ rotate(parseInt($(this).attr("rel"))); });
        $(preBut).click(function(){ rotate(parseInt(activeID>1?activeID-1:imageNum)); });
        $(nextBut).click(function(){ rotate(parseInt(activeID<imageNum?activeID+1:1)); });
    });
});
