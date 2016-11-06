function test(Names, cat_count) {
    if (Names == 0) {
        for (var j = 1; j <= cat_count; j++) $(".cat" + j).css("display", "");
        return;
    }
    for (var j = 1; j < Names; j++) $(".cat" + j).css("display", "none");
    $(".cat" + Names).css("display", "");
    for (var j = parseInt(Names) + 1; j <= cat_count; j++) $(".cat" + j).css("display", "none");
}
$(document).foundation();