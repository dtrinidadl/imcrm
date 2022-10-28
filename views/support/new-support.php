<div class="row">
    <div class="col-md-12">
        <form method="POST" action="<?= base_url . 'support/save' ?>" enctype="multipart/form-data" id="supportForm">
            <div class="card ">
                <div class="card-header card-header-success card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">menu_book</i>
                    </div>
                    <h4 class="card-title">Ticket</h4>
                </div>
                <br />
                <div class="card-body ">
                    <div class="row" id="divInformacion">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <select class="selectpicker" data-style="select-with-transition" name="opt_supportProjectCode" id="opt_supportProjectCode" required>
                                    <option disabled selected>Proyecto</option>
                                    <?php while ($data = $project_list->fetch_object()) : ?>
                                        <option value="<?= $data->userProjectProjectCode; ?>">
                                            <?= $data->projectName; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <select class="selectpicker" data-style="select-with-transition" title="Tipo" name="opt_supportType" id="opt_supportType" required>
                                    <option disabled selected>Tipo</option>
                                    <option value=1>Nueva Implementación</option>
                                    <option value=2>Mejora</option>
                                    <option value=3>Error</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <select class="selectpicker" data-style="select-with-transition" title="Prioridad" name="opt_supportPriority" id="opt_supportPriority" required>
                                    <option disabled selected>Prioridad</option>
                                    <option value=1>Alta</option>
                                    <option value=2>Media</option>
                                    <option value=3>Baja</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="bmd-label-floating">Titulo</label>
                                <input type="text" class="form-control" name="txt_supportTitle" id="txt_supportTitle" minlength="8" maxlength="149" required />
                            </div>
                        </div>
                        <div class=" col-12">
                            <label class="bmd-label-floating">Descripción</label>
                            <textarea name="ckeditor" id="ckeditor" class="ckeditor" placeholder="Descripción"></textarea>
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
                                <button type="submit" class="btn btn-fill btn-success">Crear ticket</button>
                            </div>
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
                    notification('success', 'Archivo cargado exitosamente!');
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
                    notification('danger', 'Error al cargar el archivo!');
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
                notification('success', result.message);
            } else {
                notification('danger', result.message);
            }
        }).fail(function(error) {
            console.log(error);
        });
    }

    // Notificacion
    function notification(type, message) {
        md.showCustomNotification('top', 'center', type, message);
    }
</script>