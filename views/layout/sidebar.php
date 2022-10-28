<?php
ob_start();
?>
<?php
if (isset($_SESSION['identity-imsupport'])) {
    $identityUserName = $_SESSION['identity-imsupport']->userName;
    $identityUserRole = $_SESSION['identity-imsupport']->userRole;
} else {
    $identityUserName = 'No esta loggeado';
    $identityUserRole = 0;
}
$active = "style='background: #ffffff73;'";
?>
<div class="logo">
    <a href="<?= base_url ?>/home/index" class="simple-text">
        <img class="img-fluid mx-auto d-block" src="<?= base_url ?>assets/img/logo.png" alt="IMA Logotipo" />
    </a>
</div>

<div class="sidebar-wrapper scrollbar">

    <div class="user">
        <div class="photo"><img src="<?= base_url ?>assets/img/avatar.jpg" /></div>
        <div class="user-info">
            <?php if (isset($_SESSION['identity-imsupport'])) : ?>
                <a data-toggle="collapse" href="#collapseExample" class="username">
                    <span>
                        <?= $identityUserName ?>
                        <b class="caret"></b>
                    </span>
                </a>
            <?php else : ?>
                <a data-toggle="collapse" href="javascript:void(0)" class="username">
                    <span>
                        No esta loggeado {Usuario}
                    </span>
                </a>
            <?php endif; ?>
            <div class="collapse" id="collapseExample">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#changePassword" data-toggle="modal" data-target="#changePassword">
                            <i class="material-icons">settings</i>
                            <span class="sidebar-normal"> Cambio Contraseña </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url ?>user/logout">
                            <i class="material-icons">exit_to_app</i>
                            <span class="sidebar-normal"> Cerrar Sesión </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!--Sidebar-->
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" <?= $_GET['controller'] == 'home' ? $active : '' ?> href="<?= base_url . 'home/index' ?>">
                <i class="material-icons">dashboard</i>
                <p>Tablero</p>
            </a>
        </li>
        <?php if ($identityUserRole == 1) : ?>
            <li class="nav-item">
                <a class="nav-link" <?= $_GET['controller'] == 'report' ? $active : '' ?> href="<?= base_url . 'report/index' ?>">
                    <i class="material-icons">pie_chart</i>
                    <p>Reporte</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#paginasMantenimiento">
                    <i class="material-icons md-36">account_circle</i>
                    <p>Usuario</p>
                </a>
                <div class="collapse" id="paginasMantenimiento">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" <?= $_GET['controller'] == 'user' ? $active : '' ?> href="<?= base_url ?>user/index">
                                <i class="material-icons md-36">person</i> Usuarios
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" <?= $_GET['controller'] == 'userProject' ? $active : '' ?> href="<?= base_url ?>userProject/index">
                                <i class="material-icons md-36">cable</i> Usuario / Proyecto
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" <?= $_GET['controller'] == 'company' ? $active : '' ?> href="<?= base_url . 'company/index' ?>">
                    <i class="material-icons">business</i>
                    <p>Empresa</p>
                </a>
            </li>
        <?php endif ?>
        <?php if ($identityUserRole == 1 || $identityUserRole == 2) : ?>
            <li class="nav-item">
                <a class="nav-link" <?= $_GET['controller'] == 'project' ? $active : '' ?> href="<?= base_url . 'project/index' ?>">
                    <i class="material-icons">category</i>
                    <p>Proyecto</p>
                </a>
            </li>
        <?php endif ?>
        <li class="nav-item">
            <a class="nav-link" <?= $_GET['controller'] == 'support' ? $active : '' ?> href="<?= base_url . 'support/index' ?>">
                <i class="material-icons">question_answer</i>
                <p>Soporte</p>
            </a>
        </li>
    </ul>
    <!--End Sidebar-->
