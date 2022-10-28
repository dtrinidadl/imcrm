<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <b>Ticket No.: </b><?= $support_head->supportIdentifier ?>.&nbsp;
                    <b>Tipo: </b>

                    <?php if ($userProjectRol == 2 && $support_head->supportStatus != 5) : ?>
                        <select class="select-support" name="opt_supportType" id="opt_supportType">
                            <option value=1 <?= $support_head->supportType == 1 ? 'selected' : ''; ?>>Nueva Implementación</option>
                            <option value=2 <?= $support_head->supportType == 2 ? 'selected' : ''; ?>>Mejora</option>
                            <option value=3 <?= $support_head->supportType == 3 ? 'selected' : ''; ?>>Error</option>
                        </select>
                        &nbsp;
                    <?php else : ?>
                        <span class="select-support"><?= $support_head->supportTypeName ?></span>
                    <?php endif; ?>

                    <b>Estado: </b>
                    <?php if ($userProjectRol == 2 && $support_head->supportStatus != 5) : ?>
                        <select class="select-support" name="opt_supportStatus" id="opt_supportStatus">
                            <option disabled <?= $support_head->supportStatus == 1 ? 'selected' : ''; ?>>Creado</option>
                            <option value=2 <?= $support_head->supportStatus == 2 ? 'selected' : ''; ?>>Analisis</option>
                            <option value=3 <?= $support_head->supportStatus == 3 ? 'selected' : ''; ?>>Desarrollo</option>
                            <option value=4 <?= $support_head->supportStatus == 4 ? 'selected' : ''; ?>>QA</option>
                            <option value=5 <?= $support_head->supportStatus == 5 ? 'selected' : ''; ?>>Finalizado</option>
                        </select>
                        &nbsp;
                    <?php else : ?>
                        <span class="select-support"><?= $support_head->supportStatusName ?></span>
                    <?php endif; ?>

                    <b>Prioridad: </b><?= $supportPriorityName ?>
                    <br>
                    <b>Proyecto: </b><?= $support_head->projectName ?>.

                    <div id="accordion" role="tablist">
                        <!-- Head -->
                        <div class="card-collapse">
                            <div class="card-header" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed text-success">
                                        <?= isset($support_head) ? $support_head->supportCreatedDate : '' ?>
                                        <?= $support_head->supportUserCode == $identityUserCode ? ' | Tu: ' : " | $support_head->userName: " ?><?= $support_head->supportTitle ?>
                                        <i class="material-icons">keyboard_arrow_down</i>
                                    </a>
                                </h5>
                            </div>
                            <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                    <?= isset($support_head) ? $support_head->supportDescription : '' ?>
                                    <div class="row">
                                        <?php foreach ($document as $value) : ?>
                                            <?php if (empty($value['documentSupportDetailCode'])) : ?>
                                                <div class='col-auto'>
                                                <a class="btn-download" href="<?= base_url ?><?= $value['documentLocation'] ?>"  download="<?=$value['documentOriginName']?>" ><i class="fa fa-download"></i> <?= $value['documentOriginName'] ?>.<?= $value['documentExtension'] ?></a>
                                                </div>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hilo de comentarios -->
                        <?php while ($data = $support_detail->fetch_assoc()) : ?>
                            <div class="card-collapse">
                                <div class="card-header" role="tab" id="heading">
                                    <h5 class="mb-0">
                                        <a class="collapsed text-<?= $data['supportDetailUserCode'] == $identityUserCode ? 'success' : 'gray' ?>" data-toggle="collapse" aria-expanded="false" aria-controls="collapse" href="#collapse_<?= $data['supportDetailCode'] ?>">
                                            <?= $data['supportDetailCreatedDate'] ?>
                                            <?= $data['supportDetailUserCode'] == $identityUserCode ? ' | Tu. ' : ' | ' . $data['userName'] . '. ' ?>
                                            <i class="material-icons">keyboard_arrow_down</i>
                                        </a>
                                    </h5>
                                </div>
                                <div class="collapse" role="tabpanel" aria-labelledby="heading" data-parent="#accordion" id="collapse_<?= $data['supportDetailCode'] ?>">
                                    <div class="card-body" style="width: 90% auto;">
                                        <?= $data['supportDetailDescription'] ?>
                                        <div class="row">
                                            <?php
                                            foreach ($document as $value) :
                                                if (!empty($value['documentSupportDetailCode']) && $value['documentSupportDetailCode'] == $data['supportDetailCode']) : ?>
                                                    <div class='col-auto p-1'>
                                                        <a class="btn-download" href="<?= base_url ?><?= $value['documentLocation'] ?>"  download="<?=$value['documentOriginName']?>" ><i class="fa fa-download"></i> <?= $value['documentOriginName'] ?>.<?= $value['documentExtension'] ?></a>
                                                    </div>
                                            <?php endif;
                                            endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
            </div>
        </div>
    </div>
    <!-- Nuevo comentario -->
    <?php if ($support_head->supportStatus != 5) : ?>
        <div class="col-12 text-right div-float">
            <a class="btn-float" href="<?= base_url ?>support/comment">
                <span class=" btn-round btn-twitter">
                    <i class="material-icons md-36">add_circle</i>
                </span>
                <b class="text-float">Comentario</b>
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Cambiar tipo/estado de un soporte -->
<script type="text/javascript">
    $(function() {
        $("#opt_supportType").on('change', function() {
            const supportType = $("#opt_supportType").val();
            const supportTypeName = $('#opt_supportType option[value="' + supportType + '"]').text();

            const settings = {
                "url": "<?= base_url ?>support/&changeType=true&supportCode=<?= $supportCode ?>&supportProjectCode=<?= $support_head->supportProjectCode ?>&supportUserCode=<?= $support_head->supportUserCode ?>&supportType=" + parseFloat(supportType),
                "method": "GET",
                "headers": {
                    "Content-Type": "application/json"
                }
            };

            $.ajax(settings).done(function(response) {
                if (response) {
                    notification('success', 'El tipo de soporte cambio a ' + supportTypeName);
                } else {
                    notification('danger', '¡Error al actualizar campo a ' + supportTypeName + '!');
                }
            }).fail(function(error) {
                notification(2, 'Error!');
                console.log(error);
            });
        })
    });
