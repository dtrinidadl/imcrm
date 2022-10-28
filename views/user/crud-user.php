<script>
    $(document).ready(function() {
        $('#txt_userPhone').mask('0000-0000');
    });

    function notification() {
        let type = $("#txt_type").val();
        let message = $("#txt_message").val();

        md.showCustomNotification('top', 'center', type, message);
    }

    function getURL() {
        window.location.href = '<?= base_url ?>user/index';
    }
</script>
<!-- Variable de notificacion -->
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
$url = isset($_user) ? 'user/update' : 'user/save';
?>
<div class="row">
    <div class="col-md-12">
        <form method="POST" action="<?= base_url . $url ?>" enctype="multipart/form-data" id="userForm">
            <div class="card ">
                <div class="card-header card-header-success card-header-icon">
                    <?php if (isset($_user)) : ?>
                        <button type="button" class="btn btn-danger close" onclick="getURL();" data-dismiss="alert" aria-label="Close">
                            <i class="material-icons">close</i>
                        </button>
                    <?php endif; ?>
                    <div class="card-icon">
                        <i class="material-icons">menu_book</i>
                    </div>
                    <h4 class="card-title">Mantenimiento de Usuarios</h4>
                </div>
                <br />
                <div class="card-body ">
                    <div class="row" id="divInformacion">
                        <div class="col-sm-6 col-md-3 col-lg-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Nombre</label>
                                <input type="hidden" name="txt_userCode" id="txt_userCode" value="<?= isset($_user) ? $_user->userCode : '' ?>" />
                                <input type="text" class="form-control" name="txt_userName" value="<?= isset($_user) ? $_user->userName : '' ?>" minlength="3" maxlength="149" required />
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3 col-lg-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Usuario</label>
                                <input type="text" class="form-control" name="txt_userNickname" value="<?= isset($_user) ? $_user->userNickname : ''; ?>" minlength="5" maxlength="30" required />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Email</label>
                                <input type="email" class="form-control" name="txt_userEmail" value="<?= isset($_user) ? $_user->userEmail : '' ?>" minlength="8" maxlength="149" required />
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Contraseña</label>
                                <input type="text" class="form-control" name="txt_userPassword" minlength="8" maxlength="50" <?= isset($_user) ? 'disabled ' : 'required' ?> />
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Télefono</label>
                                <input type="text" class="form-control" name="txt_userPhone" id="txt_userPhone" value="<?= isset($_user) ? $_user->userPhone : ''; ?>" required />
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <select class="selectpicker" data-style="select-with-transition" name="opt_userRole" id="opt_userRole" required>
                                    <option disabled <?= isset($_user) ? '' : 'selected'; ?>>Rol</option>
                                    <option value=1 <?= (isset($_user) && $_user->userRole == 1) ? 'selected' : ''; ?>>Administrador</option>
                                    <option value=2 <?= (isset($_user) && $_user->userRole == 2) ? 'selected' : ''; ?>>Operativo</option>
                                    <option value=3 <?= (isset($_user) && $_user->userRole == 3) ? 'selected' : ''; ?>>Cliente</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" align="center">
                            <div class="form-group">
                                <!-- <input type="hidden" value="< ?= $_user->id ?>" id="userId"> id="userId -->
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
                </div>
                <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Telefono</th>
                                <th>Rol</th>
                                <th>Fecha</th>
                                <th class="text-center" class="disabled-sorting text-center">Acción</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nombre</th>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Telefono</th>
                                <th>Rol</th>
                                <th>Fecha</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php while ($data = $user_list->fetch_assoc()) : ?>
                                <tr>
                                    <td><?= $data['userName'] ?></td>
                                    <td><?= $data['userNickname'] ?></td>
                                    <td><?= $data['userEmail'] ?></td>
                                    <td><?= $data['userPhone'] ?></td>
                                    <td>
                                        <?php
                                        switch ($data['userRole']):
                                            case 1:
                                                echo 'Administrador';
                                                break;
                                            case 2:
                                                echo 'Operador';
                                                break;
                                            case 3:
                                                echo 'Cliente';
                                                break;
                                        endswitch;
                                        ?>
                                    </td>
                                    <td><?= $data['userDate'] ?></td>
                                    <td align="center">
                                        <a href="<?= base_url ?>user/edit&userCode=<?= $data['userCode'] ?>">
                                            <i class="fa fa-pencil fa-lg"></i>
                                        </a>
                                        &nbsp;
                                        <a style="color: red;" href="<?= base_url ?>user/deleted&userCode=<?= $data['userCode'] ?>">
                                            <i class="fa fa-remove fa-lg"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>