</div>
</div>
<div class="main-panel">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top" style="background: #b0b8a736 !important;">
        <div class="container-fluid">
            <div class="navbar-wrapper">
                <div class="navbar-minimize">
                    <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                        <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                        <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
                    </button>
                </div>
                <?php if (isset($_SESSION['identity-imsupport'])) : ?>
                    <a class="navbar-brand" href="javascript:void(0)">
                        <?php echo $identityUserName ?>
                    </a>
                <?php else : ?>
                    <a class="navbar-brand" href="javascript:void(0)">
                        No esta loggeado
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

            <!-- Notificaciones de Campana  -->
            <ul class="navbar-nav hide-movil" style="padding-right: 10px;">
                <li class="nav-item dropdown" id="notification" name="notification">
                </li>
            </ul>
        </div>
    </nav>
    <!-- Modal para cambio de contraseña -->
    <div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                    <form id="RegisterValidation" action="<?= base_url ?>user/changePassword" method="POST">
                        <div class="form-group">
                            <label for="examplePassword" class="bmd-label-floating"> Contraseña *</label>
                            <input type="password" class="form-control" id="password" required="true" name="password">
                        </div>
                        <div class="form-group">
                            <label for="examplePassword1" class="bmd-label-floating"> Confirme Contraseña *</label>
                            <input type="password" class="form-control" id="confirm_password" required="true" equalTo="#password" name="confirm_password">
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-success">Confirmar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Validar formulario  -->
    <script>
        function setFormValidation(id) {
            $(id).validate({
                highlight: function(element) {
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-danger');
                    $(element).closest('.form-check').removeClass('has-success').addClass('has-danger');
                },
                success: function(element) {
                    $(element).closest('.form-group').removeClass('has-danger').addClass('has-success');
                    $(element).closest('.form-check').removeClass('has-danger').addClass('has-success');
                },
                errorPlacement: function(error, element) {
                    $(element).closest('.form-group').append(error);
                },
            });
        }
        $(document).ready(function() {
            setFormValidation('#RegisterValidation');
        });
    </script>

    <!-- Notificationes campanan y home -->
    <script>
        function getNotification() {
            var settings = {
                "url": "<?= base_url ?>home/&getNotification=true"
            };
            $.ajax(settings).done(function(response) {
                const controller = window.location.pathname.split('/');
                const json = JSON.parse(response);
                const count = json.length;
                let notificationBell = '';
                let notificationHome = '';

                for (e of json) {
                    notificationBell += `<a class='dropdown-item' onclick='viewNotification(${e.notificationCode})'>
                                            <i class='material-icons x-notification'>close</i>
                                            <span>Proyecto: ${e.projectName}. | Ticket: ${e.supportIdentifier}. ${e.notificationText}.</span>
                                        </a>`;

                    notificationHome += `<div class='alert alert-info  notification-index'>                    
                                            <a class='close' onclick='viewNotification(${e.notificationCode})'><i class='material-icons'>close</i></a>
                                            <span style='text-shadow: 1px 2px 2px #08206e36; font-weight: bold'>Proyecto: ${e.projectName} | Ticket: ${e.supportIdentifier}. Mensaje: ${e.notificationText}. Fecha: ${e.notificationDate}. Hora: ${e.notificationHour}</span>
                                        </div>`;
                }

                const html = `<a class='nav-link' href='#' id='navbarDropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                <i class='material-icons'>notifications</i>
                                <span class='notification'>${json.length}</span>
                                <p class='d-lg-none d-md-block'>Some Actions</p>
                            </a>
                            <div class='dropdown-menu dropdown-menu-right' aria-labelledby='navbarDropdownMenuLink'>
                                ${notificationBell}
                            </div>`;

                $('#notification').html(html);
                (controller[2] == 'home') && $('#notificationHome').html(notificationHome);
            }).fail(function(error) {
                console.log(error);
            });
        };

        function viewNotification(notificationCode) {
            var settings = {
                "url": "<?= base_url ?>home/&notificationUpdate=true&notificationCode=" + notificationCode
            };
            $.ajax(settings).done(function(response) {
                if (response == 1) {
                    getNotification();
                } else {
                    console.log(response);
                    alert('¡Hubo un error al leer la notificación! Error: 500');
                }
            }).fail(function(error) {
                alert('¡Error en la petición! Error: 501');
            });
        }

        $(document).ready(function() {
            getNotification();
            setInterval('getNotification()', 180000);
        });
    </script>

    <!-- Notification push -->
    <script>
        function notification() {
            const type = $("#txt_type").val();
            const message = $("#txt_message").val();
            md.showCustomNotification('top', 'center', type, message);
        }
    </script>
    <input type="hidden" name="txt_type" id="txt_type" value="<?= $_SESSION['type-imSupport'] ?>" />
    <input type="hidden" name="txt_tessage" id="txt_message" value="<?= $_SESSION['message-imSupport'] ?>" />

    <?php if (isset($_SESSION['type-imSupport'])) : ?>
        <script>
            notification();
        </script>
    <?php endif; ?>
    <?php
    Utils::deleteSession('type-imSupport');
    Utils::deleteSession('message-imSupport');
    ?>

    <!-- Fin del Modal -->
    <!-- End Navbar -->
    <div class="content">
        <div class="container-fluid">