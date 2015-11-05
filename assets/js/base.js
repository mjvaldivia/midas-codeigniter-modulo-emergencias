//Sidebar Toggle
$("#sidebar-toggle").click(function(e) {
    e.preventDefault();
    $(".navbar-side").toggleClass("collapsed");
    $("#page-wrapper").toggleClass("collapsed");
});

//Portlet Icon Toggle
$(".portlet-widgets .fa-chevron-down, .portlet-widgets .fa-chevron-up").click(function() {
    $(this).toggleClass("fa-chevron-down fa-chevron-up");
});

$(function() {
    $('.page-content').addClass('page-content-ease-in');
});

