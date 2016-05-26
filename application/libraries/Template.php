<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 13-08-15
 * Time: 08:16 AM
 */
class Template
{
    private $ci;

    function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->helper(array(
            'url',
            'modulo/layout/layout',    
            'session'
        ));
    }


    function load($tpl_view, $body_view = null, $data = null)
    {

        //$data = array_merge($data, $this->ci->session->all_userdata());


        if ( ! is_null( $body_view ) )
        {
            if ( file_exists( APPPATH.'views/'.$tpl_view.'/'.$body_view ) )
            {
                $body_view_path = $tpl_view.'/'.$body_view;
            }
            else if ( file_exists( APPPATH.'views/'.$tpl_view.'/'.$body_view.'.php' ) )
            {
                $body_view_path = $tpl_view.'/'.$body_view.'.php';
            }
            else if ( file_exists( APPPATH.'views/'.$body_view ) )
            {
                $body_view_path = $body_view;
            }
            else if ( file_exists( APPPATH.'views/'.$body_view.'.php' ) )
            {
                $body_view_path = $body_view.'.php';
            }
            else
            {
                show_error('Unable to load the requested file: ' . $tpl_name.'/'.$view_name.'.php');
            }

            $body = $this->ci->load->view($body_view_path, $data, TRUE);

            if ( is_null($data) )
            {
                $data = array('body' => $body);
            }
            else if ( is_array($data) )
            {
                $data['body'] = $body;
            }
            else if ( is_object($data) )
            {
                $data->body = $body;
            }
        }

        $this->ci->load->view('templates/'.$tpl_view, $data);
    }

    function parse($tpl_view, $body_view = null, $data = null)
    {
        
      //  $data = array_merge($data, $this->ci->session->all_userdata());

        if ( ! is_null( $body_view ) )
        {
            $this->ci->load->library('parser');

            if ( file_exists( APPPATH.'views/'.$tpl_view.'/'.$body_view ) )
            {
                $body_view_path = $tpl_view.'/'.$body_view;
            }
            else if ( file_exists( APPPATH.'views/'.$tpl_view.'/'.$body_view.'.php' ) )
            {
                $body_view_path = $tpl_view.'/'.$body_view.'.php';
            }
            else if ( file_exists( APPPATH.'views/'.$body_view ) )
            {
                $body_view_path = $body_view;
            }
            else if ( file_exists( APPPATH.'views/'.$body_view.'.php' ) )
            {
                $body_view_path = $body_view.'.php';
            }
            else
            {
                show_error('Unable to load the requested file: ' . $tpl_name.'/'.$view_name.'.php');
            }

            $body = $this->ci->parser->parse($body_view_path, $data, TRUE);

            if ( is_null($data) )
            {
                $data = array('body' => $body);
            }
            else if ( is_array($data) )
            {
                $data['body'] = $body;
            }
            else if ( is_object($data) )
            {
                $data->body = $body;
            }
        }

        $this->ci->parser->parse('templates/'.$tpl_view, $data);
    }
}