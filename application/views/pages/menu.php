<div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    <div class="trama_menu noOverflow demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
        <header id="MenuFondo" class="demo-drawer-header">
            <img id="imgUser" src="<?PHP echo base_url();?>assets/img/sp_logo_menu.png" width="78%" >
           
            <div id="user" class="row">
                <div class="col l2 center">
                  <i class=" material-icons">face</i>
                </div>
                <div class="col l9 center">
                  <span class="Loggen"><?php echo $this->session->userdata('UserN');?></span>
                </div>
            </div>
        </header>

       <div id="menu">
          <?php
            $menuH = '<ul class="nav menu demo-navigation mdl-navigation__link" >';
            
            $menuF = '<ul id="conTIcon2" class="nav menu demo-navigation mdl-navigation__link" >
                        <a class="modal-trigger" href="#modalAcercaDe"><li href="#"><i class="material-icons">info_outline</i> acerca de</li></a>
                        <a href="salir"><li><i class="material-icons">exit_to_app</i> cerrar sesión</li></a>
                      </ul>';

            if ($this->session->userdata('IdRol')==1){
              $menuH .= '<a href="Main"><li href="Main"><i class="material-icons">home</i> inicio</li></a>
                        <a href="Facturas"><li href="Facturas"><i class="material-icons">remove_circle</i> Facturas</li></a>
                        <a href="Clientes"><li href="Clientes"><i class="material-icons">supervisor_account</i> clientes</li></a>
                        <a href="PuntosClientes"><li href="PuntosClientes"><i class="material-icons">content_copy</i> puntos clientes</li></a>
                        <a href="Frp"><li href="Frp"><i class="material-icons">payment</i> canje puntos (frp)</li></a>
                        <a href="Catalogo"><li href="Catalogo"><i class="material-icons">dashboard</i> catálogo</li></a>
                        <a href="Usuarios"><li href="Usuarios"><i class="material-icons">account_box</i> usuarios</li></a>
                        <a href="Reportes"><li href="Reportes"><i class="material-icons">description</i> reportes</li></a>
                        <a class="modal-trigger" href="#modalAcercaDe"><li href="#"><i class="material-icons">info_outline</i> acerca de</li></a>
                        <a href="salir"> <li href="salir"><i class="material-icons">exit_to_app</i> cerrar sesión</li></a>';
              }else if($this->session->userdata('IdRol')==2){
                $menuH .= '<a href="Main"><li href="Main"><i class="material-icons">home</i> inicio</li></a>
                        <a href="Facturas"><li href="Facturas"><i class="material-icons">remove_circle</i> Facturas</li></a>
                        <a href="Clientes"><li href="Clientes"><i class="material-icons">supervisor_account</i> clientes</li></a>
                        <a href="PuntosClientes"><li href="PuntosClientes"><i class="material-icons">content_copy</i> puntos clientes</li></a>
                        <a href="Frp"><li href="Frp"><i class="material-icons">payment</i> canje puntos (frp)</li></a>
                        <a href="Reportes"><li href="Reportes"><i class="material-icons">description</i> reportes</li></a>
                        <a class="modal-trigger" href="#modalAcercaDe"><li href="#"><i class="material-icons">info_outline</i> acerca de</li></a>
                        <a href="salir"> <li href="salir"><i class="material-icons">exit_to_app</i> cerrar sesión</li></a>';
              }else if( $this->session->userdata('IdRol')==3){
                $menuH .= '<a href="Main"><li href="Main"><i class="material-icons">home</i> inicio</li></a>
                        <a href="Facturas"><li href="Facturas"><i class="material-icons">remove_circle</i> Facturas</li></a>
                        <a href="Clientes"><li href="Clientes"><i class="material-icons">supervisor_account</i> clientes</li></a>
                        <a href="PuntosClientes"><li href="PuntosClientes"><i class="material-icons">content_copy</i> puntos clientes</li></a>
                        <a href="Catalogo"><li href="Catalogo"><i class="material-icons">dashboard</i> catálogo</li></a>
                        <a href="Reportes"><li href="Reportes"><i class="material-icons">description</i> reportes</li></a>';
                echo $menuF; 
              }else if($this->session->userdata('IdRol')==7){
                $menuH .= '<a href="Main"><li href="Main"><i class="material-icons">home</i> inicio</li></a>
                        <a href="Clientes"><li href="Clientes"><i class="material-icons">supervisor_account</i> clientes</li></a>
                        <div id="sac"><img src="'.base_url().'assets/img/sac_atencion.png" alt="Icon" /></div>';
              echo $menuF; 
              }else if ($this->session->userdata('IdRol')==4 || $this->session->userdata('IdRol')==5 || $this->session->userdata('IdRol')==6){
                $menuH .= '<a href="Main"><li href="Main"><i class="material-icons">home</i> inicio</li></a>
                           <a href="Facturas"><li href="Facturas"><i class="material-icons">remove_circle</i> Facturas</li></a>
                           <a href="Clientes"><li href="Clientes"><i class="material-icons">supervisor_account</i> clientes</li></a>
                           <a href="PuntosClientes"><li href="PuntosClientes"><i class="material-icons">content_copy</i> puntos clientes</li></a>
                           <div id="sac"><img src="'.base_url().'assets/img/sac_atencion.png" alt="Icon" /></div>';
                
                echo $menuF; 
              }

              $menuH .='</ul>';
              echo $menuH;
          ?>         
       </div>
    </div>

    <!-- Modal Structure ACERCA DE!! -->
    <div id="modalAcercaDe" class="modal">
      <div class="btnCerrar right"><i style='color:red;' class="material-icons modal-action modal-close">highlight_off</i></div>
      <div class="row noMargen TextColor center">
            <div class="col s12 m12 l12">ACERCA DE</div>
      </div>
      <div class="row">
        <div class="col s3 m2 l2 offset-m5 offset-s4">
          <img id="logo" src="<?PHP echo base_url();?>assets/img/spinnova_logo.png" width="120%">
        </div>
        <div class="col l9 TextColor center">
            <div class="col s12 m12 l12">DESARROLLADO POR GERENCIA CORPORATIVA IT (505) 2278-8787, EXT: 131</div>
        </div>
      </div>
      <div class="row foterAcercaDe center">
            COPYRIGHT © TODOS LOS DERECHOS RESERVADOS - INNOVA INDUSTRIAS S.A
      </div>
    </div>