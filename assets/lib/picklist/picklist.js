/**
 * Created by claudio on 17-08-15.
 */
(function ( $ ) {

    $.fn.picklist = function(options) {
        this.self = {};

        var checkeaId = function() {
            if ($(this.elemento).attr("id")) {
                this.id = $(this.elemento).attr("id");
            } else {
                do {
                    var id = __random(1, 1000);
                } while (!$("#"+id).length);
                this.id = id;
            }
        };

        var random = function (min, max) {
            return Math.random() * (max - min) + min;
        };

        var creaPickList = function () {
            var disponibles = $(this.elemento).find("option");
            var elementoPadre = $(this.elemento).parent().get(0);

            var labelDisponibles = document.createElement("label");
            labelDisponibles.appendChild(document.createTextNode("Disponibles"));

            var labelSeleccionados = document.createElement("label");
            labelSeleccionados.appendChild(document.createTextNode("Seleccionados"));

            var contenedor = document.createElement("div");

            var contenedorDisponibles = document.createElement("div");
            contenedorDisponibles.appendChild(labelDisponibles);
            contenedorDisponibles.setAttribute("class", "picklist disponibles");

            var contenedorSeleccionadas = document.createElement("div");
            contenedorSeleccionadas.appendChild(labelSeleccionados)
            contenedorSeleccionadas.setAttribute("class", "picklist seleccionados");

            var contenedorBotonera = document.createElement("div");
            contenedorBotonera.setAttribute("class", "picklist botonera");
            contenedorBotonera.appendChild(document.createElement("label"));

            var iconBtnAgregar = document.createElement("i");
            iconBtnAgregar.setAttribute("class", this.opciones.iconBtnAgregar);

            var iconBtnAgregarTodos = document.createElement("i");
            iconBtnAgregarTodos.setAttribute("class", this.opciones.iconBtnAgregarTodos);

            var iconBtnQuitar = document.createElement("i");
            iconBtnQuitar.setAttribute("class", this.opciones.iconBtnQuitar);

            var iconBtnQuitarTodos = document.createElement("i");
            iconBtnQuitarTodos.setAttribute("class", this.opciones.iconBtnQuitarTodos);

            var btnAgregar = document.createElement("a");
            btnAgregar.setAttribute("id", "picklist-btn-" + this.id + "-a");
            btnAgregar.setAttribute("href", "javascript:void(0)");
            btnAgregar.appendChild(iconBtnAgregar);

            var btnQuitar = document.createElement("a");
            btnQuitar.setAttribute("id", "picklist-btn-" + this.id + "-q");
            btnQuitar.setAttribute("href", "javascript:void(0)");
            btnQuitar.appendChild(iconBtnQuitar);

            var btnAgregarTodos = document.createElement("a");
            btnAgregarTodos.setAttribute("id", "picklist-btn-" + this.id + "-at");
            btnAgregarTodos.setAttribute("href", "javascript:void(0)");
            btnAgregarTodos.appendChild(iconBtnAgregarTodos);

            var btnQuitarTodos = document.createElement("a");
            btnQuitarTodos.setAttribute("id", "picklist-btn-" + this.id + "-qt");
            btnQuitarTodos.setAttribute("href", "javascript:void(0)");
            btnQuitarTodos.appendChild(iconBtnQuitarTodos);

            btnAgregar.appendChild(document.createTextNode(this.opciones.textBtnAgregar));
            btnAgregar.setAttribute("title", "Agregar");
            btnAgregar.setAttribute("class", this.opciones.classBtnAgregar);

            btnAgregarTodos.appendChild(document.createTextNode(this.opciones.textBtnAgregarTodos));
            btnAgregarTodos.setAttribute("title", "Agregar todos");
            btnAgregarTodos.setAttribute("class", this.opciones.classBtnAgregarTodos);

            btnQuitar.appendChild(document.createTextNode(this.opciones.textBtnQuitar));
            btnQuitar.setAttribute("title", "Quitar");
            btnQuitar.setAttribute("class", this.opciones.classBtnQuitar);

            btnQuitarTodos.appendChild(document.createTextNode(this.opciones.textBtnQuitarTodos));
            btnQuitarTodos.setAttribute("title", "Quitar todos");
            btnQuitarTodos.setAttribute("class", this.opciones.classBtnQuitarTodos);

            var selectDisponibles = document.createElement("select");
            var selectSeleccionados = document.createElement("select");

            selectDisponibles.setAttribute("multiple", "true");
            selectDisponibles.setAttribute("id", this.opciones.idSelectDisponibles);
            selectDisponibles.setAttribute("class", this.opciones.classSelectDisponibles);

            selectSeleccionados.setAttribute("multiple", "true");
            selectSeleccionados.setAttribute("id", this.opciones.idSelectSeleccionados);
            selectSeleccionados.setAttribute("class", this.opciones.classSelectSeleccionados);

            for (var i = 0; i < disponibles.length; i++) {
                var option = disponibles[i];
                var nodoOption = document.createElement("option");

                nodoOption.setAttribute("value", $(option).val());
                nodoOption.textContent = $(option).text();

                selectDisponibles.appendChild(nodoOption);
            }

            contenedorSeleccionadas.appendChild(selectSeleccionados);

            contenedorDisponibles.appendChild(selectDisponibles);

            contenedorBotonera.appendChild(btnAgregar);
            contenedorBotonera.appendChild(btnAgregarTodos);
            contenedorBotonera.appendChild(btnQuitar);
            contenedorBotonera.appendChild(btnQuitarTodos);

            contenedor.setAttribute("class", "picklist");
            contenedor.appendChild(contenedorDisponibles);
            contenedor.appendChild(contenedorBotonera);
            contenedor.appendChild(contenedorSeleccionadas);

            elementoPadre.appendChild(contenedor);
        }

        var creaEventos = function () {
            var _this = this;
            $("#picklist-btn-" + this.id + "-a").click(function() {
                var seleccionados = $("#" + _this.opciones.idSelectDisponibles + " option:selected");
                if (!seleccionados.length) { return; }

                var valores = $(_this.elemento).val() || [];

                $.each(seleccionados, function (i, item) {
                    $("#" + _this.opciones.idSelectSeleccionados).append($("<option>", {
                        value: item.value,
                        text : item.text
                    }));
                    valores.push(item.value);
                    $(item).remove();
                });

                $(_this.elemento).val(valores);
            });

            $("#picklist-btn-" + this.id + "-q").click(function() {
                var seleccionados = $("#" + _this.opciones.idSelectSeleccionados + " option:selected");
                if (!seleccionados.length) { return; }
                var noSeleccionados = $("#" + _this.opciones.idSelectSeleccionados + " option:not(:selected)");

                var valores = [];

                $.each(seleccionados, function (i, item) {
                    $("#" + _this.opciones.idSelectDisponibles).append($("<option>", {
                        value: item.value,
                        text : item.text
                    }));
                    $(item).remove();
                });

                $.each(noSeleccionados, function(i, item) {
                    valores.push(item.value);
                });

                $(_this.elemento).val(valores);
            });

            $("#picklist-btn-" + this.id + "-at").click(function() {
                var seleccionados = $("#" + _this.opciones.idSelectDisponibles + " option");
                if (!seleccionados.length) { return; }

                var valores = [];
                $.each(seleccionados, function (i, item) {
                    $("#" + _this.opciones.idSelectSeleccionados).append($("<option>", {
                        value: item.value,
                        text : item.text
                    }));
                    valores.push(item.value);
                    $(item).remove();
                });
                $(_this.elemento).val(valores);
            });

            $("#picklist-btn-" + this.id + "-qt").click(function() {
                var seleccionados = $("#" + _this.opciones.idSelectSeleccionados + " option");
                if (!seleccionados.length) { return; }

                var valores = [];
                $.each(seleccionados, function (i, item) {
                    $("#" + _this.opciones.idSelectDisponibles).append($("<option>", {
                        value: item.value,
                        text : item.text
                    }));
                    $(item).remove();
                });

                $(_this.elemento).val(valores);
            });
        };

        var methods = {
            init: function(opciones) {
                self = {
                    id: null,
                    opciones: null,
                    elemento: this
                };

                checkeaId.call(self);

                opcionesPorDefecto = {
                    "idSelectDisponibles": self.id + "_disponibles",
                    "idSelectSeleccionados": self.id + "_seleccionados",

                    "textBtnAgregar": "",
                    "iconBtnAgregar": "fa fa-angle-right",
                    "classBtnAgregar": "btn btn-xs btn-default",

                    "textBtnAgregarTodos": "",
                    "iconBtnAgregarTodos": "fa fa-angle-double-right",
                    "classBtnAgregarTodos": "btn btn-xs btn-default",

                    "textBtnQuitar": "",
                    "iconBtnQuitar": "fa fa-angle-left",
                    "classBtnQuitar": "btn btn-xs btn-default",

                    "textBtnQuitarTodos": "",
                    "iconBtnQuitarTodos": "fa fa-angle-double-left",
                    "classBtnQuitarTodos": "btn btn-xs btn-default",

                    "classSelectDisponibles": "form-control",
                    "classSelectSeleccionados": "form-control",
                }
                self.opciones = $.extend(opcionesPorDefecto, opciones);
                $(self.elemento).css("display", "none");

                creaPickList.call(self);
                creaEventos.call(self);
                
                
                if(self.opciones.value){
                    $('#'+self.opciones.idSelectDisponibles).val(self.opciones.value);
                } else {
                    var seleccionado = [];
                    $.each( $("#" + self.id).find(":selected"), function(i,val){
                        seleccionado.push($(val).attr("value"));
                    });
                    $('#'+self.opciones.idSelectDisponibles).val(seleccionado);
                }
                
                $("#picklist-btn-" + self.id + "-a").trigger('click');
                
            },

            destroy: function() {
                $(this).parent().find("div.picklist").remove();
                $(this).css("display", "block");
            },

            reset: function() {
                $("#picklist-btn-" + self.id + "-qt").click();
            }
        };

        if (methods[options]) {
            return methods[options].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if ( typeof options === 'object' || ! options ) {
            return methods.init.apply(this, arguments);
        }
    };
}(jQuery));
