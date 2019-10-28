 function ajaxYhc(type,url,data,sfun,efun){
    var loading;
    $.ajax({
        url:url,
        type:type,
        contentType:"application/x-www-form-urlencoded",
        data:data,
        async:true,
        dataType:'json',
        beforeSend: function(){
           $.showLoading();
       },
       success:function(result) {
         $.hideLoading();
        console.log(result);
        if(result.code==0){
            if(sfun){
                sfun(result);
            }else{
                $.toast(result.msg,'text');
            }
        }else if(result.code==-1){
           $.toast('请先登录','text');
           setTimeout('top.location.href="index.html";',800);
       }else{
        if(efun){
            efun(result);
        }else{
          $.toast(result.msg,'text');
      }
      return;
  }
},complete:function(){

},error:function(result){

  $.toast('请求失败，请重试','text');
  console.log("AJAX ERROR",result);
}
})
}