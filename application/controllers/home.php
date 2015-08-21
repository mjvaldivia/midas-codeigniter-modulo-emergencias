<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 12-08-15
 * Time: 04:24 PM
 */
class Home extends CI_Controller
{
    public function index () {
        $this->load->helper("session");

        sessionValidation();

        if ( ! file_exists(APPPATH.'/views/pages/home.php'))
        {
            // Whoops, we don't have a page for that!
            show_404();
        }

        // load basicos
        $this->load->library('template');
        $this->load->library('form_validation');

        $data = array(
        );

        $this->template->parse("default", "pages/home", $data);
//        $this->load->view('pages/home', $data);
    }
}