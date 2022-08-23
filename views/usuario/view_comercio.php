<?php

class view_comercio {
   
    public function drawListaComercio($lista_comercios) {
        
        ?>
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
                        <?php while ($data = $lista_comercios->fetch_object()): ?>
                            <tr>
                                <td><a href="javascript:void(0)" onclick="agregarComercio(<?= $data->id; ?>, '<?= $data->nombre; ?>');"><?= $data->id; ?></a></td>
                                <td><?= $data->nombre; ?></td>
                                <td><?= $data->representante; ?></td>
                                <td><?= utils::getEstadoAIById($data->idEstado); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <!-- end content-->
        </div>

        <script>

            function agregarComercio(id, nombre) {
                
                /*
                $("#id_comercio").val(id);
                $("#nombreComercio").val(nombre);
                $('#infoComercio').modal('hide');
                return false;
                */
                var id = id;
                var nombre = nombre;

                //                console.log(codigo + ' ' + nombre);

                $.ajax({
                    url: "<?= base_url ?>usuario/&getAddArray=true&key=2&id=" + id + "&nombreComercio=" + nombre,
                    //url: "<?= base_url ?>usuario/&getAddArray=true&key=2&id=" + id + "&nombreComercio=" + nombre,
                    success: function (result) {
                        
                        //$("#id_comercio").val(id);
                        //$("#txt_nombreComercio").val(nombre);
                        $("#divInformacion").html(result);
                        
                    }
                });

                $('#infoComercio').modal('hide');

            }
        </script>

        <?php
    }

    public function drawComercioByCodigo($id, $nombre) {
        ?>
        <div class="col-md-5">
            <div class="form-group">
                <input type="hidden" name="id_comercio" value="<?= $id; ?>"/>
                <label class="bmd-label-floating">Empresa</label>
                <input type="text" class="form-control" id="txt_nombreComercio" value="<?= $nombre; ?>"/>
            </div>
        </div>
        <div class="col-md-1" style="margin-top: 2%;">
            <a href="#infoComercio"  data-toggle="modal" data-target="#infoComercio">
                <span class="material-icons success">search</span>
            </a>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="bmd-label-floating">Nombre</label>
                <input type="text" class="form-control" name="txt_nombre" />
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="bmd-label-floating">Usuario</label>
                <input type="text" class="form-control" name="txt_usuario" />
            </div>
        </div>
        <?php
    }

}
