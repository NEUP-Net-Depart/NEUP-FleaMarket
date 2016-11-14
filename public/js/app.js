function goodList_changeCat(cat_id) {
    if (cat_id == 0) window.location.href = '/good';
    else window.location.href = '?cat_id=' + cat_id;
}
$(document).foundation();