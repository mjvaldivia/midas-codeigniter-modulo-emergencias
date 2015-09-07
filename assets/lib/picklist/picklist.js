/**
 * Created by claudio on 17-08-15.
 */
(function ( $ ) {

    $.fn.picklist = function(opciones) {
        var element = this;
        var self = {
            id: null,
            opciones: null,
            elemento: element
        };

        __checkeaId(self);

        opcionesPorDefecto = {
            "idSelectDisponibles": self.id + "_disponibles",
            "idSelectSeleccionados": self.id + "_seleccionados",

            "textBtnAgregar": "",
            "iconBtnAgregar": "ui-icon ui-icon-arrow-1-e",
            "classBtnAgregar": "btn btn-xs btn-default",

            "textBtnAgregarTodos": "",
            "iconBtnAgregarTodos": "ui-icon ui-icon-arrowstop-1-e",
            "classBtnAgregarTodos": "btn btn-xs btn-default",

            "textBtnQuitar": "",
            "iconBtnQuitar": "ui-icon ui-icon-arrow-1-w",
            "classBtnQuitar": "btn btn-xs btn-default",

            "textBtnQuitarTodos": "",
            "iconBtnQuitarTodos": "ui-icon ui-icon-arrowstop-1-w",
            "classBtnQuitarTodos": "btn btn-xs btn-default",

            "classSelectDisponibles": "form-control",
            "classSelectSeleccionados": "form-control",
        }
        self.opciones = $.extend(opcionesPorDefecto, opciones);

        $(element).css("display", "none");
        __creaPickList(self);
        __creaEventos(self);

        function __checkeaId(self) {
            if ($(element).attr("id")) {
                self.id = $(element).attr("id");
            } else {
                do {
                    var id = __random(1, 1000);
                } while (!$("#"+id).length);
                self.id = id;
            }
        }

        function __random(min, max) {
            return Math.random() * (max - min) + min;
        }

        function __creaPickList(self) {
            var disponibles = $(element).find("option");
            var elementoPadre = $(element).parent().get(0);

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
            iconBtnAgregar.setAttribute("class", self.opciones.iconBtnAgregar);

            var iconBtnAgregarTodos = document.createElement("i");
            iconBtnAgregarTodos.setAttribute("class", self.opciones.iconBtnAgregarTodos);

            var iconBtnQuitar = document.createElement("i");
            iconBtnQuitar.setAttribute("class", self.opciones.iconBtnQuitar);

            var iconBtnQuitarTodos = document.createElement("i");
            iconBtnQuitarTodos.setAttribute("class", self.opciones.iconBtnQuitarTodos);

            var btnAgregar = document.createElement("a");
            btnAgregar.setAttribute("id", "picklist-btn-" + self.id + "-a");
            btnAgregar.setAttribute("href", "javascript:void(0)");
            btnAgregar.appendChild(iconBtnAgregar);

            var btnQuitar = document.createElement("a");
            btnQuitar.setAttribute("id", "picklist-btn-" + self.id + "-q");
            btnQuitar.setAttribute("href", "javascript:void(0)");
            btnQuitar.appendChild(iconBtnQuitar);

            var btnAgregarTodos = document.createElement("a");
            btnAgregarTodos.setAttribute("id", "picklist-btn-" + self.id + "-at");
            btnAgregarTodos.setAttribute("href", "javascript:void(0)");
            btnAgregarTodos.appendChild(iconBtnAgregarTodos);

            var btnQuitarTodos = document.createElement("a");
            btnQuitarTodos.setAttribute("id", "picklist-btn-" + self.id + "-qt");
            btnQuitarTodos.setAttribute("href", "javascript:void(0)");
            btnQuitarTodos.appendChild(iconBtnQuitarTodos);

            btnAgregar.appendChild(document.createTextNode(self.opciones.textBtnAgregar));
            btnAgregar.setAttribute("title", "Agregar");
            btnAgregar.setAttribute("class", self.opciones.classBtnAgregar);

            btnAgregarTodos.appendChild(document.createTextNode(self.opciones.textBtnAgregarTodos));
            btnAgregarTodos.setAttribute("title", "Agregar todos");
            btnAgregarTodos.setAttribute("class", self.opciones.classBtnAgregarTodos);

            btnQuitar.appendChild(document.createTextNode(self.opciones.textBtnQuitar));
            btnQuitar.setAttribute("title", "Quitar");
            btnQuitar.setAttribute("class", self.opciones.classBtnQuitar);

            btnQuitarTodos.appendChild(document.createTextNode(self.opciones.textBtnQuitarTodos));
            btnQuitarTodos.setAttribute("title", "Quitar todos");
            btnQuitarTodos.setAttribute("class", self.opciones.classBtnQuitarTodos);

            var selectDisponibles = document.createElement("select");
            var selectSeleccionados = document.createElement("select");

            selectDisponibles.setAttribute("multiple", "true");
            selectDisponibles.setAttribute("id", self.opciones.idSelectDisponibles);
            selectDisponibles.setAttribute("class", self.opciones.classSelectDisponibles);

            selectSeleccionados.setAttribute("multiple", "true");
            selectSeleccionados.setAttribute("id", self.opciones.idSelectSeleccionados);
            selectSeleccionados.setAttribute("class", self.opciones.classSelectSeleccionados);

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

        function __creaEventos(self) {
            $("#picklist-btn-" + self.id + "-a").click(function() {
                var seleccionados = $("#" + self.opciones.idSelectDisponibles + " option:selected");
                if (!seleccionados.length) { return; }

                var valores = $(self.elemento).val() || [];

                $.each(seleccionados, function (i, item) {
                    $("#" + self.opciones.idSelectSeleccionados).append($("<option>", {
                        value: item.value,
                        text : item.text
                    }));
                    valores.push(item.value);
                    $(item).remove();
                });

                $(self.elemento).val(valores);
            });

            $("#picklist-btn-" + self.id + "-q").click(function() {
                var seleccionados = $("#" + self.opciones.idSelectSeleccionados + " option:selected");
                if (!seleccionados.length) { return; }
                var noSeleccionados = $("#" + self.opciones.idSelectSeleccionados + " option:not(:selected)");

                var valores = [];

                $.each(seleccionados, function (i, item) {
                    $("#" + self.opciones.idSelectDisponibles).append($("<option>", {
                        value: item.value,
                        text : item.text
                    }));
                    $(item).remove();
                });

                $.each(noSeleccionados, function(i, item) {
                    valores.push(item.value);
                });

                $(self.elemento).val(valores);
            });

            $("#picklist-btn-" + self.id + "-at").click(function() {
                var seleccionados = $("#" + self.opciones.idSelectDisponibles + " option");
                if (!seleccionados.length) { return; }

                var valores = [];
                $.each(seleccionados, function (i, item) {
                    $("#" + self.opciones.idSelectSeleccionados).append($("<option>", {
                        value: item.value,
                        text : item.text
                    }));
                    valores.push(item.value);
                    $(item).remove();
                });
                $(self.elemento).val(valores);
            });

            $("#picklist-btn-" + self.id + "-qt").click(function() {
                var seleccionados = $("#" + self.opciones.idSelectSeleccionados + " option");
                if (!seleccionados.length) { return; }

                var valores = [];
                $.each(seleccionados, function (i, item) {
                    $("#" + self.opciones.idSelectDisponibles).append($("<option>", {
                        value: item.value,
                        text : item.text
                    }));
                    $(item).remove();
                });

                $(self.elemento).val(valores);
            });
        }
    };

}(jQuery));