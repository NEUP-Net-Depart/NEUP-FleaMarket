
function editfav(){
    $(".cb").attr("style","visibility:show;width:30px;height:30px;");
    $(".cb").removeAttr("checked");
    $("#editbutton").attr("onclick","back()");
    $("#editbutton").text("返回");
    $("#del_submit").show();
}
function back(){
    $(".cb").attr("style","visibility:hidden;width:30px;height:30px;");
    $("#editbutton").attr("checked",'true');
    $("#editbutton").text("编辑收藏夹");
    $("#editbutton").attr("onclick","editfav()");
    $("#del_submit").hide();
}
function submitdel(){
    if(confirm("你真的不爱它们了么？")) {
        $(".cb").each(function () {
            if ($(this).attr("value") != 0) {
                $(this).parents(".good").hide();
            }
        });
        var str_data1 = $('#favdel').serialize();
        var str_data = str_data1 + '&_method=DELETE';
        $.ajax({
            type: "POST",
            url: "/user/fav/del",
            data: str_data,
            success: function (msg) {


            }
        });
    }
}
function setValue(good_id) {
    if (document.getElementById("box" + good_id).value == good_id)
        document.getElementById("box" + good_id).value = 0;
    else
        document.getElementById("box" + good_id).value = good_id;
}
confirm:function a(msg,fn){
    //fn为回调函数，参数和show方法的一致
    this.show({buttons:{yes:'确认',no:'取消'},msg:msg,title:'提示',fn:fn});
}