</script>

<script type="text/javascript">
    $(function() {
        $("#opt_supportStatus").on('change', function() {
            const supportStatus = $("#opt_supportStatus").val();
            const supportStatusName = $('#opt_supportStatus option[value="' + supportStatus + '"]').text();

            const settings = {
                // "url": "<?= base_url ?>support/&changeStatus=true&supportCode=<?= $supportCode ?>&supportStatus=" + parseFloat(supportStatus),
                "url": "<?= base_url ?>support/&changeStatus=true&supportCode=<?= $supportCode ?>&supportProjectCode=<?= $support_head->supportProjectCode ?>&supportUserCode=<?= $support_head->supportUserCode ?>&supportStatus=" + parseFloat(supportStatus),
                "method": "GET",
                "headers": {
                    "Content-Type": "application/json"
                }
            };

            $.ajax(settings).done(function(response) {
                if (response) {
                    notification('success', 'El estado de soporte cambio a ' + supportStatusName);
                    // Dirigir al index cuando finaliza un ticket
                    (parseFloat(supportStatus) == 5) && (setTimeout("window.location.href = '<?= base_url ?>support/index'", 2000));
                } else {
                    notification('danger', '¡Error al actualizar campo a ' + supportStatusName + '!');
                }
            }).fail(function(error) {
                notification(2, 'Error!');
                console.log(error);
            });
        })
    });
</script>

<script>
    function notification(type, message) {
        md.showCustomNotification('top', 'center', type, message);
    }
</script>