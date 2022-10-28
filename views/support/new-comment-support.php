<script>
    function notification() {
        const type = $("#txt_type").val();
        const message = $("#txt_message").val();
        md.showCustomNotification('top', 'center', type, message);
    }
</script>
<!-- Variable de notificacion -->
<input type="hidden" name="txt_type" id="txt_type" value="<?= $_SESSION['type-imSupport'] ?>" />
<input type="hidden" name="txt_tessage" id="txt_message" value="<?= $_SESSION['message-imSupport'] ?>" />

<?php if (isset($_SESSION['type-imSupport'])) : ?>
    <script>
        notification();
    </script>
<?php endif; ?>
<?php
Utils::deleteSession('type-imSupport');
Utils::deleteSession('message-imSupport');
$url = isset($_userProject) ? 'userProject/update' : 'userProject/save';
?>

<div class="row">
    <div class="col-md-12">
        <form method="POST" action="<?= base_url . 'support/saveComment' ?>" enctype="multipart/form-data" id="supportForm">
            <div class="card ">
                <div class="card-header card-header-success card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">menu_book</i>
                    </div>
                    <h4 class="card-title">Nuevo comentario</h4>
                </div>
                <br />
                <div class="card-body ">
                    <div class="row" id="divInformacion">
                        <div class=" col-12">
                            <label class="bmd-label-floating">Comentario</label>
                            <input type="hidden" name="txt_supportCode" id="txt_supportCode" value="<?= $supportCode ?>" />
                            <textarea name="ckeditor" id="ckeditor" class="ckeditor" placeholder="Descripción"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="row" name="contenido_doc" id="contenido_doc">
                            <div class="col-sm-6 col-md-3 col-lg-2">
                                <div class="card-file">
                                    <span class="btn btn-info btn-round btn-file">
                                        <i class="fa fa-upload"></i>
                                        <span class="fileinput-new">Cargar</span>
                                        <input type="file" name="upload" id="upload">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12" align="center">
                        <div class="form-group">
                            <button type="submit" class="btn btn-fill btn-success">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Subir archivo
    $(function() {
        $("#upload").on('change', function() {
            const files = $('#upload')[0].files[0];
            const formData = new FormData();
            formData.append('file', files);

            const settings = {
                url: "<?= base_url ?>support/&upload=true",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
            };

            $.ajax(settings).done(function(response) {
                const result = JSON.parse(response);
                if (result.documentCode && result.error == 0) {
                    notificationDoc('success', 'Archivo cargado exitosamente!');
                    const html = `<div class='col-sm-6 col-md-4 col-lg-2' id='document_${result.documentCode}'>
                                    <div class="card">
                                            <div class="card-body">
                                            <input type='hidden' name='doc_${result.documentCode}' id='doc_${result.documentCode}' value='${result.documentCode}'/>
                                            <i class="fa ${result.icon}"></i> ${result.name}... 
                                            <a href="#" style='float: right;' onclick="remove(${result.documentCode})"><i class="fa fa-times"></i></a>
                                        </div>
                                    </div>
                                </div>`;
                    $("#contenido_doc").append(html);
                } else {
                    notificationDoc('danger', result.message);                    
                }
            }).fail(function(error) {
                console.log(error);
            });
        })
    })

    // Eliminar archivo
    function remove(documentCode) {
        const settings = {
            url: "<?= base_url ?>support/&remove=true&documentCode=" + documentCode,
            method: "GET",
        };

        $.ajax(settings).done(function(response) {
            const result = JSON.parse(response);
            if (result.error == 0) {
                $("#document_" + documentCode).remove();
                notificationDoc('success', result.message);
            } else {
                notificationDoc('danger', result.message);
            }
        }).fail(function(error) {
            console.log(error);
        });
    }

    // Notificacion
    function notificationDoc(type, message) {
        md.showCustomNotification('top', 'center', type, message);
    }
</script>