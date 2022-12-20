
<nav class="navbar navbar-expand-lg mb-5">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav" style="position: absolute; left: 80%; top: 5%;">
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="assets/img/img_perfil/<?php echo $dataUser->nombre_u; ?>/<?php echo $dataUser->nombre_u?>.jpeg" alt="" width="35">    
                    <?php echo $dataUser->nombre." ".$dataUser->apellido ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="logout.php">Cerrar Sesión</a></li>
                    </ul>
                    </li>
                </ul>
        </div>
    </div>
</nav>