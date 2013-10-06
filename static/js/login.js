;
$(document).ready(function(){
  $(".form-signin").submit(function(){
     return false;
  });
  $("#loginbutton").click(function(){
        var username= $.trim($("#username").val());
        var pwd= $.trim($("#password").val());
       if(username.length<=0 || pwd.length<=0){
           alert("请输入用户名和密码");
           return false;
       }
        $.ajax({
          type:"POST",
          url:"index.php?a=dologin",
          data:{'username':username,'password':pwd},
          dataType:'json',
          success:function (response) {
              var code = response.code;
              if (code == 1) {
                  window.location.href="index.php";
              } else {
                  alert("登录失败");
              }
          }
        });
  });
});
