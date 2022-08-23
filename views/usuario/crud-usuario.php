<script>

    $(document).ready(function () {
        $('#txt_telefono1').mask('0000-0000');
        $('#txt_telefono2').mask('0000-0000');
        $('#txt_dpi').mask('0000 00000 0000');
        $('#userForm').submit(function () {
            const userId = $('#userId').val()
            fntTomarId(userId)
            return true;
        })
    });

    function backPage() {

        location.href = "<?= base_url ?>home/index";
    }

    function fntTomarId(idUsuario) {
        const selectedAccess = $('#opt_perfil').val();
        if (selectedAccess.length === 0) {
            swal.fire('Alerta', 'No seleccionados', 'error');
            return
        }
        $.ajax({
            type: 'GET',
            url: "<?= base_url ?>usuario/savePerfilUsuario&idUsuario=" + idUsuario + "&perfiles=" + selectedAccess.join(','),
            success: function (response) {
                console.log("ok");
            }
        })
    }

    function notification() {

        var type = $("#txt_type").val();
        var message = $("#txt_message").val();

        md.showCustomNotification('top', 'center', type, message);
    }

    function findEmpresa() {
        alert("Modal para buscar empresa");
    }

    function buscarComercio() {
        var nombre = $("#txt_buscarComercio").val();
        //console.log(nombre);
        if (nombre) {
            //alert("Algun texto esta lleno");
            $.ajax({
                url: "<?= base_url ?>usuario/&getAddArray=true&key=1&nombreComercio=" + nombre,
                success: function (result) {

                    $("#listaComercios").html(result);
                }
            });

            document.getElementById("txt_buscarComercio").value = "";

            $("#txt_buscarComercio").focus();

        } else {
            alert("No has enviado nada en empresa");
        }
    }

    function agregarEmpresa() {
        console.log("Con esto se agrega empresa");
    }
    function getURL() {
        window.location.href = '<?= base_url ?>/usuario/index';
    }
</script>
<!-- Inputs ocultos que almacenan las variables de sesion de notificacion -->
<input type="hidden" name="txt_type" id="txt_type" value="<?= $_SESSION['type-imfel'] ?>" />
<input type="hidden" name="txt_tessage" id="txt_message" value="<?= $_SESSION['message-imfel'] ?>" />

<?php if (isset($_SESSION['type-imfel'])): ?>
    <script>notification();</script>
