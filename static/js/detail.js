;
var ops={
    init:function(){
        this.eventBind();
        this.view();
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
                        $(".reply .alert-success").show();
                    }
                });
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
    }
}
$(document).ready(function(){


    ops.init();
});