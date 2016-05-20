var hospital_marcador = [];

var MapaHospital = Class({  
    
    /**
     * Google maps
     */
    mapa : null,
        
    /**
     * Setea mapa
     * @param {googleMap} mapa
     * @returns {undefined}
     */
    seteaMapa : function(mapa){
        this.mapa = mapa;
    },
    
    /**
     * Carga el KML desde conaf
     * @returns {void}
     */
    load : function(){
        var yo = this;
        if(hospital_marcador.length == 0){ //si ya esta cargado no se vuelve a cargar
            Messenger().run({
                action: $.ajax,
                successMessage: '<strong> Hospitales </strong> <br> Ok',
                errorMessage: '<strong> Hospitales </strong> <br> No se pudo recuperar la información de los hospitales. <br/> Espere para reintentar',
                showCloseButton: true,
                progressMessage: '<strong> Hospitales </strong> <br> <i class=\"fa fa-spin fa-spinner\"></i> Cargando...'
            },{        
                dataType: "json",
                cache: false,
                async: true,
                data: "",
                type: "post",
                url: baseUrl + getController() + "/info_hospitales", 
                success:function(json){
                    if(json.correcto){
                        $.each(json.lista, function(i, valor){
                            
                            switch(valor.id_estado){
                                
                                case "2":
                                    var icono = baseUrl + "assets/img/markers/hospital-amarillo.png"
                                    break;
                                case "3":
                                    var icono = baseUrl + "assets/img/markers/hospital-rojo.png"
                                    break;
                                default:
                                    var icono = baseUrl + "assets/img/markers/hospital-verde.png"
                                    break;
                            }
                            
                            
                            var marcador = new MapaMarcadorLabel();
                            marcador.seteaMapa(yo.mapa);
                            marcador.posicionarMarcador("hospitales_" + valor.id, "" , valor.lng, valor.lat, null, valor.propiedades, icono);
                            hospital_marcador.push("hospitales_" + valor.id);
                        });
                    } else {
                        notificacionError("", "No es posible encontrar la información de los hospitales.");
                    }
               }
            });
        }
    },
    
    /**
     * Quita los marcadores
     * @returns {undefined}
     */
    remove : function(){
        var marcador = new MapaMarcador();
        $.each(hospital_marcador, function(i, identificador){
            marcador.removerMarcadores("identificador", identificador);
        });
        
        hospital_marcador= [];
    }
});
