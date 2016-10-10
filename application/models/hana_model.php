<?php 
class Hana_model extends CI_Model
{

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    public $BD = 'INNOVA201608';

    public  function OPen_database_odbcSAp(){/*conexion a hana innova*/
        return odbc_connect("HANA","SYSTEM","B1Adminhana", SQL_CUR_USE_ODBC);
    }

    public  function vendedores(){
        $conn = $this->OPen_database_odbcSAp();  
        $query = 'SELECT * from '.$this->BD.'.SPINN_VENDEDORES';
        $resultado =  odbc_exec($conn,$query);
        $json = array();  
        $i=0;      
        while ($fila = odbc_fetch_array($resultado)){
            $json[$i]['CODIGO'] = $fila['CODIGO'];  
            $json[$i]['NOMBRE'] = utf8_encode($fila['NOMBRE']);  
            $json[$i]['RUTA'] = utf8_encode($fila['RUTA']);              
            $i++;
        }
        return $json;      
    }
    public function LoadClients()
    {
        $conn = $this->OPen_database_odbcSAp();
        if ($this->session->userdata('IdRol')==3) {
            $query = 'SELECT * from '.$this->BD.'.SPINN_CLIENTES WHERE COD_VENDEDOR = '.$this->session->userdata('IdVendedor').'';
        }
        else{$query = 'SELECT * from '.$this->BD.'.SPINN_CLIENTES ';}
        $resultado =  @odbc_exec($conn,$query);
        $json = array();  
        $i=0;
        if (count($resultado)==0) {
            $json[$i]['CODIGO'] = "";  
            $json[$i]['VENDEDOR'] = "";
            $json[$i]['NOMBRE'] = "";
            $json[$i]['RUC'] = "";
            $json[$i]['DIRECCION'] = "";
        }
        else{
            while ($fila = @odbc_fetch_array($resultado)){
                $json[$i]['CODIGO'] = $fila['CODIGO'];  
                $json[$i]['VENDEDOR'] = utf8_encode($fila['VENDEDOR']);  
                $json[$i]['NOMBRE'] = utf8_encode($fila['NOMBRE']);
                $json[$i]['RUC'] = utf8_encode($fila['RUC']);
                $json[$i]['DIRECCION'] = utf8_encode($fila['DIRECCION']);
                $i++;
            }
        }
        return $json;
    }
    public function Factuas()
    {
        $conn = $this->OPen_database_odbcSAp();
        $query = 'SELECT * from '.$this->BD.'.SPINN_TTFACTURAS_PUNTOS';
        $resultado =  @odbc_exec($conn,$query);
        $json = array();
        $i=0;
        while ($fila = odbc_fetch_array($resultado)){
            $json[$i]['FECHA'] = $fila['FECHA'];
            $json[$i]['FACTURA'] = $fila['FACTURA'];
            $json[$i]['COD_CLIENTE'] = $fila['COD_CLIENTE'];
            $json[$i]['CLIENTE'] = $fila['CLIENTE'];
            $json[$i]['COD_VENDEDOR'] = $fila['COD_VENDEDOR'];
            $json[$i]['VENDEDOR'] = $fila['VENDEDOR'];
            $json[$i]['DISPONIBLE'] = $fila['DISPONIBLE'];
            $json[$i]['ACUMULADO'] = $fila['ACUMULADO'];
            $i++;
        }
        return $json;
        }
    public function DFacturas($ID)
    {
        $conn = $this->OPen_database_odbcSAp();
        $query = "SELECT * from ".$this->BD.".SPINN_FACTURA_PUNTOS WHERE FACTURA='".$ID."'";

        $resultado =  @odbc_exec($conn,$query);
        $json = array();
        $i=0;

        while ($fila = odbc_fetch_array($resultado)){
            $json['data'][$i]['COD_ARTICULO'] = $fila['COD_ARTICULO'];
            $json['data'][$i]['ARTICULO'] = $fila['ARTICULO'];
            $json['data'][$i]['CANTIDAD'] = $fila['CANTIDAD'];
            $json['data'][$i]['TT_PUNTOS'] = $fila['TT_PUNTOS'];
            $i++;
        }
        echo json_encode($json);
    }
    public function FacturasFRP($ID)
    {
        $conn = $this->OPen_database_odbcSAp();

        $query = "SELECT * from ".$this->BD.".SPINN_TTFACTURAS_PUNTOS WHERE COD_CLIENTE='".$ID."' AND ".'"'."DISPONIBLE".'"'." > 0";
        $resultado =  @odbc_exec($conn,$query);
        $json = array();
        $i=0;

        $json['data'][$i]['FECHA']      = "SIN DATOS";
        $json['data'][$i]['FACTURA']    = "";
        $json['data'][$i]['DISPONIBLE'] = "";
        $json['data'][$i]['CAM1']       = "";
        $json['data'][$i]['CAM2']       = "";
        $json['data'][$i]['CAM3']       = "";
        $json['data'][$i]['CAM4']       = "";

        while ($fila = odbc_fetch_array($resultado)){
            $json['data'][$i]['FECHA']      = substr($fila['FECHA'],0,10);
            $json['data'][$i]['FACTURA']    = $fila['FACTURA'];
            $json['data'][$i]['DISPONIBLE'] = $fila['DISPONIBLE'];
            $json['data'][$i]['CAM1']       = "";
            $json['data'][$i]['CAM2']       = "";
            $json['data'][$i]['CAM3']       = "<p><input type='checkbox' id='test1' /><label for='test1'></label></p>";
            $json['data'][$i]['CAM4']       = "";
            $i++;
        }

        echo json_encode($json);
    }

    public function PuntosCliente($IdCliente)
    {
        $json = array();  
        $i=0;
        $conn = $this->OPen_database_odbcSAp();
        $query = 'SELECT count(*) AS "CONTADOR" FROM '.$this->BD.'.SPINN_CLIENTES_PUNTOS WHERE COD_CLIENTE = '."'".$IdCliente."'".'';
        $resultado =  @odbc_exec($conn,$query);
        if (count($resultado)==0) {echo " ERROR AL CARGAR LOS PUNTOS ";
        }else{  
            while ($fila = @odbc_fetch_array($resultado)){
                if($fila['CONTADOR']==0){
                    $json[$i]['DISPONIBLE'] = 0;
                    $json[$i]['ACUMULADO'] = 0;
                }
                else{
                    $query = 'SELECT "DISPONIBLE", "ACUMULADO" FROM '.$this->BD.'.SPINN_CLIENTES_PUNTOS WHERE COD_CLIENTE = '."'".$IdCliente."'".'';
                    $resultado =  @odbc_exec($conn,$query);
                    if (count($resultado)==0) {
                        }
                        else{
                            while ($fila = @odbc_fetch_array($resultado)){
                                if ($fila['DISPONIBLE']=='') {
                                    $json[$i]['DISPONIBLE'] = 0;
                                    $json[$i]['ACUMULADO'] = 0;
                                }else{
                                    $json[$i]['DISPONIBLE'] = $fila['DISPONIBLE'];
                                    $json[$i]['ACUMULADO'] = $fila['ACUMULADO'];$i++;
                                }
                            }
                        }
                }                    
            }
            echo json_encode($json);
        }        
    }
}
?>