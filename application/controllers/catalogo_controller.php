<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogo_controller extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if($this->session->userdata('logged')==0){ //No aceptar a usuarios sin loguearse
            redirect(base_url().'index.php/login','refresh');
        }
    }

    public function index(){
    	$this->load->view('header/header');
      $this->load->view('pages/menu');
      $data['catalogo'] = $this->catalogo_model->traerCatalogoImg();
      $data['catalogo2'] = $this->catalogo_model->traerCatalogoImgActual();
      $data['catalogos'] = $this->catalogo_model->traerCatalogo();
      $data['bandera'] = $this->catalogo_model->bandera();
      $data['catActual'] = $this->catalogo_model->traerCatalogosActual();
      $this->load->view('pages/catalogo/Catalogo',$data);
      $this->load->view('footer/footer');
    }

    public function NuevoCatalogo(){
      $this->load->view('header/header');
      $this->load->view('pages/menu');
      $data['catalogo'] = $this->catalogo_model->traerCatalogoImgActual();
      $data['catalogos'] = $this->catalogo_model->traerCatalogosHistorial();
      $data['catActual'] = $this->catalogo_model->traerCatalogosActual();
      $data['bandera'] = $this->catalogo_model->bandera();
      $this->load->view('pages/catalogo/nuevocatalogo',$data);
      $this->load->view('footer/footer');
    }

    public function actualizarCatalogo(){
      $codigo = $this->input->post('codigo');
      $articulo = $this->input->post('articulo');
      $puntos = $this->input->post('puntos');
      $idCatalogo = $this->input->post('IdCatalogo');
      $idCatalogoArticulo = $this->input->post('IdCatalogoArticulo');
      $this->catalogo_model->actualizarCatalogo($codigo,$articulo,$puntos,$idCatalogo,$idCatalogoArticulo);
    }

    public function ActualizarEstadoArticulo(){
      $idarticulo = $this->input->post('idarticulo');
      $idcatalogo = $this->input->post('catalogo');
      $this->catalogo_model->ActualizarEstadoArticulo($idarticulo,$idcatalogo);
    }

    public function CatalogoPasado($idCatalogo){
        $data = $this->catalogo_model->CatalogoPasado($idCatalogo);
    }

    public function actualizarPuntos($codImagen,$codCatalogo,$puntos){
        $this->catalogo_model->actualizarPuntos($codImagen,$codCatalogo,$puntos);
    }

    public function crearCatalogo(){
        $Descripcion = $this->input->post('descripcion');
        $fecha = $this->input->post('fecha');
        
        if ($Descripcion != "" and $fecha != "") {
          $this->catalogo_model->crearCatalogo($Descripcion,$fecha);
        }
        
        redirect(base_url().'index.php/Catalogo','refresh');
    }

   	public function subirImg(){
      $ruta='assets/img/catalogo/';//ruta carpeta donde queremos copiar las imágenes        
      if(!@$_FILES['txtimagen']['tmp_name']){
          $uploadfile_temporal='';
          $uploadfile_nombre='';
      } else {
        $uploadfile_temporal=$_FILES['txtimagen']['tmp_name'];
        $uploadfile_nombre=$ruta.$_FILES['txtimagen']['name'];
      }

      if($_POST['bandera']==0){
    	  if (strlen($_FILES['txtimagen']['name'])>35) {
    		  echo "El nombre de la imagen es demasiado largo";
    			redirect('Catalogo','refresh');
  		  }   
  		  $this->saveIMG($uploadfile_temporal,$uploadfile_nombre);
      } else {      
        $this->guardarEditarArticulo($uploadfile_temporal,$uploadfile_nombre);
      }
   	}

    public function guardarEditarArticulo($uploadfile_temporal,$uploadfile_nombre){
      if (is_uploaded_file($uploadfile_temporal)){
          move_uploaded_file($uploadfile_temporal,$uploadfile_nombre);
          $this->catalogo_model->editarArticulo($_POST['codigo'],$_POST['nombre'],$_FILES['txtimagen']['name'],$_POST['puntos']);
          redirect('Catalogo','refresh');
      } else {     //echo "no encontro imagen"."<br>";
        $this->catalogo_model->editarArticulo($_POST['codigo'],$_POST['nombre'],0,$_POST['puntos']);
        redirect('Catalogo','refresh');
      }
    }

   	function saveIMG($uploadfile_temporal,$uploadfile_nombre) {
  		if (is_uploaded_file($uploadfile_temporal)){    //echo "entro al guardaro 2 sin problemas"."<br>";
  		    move_uploaded_file($uploadfile_temporal,$uploadfile_nombre); 
          $this->catalogo_model->guardarIMG($_POST['codigo'],$_POST['nombre'],$_FILES['txtimagen']['name'],$_POST['puntos']);
  		    redirect('Catalogo','refresh');
  		} else { 
        redirect('Catalogo','refresh');
  		}
   	}

    function verificarImg($bandera){
      if($bandera==0){
        $file = $_FILES["txtimagen"];
        $nombre = $file["name"];
        $tipo = $file["type"];
        $ruta_provisional = $file["tmp_name"];
        $size = $file["size"];
        $dimensiones = getimagesize($ruta_provisional);
        $width = $dimensiones[0];
        $height = $dimensiones[1];
        $carpeta = 'assets/img/catalogo/';
        $uploadfile_nombre=$carpeta.$nombre;

        if (file_exists($uploadfile_nombre)) {
          echo "Esta imagen ya existe <br> ¿Desea Reemplazarla?";return false;
        }
        
        if ($tipo != 'image/jpg' && $tipo != 'image/jpeg' && $tipo != 'image/png' && $tipo != 'image/gif'){
          echo "Error, el archivo no es una imagen";return false;
        } else if ($size > 1024*1024) {
          echo "Error, el tamaño máximo permitido es un 1MB";return false;
        }
      } else{echo 0;}
    }
}
?>