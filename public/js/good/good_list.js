$(".good").mouseenter(function(){
    $(this).stop().animate({opacity:'0.5'},"fast");

});
$(".good").mouseleave(function(){
    $(".good").stop().animate({opacity:'1.0'},"fast");
});
$(".cat").mouseenter(function(){
    $(this).stop().animate({backgroundColor:'#3399CC'},"fast");
    $("a",this).stop().animate({color:"#FFFFFF"},"fast");

});
$(".cat").mouseleave(function(){
    $(this).stop().animate({backgroundColor:'#FFFFFF'},"fast");
    $("a",this).stop().animate({color:"#1779ba"},"fast");
});

