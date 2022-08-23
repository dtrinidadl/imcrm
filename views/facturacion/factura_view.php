<?php

class factura_view {

    //public function drawContenidoModalFactura($id_perfil, $_perfil, $lista_estados, $url)
    public function drawContenidoModalFactura($_comercio, $_facturaE, $_facturaD) {
        ?>

        <script>
            setTimeout(subtotal, 200);
            $(document).ready(function () {
                ('#txt_telefono').mask('0000-0000');

            });

            function buscarCliente() {
                var nit = $("#txt_nit").val();

                if (nit) {
                    $.ajax({
                        url: "<?= base_url ?>cliente/&getCliente=true&txt_nit=" + nit,
                        success: function (result) {
                            $("#divInfoCliente").html(result);
                            $('#txt_nit').focus();
                            buscarDireccion();
                        }
                    });
                }
            }
        </script>

        <script>
            $(document).ready(function () {

                fntShowProductoComercioSale();
                /*$("#slcEmpresaSale").change(function () {
                 fntShowProductoComercioSale();
                 });*/

            });

            function fntShowProductoComercioSale() {

                $.ajax({
                    //url: "< ?= base_url ?>facturacion/&drawProductoComercioSale=true&comercio=" + $("#slcEmpresaSale").val(),
                    url: "<?= base_url ?>facturacion/&drawProductoComercioSale=true",
                    success: function (result) {

                        $("#divSumaProducto").html(result);
                    }
                });

            }
            ///////////////////////////////
            //Nuevo Vergueo
            function fntSetFactura() {

                console.log("Hola por Consola");

                /*
                 boolErrorProducto = false;
                 $(".txtCantidadProducto").each(function () {
                 
                 arrExplore = this.id.split("_");
                 
                 $("#txtCantidadProductoError_" + arrExplore[1]).hide();
                 
                 if (parseInt(this.value) <= 0 || this.value == "") {
                 
                 boolErrorProducto = true;
                 $("#txtCantidadProductoError_" + arrExplore[1]).html("Mayor a 0");
                 $("#txtCantidadProductoError_" + arrExplore[1]).show();
                 
                 }
                 
                 });
                 
                 if (boolErrorProducto) {
                 
                 Swal.fire('Alerta', 'Todos los producto deben tener una cantidad mayor a 0', 'error')
                 return false;
                 
                 }
                 
                 if ($("#slcEmpresaEntra").val() == "") {
                 
                 Swal.fire('Alerta', 'Selecciona una empresa destino', 'error')
                 return false;
                 }
                 */


                var formData = new FormData(document.getElementById("frmFactura"));
                $.ajax({
                    url: "<?= base_url ?>facturacion/&setFactura=true",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {

                        if (result["error"]) {

                            md.showCustomNotification('top', 'right', "error", result["error_mensaje"]);

                        } else {
                            location.reload();
                        }

                    },
                    error: function (result) {

                        md.showCustomNotification('top', 'right', "error", "Error");

                    }
                });

            }

        </script>


        <div class="modal-header">
            <h4 class="modal-title font-weight-bold text-gray">
                Factura FEL
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="material-icons">clear</i>
            </button>
        </div>                   
        <div class="modal-body" >
            <!--< ?= base_url . $url ?>-->
            <!--<form method="POST" action="< ?= base_url . $url ?>" id="frmFactura" onsubmit="return false;">-->
            <form method="POST" action="<?= base_url ?>facturacion/save" enctype="multipart/form-data">
                <!--Datos del Comercio-->
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <label><?= isset($_comercio) ? $_comercio->nombre : ''; ?></label>  
                                <input type="hidden" class="form-control" name="id_comercio" value="<?= isset($_comercio) ? $_comercio->id : ''; ?>"/>
                            </div>
                            <div class="col-md-12 text-center">
                                <label><?= isset($_comercio) ? $_comercio->domicilio . ' Zona ' . $_comercio->zona . ', ' . $_comercio->nombreDepartamento . ', ' . $_comercio->nombreMunicipio : ''; ?></label>
                            </div>
                            <div class="col-md-12 text-center">
                                <label>Nit <?= isset($_comercio) ? 'Acá va el Nit' : ''; ?></label>    
                            </div>
                            <div class="col-md-12 text-center">
                                <?php if (isset($_facturaE)) : ?>
                                    <label>Serie: <?= $_facturaE->serie; ?></label>    
                                    <label>No.:  <?= $_facturaE->noFactura; ?></label>  

                                <?php else : ?>
                                    <label>Serie: <?= isset($_comercio) ? '####' : ''; ?></label>  
                                    <input type="hidden" name="txt_serie" id="txt_serie" value="ABCD" />
                                    <label>No.  <?= isset($_comercio) ? '0000' : ''; ?></label>  
                                    <input type="hidden" name="txt_numero" id="txt_numero" value="1234" />
                                    <!--Llave de Autorizacion-->
                                    <input type="hidden" name="txt_autorizacion" id="txt_numero" value="llave111prueba222" />

                                <?php endif; ?>
                            </div>
                        </div>
                        <!--Fin Datos del Comercio-->

                        <?php if (!isset($_facturaD)) : ?>
                            <!--Buscar Cliente-->
                            <div id="divInfoCliente">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">NIT *</label>
                                            <input type="text" class="form-control" name="txt_nit" id="txt_nit" required onchange="buscarCliente();" />
                                        </div>
                                    </div>
                                    <div class="col-md-1" align="center">
                                        <div class="form-group">
                                            <a class="btn btn-success btn-sm btn-link" href="javascript:void(0)" onclick="buscarCliente();">
                                                <span class="material-icons">search</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Nombre Completo de cliente *</label>
                                            <input type="text" class="form-control" name="txt_nombre" id="txt_nombre" required/>

                                            <div id="divAutoResultado" style="position: absolute; background-color: white; z-index: 9999;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Mail</label>
                                            <input type="email" class="form-control" name="txt_mail" id="txt_mail"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Telefono</label>
                                            <input type="text" class="form-control" name="txt_telefono" id="txt_telefono"/>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Domicilio</label>
                                            <input type="text" class="form-control" name="txt_domicilio" id="txt_domicilio"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Fin Buscar Cliente-->

                            <!--Ingresar Detalle a la factura-->
                            <div class="modal-header">
                                <h5 class="modal-title font-weight-bold text-gray">
                                    Detalle de Factura
                                </h5>
                            </div>                  
                            <div class="modal-body">

                                <!--<form method="POST" action="< ?= base_url . $url ?>" id="frmFactura" onsubmit="return false;">-->
                                <div class="row">
                                    <div class="col-lg-12" id="divSumaProducto">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 text-right">
                                        <input type="button" class="btn btn-warning  btn-wd" onclick="fntAddRowProductoModal();" value="+">    
                                    </div>
                                </div>
                                <!--Guardar Informacion-->
<!--                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <input type="button" class="btn btn-fill btn-success" onclick="fntSetFactura();" value="Generar Factura">    
                                    </div>
                                </div>-->
                                <!--</form>-->
                            </div>
                            <!--</div>-->
                            <!--Fin Ingresar Detalle a la factura-->

                        <?php elseif (isset($_facturaD)) : ?>
                            <!--Datos de Cliente-->
                            <div class="row" id="divInformacion">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <a href="#infoComercios" data-toggle="modal" data-target="#infoComercios">
                                            <input type="hidden" name="id_comercio" value="<?= isset($_perfil) ? $_perfil->idComercio : ''; ?>"/>
                                            <label class="bmd-label-floating">Nit </label>
                                            <input type="text" class="form-control" name="txt_nit" value="<?= isset($_facturaE) ? $_facturaE->nitCliente : ''; ?>" disabled/>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Nombre </label>
                                        <input type="text" class="form-control" name="txt_perfil" value="<?= isset($_facturaE) ? $_facturaE->nombreCliente : '' ?>" disabled required />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Telefono</label>
                                        <input type="text" class="form-control" name="txt_telefono" id="txt_telefono"  value="<?= isset($_facturaE) ? $_facturaE->telefono : ''; ?>" disabled required />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Mail </label>
                                        <input type="text" class="form-control" name="txt_email" value="<?= isset($_facturaE) ? $_facturaE->email : '' ?>" disabled required />
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Domicilio </label>
                                        <input type="text" class="form-control" name="txt_perfil" value="<?= isset($_facturaE) ? $_facturaE->domicilioCliente : '' ?>" disable required />
                                    </div>
                                </div>
                            </div>
                            <!--Fin Datos de Cliente-->

                            <!--Detalle de Factura-->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header card-header-primary card-header-icon">
                                            <h4 class="card-title">Detalle de Factura</h4>
                                        </div>
                                        <div class="card-body">

                                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Cantidad</th>
                                                        <th>Descripción</th>
                                                        <th>P. Unitario</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($data = $_facturaD->fetch_object()): ?>
                                                        <tr>
                                                            <td><?= $data->cantidad; ?></td>
                                                            <td><?= $data->descripcion; ?></td>
                                                            <td class="text-right"><?= $data->precioUnidad; ?></td>
                                                            <td class="text-right"><?= $data->total; ?></td>
                                                        </tr>
                                                    <?php endwhile; ?>
                                                </tbody>
                                            </table>
                                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                <tbody class="font-weight-bold">
                                                    <tr>
                                                        <td>SubTotal</td>
                                                        <td class="text-right"><?= $_facturaE->subTotal; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>IVA 12%</td>
                                                        <td class="text-right"><?= $_facturaE->impuesto; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>TOTAL</td>
                                                        <td class="text-right"><?= $_facturaE->montoTotal; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="col-md-12 text-center">
                                                <label>No. de Autorización:
                                                    <br>
                                                    <?= $_facturaE->autorizacion; ?>
                                                    <br>
                                                    <?= $_facturaE->fecha; ?>
                                                    <br>
                                                    Sujeto a pagos trimestrales ISR
                                                </label> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <label>
                                    Certificado por 
                                    <a href="https://www.ima.com.gt" target="_blank" style="color: #4caf50 !important;">IMA</a> &copy;
                                </label> 
                            </div>
                        <?php endif; ?>
                        <!--Fin detalle de Factura-->

                        <?php if (!isset($_facturaD)) : ?>
                            <div class="row">  <!--justify-content-center-->
                                <div class="col-md-12" align="center">
                                    <div class="form-group">
                                        <!--<input type="button" class="btn btn-success btn-wd" onclick="fntSetTraslado();" value="Crear Traslado">--> 
                                        <!--<input type="button" class="btn btn-fill btn-success" onclick="fntSetFactura();" value="Generar Factura">--> 
                                        <button type="submit" class="btn btn-fill btn-success">Generar Factura</button>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </form>

        </div>

        <script>

            $(document).ready(function () {
                $('#opt_estado').selectpicker();
            });

        </script>

        <?php
    }

}
