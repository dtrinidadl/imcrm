<script>
    function notification() {
        var type = $("#txtType").val();
        var message = $("#txtMessage").val();
        md.showCustomNotification('top', 'right', type, message);
    }
</script>
<!-- Inputs ocultos que almacenan las variables de sesion de notificacion -->
<input type="hidden" name="txtType" id="txtType" value="<?= $_SESSION['noti_tipo'] ?>" />
<input type="hidden" name="txtMessage" id="txtMessage" value="<?= $_SESSION['noti_mensaje'] ?>" />
<?php if (isset($_SESSION['noti_tipo'])) : ?>
    <script>
        notification();
    </script>
<?php endif; ?>
<?php
$identity = $_SESSION['identity-imsupport']
?>
<?php Utils::deleteSession('noti_tipo'); ?>
<?php Utils::deleteSession('noti_mensaje'); ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">account_box</i>
                </div>
                <h4 class="card-title">Bienvenido nuevamente <?= $identity->userName ?></h4>
                <label>Notificaciones pendientes de leer:</label>
            </div>
            <div class="card-body" id="notificationHome" name="notificationHome">
            </div>
        </div>
    </div>
</div>