$(".good").mouseenter(function(){
    $(this).stop().animate({opacity:'0.5'},"fast");
});
$(".good").mouseleave(function(){
    $(".good").stop().animate({opacity:'1.0'},"fast");
});