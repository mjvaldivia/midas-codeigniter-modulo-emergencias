<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 17-08-15
 * Time: 10:09 AM
 */
class Alarma_Comuna_Model extends CI_Model
{    
    
    /**
     *
     * @var Query 
     */
    protected $_query;
    
    /**
     *
     * @var string 
     */
    protected $_tabla = "alertas_vs_comunas";
    
    
    
    /**
     * Lista de comunas por alerta
     * @param int $id_alerta
     * @return string
     */
    public function listaComunasPorAlerta($id_alerta){
        $query = $this->db->query("SELECT * "
                                 ."FROM alertas_vs_comunas avc "
                                 ."WHERE avc.ala_ia_id = ?", array($id_alerta));
        
        if ($query->num_rows() > 0){
           return $query->result_array(); 
        }
    }
}
