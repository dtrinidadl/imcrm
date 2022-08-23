<script>
    function getMunicipio() {

        var codIso_departamento = $("#opt_departamento").val();

        $.ajax({
            url: "<?= base_url ?>cliente/&getMunicipio=true&opt_departamento=" + codIso_departamento,
            success: function (result) {

                $("#getMunicipios").html(result);
            }
        });

        //console.log(codIso_departamento);
    }
    function notificacion() {
        var type = $("#txt_type").val();
        var message = $("#txt_message").val();

        md.showCustomNotification('top', 'center', type, message);
    }
    function getURL() {
        window.location.href = '<?= base_url ?>/cliente/index';
    }
</script>
<input type="hidden" id="txt_type" value="<?= $_SESSION['type-imfel'] ?>"/>
<input type="hidden" id="txt_message" value="<?= $_SESSION['message-imfel'] ?>"/>

<?php if (isset($_SESSION['type-imfel'])) : ?>
    <script>notificacion();</script>
<?php endif; ?>

<?php utils::deleteSession('type-imfel'); ?>
<?php utils::deleteSession('message-imfel'); ?>
<div class="row">
    <div class="col-md-12 text-center">
        <h1>
            <p class="text-success">
                Personas
            </p>
        </h1>
    </div>
    <div class="col-md-12">
        <?php $accion = isset($_cliente) ? "save&id_cliente=" . $_cliente->id : "save"; ?>
        <form method="POST" action="<?= base_url ?>cliente/<?= $accion ?>" enctype="multipart/form-data">
            <div class="card ">
                <div class="card-header card-header-success card-header-icon">
                    <?php if (isset($_cliente)) : ?>
                        <button type="button" class="btn btn-danger close" onclick="getURL();" data-dismiss="alert" aria-label="Close">
                            <i class="material-icons">close</i>
                        </button>
                    <?php endif; ?>
                    <div class="card-icon">
                        <i class="material-icons">menu_book</i>
                    </div>
                    <h4 class="card-title">Mantenimiento de Personas</h4>
                </div>
                &nbsp;<br/>&nbsp;
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="bmd-label-floating">Nombre</label>
                                <input type="text" class="form-control" name="txt_nombre" id="txt_nombre" value="<?= isset($_cliente) ? $_cliente->nombre : '' ?>" required/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="bmd-label-floating">NIT</label>
                                <input type="text" class="form-control" name="txt_nit" id="txt_nit" value="<?= isset($_cliente) ? $_cliente->NIT : '' ?>" required/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="bmd-label-floating">Telefono</label>
                                <input type="text" class="form-control" name="txt_telefono" id="txt_telefono" value="<?= isset($_cliente) ? $_cliente->telefono : '' ?>" required/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Domicilio</label>
                                <input type="text" class="form-control" name="txt_domicilio" id="txt_domicilio" value="<?= isset($_cliente) ? $_cliente->domicilio : '' ?>" required/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="selectpicker" onchange="getMunicipio();" name="opt_departamento" id="opt_departamento" data-style="select-with-transition" title="Departamento" data-size="7">
                                    <?php while ($row = $lista_departamentos->fetch_object()): ?>
                                        <option value="<?= $row->codIso; ?>" <?= isset($_cliente) && $row->codIso == $_cliente->codDepartamento ? 'selected' : ''; ?> > <?= $row->nombre; ?> </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3" id="getMunicipios">
                            <div class="form-group">
                                <?php if (isset($_cliente)): ?>
                                    <select class="selectpicker dropdown"  data-style="select-with-transition"  title="Municipio" name="opt_municipio" id="opt_municipio" data-size="7" tabindex="-98" required="required">
                                        <?php while ($row = $lista_municipios->fetch_object()): ?>
                                            <option value="<?= $row->codMunicipio ?>" <?= isset($_cliente) && $row->codMunicipio == $_cliente->codMunicipio ? 'selected' : ''; ?>> <?= $row->nombre ?> </option>
                                        <?php endwhile; ?>
                                    </select>
                                <?php else: ?>
                                    <select class="selectpicker" name="opt_municipio" data-style="select-with-transition" title="Municipio">
                                        <option> Seleccionar </option>
                                    </select>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="selectpicker" name="opt_estado" data-style="select-with-transition" title="Estado" id="opt_estado" data-size="7" tabindex="-98" required="">
                                    <?php while ($data = $lista_estados->fetch_object()): ?>
                                        <option value="<?= $data->id; ?>" <?= isset($_cliente) && $data->id == $_cliente->idEstado ? 'selected' : ''; ?> > <?= $data->nombre; ?> </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" align="center">
                            <div class="form-group">
                                <input type="hidden" >  <!-- value="< ?= $_usuario->id ?>" id="userId" -->
                                <button type="submit" class="btn btn-fill btn-success">Guardar Información</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-icon">
                <h4 class="card-title">Personas Almacenadas</h4>
            </div>
            <div class="card-body">
                <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                </div>
                <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>NIT</th>
                                <th>Telefono</th>
                                <th>Domicilio</th>
                                <th>Departamento</th>
                                <th>Municipio</th>
                                <th>Estado</th>
                                <th class="disabled-sorting text-center">&nbsp;</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>NIT</th>
                                <th>Telefono</th>
                                <th>Domicilio</th>
                                <th>Departamento</th>
                                <th>Municipio</th>
                                <th>Estado</th>
                                <th class="text-center">&nbsp;</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php while ($row = $lista_clientes->fetch_object()) : ?>
                                <tr>
                                    <td><a href="<?= base_url ?>cliente/edit&id_cliente=<?= $row->id ?>" class="btn btn-success"><?= $row->id ?></a></td>
                                    <td><?= $row->nombre; ?></td>
                                    <td><?= $row->NIT; ?></td>
                                    <td><?= $row->telefono; ?></td>
                                    <td><?= $row->domicilio; ?></td>
                                    <td><?= $row->nombreDepartamento; ?></td>
                                    <td><?= $row->nombreMunicipio; ?></td>
                                    <td><?= $row->nombreEstado; ?></td>
                                    <td class="text-center">
                                        <?php if($row->idEstado == 2) : ?>
                                        <a class="align-right" style="color: green;" href="<?=base_url?>cliente/action&id_option=1&id_cliente=<?=$row->id?>">
                                            <i class="fa fa-check"></i>
                                        </a>
                                        <?php elseif ($row->idEstado == 1): ?>
                                        <a style="color: red;" href="<?=base_url?>cliente/action&id_option=2&id_cliente=<?=$row->id?>">
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
    </div>
    <!--  end card  -->
</div>
</div>