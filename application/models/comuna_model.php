<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 17-08-15
 * Time: 10:09 AM
 */
class Comuna_Model extends MY_Model
{    
    
    /**
     *
     * @var string 
     */
    protected $_tabla = "comunas";
               
    /**
     * 
     * @param int $id
     * @return int
     */
    public function getById($id){
        return $this->_query->getById("com_ia_id", $id);
    }
    
    
}

