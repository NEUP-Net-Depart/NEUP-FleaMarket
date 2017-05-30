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
function sort(ha){
    var hr=window.location;
   var a= $.get(hr);
    alert(a.sort);
}
function setc(ha){
    var hr="/good/?";
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
    location.href=hr;
}