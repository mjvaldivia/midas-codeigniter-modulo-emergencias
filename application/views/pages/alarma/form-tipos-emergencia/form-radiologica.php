<form  id="form-tipos-emergencia" name="form_tipos_emergencia" enctype="application/x-www-form-urlencoded" action="" method="post">
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group clearfix">
                <label for="form_tipo_descripcion" class="control-label">Descripción:</label>
                <textarea  class="form-control" name="form_tipo_descripcion" id="form_tipo_descripcion"><?php echo $form_tipo_descripcion; ?></textarea>
                <span class="help-block hidden"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <legend> Material radioactivo </legend>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group clearfix">
                <label for="form_tipo_fuente_radioactiva" class="control-label">Equipo y/o fuente radioactiva:</label>
                <input  class="form-control" name="form_tipo_fuente_radioactiva" id="form_tipo_fuente_radioactiva" value="<?php echo $form_tipo_fuente_radioactiva; ?>" />
                <span class="help-block hidden"></span>
            </div>
        </div>
    </div>
</form>
    
<!--
<div class="col-md-12">
    <div class="form-group">
        <div class="page-header" style="margin-bottom: 0px; margin-top: 10px">
            <h4>1.- Material radioactivo</h4>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-offset-1 col-md-3 control-label">Equipo y/o fuente radioactiva</label>
        <div class="col-md-5">
            <input class="form-control" type="text"></input>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-offset-1 col-md-3 control-label">Actividad del material radioactivo</label>
        <div class="col-md-5">
            <input class="form-control" type="text"></input>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-offset-1 col-md-3 control-label">Marca</label>
        <div class="col-md-5">
            <input class="form-control" type="text"></input>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-offset-1 col-md-3 control-label">Modelo</label>
        <div class="col-md-5">
            <input class="form-control" type="text"></input>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-offset-1 col-md-3 control-label">N° serie de fábrica</label>
        <div class="col-md-5">
            <input class="form-control" type="text"></input>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-offset-1 col-md-3 control-label">Año de fábrica</label>
        <div class="col-md-5">
            <input class="form-control" type="text"></input>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-offset-1 col-md-3 control-label">Antecedentes documentales</label>
        <div class="col-md-5">
            <input id="iDocMaterial" name="iDocMaterial[]" class="form-control" type="file" multiple></input>
        </div>
    </div>

    <div class="form-group">
        <div class="page-header" style="margin-bottom: 0px; margin-top: 10px">
            <h4>2.- Lugar de la emergencia</h4>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-offset-1 col-md-3 control-label"></label>
        <div class="col-md-5 checkbox">
            <label>
                <input id="iViaPublica" name="iViaPublica" type="checkbox"></input>
                <b>Vía pública</b>
            </label>
        </div>
    </div>
    <div class="viaPublica">
        <div class="form-group">
            <label class="col-md-offset-2 col-md-3 control-label"></label>
            <div class="col-md-5 checkbox">
                <label>
                    <input type="checkbox"></input>
                    Calle
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-offset-2 col-md-3 control-label"></label>
            <div class="col-md-5 checkbox">
                <label>
                    <input type="checkbox"></input>
                    Sitio eriazo
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-offset-2 col-md-3 control-label"></label>
            <div class="col-md-5 checkbox">
                <label>
                    <input type="checkbox"></input>
                    Parque
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-offset-2 col-md-3 control-label"></label>
            <div class="col-md-5 checkbox">
                <label>
                    <input type="checkbox"></input>
                    Canal
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-offset-2 col-md-3 control-label"></label>
            <div class="col-md-5 checkbox">
                <label>
                    <input type="checkbox"></input>
                    Otro
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-offset-1 col-md-3 control-label"></label>
        <div class="col-md-5 checkbox">
            <label>
                <input id="iPropiedadPrivada" name="iPropiedadPrivada" type="checkbox"></input>
                <b>Propiedad privada y/o pública</b>
            </label>
        </div>
    </div>
    <div class="propiedadPrivada">
        <div class="form-group">
            <label class="col-md-offset-2 col-md-3 control-label"></label>
            <div class="col-md-5 checkbox">
                <label>
                    <input type="checkbox"></input>
                    Hospital
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-offset-2 col-md-3 control-label"></label>
            <div class="col-md-5 checkbox">
                <label>
                    <input type="checkbox"></input>
                    Propiedad en construcción
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-offset-2 col-md-3 control-label"></label>
            <div class="col-md-5 checkbox">
                <label>
                    <input type="checkbox"></input>
                    Relleno sanitario
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-offset-2 col-md-3 control-label"></label>
            <div class="col-md-5 checkbox">
                <label>
                    <input type="checkbox"></input>
                    Depósito industrial
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-offset-2 col-md-3 control-label"></label>
            <div class="col-md-5 checkbox">
                <label>
                    <input type="checkbox"></input>
                    Industria
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-offset-2 col-md-3 control-label"></label>
            <div class="col-md-5 checkbox">
                <label>
                    <input type="checkbox"></input>
                    Bodega
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-offset-2 col-md-3 control-label"></label>
            <div class="col-md-5 checkbox">
                <label>
                    <input type="checkbox"></input>
                    Recinto aduanero
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-offset-2 col-md-3 control-label"></label>
            <div class="col-md-5 checkbox">
                <label>
                    <input type="checkbox"></input>
                    Otro
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="page-header" style="margin-bottom: 0px; margin-top: 10px">
            <h4>3.- Investigador</h4>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-offset-1 col-md-3 control-label">Nombre</label>
        <div class="col-md-5">
            <input class="form-control" type="text"></input>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-offset-1 col-md-3 control-label">Correo electrónico</label>
        <div class="col-md-5">
            <input class="form-control" type="text"></input>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-offset-1 col-md-3 control-label">Función o cargo</label>
        <div class="col-md-5">
            <input class="form-control" type="text"></input>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-offset-1 col-md-3 control-label">Teléfono</label>
        <div class="col-md-5">
            <input class="form-control" type="text"></input>
        </div>
    </div>

    <div class="form-group">
        <div class="page-header" style="margin-bottom: 0px; margin-top: 10px">
            <h4>4.- Otro contacto</h4>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-offset-1 col-md-3 control-label">Nombre</label>
        <div class="col-md-5">
            <input class="form-control" type="text"></input>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-offset-1 col-md-3 control-label">Correo electrónico</label>
        <div class="col-md-5">
            <input class="form-control" type="text"></input>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-offset-1 col-md-3 control-label">Función o cargo</label>
        <div class="col-md-5">
            <input class="form-control" type="text"></input>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-offset-1 col-md-3 control-label">Teléfono</label>
        <div class="col-md-5">
            <input class="form-control" type="text"></input>
        </div>
    </div>

    <div class="form-group">
        <div class="page-header" style="margin-bottom: 0px; margin-top: 10px">
            <h4>5.- Instituciones u organismos presentes</h4>
        </div>
    </div>

    <div class="form-group">
        <div class="page-header" style="margin-bottom: 0px; margin-top: 10px">
            <h4>6.- Análisis preliminar del riesgo radiológico</h4>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-offset-1 col-md-3 control-label"></label>
        <div class="col-md-5 checkbox">
            <label>
                <input id="iRiesgoPotencial" name="iRiesgoPotencial" type="checkbox"></input>
                <b>Riesgo Potencial</b>
            </label>
        </div>
    </div>
    <div class="riesgoPotencial">
        <div class="form-group">
            <label class="col-md-offset-2 col-md-3 control-label"></label>
            <div class="col-md-5 checkbox">
                <label>
                    <input type="checkbox"></input>
                    Irradiación a personas
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-offset-2 col-md-3 control-label"></label>
            <div class="col-md-5 checkbox">
                <label>
                    <input type="checkbox"></input>
                    Contaminación a personas
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-offset-2 col-md-3 control-label"></label>
            <div class="col-md-5 checkbox">
                <label>
                    <input type="checkbox"></input>
                    Irradiación ambiental
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-offset-2 col-md-3 control-label"></label>
            <div class="col-md-5 checkbox">
                <label>
                    <input type="checkbox"></input>
                    Contaminación ambiental
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-offset-1 col-md-3 control-label"></label>
        <div class="col-md-5 checkbox">
            <label>
                <input id="iEvaluacionRadiacion" name="iEvaluacionRadiacion" type="checkbox"></input>
                <b>Evaluación de la radiación</b>
            </label>
        </div>
    </div>
    <div class="evaluacionRadiacion">
        <div class="form-group">
            <label class="col-md-offset-2 col-md-3 control-label"></label>
            <div class="col-md-5 checkbox">
                <label>
                    <input type="checkbox"></input>
                    Eféctua medición de radiación
                </label>
            </div>
        </div>
        <div class="efectuaMedicion">
            <div class="form-group">
                <label class="col-md-offset-4 col-md-3 control-label">Instrumento</label>
                <div class="col-md-2">
                    <input type="text" class="form-control"></input>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-offset-4 col-md-3 control-label">Unidad</label>
                <div class="col-md-2">
                    <input type="text" class="form-control"></input>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-offset-2 col-md-3 control-label">Tasa de dosis de radiación natural (fondo)</label>
            <div class="col-md-5">
                <input class="form-control" type="text"></input>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="page-header" style="margin-bottom: 0px; margin-top: 10px">
            <h4>7.- Acciones tomadas</h4>
        </div>
    </div>
</div>-->