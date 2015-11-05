/**
 * @author Vladimir Esparza
 * 
 * @type type
 * ejemplo de uso <a data-toggle="modal" class='modal-sipresa' href="test2.html" data-title="Información de la actividad" data-success='funcion js que dibujará en el boton aceptar' data-target="#myModal">Click me !</a>
 * si data-sucess es vacio o no existe no dibuja el boton aceptar, y solo dibuja el cerrar
 */

var ModalSipresa = {
  
    addSuccess: function (id,a,href){    
        

            var modal = $('#'+id);
             if($('#'+id+' .modal-content').length<1){
             modal.find(' .modal-dialog').append('<div class="modal-content"></div>');
         }
         
         
            if($('#'+id+' .modal-header').length<1){
             modal.find(' .modal-content').append('<div class="modal-header">'+
                        '<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick=ModalSipresa.close_modal("'+id+'"); >&times;</button>'+
                        '<h4 class="modal-title">'+a.attr("data-title")+'</h4>'+
                        '</div>');
            }  
            
           $('#'+id+' .modal-content').append('<div class="modal-body" style="overflow:hidden;"></div>');
            $('#'+id+' .modal-body').load(href);
            
            
            
            
                if($('#'+id+' .modal-footer').length<1){
                    if(a.attr("data-success") || a.attr("data-success-title"))
                    {
                        var title_aceptar = (a.attr("data-success-title"))? a.attr("data-success-title") : 'Aceptar';
                        modal.find(' .modal-body').after('<div class="modal-footer">'+
                            '<button type="button" class="btn btn-default" onclick='+a.attr("data-success")+';ModalSipresa.close_modal(\''+id+'\'); >'+title_aceptar+'</button>'+
                            '<button type="button" class="btn btn-primary" data-dismiss="modal" onclick=ModalSipresa.close_modal("'+id+'"); >Cerrar</button>'+
                            '</div>');
                    }
                    else
                    {
                       modal.find(' .modal-body').after('<div class="modal-footer">'+
                            '<button type="button" class="btn btn-primary" data-dismiss="modal" onclick=ModalSipresa.close_modal("'+id+'"); >Cerrar</button>'+
                            '</div>'); 

                    }
                }


  },
    
    
    close_modal : function (id){
        $('#'+id).remove();$(".modal-backdrop").last().remove();$("body").removeClass("modal-open");$("body").css({'padding-right':0});
    }
};