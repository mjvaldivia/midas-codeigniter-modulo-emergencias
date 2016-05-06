<?php
/**
 * View helpers para modulode de direccion
 */

require_once(APPPATH . "helpers/modulo/direccion/form/element/SelectComuna.php");

/**
 * Retorna elemento de formulario Select
 * @param int $id_region identificador de region
 */
function formElementSelectComunaUsuario($input_nombre, $input_valor = array()){
    $select = New Direccion_Form_Element_SelectComuna();
    $select->setNombre($input_nombre);
    return $select->render($input_valor);
}

/**
 * Retorna elemento de formulario Select
 * @param int $id_region identificador de region
 */
function formElementSelectComuna($input_nombre, $input_valor, $id_region){
    $_ci =& get_instance();
    $_ci->load->model("comuna_model", "_comuna_model");
    $form_select = New Cosof_Form_Select();
    $form_select->setNombre($input_nombre);
    $form_select->populate($_ci->_comuna_model->listarComunasPorRegion($id_region));
    $form_select->setOptionId("com_ia_id");
    $form_select->addAtributos(array("class" => "form-control"));
    $form_select->setOptionName("com_c_nombre");
    return $form_select->render($input_nombre, $input_valor);
}