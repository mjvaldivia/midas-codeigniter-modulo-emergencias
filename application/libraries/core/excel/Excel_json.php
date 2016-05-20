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
    
    public function render(){
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="marea_roja_' . date('d-m-Y') . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->_excel, 'Excel2007');
        $objWriter->save('php://output');
    }
    
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
                $salida = (string) nombreUsuario($valor);
                break;
            case "FECHA":
                $fecha = $this->_ci->fecha_conversion->fechaToDateTime(
                    $valor,
                    $configuracion["formato_entrada"]
                );
                $salida = $fecha->format($configuracion["formato_salida"]);
                break;
            default:
                $salida = $valor;
                break;
        }
        return $salida;
    }
}
