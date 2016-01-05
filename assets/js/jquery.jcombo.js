/*!

 * jQuery jCombo Plugin
 * Carlos De Oliveira
 * cardeol@gmail.com
 *
 * Latest Release: Sep 2011 
 */
(function ($) {
    $.fn.jCombo = function (url, user_options) {
        var default_options = {
            parent: "",
            selected_value: "0",
            parent_value: "",
            initial_text: "-- Seleccione --",
            handlerLoad: ""
        };
        var user_options = $.extend(default_options, user_options);
        var obj = $(this);
        if (user_options.parent != "") {
            var $parent = $(user_options.parent);
            $parent.removeAttr("disabled", "disabled");
            //$parent.unbind('change');
            $parent.bind('change', function (e) {
                obj.attr("disabled", "disabled");
                if ($(this).val()) obj.removeAttr("disabled");
                __fill(obj,
                    url,
                    $(this).val(),
                    user_options.initial_text,
                    user_options.selected_value,
                    user_options.handlerLoad);
                //user_options.selected_value	= "0";
            });
        }
        __fill(obj, url, user_options.parent_value, user_options.initial_text, user_options.selected_value, user_options.handlerLoad);
        //user_options.selected_value	= "0";
        function __fill($obj, $url, $id, $initext, $inival, $handlerLoad) {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: $url + $id,
                success: function (j) {
                    var choices = '';
                    if (j.length == 0) {
                        choices += '<option value="0">-- Sin coincidencias --</option>';
                        $obj.html(choices);
                    } else {
                        if ($initext != "" && $initext != null && !$obj.attr("multiple")) {
                            choices += '<option value="0">' + $initext + '</option>';
                        }
                        for (var i = 0; i < j.length; i++) {
                            selected = (j[i][0] == $inival) ? ' selected="selected"' : '';
                            c = j[i];
                            choices += '<option value="' + c[0] + '"' +
                                selected + '>' + c[1] +
                                '</option>';
                        }
                        $obj.html(choices);
                    }
                    $obj.trigger("change");

                    if ($handlerLoad)
                        $handlerLoad($obj);
                }
            });
        }
    }
})(jQuery);