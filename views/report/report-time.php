<div class="container-fluid text-center">
    <div class="row">
        <!-- Grafica -->
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-body" style="text-align: left; vertical-align: middle;">
                    <div class="text-center text-imsupport">
                        <b class="font-weight-bold">TICKET'S</b><br>
                    </div>
                    <table class="text-center w-100">
                        <tr>
                            <td><i class="icon-reports material-icons">open_in_new</i></td>
                            <td><i class="icon-reports material-icons">open_in_new_off</i></td>
                        </tr>
                        <tr>
                            <th><?= $params->TOTAL ?></th>
                            <th><?= $params->E_CERRADO ?></th>
                        </tr>
                        <tr>
                            <td width="50%">Total</td>
                            <td width="50%">Cerrados</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-body" style="text-align: left; vertical-align: middle;">
                    <div class="text-center text-imsupport">
                        <b class="font-weight-bold">MÁS TICKET'S</b><br>
                        <i class="icon-reports material-icons">report_problem</i>
                    </div>
                    <table class="text-center w-100">
                        <tr>
                            <th><?= $ticket_max->COUNT ?></th>
                            <th><?= $ticket_max->PROJECT_NAME ?></th>
                        </tr>
                        <tr>
                            <td width="50%">Cantidad</td>
                            <td width="50%">Proyecto</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-body" style="text-align: left; vertical-align: middle;">
                    <div class="text-center text-imsupport">
                        <b class="font-weight-bold">PROMEDIO</b><br>
                    </div>
                    <table class="text-center w-100">
                        <tr>
                            <td><i class="icon-reports material-icons">timer</i></td>
                            <td><i class="icon-reports material-icons">history</i></td>
                        </tr>
                        <tr>
                            <th><?= $params->P_DIAS ?></th>
                            <th><?= $params->P_MIN ?></th>
                        </tr>
                        <tr>
                            <td width="50%">Días</td>
                            <td width="50%">Minutos</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="material-datatables">
                        <table id="example" class="table table-striped table-bordered" style="width:100%;">
                            <thead>
                                <tr>
                                    <th class="font-weight-bold">Proyecto</th>
                                    <th class="font-weight-bold">Usuario</th>
                                    <th class="font-weight-bold">Ticket</th>
                                    <th class="font-weight-bold">F. Cracion</th>
                                    <th class="font-weight-bold">D. Analisis</th>
                                    <th class="font-weight-bold">D. Desarrollo</th>
                                    <th class="font-weight-bold">D. QA</th>
                                    <th class="font-weight-bold">D. Total</th>
                                    <th class="font-weight-bold">F. Cierre</th>                                    
                                    <th class="font-weight-bold">Tipo</th>
                                    <th class="font-weight-bold">Prioridad</th>
                                    <th class="font-weight-bold">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($data = $report_list->fetch_assoc()) : ?>
                                    <tr>
                                        <td><?= $data['projectName'] ?></td>
                                        <td><?= $data['userName'] ?></td>
                                        <td>
                                            <a href="<?= base_url ?>support/view&supportCode=<?= $data['supportCode'] ?>" class="btn-report-line">
                                                <?= $data['supportIdentifier'] ?>
                                            </a>
                                        </td>
                                        <td><?= $data['supportCreatedDate'] ?></td>
                                        <td><?= $data['dif_a'] ?></td>
                                        <td><?= $data['dif_d'] ?></td>
                                        <td><?= $data['dif_qa'] ?></td>
                                        <td><?= $data['dif_f'] ?></td>
                                        <td><?= $data['supportFinishDate'] ?></td>                                        
                                        <td><?= $data['supportType'] ?></td>
                                        <td><?= $data['supportPriority'] ?></td>
                                        <td><?= $data['supportStatus'] ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Proyecto</th>
                                    <th>Usuario</th>
                                    <th>Ticket</th>
                                    <th>F. Cracion</th>
                                    <th>D. Analisis</th>
                                    <th>D. Desarrollo</th>
                                    <th>D. QA</th>
                                    <th>D. Total</th>
                                    <th>F. Cierre</th>
                                    <th>Tipo</th>
                                    <th>Prioridad</th>
                                    <th>Estado</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'csv',
                    filename: 'imSupport-reporte',
                    text: 'CSV',
                    className: 'btn btn-success btn-sm btn-export mr-1'
                },
                {
                    extend: 'excel',
                    filename: 'imSupport-reporte',
                    text: 'Excel',
                    className: 'btn btn-success btn-sm btn-export'
                },
                {
                    extend: 'pdf',
                    filename: 'imSupport-reporte',
                    text: 'pdf',
                    className: 'btn btn-success btn-sm btn-export ml-1'
                }
            ]
        });
    });
</script>