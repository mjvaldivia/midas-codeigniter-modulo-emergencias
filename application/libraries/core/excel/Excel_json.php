<?php

Class Excel_json{
    
    protected $_columnas = array();
    
    
    protected $_excel;
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    
    /**
     * 
     */
    public function __construct() {
        $this->_ci =& get_instance();

        
        $this->_ci->load->helper(
            array(
                "modulo/usuario/usuario",
                "modulo/formulario/formulario",
                "modulo/comuna/default",
                "modulo/direccion/region"
            )
        );

        $this->_ci->load->library(
            array(
                "core/fecha/fecha_conversion",
                "core/string/arreglo",
                "core/string/random",
                "excel"
            )
        );
        
        $this->_excel = $this->_ci->excel->nuevoExcel();

        $this->_excel->getProperties()
            ->setCreator("Midas - Emergencias")
            ->setLastModifiedBy("Midas - Emergencias")
            ->setTitle("Exportación de marea roja")
            ->setSubject("Emergencias")
            ->setDescription("Marea roja")
            ->setKeywords("office 2007 openxml php emergencias")
            ->setCategory("Midas");
    }
    
    /**
     * 
     * @param array $columnas
     */
    public function setColumnas($columnas){
        $this->_columnas = $columnas;

        $i = 0;
        foreach($this->_columnas as $columna => $valor){
            $this->_excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i, 1, $columna);
            $i++;
        }
    }
    
    /**
     * Recorre los datos y llena el excel
     * @param array $data
     * @param array $json_fields
     */
    public function setData($data, $json_fields = array()){
        if(count($data)>0){
            $j = 2;
            foreach($data as $row){
                
                $json_data = array();
                if(count($json_fields)>0){
                    foreach($json_fields as $json){
                        $json_data = array_merge(Zend_Json::decode($row[$json]), $json_data);
                    }
                }
                
                
                $i=0;
                foreach($this->_columnas as $columna => $valores){
                    $this->_excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i, $j, $this->_procesaValor($valores, $row, $json_data));
                    $i++;
                }
                $j++;
                
            }
        }
    }
    
    public function getExcel(){
        $objWriter = PHPExcel_IOFactory::createWriter($this->_excel, 'Excel2007');
        $hash = $this->_ci->random->rand_string(20);
        
        $path = FCPATH . "media/tmp/" . $hash . ".xlsx";
        $objWriter->save(FCPATH . "media/tmp/" . $hash . ".xlsx");
        return array("path" => $path,
                     "nombre" => 'marea_roja_' . date('d-m-Y') . '.xlsx');
    }
    
    /**
     * Retorna el excel a la salida de la vista
     */
    public function render(){
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="marea_roja_' . date('d-m-Y') . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->_excel, 'Excel2007');
        $objWriter->save('php://output');
    }
    
    /**
     * Asigna el valor a la celda
     * @param array $configuracion
     * @param int $fila
     * @param array $json
     * @return string
     */
    protected function _procesaValor($configuracion, $fila, $json){
        if($configuracion["tipo"] == "json"){
            $valor = $json[$configuracion["valor"]];
        } else {
            $valor = $fila[$configuracion["valor"]];
        }
        
        $salida = "";
        switch ($configuracion["metodo"]) {
            case "NOMBRE_REGION":
                $salida = nombreRegion($valor);
                break;
            case "NOMBRE_COMUNA":
                $salida = nombreComuna($valor);
                break;
            case "NOMBRE_USUARIO":
                if(TRIM($valor) == ""){
                    $salida = "CARGA MASIVA";
                } else {
                    $salida = (string) nombreUsuario($valor);
                }
                break;
            case "FECHA":
                $fecha = $this->_ci->fecha_conversion->fechaToDateTime(
                    $valor,
                    $configuracion["formato_entrada"]
                );
                $salida = $fecha->format($configuracion["formato_salida"]);
                break;
            case "CORRECCION_SALTO_LINEA":
                $salida = str_replace("\n", "", $valor);
                break;
            default:
                $salida = $valor;
                break;
        }
        return $salida;
    }
}
