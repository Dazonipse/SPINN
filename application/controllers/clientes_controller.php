<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes_controller extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        
        if($this->session->userdata('logged')==0){ //No aceptar a usuarios sin loguearse
            redirect(base_url().'index.php/login','refresh');
        }
    }
    public function Clientes(){
        $data['Clientes'] = $this->hana_model->LoadClients();// Cargar Clientes
        $this->load->view('header/header');
        $this->load->view('pages/menu');
        $this->load->view('pages/Clientes',$data);
        $this->load->view('footer/footer');
    }
    public function FindClient($cond){
         $this->cliente_model($cond);
    }
}