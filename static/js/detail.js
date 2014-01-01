;
var ops={
    init:function(){
        this.eventBind();
        this.view();
        this.getList();
    },
    eventBind:function(){
        var that=this;
        $("ul.nav-tabs li").each(function(idx){
            $(this).click({index:idx},function(event){
                var data=event.data;
                var idx=data['index'];
                if(idx==0){
                    $(".replylist").show();
                    $(".reply").hide();
                }else if(idx==1){
                    $(".reply").show();
                    $(".replylist").hide();
                }
                $(this).addClass("active");
                $(this).siblings().each(function(){
                    $(this).removeClass("active");
                })
            });
        });
        $("#replycontent").ctrlSubmit(function(){
                that.submitContent();
        });
        $(".reply .span4 .btn-primary").click(function(){
                that.submitContent();
        });
    },
    submitContent:function(){
        var request=GetRequest();
        var bookid=request['id'];
        if(/^\d*$/.test(bookid)){
            var content= $.trim($("#replycontent").val());
            if(content){
                $.ajax({
                    type:"POST",
                    url:"index.php?a=reply",
                    data:"id="+bookid+"&content="+content,
                    dataType:'json',
                    success:function (response) {
                        var code=response.code;
                        $(".reply .alert strong").html("发布成功!!");
                        $(".reply .alert").show();
                    }
                });
            }else{
                $(".reply .alert strong").html("请输入内容!!");
                $(".reply .alert").show();
            }
        }
    },
    view:function(){
        var request=GetRequest();
        var bookid=request['id'];
        if(/^\d*$/.test(bookid)){
            $.ajax({
                type:"POST",
                url:"index.php?a=view",
                data:"id="+bookid+"&flag="+ $.trim($("#bookdetail").val()),
                dataType:'json',
                success:function (response) {
                }
            });
        }
    },
    getList:function(){
        var request=GetRequest();
        var bookid=request['id'];
        if(/^\d*$/.test(bookid)){
            $.ajax({
                type:"POST",
                url:"index.php?a=replylist",
                data:"id="+bookid,
                dataType:'text',
                success:function (response) {
                    if(response){
                        $(".replylist").html(response);
                    }
                }
            });
        }
    },
    tabChange:function(flag){
        $($("ul.nav-tabs li").get(flag)).click();
    }
}
$(document).ready(function(){
    ops.init();
});