<script>
    $(document).ready(function() {
        $('#txt_companyContactPhone').mask('0000-0000');
    });

    function notification() {
        let type = $("#txt_type").val();
        let message = $("#txt_message").val();

        md.showCustomNotification('top', 'center', type, message);
    }

    function getURL() {
        window.location.href = '<?= base_url ?>company/index';
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
$url = isset($_company) ? 'company/update' : 'company/save';
?>
<div class="row">
    <div class="col-md-12">
        <form method="POST" action="<?= base_url . $url ?>" enctype="multipart/form-data" id="companyForm">
            <div class="card ">
                <div class="card-header card-header-success card-header-icon">
                    <?php if (isset($_company)) : ?>
                        <button type="button" class="btn btn-danger close" onclick="getURL();" data-dismiss="alert" aria-label="Close">
                            <i class="material-icons">close</i>
                        </button>
                    <?php endif; ?>
                    <div class="card-icon">
                        <i class="material-icons">menu_book</i>
                    </div>
                    <h4 class="card-title">Mantenimiento de Empresas</h4>
                </div>
                <br />
                <div class="card-body ">
                    <div class="row" id="divInformacion">
                        <div class="col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Nombre</label>
                                <input type="hidden" name="txt_companyCode" id="txt_companyCode" value="<?= isset($_company) ? $_company->companyCode : '' ?>" />
                                <input type="text" class="form-control" name="txt_companyName" value="<?= isset($_company) ? $_company->companyName : '' ?>" minlength="3" maxlength="150" required />
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Nombre Comercial</label>
                                <input type="text" class="form-control" name="txt_companyBusinessName" value="<?= isset($_company) ? $_company->companyBusinessName : ''; ?>" minlength="5" maxlength="150" required />
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">NIT</label>
                                <input type="text" class="form-control" name="txt_companyTaxDocument" value="<?= isset($_company) ? $_company->companyTaxDocument : ''; ?>" minlength="5" maxlength="10" required />
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3 col-lg-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Rubro</label>
                                <input type="text" class="form-control" name="txt_companyEntry" value="<?= isset($_company) ? $_company->companyEntry : ''; ?>" minlength="5" maxlength="150" required />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-9 col-lg-8">
                            <div class="form-group">
                                <label class="bmd-label-floating">Dirección</label>
                                <input type="text" class="form-control" name="txt_companyAddress" value="<?= isset($_company) ? $_company->companyAddress : ''; ?>" minlength="6" maxlength="200" required />
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3 col-lg-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Nombre Contacto</label>
                                <input type="text" class="form-control" name="txt_companyContactName" value="<?= isset($_company) ? $_company->companyContactName : '' ?>" minlength="3" maxlength="150" required />
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3 col-lg-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Télefono Contacto</label>
                                <input type="text" class="form-control" name="txt_companyContactPhone" id="txt_companyContactPhone" value="<?= isset($_company) ? $_company->companyContactPhone : ''; ?>" required />
                            </div>
                        </div> 
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Email Contacto</label>
                                <input type="email" class="form-control" name="txt_companyContactEmail" value="<?= isset($_company) ? $_company->companyContactEmail : '' ?>" minlength="8" maxlength="150" required />
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
                                <th>Nombre C.</th>
                                <th>NIT</th>
                                <th>Contacto</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>Fecha</th>
                                <th class="text-center" class="disabled-sorting text-center">Acción</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>                                
                                <th>Nombre C.</th>
                                <th>NIT</th>
                                <th>Contacto</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>Fecha</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php while ($data = $company_list->fetch_assoc()) : ?>
                                <tr>                                                                   
                                    <td><?= $data['companyBusinessName'] ?></td>
                                    <td><?= $data['companyTaxDocument'] ?></td>
                                    <td><?= $data['companyContactName'] ?></td>
                                    <td><?= $data['companyContactPhone'] ?></td>                                
                                    <td><?= $data['companyContactEmail'] ?></td>
                                    <td><?= $data['companyDate'] ?></td>
                                    <td align="center">
                                        <a href="<?= base_url ?>company/edit&companyCode=<?= $data['companyCode'] ?>">                                        
                                            <i class="fa fa-pencil fa-lg"></i>
                                        </a>
                                        &nbsp;
                                        <a style="color: red;" href="<?= base_url ?>company/deleted&companyCode=<?= $data['companyCode'] ?>">
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