 function ajaxYhc(type,url,data,sfun,efun){
    var loading;
    $.ajax({
        url:url,
        type:type,
        contentType:"application/x-www-form-urlencoded",
        data:data,
        time:60,
        async:true,
        dataType:'json',
        beforeSend: function(){
           loading= layer.load(1, {shade: [0.3,'#000']});
        },
        success:function(result) {
            console.log(result);
            if(result.code==0){
                if(sfun){
                    sfun(result);
                }else{
                    layer.msg(result.msg);
                }
            }else if(result.code==-1){
                layer.msg('请先登录');
                setTimeout('top.location.href="index.html";',800);
            }else{
                if(efun){
                    efun(result);
                }else{
                    layer.msg(result.msg);
                }
                return;
            }
        },complete:function(){
            layer.close(loading);
        },error:function(result){
            layer.msg('请求失败，请重试');
            console.log("AJAX ERROR",result);
        }
    })
}