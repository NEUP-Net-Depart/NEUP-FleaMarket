$(".good").mouseenter(function(){
    $(this).animate({opacity:'0.5'},10.0);
});
$(".good").mouseleave(function(){
    $(".good").animate({opacity:'1.0'},10.0);
});
$(".cat").mouseenter(function(){
    $(this).animate({backgroundColor:'#3399CC'},10.0);
    $("a",this).animate({color:"#FFFFFF"},10.0);

});
$(".cat").mouseleave(function(){
    $(this).animate({backgroundColor:'#FFFFFF'},10.0);
    $("a",this).animate({color:"#1779ba"},10.0);
});