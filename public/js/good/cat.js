$(".cat").mouseenter(function(){
    $(this).stop().animate({backgroundColor:'#3399CC'},"fast");
    $("a",this).stop().animate({color:"#FFFFFF"},"fast");

});
$(".cat").mouseleave(function(){
    $(this).stop().animate({backgroundColor:'#FFFFFF'},"fast");
    $("a",this).stop().animate({color:"#1779ba"},"fast");
});