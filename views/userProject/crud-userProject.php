<script>
    function notification() {
        let type = $("#txt_type").val();
        let message = $("#txt_message").val();

        md.showCustomNotification('top', 'center', type, message);
    }

    function getURL() {
        window.location.href = '<?= base_url ?>userProject/index';
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
$url = isset($_userProject) ? 'userProject/update' : 'userProject/save';
?>
<div class="row">
    <div class="col-md-12">
        <form method="POST" action="<?= base_url . $url ?>" enctype="multipart/form-data" id="userForm">
            <div class="card ">
                <div class="card-header card-header-success card-header-icon">
                    <?php if (isset($_userProject)) : ?>
                        <button type="button" class="btn btn-danger close" onclick="getURL();" data-dismiss="alert" aria-label="Close">
                            <i class="material-icons">close</i>
                        </button>
                    <?php endif; ?>
                    <div class="card-icon">
                        <i class="material-icons">menu_book</i>
                    </div>
                    <h4 class="card-title">Mantenimiento relación usuario - proyecto</h4>
                </div>
                <br />
                <div class="card-body ">
                    <div class="row" id="divInformacion">
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <input type="hidden" name="txt_userProjectCode" id="txt_userProjectCode" value="<?= isset($_userProject) ? $_userProject->userProjectCode : '' ?>" />
                                <select class="selectpicker" data-style="select-with-transition" title="Empresa" name="opt_userProjectCompanyCode" id="opt_userProjectCompanyCode" required>
                                    <?php while ($data = $company_list->fetch_object()) : ?>
                                        <option value="<?= $data->companyCode; ?>" <?= isset($_userProject) && $data->companyCode == $_userProject->userProjectCompanyCode ? 'selected' : ''; ?>>
                                            <?= $data->companyBusinessName; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <select class="form-control" name="opt_userProjectProjectCode" id="opt_userProjectProjectCode" required>
                                    <?php if (!isset($project_list)) : ?>
                                        <option selected disabled>-- Selecciona una empresa --</option>
                                    <?php else : ?>
                                        <?php while ($data = $project_list->fetch_object()) : ?>
                                            <option value="<?= $data->projectCode; ?>" <?= isset($_userProject) && $data->projectCode == $_userProject->userProjectProjectCode ? 'selected' : ''; ?>>
                                                <?= $data->projectName; ?>
                                            </option>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <select class="selectpicker" data-style="select-with-transition" title="Usuario" name="opt_userProjectUserCode" id="opt_userProjectUserCode" required>
                                    <?php while ($data = $user_list->fetch_object()) : ?>
                                        <option value="<?= $data->userCode; ?>" <?= isset($_userProject) && $data->userCode == $_userProject->userProjectUserCode ? 'selected' : ''; ?>>
                                            <?= $data->userName; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <select class="selectpicker" data-style="select-with-transition" name="opt_userProjectRole" id="opt_userProjectRole" required>
                                    <option disabled <?= isset($_userProject) ? '' : 'selected'; ?>>Rol</option>
                                    <option value=1 <?= (isset($_userProject) && $_userProject->userProjectRole == 1) ? 'selected' : ''; ?>>Cliente</option>
                                    <option value=2 <?= (isset($_userProject) && $_userProject->userProjectRole == 2) ? 'selected' : ''; ?>>PO</option>
                                    <option value=3 <?= (isset($_userProject) && $_userProject->userProjectRole == 3) ? 'selected' : ''; ?>>Lead Developer</option>
                                    <option value=4 <?= (isset($_userProject) && $_userProject->userProjectRole == 4) ? 'selected' : ''; ?>>Developer</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" align="center">
                            <div class="form-group">
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
                                <th>Empresa</th>
                                <th>Projecto</th>
                                <th>Usuario</th>
                                <th>Rol</th>
                                <th class="text-center" class="disabled-sorting text-center">Acción</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Empresa</th>
                                <th>Projecto</th>
                                <th>Usuario</th>
                                <th>Rol</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php while ($data = $userProject_list->fetch_assoc()) : ?>
                                <tr>
                                    <td><?= $data['companyBusinessName'] ?></td>
                                    <td><?= $data['projectName'] ?></td>
                                    <td><?= $data['userName'] ?></td>
                                    <td><?= $data['userProjectStatus'] ?></td>
                                    <td align="center">
                                        <a href="<?= base_url ?>userProject/edit&userProjectCode=<?= $data['userProjectCode'] ?>">
                                            <i class="fa fa-pencil fa-lg"></i>
                                        </a>
                                        &nbsp;
                                        <a style="color: red;" href="<?= base_url ?>userProject/deleted&userProjectCode=<?= $data['userProjectCode'] ?>">
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

<script type="text/javascript">
    $(function() {
        $("#opt_userProjectCompanyCode").on('change', function() {
            const projectCompanyCode = $("#opt_userProjectCompanyCode").val();

            var settings = {
                "url": "<?= base_url ?>userProject/&view=true&projectCompanyCode=" + projectCompanyCode,
                "method": "POST",
                "headers": {
                    "Content-Type": "application/json"
                },
                "data": JSON.stringify({
                    "projectCompanyCode": projectCompanyCode
                }),
            };

            $.ajax(settings).done(function(response) {
                $('#opt_userProjectProjectCode').html(response);
                // console.log(response);
                const select = document.getElementById('#opt_userProjectProjectCode');
                select.classList.add("selectpicker");
            }).fail(function(error) {
                console.log(error);
            });
        })
    })
</script>