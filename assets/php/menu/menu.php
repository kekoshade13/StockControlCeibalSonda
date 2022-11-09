<div class="nav-MenuVert">
                <nav class="navbar navbar-expand d-flex flex-column align-items-start" id="sidebar">
                    <a href="index.php?id=<?php echo isset($userData->id_user); ?>" class="navbar-brand text-light mt-5 d-block mx-auto">
                        <div class="display-6" style="font-size: 30px;">StockControl
                        </div>
                    </a>
                    <ul class="navbar-nav d-flex flex-column mt-5 w-100">
                        <li class="nav-item w-100 mt-1">
                            <a href="consumirrepuestos.php" class="nav-link text-light pl-4">Consumo repuestos</a>
                        </li>
                        <li class="nav-item w-100 mt-3">
                            <a href="movimientos.php" class="nav-link text-light pl-4">Movimientos</a>
                        </li>
                        <li class="nav-item w-100 mt-3">
                            <a href="inventario.php" class="nav-link text-light pl-4">Inventario</a>
                        </li>

                        <li class="nav-item w-100 mt-3">
                            <a href="planilla.php" class="nav-link text-light pl-4">Planilla</a>
                        </li>
                        
                        <li class="nav-item w-100" style="margin-top: 85%;">
                            <a href="admin/index.php?id=<?php echo $dataUser->id_user; ?>" class="nav-link text-light pl-4">Admin</a>
                        </li>
                    </ul>
                </nav>  
        </div>