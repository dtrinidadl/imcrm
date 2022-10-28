<div class="row">
    <div class="col-md-12" align="left">
        <div class="form-group">
            <a href="<?= base_url ?>support/index" class="btn btn-fill btn-success"><i class="material-icons">reply</i> Soporte</a>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary card-header-icon">
                <h4 class="card-title">Historial de ticket's creados</h4>
            </div>
            <div class="card-body">
                <div class="toolbar">
                </div>
                <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                            <tr>
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
                                switch ($data['supportPriority']):
                                    case 1:
                                        $style = "style='color: red; font-weight: bold;'";
                                        break;
                                    case 2:
                                        $style = "style='color: orange; font-weight: bold;'";
                                        break;
                                    default:
                                        $style = "style='color: grey; font-weight: bold;'";
                                        break;
                                endswitch;
                                ?>
                                <tr>
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
                                        Cerrado
                                    </td>
                                    <td align="center">
                                        <a style="color: blue;" href="<?= base_url ?>support/view&supportCode=<?= $data['supportCode'] ?>">
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