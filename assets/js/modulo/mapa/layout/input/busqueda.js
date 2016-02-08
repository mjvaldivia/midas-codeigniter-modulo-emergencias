var marker_search = null;

var MapaLayoutInputBusqueda = Class({
    
    div : "",
    
    __construct : function(div) {
        this.div = div
        this.html();
    },
    
    /**
     * Carga el HTML del buscador
     * @returns {undefined}
     */
    html : function(){
      $("body").append("<div class=\"row hidden\">"
                     + "<div id=\"" + this.div + "\" class=\"input-group\" style=\"width:600px;padding-right:50px\">"
                     + "<span class=\"input-group-addon\"><i class=\"fa fa-search\"></i></span>"
                     + "<input id=\"" + this.div + "-input\" class=\"form-control\" type=\"text\" placeholder=\"Buscar dirección\">"
                     + "</div>"
                     + "</div>");
    },
    
    /**
     * Agrega el buscador al mapa
     * @param {type} map
     * @returns {undefined}
     */
    addToMap : function(map){
        var yo = this;
        $("#" + this.div).parent().removeClass("hidden");
        var input = document.getElementById($("#" + this.div).children('input').attr("id"));
   
        ac = new google.maps.places.Autocomplete(input, {
            componentRestrictions: {country: 'cl'}
        });

        ac.addListener('place_changed', function () {
            var place = ac.getPlace();
            if (place.length === 0) {
                return;
            }
            yo.marker(map, place.geometry.location);
        });
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(document.getElementById('busqueda'));
    },
    
    
    /**
     * Posiciona el marcador
     * @param {type} map
     * @param {type} location
     * @returns {undefined}
     */
    marker : function(map, location){
        map.setCenter(location);

        //se borra marcador de busqueda si ya existia
        if(!(marker_search == null)){
            marker_search.setMap(null);
            marker_search = null;
        }

        //se agrega marcador
        var marker = new google.maps.Marker({
            position: location,
            icon: {
              path: google.maps.SymbolPath.BACKWARD_CLOSED_ARROW,
              scale: 3
            },
            draggable: true,
            map: map
        });

        marker.setAnimation(google.maps.Animation.BOUNCE);
        
        marker_search = marker;
        
        this.listenerRightClick(map);
    },
    
    /**
     * 
     * @param {type} mapa
     * @returns {undefined}
     */
    listenerRightClick : function(mapa){
        var yo = this;
        
        var contextMenuOptions={}; 
        
        contextMenuOptions.classNames = {
            menu:'context_menu', 
            menuSeparator:'context_menu_separator'
        }; 

        var menuItems=[]; 
       
        menuItems.push({
            className:'context_menu_item', 
            eventName:'quitar_marcador_busqueda', 
            label:'<i class=\"fa fa-plus\"></i> Quitar marcador '
        });

        contextMenuOptions.menuItems = menuItems; 

        var contextMenu = new ContextMenu(
            mapa , 
            contextMenuOptions
        ); 

        google.maps.event.addListener(marker_search, 'rightclick', function(mouseEvent){ 
            contextMenu.show(mouseEvent.latLng); 
        }); 

        google.maps.event.addListener(contextMenu, 'menu_item_selected', function(latLng, eventName){
            switch(eventName){
                case 'quitar_marcador_busqueda':
                    marker_search.setMap(null);
                    marker_search = null;
                    contextMenu.hide();
                break;
            }
	});
    },
});


