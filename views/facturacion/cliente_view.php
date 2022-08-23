<?php

class cliente_view {

    public function drawInfoCliente($cliente, $nitBuscado) {

        //print 'llega'; die();
        if (isset($cliente)) {
            $telefono = $cliente->telefono;
            $telefono = explode(" ", $telefono);
        }
        ?>

        <script>
            $(document).ready(function () {
                $('#txt_telefono').mask('0000-0000');
            });
        </script>
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <input type="hidden" name="id_cliente" value="<?= $cliente->id; ?>">
                    <label class="bmd-label-floating">Nit *</label>
                    <input type="text" class="form-control" name="txt_nit" id="txt_nit" value="<?= $nitBuscado; ?>"  required/>
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
                    <label class="bmd-label-floating">Nombres Completo de cliente *</label>
                    <input type="text" class="form-control" name="txt_nombre" id="txt_nombre" value="<?= isset($cliente) ? $cliente->nombre : ''; ?>"  required/>
                    <div id="divAutoResultado" style="position: absolute; background-color: white; z-index: 9999;"></div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="bmd-label-floating">Mail</label>
                    <input type="text" class="form-control" name="txt_mail" id="txt_mail" value="<?= isset($cliente) ? $cliente->email : ''; ?>"/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="bmd-label-floating">Telefono</label>
                    <input type="text" class="form-control" name="txt_telefono" id="txt_telefono"  value="<?= isset($cliente) ? $cliente->telefono : ''; ?>"/>
                    <!--onchange="subtotal();-->
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="bmd-label-floating">Domicilio</label>
                    <input type="text" class="form-control" name="txt_domicilio" id="txt_domicilio" value="<?= isset($cliente) ? $cliente->domicilio : ''; ?>"/>
                </div>
            </div>
        </div>

        <?php
    }

}