<?php endif; ?>
<?php
Utils::deleteSession('type-imfel');
Utils::deleteSession('message-imfel');
$url = isset($_usuario) ? 'usuario/save&id=' . $_usuario->id : 'usuario/save';
?>
<div class="row">
    <!--    <div class="col-md-1 text-left">
            <button class="btn btn-round btn-fab" style="background: #ffd314" onclick="backPage();"> 
                <i class="material-icons">keyboard_arrow_left</i>
            </button>
        </div> Cambiar el div debajo a 10-->
    <div class="col-md-12 text-center">
        <h1>
            <p class="text-success">
                Usuarios
            </p>
        </h1>
    </div>
    <div class="col-md-12">
        <!--< ?php $accion = isset($_usuario) ? "save&id_usuario=" . $_usuario->id : "save"; ?> -->
        <form method="POST" action="<?= base_url . $url ?>" enctype="multipart/form-data" id="userForm"> <!--enctype="multipart/form-data"-->
            <div class="card ">
                <div class="card-header card-header-success card-header-icon">
                    <?php if (isset($_usuario)) : ?>
                        <button type="button" class="btn btn-danger close" onclick="getURL();" data-dismiss="alert" aria-label="Close">
                            <i class="material-icons">close</i>
                        </button>
                    <?php endif; ?>
                    <div class="card-icon">
                        <i class="material-icons">menu_book</i>
                    </div>
                    <h4 class="card-title">Mantenimiento de Usuarios</h4>
                </div>
                &nbsp;<br/>&nbsp;
                <div class="card-body ">
                    <div class="row" id="divInformacion" >
                        <div class="col-md-5">
                            <div class="form-group">
                                <a href="#infoComercio" data-toggle="modal" data-target="#infoComercio">
                                    <input type="hidden" name="id_comercio" value="<?= isset($_usuario) ? $_usuario->idComercio : ''; ?>"/>
                                    <label class="bmd-label-floating">Comercio</label>
                                    <input type="text" class="form-control" name="nombreComercio" value="<?= isset($_usuario) ? utils::getComercioById($_usuario->idComercio) : ''; ?>"  required/>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-1" style="margin-top: 2%;">
                            <a href="#infoComercio" data-toggle="modal" data-target="#infoComercio">
                                <span class="material-icons">search</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="bmd-label-floating">Nombre</label>
                                <input type="text" class="form-control" name="txt_nombre" value="<?= isset($_usuario) ? $_usuario->nombre : '' ?>" required/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="bmd-label-floating">Usuario</label>
                                <input type="text" class="form-control" name="txt_usuario"  value="<?= isset($_usuario) ? $_usuario->usuario : ''; ?>" required/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="bmd-label-floating">DPI</label>
                                <input type="text" class="form-control" name="txt_dpi"  id="txt_dpi" value="<?= isset($_usuario) ? $_usuario->dpi : ''; ?>" required/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="bmd-label-floating">Email</label>
                                <input type="email" class="form-control" name="txt_email"  value="<?= isset($_usuario) ? $_usuario->email : '' ?>" required/>
                            </div>
                        </div>  
                        <?php if (!isset($_usuario)) : ?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Contraseña</label>
                                    <input type="text" class="form-control" name="txt_contrasena"  required/>
                                </div>
                                <!--                            <div class="form-group">
                                                                <label class="bmd-label-floating">Contraseña</label>
                                                                <input type="text" class="form-control" name="txt_contrasena"  value="< ?= isset($_usuario) ? $_usuario->contrasena : '' ?>" required/>
                                                            </div>-->
                            </div>
                        <?php endif; ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="bmd-label-floating">Telefono 1</label>
                                <input type="text" class="form-control" name="txt_telefono1" id="txt_telefono1" value="<?= isset($_usuario) ? $telefono[0] : ''; ?>" required/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="bmd-label-floating">Telefono 2</label>
                                <input type="text" class="form-control" name="txt_telefono2" id="txt_telefono2" value="<?= isset($_usuario) && isset($telefono[1]) ? $telefono[1] : ''; ?>"/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="selectpicker" name="opt_estado" data-style="select-with-transition" title="Estado" id="opt_estado" data-size="7" tabindex="-98">
                                    <?php while ($data = $lista_estados->fetch_object()): ?>
                                        <option value="<?= $data->id; ?>"<?= isset($_usuario) && $data->id == $_usuario->idEstado ? 'selected' : ''; ?> > <?= $data->nombre; ?> </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="selectpicker" data-style="select-with-transition" name="opt_rol" id="opt_rol" required>
                                    <option disabled selected>Rol</option>
                                    <?php while ($rol = $lista_roles->fetch_object()): ?>
                                        <option value="<?= $rol->id ?>" <?= isset($_usuario) && $rol->id == $_usuario->idRol ? 'selected' : ''; ?>> <?= $rol->nombreRol ?> </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="selectpicker" multiple data-style="select-with-transition" name="opt_perfil" id="opt_perfil">
                                    <option disabled>Perfil</option>
                                    <?php foreach ($perfiles as $perfil): ?>
                                        <option value="<?= $perfil->id_perfil ?>" selected> <?= utils::getPerfilById($perfil->id_perfil) ?> </option>                
                                    <?php endforeach; ?>
                                    <?php foreach ($no_perfil as $data): ?>
                                        <option value="<?= $data->id_perfil ?>"> <?= utils::getPerfilById($data->id_perfil) ?> </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" align="center">
                            <div class="form-group">
                                <input type="hidden" value="<?= $_usuario->id ?>" id="userId">  <!-- id="userId -->
                                <button type="submit" class="btn btn-fill btn-success">Guardar Información</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <!-- Lista de Usuarios -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary card-header-icon">
                <h4 class="card-title">Información almacenada</h4>
            </div>
            <div class="card-body">
                <div class="toolbar">
                    <!-- Here you can write extra buttons/actions for the toolbar -->
                </div>
                <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Empresa</th>
                                <th>Nombre</th>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th class="disabled-sorting text-center">&nbsp;</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Empresa</th>
                                <th>Nombre</th>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th class="text-center">&nbsp;</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php while ($data = $lista_usuarios->fetch_object()): ?>
                                <tr>
                                    <td><a href="<?= base_url ?>usuario/edit&id_usuario=<?= $data->id ?>" class="btn btn-success"><?= $data->id ?></a></td>
                                    <td><?= $data->nombreEmpresa ?></td>
                                    <td><?= $data->nombre ?></td>
                                    <td><?= $data->usuario ?></td>
                                    <td><?= $data->email ?></td>
                                    <td><?= $data->Rol ?></td>
                                    <td><?= $data->nombreEstado ?></td>
                                    <td class="text-center">
                                        <?php if ($data->idEstado == 2) : ?>  
                                            <a class="align-right" style="color: green;" href="<?= base_url ?>usuario/action&id_option=1&id_usuario=<?= $data->id ?>">
                                                <i class="fa fa-check"></i>
                                            </a>
                                        <?php elseif ($data->idEstado == 1): ?>                                            
                                            <a style="color: red;" href="<?= base_url ?>usuario/action&id_option=2&id_usuario=<?= $data->id ?>">
                                                <i class="fa fa-remove"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- end content-->
        </div>
        <!--  end card  -->
    </div>
    <!-- end col-md-12 -->
</div>

<!-- Modal para buscar empresas -->
<div class="modal fade" id="infoComercio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 700px !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="font-weight: bold;">
                    Busqueda de Comercio
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label class="bmd-label-floating">Nombre Comercio</label>
                            <input type="text" class="form-control" name="txt_buscarComercio" id="txt_buscarComercio"/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <button class="btn btn-success btn-link" onclick="buscarComercio();">Buscar</button>
                        </div>
                    </div>
                </div>
                <div class="row" id="listaComercios">
                    <div class="col-md-12">
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre Empresa</th>
                                        <th>Nombre Contacto</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <!-- end content-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fin del Modal -->
