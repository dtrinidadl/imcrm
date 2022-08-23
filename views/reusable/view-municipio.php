<?php

class viewMunicipio {

    public function drawMunicipios($lista_municipios) {
        ?>
        <div class="form-group">
            <select class="selectpicker" name="opt_municipio" id="opt_municipio" data-style="select-with-transition" title="Municipio" >
                <?php while ($row1 = $lista_municipios->fetch_object()): ?>
                    <option value="<?= $row1->codMunicipio; ?>" > <?= $row1->nombre; ?> </option>
                <?php endwhile; ?>
            </select>
        </div>
        <script>
            $("#opt_municipio").selectpicker();
        </script>
        <?php
    }

}
