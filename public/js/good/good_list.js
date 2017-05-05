$(".good").mouseenter(function(){
    $(this).animate({opacity:'0.5'},"fast");
});
$(".good").mouseleave(function(){
    $(".good").animate({opacity:'1.0'},"fast");
});
$(".cat").mouseenter(function(){
    $(this).animate({backgroundColor:'#3399CC'},"fast");
    $("a",this).animate({color:"#FFFFFF"},"fast");

});
$(".cat").mouseleave(function(){
    $(this).animate({backgroundColor:'#FFFFFF'},"fast");
    $("a",this).animate({color:"#1779ba"},"fast");
});

