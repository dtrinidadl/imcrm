<div class="row">
    <?php if ($insert == true) : ?>
        <div class="col-md-8 ml-auto mr-auto">
            <div class="rotating-card-container">
                <div class="card card-rotate card-background">
                    <div class="front front-background" style="background-image:url('<?= base_url ?>assets/img/13184983_5127047.jpg');">
                        <div class="card-body">
                            <br>
                            <a href="#pablo">
                                <h2 class="card-title" style="font-weight: bold;">Ticket's</h2>
                            </a>
                            <p class="card-description" style="font-weight: bold;">
                                Si usted tiene problemas con alguno de los proyectos nos puede enviar un nuevo ticket, nosotros lo respondemos y solucionaremos su problema.
                                Tambien puedes revisar un ticket que ya se resolvio.
                            </p>
                        </div>
                    </div>
                    <div class="back back-background" style="background-image:url('<?= base_url ?>assets/img/13184983_5127047.jpg');">
                        <div class="card-body">
                            <br>
                            <br>
                            <br>
                            <div class="stats">
                                <a href="<?= base_url ?>support/new" name="button" class="btn btn-white btn-fill btn-round">
                                    <i class="material-icons">library_add</i> Crear un Ticket
                                </a>
                                &nbsp;
                                <a href="<?= base_url ?>support/history" name="button" class="btn btn-white btn-fill btn-round">
                                    <i class="material-icons">history</i> Historial de Ticket's
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="col-md-12" align="left">
            <div class="form-group">
                <a href="<?= base_url ?>support/history" name="button" class="btn btn-grey btn-fill btn-round">
                    <i class="material-icons">history</i> Historial de Ticket's
                </a>
            </div>
        </div>
    <?php endif; ?>

    <!-- Lista de Usuarios -->
    
    <div class="col-md-12">
    <?= 'Codigo: ', $identityUserCode ?>
    <?= 'Rol: ', $identityUserRole ?>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary card-header-icon">
                <h4 class="card-title">Ticket's creados activos</h4>
            </div>
            <div class="card-body">
                <div class="toolbar">
                </div>
                <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>Ingreso</th>
                                <th>Proyecto</th>
                                <th>Ticket</th>
                                <th>Tipo</th>
                                <th>Prioridad</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th class="text-center" class="disabled-sorting text-center">Acción</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Ingreso</th>
                                <th>Proyecto</th>
                                <th>Ticket</th>
                                <th>Tipo</th>
                                <th>Prioridad</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php while ($data = $support_list->fetch_assoc()) : ?>
                                <?php
                                
                                if($data['supportUserCode'] == $identityUserCode || $identityUserRole < 3) :

                                switch ($data['supportPriority']):
                                    case 1:
                                        $style = "style='color: red; font-weight: bold;'";
                                        break;
                                    case 2:
                                        $style = "style='color: orange; font-weight: bold;'";
                                        break;
                                    default:
                                        $style = "style='color: #e6ce00; font-weight: bold;'";
                                        break;
                                endswitch;
                                ?>
                                <tr>
                                    <td>
                                        <?=  ($data['supportUserCode'] == $identityUserCode) ? "<b style='color: green; font-weight: bold;'>Tu</b>" : $data['userName'] ?>
                                    </td>
                                    <td>
                                        <?= $data['projectName'] ?>
                                    </td>
                                    <td>
                                        <?= $data['supportIdentifier'] ?>
                                    </td>
                                    <td>
                                        <?= $data['supportType'] ?>
                                    </td>
                                    <td <?= $style ?>>
                                        <?= $data['supportPriorityShow'] ?>
                                    </td>
                                    <td>
                                        <?= $data['supportCreatedDate'] ?>
                                    </td>
                                    <td>
                                        <?= $data['supportStatus'] ?>
                                    </td>
                                    <td align="center">
                                        <a style="color: blue;" href="<?= base_url ?>support/view&supportCode=<?= $data['supportCode'] ?>">
                                            <i class="fa fa-eye fa-lg"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endif;
                        endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>