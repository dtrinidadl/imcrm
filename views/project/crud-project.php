<script>
    function notification() {
        let type = $("#txt_type").val();
        let message = $("#txt_message").val();

        md.showCustomNotification('top', 'center', type, message);
    }

    function getURL() {
        window.location.href = '<?= base_url ?>project/index';
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
$url = isset($_project) ? 'project/update' : 'project/save';
?>
<div class="row">
    <?php if($identityUserRole == 1): ?>
    <div class="col-md-12">
        <form method="POST" action="<?= base_url . $url ?>" enctype="multipart/form-data" id="projectForm">
            <div class="card ">
                <div class="card-header card-header-success card-header-icon">
                    <?php if (isset($_project)) : ?>
                        <button type="button" class="btn btn-danger close" onclick="getURL();" data-dismiss="alert" aria-label="Close">
                            <i class="material-icons">close</i>
                        </button>
                    <?php endif; ?>
                    <div class="card-icon">
                        <i class="material-icons">menu_book</i>
                    </div>
                    <h4 class="card-title">Mantenimiento de proyecto</h4>
                </div>
                <br />
                <div class="card-body ">
                    <div class="row" id="divInformacion">
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <select class="selectpicker" title="Empresa" name="opt_projectCompanyCode" id="opt_projectCompanyCode" data-style="select-with-transition" data-size="7" tabindex="-98">
                                    <?php while ($data = $company_list->fetch_object()) : ?>
                                        <option value="<?= $data->companyCode; ?>" <?= isset($_project) && $data->companyCode == $_project->projectCompanyCode ? 'selected' : ''; ?>>
                                            <?= $data->companyBusinessName; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <select class="selectpicker" data-style="select-with-transition" title="Categoría" name="opt_projectCategory" id="opt_projectCategory" required>
                                    <option value=1 <?= (isset($_project) && $_project->projectCategory == 1) ? 'selected' : ''; ?>>Asesoría</option>
                                    <option value=2 <?= (isset($_project) && $_project->projectCategory == 2) ? 'selected' : ''; ?>>Aplicación web</option>
                                    <option value=3 <?= (isset($_project) && $_project->projectCategory == 3) ? 'selected' : ''; ?>>Aplicación móvil </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <select class="selectpicker" data-style="select-with-transition" title="Estado" name="opt_projectStatus" id="opt_projectStatus" required>
                                    <option value=1 <?= (isset($_project) && $_project->projectStatus == 1) ? 'selected' : ''; ?>>Requerimientos</option>
                                    <option value=2 <?= (isset($_project) && $_project->projectStatus == 2) ? 'selected' : ''; ?>>Planificación</option>
                                    <option value=3 <?= (isset($_project) && $_project->projectStatus == 3) ? 'selected' : ''; ?>>Diseño</option>
                                    <option value=4 <?= (isset($_project) && $_project->projectStatus == 4) ? 'selected' : ''; ?>>Análisis</option>
                                    <option value=5 <?= (isset($_project) && $_project->projectStatus == 5) ? 'selected' : ''; ?>>Arquitectura</option>
                                    <option value=6 <?= (isset($_project) && $_project->projectStatus == 6) ? 'selected' : ''; ?>>Desarrollo</option>
                                    <option value=7 <?= (isset($_project) && $_project->projectStatus == 7) ? 'selected' : ''; ?>>Garantía</option>
                                    <option value=8 <?= (isset($_project) && $_project->projectStatus == 8) ? 'selected' : ''; ?>>Finalizado</option>
                                    <option value=9 <?= (isset($_project) && $_project->projectStatus == 9) ? 'selected' : ''; ?>>Discontinuado</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <select class="selectpicker" data-style="select-with-transition" title="Ranking" name="opt_projectRank" id="opt_projectRank" required>
                                    <option value=1 <?= (isset($_project) && $_project->projectRank == 1) ? 'selected' : ''; ?>>Top</option>
                                    <option value=2 <?= (isset($_project) && $_project->projectRank == 2) ? 'selected' : ''; ?>>Alto</option>
                                    <option value=3 <?= (isset($_project) && $_project->projectRank == 3) ? 'selected' : ''; ?>>Medio</option>
                                    <option value=4 <?= (isset($_project) && $_project->projectRank == 4) ? 'selected' : ''; ?>>Bajo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Nombre</label>
                                <input type="hidden" name="txt_projectCode" id="txt_projectCode" value="<?= isset($_project) ? $_project->projectCode : '' ?>" />
                                <input type="text" class="form-control" name="txt_projectName" value="<?= isset($_project) ? $_project->projectName : '' ?>" minlength="3" maxlength="150" required />
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label class="label-control">Fecha de Inicio</label>
                                <input type="date" class="form-control datetimepicker" name="txt_projectStartDate" value="<?= isset($_project) ? $_project->projectStartDate : ''; ?>" required />
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label class="label-control">Fecha de Finalización</label>
                                <input type="date" class="form-control datetimepicker" name="txt_projectFinishDate" value="<?= isset($_project) ? $_project->projectFinishDate : ''; ?>" />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Repositorio</label>
                                <input type="text" class="form-control" name="txt_projectRepository" value="<?= isset($_project) ? $_project->projectRepository : '' ?>" />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Documentación</label>
                                <input type="text" class="form-control" name="txt_projectDocumentation" value="<?= isset($_project) ? $_project->projectDocumentation : '' ?>" />
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="bmd-label-floating">Descripción</label>
                                <textarea class="form-control" name="txt_projectDescription" rows="6" required><?= isset($_project) ? $_project->projectDescription : ''; ?></textarea>
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
    <?php endif; ?>

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
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Estado</th>
                                <th>Inicio</th>
                                <th>Finalizo</th>
                                <th class="text-center" class="disabled-sorting text-center">Acción</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Empresa</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Estado</th>
                                <th>Inicio</th>
                                <th>Finalizo</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php while ($data = $project_list->fetch_assoc()) : ?>
                                <tr>
                                    <td><?= $data['companyBusinessName'] ?></td>
                                    <td><?= $data['projectName'] ?></td>
                                    <td><?= $data['projectCategory'] ?></td>
                                    <td><?= $data['projectStatus'] ?></td>
                                    <td><?= $data['startDate'] ?></td>
                                    <td><?= $data['finishDate'] ?></td>
                                    <td align="center">
                                        <?php if($identityUserRole == 1): ?>
                                        <a href="<?= base_url ?>project/edit&projectCode=<?= $data['projectCode'] ?>">
                                            <i class="fa fa-pencil fa-lg"></i>
                                        </a>                                        
                                        &nbsp;
                                        <?php endif; ?>
                                        <!-- <a style="color: blue;" href="#viewProject" data-toggle="modal" data-target="#viewProject">
                                            <i class="fa fa-eye fa-lg"></i>
                                        </a> -->
                                        <a style="color: blue;" onclick="viewProject(<?= $data['projectCode'] ?>);" data-toggle="modal" data-target="#viewProject">
                                            <i class="fa fa-eye fa-lg"></i>
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
<!-- Modal para cambio de contraseña -->
<div class="modal fade" id="viewProject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title card-title text-success">
                    <i class="material-icons">category</i>
                    <b>Projecto</b>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <p>
                            <b>Nombre: </b>
                            <span id="_projectName"><span>
                        </p>
                    </div>
                    <div class="col-6">
                        <p>
                            <b>Empresa: </b>
                            <span id="_projectCompanyCode"><span>
                        </p>
                    </div>
                    <div class="col-6">
                        <p>
                            <b>Fecha Inicio: </b>
                            <span id="_projectStartDate"><span>
                        </p>
                    </div>
                    <div class="col-6">
                        <p>
                            <b>Fecha Fin: </b>
                            <span id="_projectFinishDate"><span>
                        </p>
                    </div>
                    <div class="col-4">
                        <p>
                            <b>Categoría: </b>
                            <span id="_projectCategory"><span>
                        </p>
                    </div>
                    <div class="col-4">
                        <p>
                            <b>Estado: </b>
                            <span id="_projectStatus"><span>
                    </div>
                    </p>
                    <div class="col-4">
                        <p>
                            <b>Ranking: </b>
                            <span id="_projectRank"><span>
                        </p>
                    </div>                    
                    <div class="col-12">
                        <p>
                            <b>Repositorio: </b>
                            <a href="" target="_blank" id="_projectRepositoryURL">
                                <span id="_projectRepository"><span>
                            </a>
                        </p>
                    </div>
                    <div class="col-12">
                        <p>
                            <b>Documentación: </b>
                            <a href="" target="_blank" id="_projectDocumentationURL">
                                <span id="_projectDocumentation"><span>
                            </a>
                        </p>
                    </div>
                    <div class="col-12">
                        <hr>
                        <p><b>Descripción: </b></p>
                        <p id="_projectDescription"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewProject(projectCode) {
            var settings = {                                
                "url": "<?= base_url ?>project/&view=true&projectCode="+projectCode,
                "method": "POST",                
                "headers": {
                    "Content-Type": "application/json"
                },
                "data": JSON.stringify({
                    "projectCode": projectCode
                }),
            };
            $.ajax(settings).done(function(response) {
                // console.log(result);
                const result = JSON.parse(response);
                $('#_projectName').html(result.projectName);
                $('#_projectCompanyCode').html(result.companyBusinessName);
                $('#_projectCategory').html(result.projectCategory);
                $('#_projectStatus').html(result.projectStatus);
                $('#_projectRank').html(result.projectRank);
                $('#_projectStartDate').html(result.startDate);
                $('#_projectFinishDate').html(result.finishDate);
                $('#_projectRepository').html(result.projectRepository);
                $("#_projectRepositoryURL").attr('href', result.projectRepository);
                $('#_projectDocumentation').html(result.projectDocumentation);
                $("#_projectDocumentationURL").attr('href', result.projectDocumentation);
                $('#_projectDescription').html(result.projectDescription);
            }).fail(function(error) {
                console.log(error);
            });
        }
    </script>
</div>