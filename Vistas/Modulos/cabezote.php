
<header class="main-header">
<!--Logotipo-->
<a href="inicio" class="logo" style="background:#212F3D;">
    <!--logo mini-->
    <span class="logo-mini">
        <img src="https://images.vexels.com/media/users/3/137382/isolated/preview/c59b2807ea44f0d70f41ca73c61d281d-logotipo-del-icono-de-linkedin-by-vexels.png" class="img-responsive" style="padding:10px" alt="">
    </span>
    <!--logo normal-->
    <span class="logo-lg ">
        <img src="https://zimwebtech.com/assets/images/media/012.png" class="img-responsive" style="padding:0px 0px" width="150px" alt="">
    </span>
</a>

<!--Sliderbar menu-->
<nav class="navbar navbar-static-top" role="navigation">
    <!--boton de navegacion-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="buttom">
        <span class="sr-only">Toggle Navigation</span>
    </a>
    <!--Perfil del usuario -->
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
                <a href="" class="dropdown-toggle" data-toggle="dropdown">
                <?php
                if($_SESSION["foto"] != ""){
                    echo '<img src="'.$_SESSION["foto"].'" class="user-image" alt="">';
                }else{
                    echo '<img src="Vistas/img/usuarios/default/anonymous.png" class="user-image" alt="">';
                }
                ?>
                <span class="hidden-xs"><?php echo $_SESSION["nombre"]; ?></span>
                </a>
                <!--Dropdown toogle-->
                <ul class="dropdown-menu">
                    <li class="user-body">
                        <div class="pull-right">
                            <a href="salir" class="btn btn-default btn-flat">Salir</a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>




</header>