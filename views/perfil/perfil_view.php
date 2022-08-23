<?php

class perfil_view {

    public function drawContenidoModalPerfil($id_perfil, $_perfil, $lista_estados, $url) {
        ?>
        <div class="modal-header">
            <h4 class="modal-title">
                <?php
                print $_perfil ? "Editar Perfil" : "Nuevo Perfil";
                ?>
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="material-icons">clear</i>
            </button>
        </div>                   
        <div class="modal-body" >

            <form method="POST" action="<?= base_url . $url ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12">
                        <div class="row" id="divInformacion">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <a href="#infoComercios" data-toggle="modal" data-target="#infoComercios">
                                        <input type="hidden" name="id_comercio" value="<?= isset($_perfil) ? $_perfil->idComercio : ''; ?>"/>
                                        <label class="bmd-label-floating">Comercio </label>
                                        <input type="text" class="form-control" name="txt_nombreEmpresa" value="<?= isset($_perfil) ? utils::getComercioById($_perfil->idComercio) : ''; ?>"/>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-1" style="margin-top: 2%;">
                                <a href="#infoComercios" data-toggle="modal" data-target="#infoComercios">
                                    <span class="material-icons">search</span>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Nombre Perfil</label>
                                    <input type="text" class="form-control" name="txt_perfil" value="<?= isset($_perfil) ? $_perfil->nombre : '' ?>" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="togglebutton">
                                        <label>
                                            <input type="checkbox" <?php print isset($_perfil) && $_perfil->predeterminado == "on" ? "checked" : ""  ?> id="chkPredeterminado" name="chkPredeterminado">
                                            <span class="toggle"></span>Predeterminado
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <select class="selectpicker" data-style="select-with-transition" name="opt_estado" id="opt_estado">
                                    <?php while ($data = $lista_estados->fetch_object()): ?>
                                        <option value="<?= $data->id ?>" <?= isset($_perfil) && $data->id == $_perfil->estado ? 'selected' : '' ?>> <?= $data->nombre ?> </option>
                                    <?php endwhile; ?>
                                </select>

                            </div>         
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-fill btn-warning">Guardar Información</button>
                                </div>
                            </div>
                        </div>
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
