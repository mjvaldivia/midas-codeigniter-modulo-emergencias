var Soportes = {};

(function() {

    this.init = function(){
        var tablaSoportes = $("#tabla_soportes").DataTable({
            language: {
                url: baseUrl + "assets/lib/DataTables-1.10.8/Spanish.json"
            },
            order: [[0, "desc"]]
        });
    }

}).apply(Soportes);