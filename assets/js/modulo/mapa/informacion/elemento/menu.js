var MapaInformacionElementoMenu = Class({ 
    elemento : null,
    
    /**
     * Carga de dependencias
     * @returns void
     */
    __construct : function(elemento) {
        this.elemento = elemento;
    },
    
    /**
     * 
     * @returns {undefined}
     */
    _hideMenu : function(){
        if(context_menu!=null){
            context_menu.hide();    
            context_menu = null;
        }
    },
    
    /**
     * 
     * @param {type} mapa
     * @param {type} lista_elementos
     * @param {type} posicion
     * @returns {undefined}
     */
    _menu : function(mapa, lista_elementos, posicion, funcion_popup){
        var yo = this;
        
        var contextMenuOptions={}; 
        
        contextMenuOptions.classNames = {
            menu:'context_menu', 
            menuSeparator:'context_menu_separator'
        }; 

        var menuItems=[]; 
       
        if(lista_elementos.length > 1){
          /*  menuItems.push({
                className:'context_menu_item', 
                eventName:'informacion_interseccion', 
                label:'<i class=\"fa\"><strong>∩</strong></i> Ver datos intersección '
            });
            
            menuItems.push({});*/
        }
                
        $.each(lista_elementos, function(i, elemento){
            
            if(elemento.capa == null){
                var nombre = elemento.informacion.NOMBRE;
            } else {
                var nombre = elemento.nombre;
            }
            
            menuItems.push({
                className:'context_menu_item', 
                eventName:'informacion_elemento__' + elemento.tipo + "__" + elemento.clave + "__" + elemento.identificador, 
                label:'<div class="row">'
                       + '<div class="col-xs-2"><div class="color-capa-preview" style="background-color:' + elemento.fillColor + '"></div></div>'
                       + '<div class="col-xs-10">' + nombre + '</div>'
                    + '</div>'
            });
        });
        
        contextMenuOptions.menuItems = menuItems; 

        var contextMenu = new ContextMenu(
            mapa , 
            contextMenuOptions
        ); 
        
        google.maps.event.addListener(contextMenu, 'loaded', function(e){ 
            contextMenu.show(posicion);
        }); 

        google.maps.event.addListener(contextMenu, 'menu_item_selected', function(latLng, eventName){
            switch(eventName){
                case 'informacion_interseccion':
                    contextMenu.hide();                    
                break;
                default:
                    contextMenu.hide();   
                    var separar = eventName.split("__");
                    var mostrar = jQuery.grep(lista_poligonos, function( a ) {
                        if(separar[1] == "CIRCULO LUGAR EMERGENCIA"){
                            if(a["identificador"] == separar[3]){
                                return true;
                            }
                        } else if(a["clave"] == separar[2]){
                            return true;
                        }
                    });
                    funcion_popup(mostrar);
                break;
            }

	});
        
        context_menu = contextMenu;
    },
    
    /**
     * 
     * @param {type} mapa
     * @param {type} lista_elementos
     * @param {type} posicion
     * @param {type} funcion_popup
     * @returns {undefined}
     */
    render : function(mapa, lista_elementos, posicion, funcion_popup){
        var yo = this;
        this._hideMenu();
        
        console.log(lista_elementos);
        console.log(lista_elementos.length);
        if(lista_elementos.length == 1){
            funcion_popup(lista_elementos);
        } else {
            
            yo._menu(mapa, lista_elementos, posicion, funcion_popup);
        }

    }
});


