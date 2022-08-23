<script>
    function notification() {

        var type = $("#txtType").val();
        var message = $("#txtMessage").val();

        md.showCustomNotification('top', 'right', type, message);
    }

    function getComercio() {

        var id_comercio = $('#opt_comercio').val();

        window.location = "<?= base_url ?>usuario/changeComercio&opt_comercio=" + id_comercio;
    }
</script>
<!-- Inputs ocultos que almacenan las variables de sesion de notificacion -->
<input type="hidden" name="txtType" id="txtType" value="<?= $_SESSION['noti_tipo'] ?>" />
<input type="hidden" name="txtMessage" id="txtMessage" value="<?= $_SESSION['noti_mensaje'] ?>" />
<?php if (isset($_SESSION['noti_tipo'])): ?>
    <script>notification();</script>
<?php endif; ?>
<?php
$is_admin = utils::adminCompanies();
$identity = $_SESSION['identity-imfel']
?>
<?php Utils::deleteSession('noti_tipo'); ?>
<?php Utils::deleteSession('noti_mensaje'); ?>
<div class="row">
    <div class="col-md-12 text-center">
        <h1>
            <p class="text-success">
                Tablero
            </p>
        </h1>
    </div>
</div>

<!--aca-->

<?php if ($is_admin): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header card-header-info card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">account_box</i>
                    </div>
                    <h4 class="card-title">Bienvenido nuevamente</h4>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-9">
                            <h5>Usted es un usuario multi empresa, si desea cambiar de empresa administrada por favor, seleccione: </h5>
                        </div>
                        <div class="col-md-3">
                            <select class="selectpicker dropdown" data-style="select-with-transition" name="opt_comercio" id="opt_comercio" onchange="getComercio();">
                                <?php while ($data = $is_admin->fetch_object()):  ?> 
                                    <option value="<?= $data->id ?>" <?= isset($identity) && $data->id == $identity->idComercio ? 'selected' : ''; ?>> <?= $data->nombre ?> </option>
                                                                                         <!--$data->id == $identity->idComercio-->
    <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header card-header-info card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">account_box</i>
                    </div>
                    <h4 class="card-title">Bienvenido nuevamente</h4>
                </div>
                <div class="card-body ">
                    <div class="row">

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
  

