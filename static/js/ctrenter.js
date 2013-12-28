;
jQuery.fn.extend({
    /**
     * ctrl+enter提交表单
     * @param {Function} fn 操作后执行的函数
     * @param {Object} thisObj 指针作用域
     */
    ctrlSubmit:function(fn,thisObj){
        var obj = thisObj || this;
        var stat = false;
        return this.each(function(){
            $(this).keyup(function(event){
                //只按下ctrl情况，等待enter键的按下
                if(event.keyCode == 17){
                    stat = true;
                    //取消等待
                    setTimeout(function(){
                        stat = false;
                    },300);
                }
                if(event.keyCode == 13 && (stat || event.ctrlKey)){
                    fn.call(obj,event);
                }
            });
        });
    }
});