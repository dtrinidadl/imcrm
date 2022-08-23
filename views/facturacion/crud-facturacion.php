<script>
    function fntShowModalFactura(noFactura, serie) {

        $.ajax({
            url: "<?= base_url ?>facturacion/&drawContenidoModalFactura=true&factura=" + noFactura +"&serie="+ serie,
            success: function (result) {
                $("#modalContentFactura").html(result);
                $("#modalFactura").modal("show");
            }
        });
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

<div class="modal fade" id="modalFactura" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 50%;">
        <div class="modal-content" id="modalContentFactura">

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 text-center">
        <h1>
            <p class="text-success">
                Factura
            </p>
        </h1>
    </div>

    <div class="col-md-12">
        <input type="button" class="btn btn-success btn-wd" onclick="fntShowModalFactura();" value="Ingresar Nueva Factura">
    </div>

    <!-- Lista de Facturas -->
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
                                <th>Serie</th>
                                <th>No. Factura</th>
                                <th>Cliente</th>
                                <th>Nit</th>
                                <th>Monto</th>
                                <th>Fecha</th>
                                <th class="disabled-sorting text-center">Estado</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Serie</th>
                                <th>No. Factura</th>
                                <th>Cliente</th>
                                <th>Nit</th>
                                <th>Monto</th>
                                <th>Fecha</th>
                                <th class="text-center">Estado</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php while ($data = $lista_facturas->fetch_object()): ?>
                                <tr>
                                    <td>
                                        <span class="badge badge-success h5" onclick="fntShowModalFactura('<?= $data->noFactura; ?>', '<?= $data->serie; ?>');" style="cursor: pointer">
                                            <?= $data->id; ?>
                                        </span>
                                    </td>
                                    <td><?= $data->serie ?></td>
                                    <td><?= $data->noFactura ?></td>
                                    <td><?= $data->nombreCliente ?></td>
                                    <td><?= $data->nitCliente ?></td>
                                    <td><?= $data->montoTotal ?></td>
                                    <td><?= $data->fFacturacion ?></td>
                                    <td class="text-center">
                                        <?php if ($data->idEstado == 2) : ?>  
                                                <!--< ?= base_url ?>usuario/action&id_option=2&id_usuario=<?= $data->id ?>"-->
                                            <a class="text-gray" href="#">
                                                Anulada
                                            </a>
                                        <?php elseif ($data->idEstado == 1): ?>                                            
                                            <!--< ?= base_url ?>usuario/action&id_option=2&id_usuario=<?= $data->id ?>"-->
                                            <a class="text-danger" href="#">
                                                Anular
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
