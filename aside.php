<?php
  $idrolSession=$_SESSION["rolusuario"];
  include_once($ruta."class/vrolmenu.php");
  $vrolmenu=new vrolmenu;
  include_once($ruta."class/vusuario.php");
  $vusuario=new vusuario;

  include_once($ruta."class/vusuario2.php");
  $vusuario2=new vusuario2;


  $datouser = $vusuario2->muestra($_SESSION["codusuario"]);
  
  $idper = $datouser['idpersona'];

  include_once($ruta."class/vfiles.php");
  $vfiles=new vfiles;

   
  $dfotoa=$vfiles->mostrarTodo("id_publicacion=".$idper." and description = 'foto ejecutivo'");
  $dfotoa=array_shift($dfotoa); 

  if (count($dfotoa)>0) {
    $rutaFotop=$ruta."persona/editar/server/php/".$idper."/thumbnail/".$dfotoa['name'];


}
else{
    $rutaFotop=$ruta."imagenes/user.png";
} 
 

  if ($_SESSION["estadoSesion"]!='Jhulios2007777705') {
    ?>
      <script type="text/javascript">
        location.href="<?php echo $ruta ?>"+"session/salir.php";
      </script>
    <?php
  }
  else
  {
    //existe session
    $rolUs=$vrolmenu->mostrarTodo("idrol=".$idrolSession." and idmenu=".$idmenu);
    $dusuario=$vusuario->muestra($_SESSION["codusuario"]);
    if(count($rolUs)<1)
    {
      if (!isset($_SESSION["faltaSistema"]))
      {  
        $_SESSION['faltaSistema']="0"; 
      }
      $_SESSION['faltaSistema']=$_SESSION['faltaSistema']+1;
       ?>
        <script type="text/javascript">
          location.href="<?php echo $ruta ?>"+"session/salir.php";
        </script>
      <?php
    }
  }
?>
<aside id="left-sidebar-nav">
  <ul id="slide-out" class="side-nav leftside-navigation">
    <li class="user-details cyan darken-2">
        <div class="row">
            <div class="col col s4 m4 l4">

                <img src="<?php echo $rutaFotop ?>" alt="" class="circle responsive-img valign profile-image">

            </div>
            <div class="col col s8 m8 l8">
                <ul id="profile-dropdown" class="dropdown-content">
                  <li><a href="#">Mi Cuenta</a>
                  </li>
                  <li class="divider"></li>
                  <li><a href="#"> Seguridad</a>
                  </li>
                  <li class="divider"></li>
                  <li><a href="#"><i class="fa fa-sign-out"></i> Salir</a>
                  </li>
                </ul>
                <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown">
                <?php echo $dusuario['nombre'].' '.$dusuario['paterno'] ?>
                <i class="mdi-navigation-arrow-drop-down right"></i></a>
                <p class="user-roal"> <?php echo $dusuario['rol']  ?></p>
            </div>
        </div>
    </li>
    <li class="no-padding">
      <ul class="collapsible collapsible-accordion">
        <?php
          foreach($vrolmenu->mostrarTodo("padre=0 and idmenu<>1000 and idrol=".$idrolSession) as $dmenu)
          {
            $actMenu=$vrolmenu->mostrarTodo("padre=".$dmenu['idmenu']." and idmenu=".$idmenu);
            if(count($actMenu)>0)$sw=true; else $sw=false;
            ?>
            <li class="bold"><a class="collapsible-header waves-effect waves-cyan <?php if($sw)echo "active"; ?>"><i class="fa fa-<?php echo $dmenu['icon'] ?>"></i> <?php echo $dmenu['nombre'] ?></a>
              <div class="collapsible-body">
                <ul>
                  <?php
                    foreach($vrolmenu->mostrarTodo("padre=".$dmenu['idmenu']." and idrol=".$idrolSession) as $dmenuN2)
                    {
                    ?>
                      <li class="<?php if ($dmenuN2['idmenu']==$idmenu) echo "active"; ?>">
                        <a href="<?php echo $ruta ?><?php echo $dmenuN2['url'] ?>"><?php echo $dmenuN2['nombre'] ?></a>
                      </li>
                    <?php
                    }
                  ?>
                </ul>
              </div>
            </li>
            <?php
          }
        ?>
      </ul>
    </li>
  </ul>
  <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-large waves-effect waves-light purple">
    <i class="mdi-navigation-menu"></i>
  </a>
</aside>