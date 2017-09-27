$(document).ready(function(){
    switch ($("#nm").val()){
        case "p":
            $("#sort").text('按价格从低到高');break;
        case "pd":
            $("#sort").text("按价格从高到低");break;
        case "c":
            $("#sort").text("按库存从少到多");break;
        case "cd":
            $("#sort").text("按库存从多到少");break;
    }
});

$(".good").mouseenter(function(){
    $(this).stop().animate({opacity:'0.5'},"fast");
});
$(".good").mouseleave(function(){
    $(".good").stop().animate({opacity:'1.0'},"fast");
});

$("#ppx").click(function(){
    $(this).attr("href","/good/?sort=pd");
})
function sq(px,sx){
    $.get("/good/",function(data,status){
        alert("Data: " + data + "nStatus: " + status);
    });
}
function setprice(){
    var hr="/good/?";
    if($("#priceSet1").val()!=""){
        hr=hr+"start_price="+$("#priceSet1").val();
    }
    if($("#priceSet2").val()!=""){
        if($("#priceSet1").val()!=""){
            hr=hr+"&";
        }
        hr=hr+"end_price="+$("#priceSet2").val();
    }
    location.href=hr;
}
function setc(ha){
    var hr="/good?";
    if($("#priceSet1").val()!=""){
        hr=hr+"&start_price="+$("#priceSet1").val();
    }
    if($("#priceSet2").val()!=""){
        hr=hr+"&end_price="+$("#priceSet2").val();
    }
    if($("#pricec").val()!=""){
        hr=hr+"&start_count="+$("#pricec").val();
    }
    if(ha!="a"){
        hr=hr+"&sort="+ha;
    }
    else if($("#nm").val()!=""){
        hr=hr+"&sort="+$("#nm").val();
    }
    if($("#searchq").val()!=""){
        hr=hr+"&query="+$("#searchq").val();
    }
    if(getUrlParam('cat_id'))
        hr = hr + '&cat_id=' + getUrlParam('cat_id');
    location.href=hr;
}

function getUrlParam(name)
{
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r != null)
        return r[2];
    return null;
}

function price(start, end)
{
    $('#priceSet1').val(start);
    $('#priceSet2').val(end);
    setc('a');
}

function price2(start)
{
    $('#priceSet1').val(start);
    $('#priceSet2').val('2147483647');
    setc('a');
}