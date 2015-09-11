$( document ).ajaxStart(function() {
 $('.cargando').fadeToggle('slow');

});
$( document ).ajaxStop(function() {
$('.cargando').fadeToggle('slow');
});

