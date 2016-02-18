<?php

if (!defined("BASEPATH")) exit("No direct script access allowed");

class Formulario extends MY_Controller 
{
    /**
     *
     * @var Rapanui_Dengue_Model 
     */
    public $_rapanui_dengue_model;
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        sessionValidation();
        $this->load->helper(array("modulo/alarma/alarma_form"));
        $this->load->model("rapanui_dengue_model", "_rapanui_dengue_model");
    }
    
    /**
     * 
     */
    public function index(){
        
        $params = $this->uri->uri_to_assoc();
        
        if(puedeEditar("casos_febriles")){
            $this->template->parse("default", "pages/formulario/dengue", array());
        } else {
            if(isset($params["ingresado"]) && $params["ingresado"] == "correcto"){
                redirect(base_url("formulario/form_dengue/ingreso/correcto"));
            } else {
                redirect(base_url("formulario/form_dengue"));
            }
        }
    }
    
    /**
     * 
     */
    public function form_dengue(){
        $params = $this->uri->uri_to_assoc();
        
        $this->template->parse(
            "default", 
            "pages/formulario/form-dengue", 
            array(
                "ingresado" => $params["ingreso"],
                "latitud" => "-27.11299",
                "longitud" => "-109.34958059999997"
                )
        );
    }
    
    /**
     * 
     */
    public function editar(){
        $params = $this->input->get(null, true);
        
        $caso = $this->_rapanui_dengue_model->getById($params["id"]);
        if(!is_null($caso)){
            
            $data = array("id" => $caso->id);
            $propiedades = json_decode($caso->propiedades);
            $coordenadas = json_decode($caso->coordenadas);
            foreach($propiedades as $nombre => $valor){
                $data[str_replace(" ", "_" ,strtolower($nombre))] = $valor;
            }
            
            $data["latitud"] = $coordenadas->lat;
            $data["longitud"] = $coordenadas->lng;
            
            $this->template->parse("default", "pages/formulario/form-dengue", $data);
        }
    }
    
    /**
     * 
     */
    public function guardar_dengue(){
        header('Content-type: application/json');

        $params = $this->input->post(null, true);

        $coordenadas = array("lat" => $params["latitud"],
                             "lng" => $params["longitud"]);

        unset($params["latitud"]);
        unset($params["longitud"]);

        $caso = $this->_rapanui_dengue_model->getById($params["id"]);
        
        unset($params["id"]);
        
        $arreglo = array();
        foreach($params as $nombre => $valor){
            $nombre = str_replace("_", " ", $nombre);
            $arreglo[strtoupper($nombre)] = $valor;
        }
         
        if(is_null($caso)){
            $this->_rapanui_dengue_model->insert(array("fecha" => date("Y-m-d H:i:s"),
                                                   "propiedades" => json_encode($arreglo),
                                                   "coordenadas" => json_encode($coordenadas)));
        } else {
            $this->_rapanui_dengue_model->update(array("propiedades" => json_encode($arreglo),
                                                       "coordenadas" => json_encode($coordenadas)),
                                                 $caso->id);
        }

        
       
        echo json_encode(array("error" => array(),
                              "correcto" => true));
    }
    
    /**
     * 
     */
    public function eliminar(){
        $params = $this->input->post(null, true);
        $this->_rapanui_dengue_model->delete($params["id"]);
        echo json_encode(array("error" => array(),
                              "correcto" => true));
    }
    
    /**
     * Genera excel para casos de dengue
     */
    public function excel(){
        $this->load->library("excel");
        $lista = $this->_rapanui_dengue_model->listar();
        
        $datos_excel = array();
        if(!is_null($lista)){
            foreach($lista as $caso){
                $datos_excel[] = Zend_Json::decode($caso["propiedades"]);
            }
        
            $excel = $this->excel->nuevoExcel();
            $excel->getProperties()
                  ->setCreator("Midas - Emergencias")
                  ->setLastModifiedBy("Midas - Emergencias")
                  ->setTitle("Exportación de casos febriles")
                  ->setSubject("Emergencias")
                  ->setDescription("Casos febriles")
                  ->setKeywords("office 2007 openxml php sumanet")
                  ->setCategory("Midas");

            $letras = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
            $columnas = reset($datos_excel);

            $i=0;
            foreach($columnas as $columna => $valor){
                $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i, 1, $columna); //setCellValue($letras[$i] . '1', strip_tags($columna));
                $i++;
            }

            $j = 2;
            foreach($datos_excel as $id => $valores){
                $i = 0;
                foreach($valores as $columna => $valor){
                    $excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i, $j, strtoupper($valor));
                    $i++;
                }
                $j++;
            }

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="casos_febriles.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $objWriter->save('php://output');
        } else {
            echo "No hay registros para generar el excel";
        }
    }
    
    /**
     * 
     */
    public function ajax_lista(){
        $lista = $this->_rapanui_dengue_model->listar();
        
        $casos = array();
        
        if(!is_null($lista)){
            foreach($lista as $caso){
                $fecha = DateTime::createFromFormat("Y-m-d H:i:s", $caso["fecha"]);
                if($fecha instanceof DateTime){
                    $fecha_formato = $fecha->format("d/m/Y");
                }
                
                $propiedades = json_decode($caso["propiedades"]);
                
                $casos[] = array("id" => $caso["id"],
                                 "fecha" => $fecha_formato,
                                 "diagnostico" => strtoupper($propiedades->{"DIAGNOSTICO CLINICO"}),
                                 "nombre" => strtoupper($propiedades->NOMBRE . " " . $propiedades->APELLIDO),
                                 "direccion" => strtoupper($propiedades->DIRECCION));
            }
        }
        
        $this->load->view("pages/formulario/grilla", array("lista" => $casos));
    }
}

