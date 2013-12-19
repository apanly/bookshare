;
$(document).ready(function(){
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
});