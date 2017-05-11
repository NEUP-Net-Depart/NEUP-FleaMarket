
$(document).ready(function() {
            $list = $(".list");
           // $list.eq(0).addClass("active");
            $list.mouseover(function(){
                $(this).find("img").css("display","block");
                $(this).siblings().find("img").css("display","none");
           });
            $("table").mouseleave(function(){
                $(this).find("img").css("display","none");
            });
        });

