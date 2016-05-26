<div class="form-group clearfix">
    <label class="col-sm-12 control-label required"> <strong> Fecha ingreso </strong>:</label>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group clearfix">

            <label for="fecha_desde" class="col-sm-3 text-left control-label required">Desde:</label>
            <div class="col-sm-9">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input value="<?php echo $fecha; ?>" id="fecha_desde" type=="text" class="form-control datepicker-date" />
                    <span class="help-block hidden"></span>
                </div>
            </div>

        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group clearfix">

            <label for="fecha_hasta" class="col-sm-3 text-right control-label required">Hasta:</label>
            <div class="col-sm-9">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input value="<?php echo $fecha; ?>" id="fecha_hasta" type="text" value="" class="form-control datepicker-date" />
                    <span class="help-block hidden"></span>
                </div>
            </div>

        </div>
    </div>
</div>
