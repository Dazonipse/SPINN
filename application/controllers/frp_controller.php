<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Frp_controller extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if($this->session->userdata('logged')==0){ //No aceptar a usuarios sin loguearse
            redirect(base_url().'index.php/login','refresh');
        }
    }
    public function MYHeaders(){
        $this->load->view('header/header');
        $this->load->view('pages/menu');
    }
    public function MYFooters(){
        $this->load->view('footer/footer');
    }
    public function getFacturaFRP($Cliente){
        $this->hana_model->FacturasFRP($Cliente);
    }
    public function CanjeFrp(){
        $this->MYHeaders();
        $data['Lista']      = $this->frp_model->getAllFRP();
        $data['Clientes'] = $this->hana_model->ClientesPuntos();
        $data['Catalogo'] = $this->catalogo_model->traerCatalogoImgActual();
        $this->load->view('pages/CanjeFRP',$data);
        $this->MYFooters();
    }
    public function SaverFRP(){
        echo $this->frp_model->save(
            $this->input->post('top'),
            $this->input->post('art'),
            $this->input->post('fac'),
            $this->input->post('log'));


    }

}