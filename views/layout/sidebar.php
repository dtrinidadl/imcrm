<?php
ob_start();
?>
<?php
if (isset($_SESSION['identity-imfel'])) {
    $identityNombre = $_SESSION['identity-imfel']->nombre;
    $identityRol = $_SESSION['identity-imfel']->idRol;
    $id_comercio = $_SESSION['identity-imfel']->idComercio;
    
} else {
    $identityNombre = 'No esta loggeado';
    $identityRol = 0;
}
?>
<div class="logo">
    <!--base_url :: lleva a la pagina de iniciar sesion--> 
    <a href="<?= base_url ?>/home/index" class="simple-text"> 
        <img class="img-fluid mx-auto d-block" src="<?= base_url ?>assets/img/logo.png" alt="IMA Logotipo" />
    </a>
</div>

<div class="sidebar-wrapper scrollbar">

    <div class="user">
        <div class="user-info">
            <?php if (isset($_SESSION['identity-imfel'])): ?>  
                <a data-toggle="collapse" href="#collapseExample" class="username">
                    <span>
                        <?= $identityNombre ?>
                        <b class="caret"></b>
                    </span>
                </a>
            <?php else: ?>
                <a data-toggle="collapse" href="javascript:void(0)" class="username">
                    <span>
                        No esta loggeado {Usuario}
                    </span>
                </a>
            <?php endif; ?>            
            <div class="collapse" id="collapseExample">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#cambioClave" data-toggle="modal" data-target="#cambioClave">
                            <i class="material-icons">settings</i>
                            <span class="sidebar-normal"> Cambio Contraseña </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url ?>usuario/logout">
                            <i class="material-icons">exit_to_app</i>
                            <span class="sidebar-normal"> Cerrar Sesión </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>





    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url . 'home/index' ?>">
                <i class="material-icons">dashboard</i>
                <p> Tablero </p>
            </a>
        </li>


        <!--Cambio Inicia-->


        <!--Cambio Finaliza-->


        <li class="nav-item">
            <a class="nav-link" href="<?= base_url . 'agente/index' ?>">
                <i class="material-icons">assignment_ind</i>
                <p> Agentes </p>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url . 'comercio/index' ?>">
                <i class="material-icons">apartment</i>
                <p> Comercio </p>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url . 'cliente/index' ?>">
                <i class="material-icons">supervisor_account</i>
                <p> Personas </p>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url . 'usuario/index' ?>">
                <i class="material-icons md-36">account_circle</i>
                <p> Usuarios </p>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url . 'perfil/index' ?>">
                <i class="material-icons md-36">addchart</i>
                <p> Perfiles </p>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url . 'facturacion/index' ?>">
                <i class="material-icons">receipt_long</i>
                <p> Facturar </p>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url . 'facturacion/indexAnulacion' ?>">
                <i class="material-icons">not_interested</i>
                <p> Anular </p>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url . 'facturacion/indexNotaDC' ?>">
                <i class="material-icons">how_to_vote</i>
                <p> Notas D/C </p>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url . 'reporte/index' ?>">
                <i class="material-icons">pie_chart</i>
                <p> Reportes </p>
            </a>
        </li>
        <li>&nbsp;</li>
    </ul>
</div>
</div>
<div class="main-panel">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
            <div class="navbar-wrapper">
                <div class="navbar-minimize">
                    <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                        <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                        <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
                    </button>
                </div>
                    <?php if (isset($_SESSION['identity-imfel'])): ?>
                        <a class="navbar-brand" href="javascript:void(0)">
                            <?= $nombre_comercio = strtoupper(utils::getComercioById($id_comercio)); ?>
                        </a>
                    <?php else: ?>
                        <a class="navbar-brand" href="javascript:void(0)">
                            No esta loggeado {Comercio}
                        </a>
                    <?php endif; ?>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="sr-only">Toggle navigation</span>
                <span class="navbar-toggler-icon icon-bar"></span>
                <span class="navbar-toggler-icon icon-bar"></span>
                <span class="navbar-toggler-icon icon-bar"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end">
            </div>
        </div>
    </nav>
    <!-- Modal para cambio de contraseña -->
    <div class="modal fade" id="cambioClave" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-small">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-weight: bold;">
                        Cambio de Contraseña
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="material-icons">clear</i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="RegisterValidation" action="<?= base_url ?>usuario/cambioClave" method="POST">
                        <div class="form-group">
                            <label for="examplePassword" class="bmd-label-floating"> Contraseña *</label>
                            <input type="password" class="form-control" id="clave" required="true" name="clave">
                        </div>
                        <div class="form-group">
                            <label for="examplePassword1" class="bmd-label-floating"> Confirme Contraseña *</label>
                            <input type="password" class="form-control" id="confirmar_clave" required="true" equalTo="#clave" name="confirmar_clave">
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-warning">Confirmar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function setFormValidation(id) {
            $(id).validate({
                highlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-danger');
                    $(element).closest('.form-check').removeClass('has-success').addClass('has-danger');
                },
                success: function (element) {
                    $(element).closest('.form-group').removeClass('has-danger').addClass('has-success');
                    $(element).closest('.form-check').removeClass('has-danger').addClass('has-success');
                },
                errorPlacement: function (error, element) {
                    $(element).closest('.form-group').append(error);
                },
            });
        }

        $(document).ready(function () {
            setFormValidation('#RegisterValidation');
        });
    </script>
    <!-- Fin del Modal -->
    <!-- End Navbar -->
    <div class="content">
        <div class="container-fluid">