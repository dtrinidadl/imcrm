<div class="container-fluid text-center">
    <div class="row">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="page-categories">
                <ul class="p-0 nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
                    <li class="p-0 m-0 nav-item">
                        <a class="p-2 m-1 nav-link <?= $report_type == 1 ? 'active show' : '' ?>" data-toggle="tab" href="#link7" role="tablist">
                            <i class="p-0 material-icons">ballot</i>REPORTE
                        </a>
                    </li>
                    <li class="p-0 m-0 nav-item">
                        <a class="p-2 m-1 nav-link <?= $report_type == 2 ? 'active show' : '' ?>" data-toggle="tab" href="#link8" role="tablist">
                            <i class="p-0 material-icons">timer</i>TIEMPOS
                        </a>
                    </li>
                    <li class="p-0 m-0 nav-item">
                        <a class="p-2 m-1 nav-link <?= $report_type == 3 ? 'active show' : '' ?>" data-toggle="tab" href="#link9" role="tablist">
                            <i class="p-0 material-icons">event</i>FECHAS
                        </a>
                    </li>
                </ul>
                <div class="p-0 m-0 tab-content tab-space tab-subcategories">
                    <!-- REPORTE #1 -->
                    <div class="p-0 tab-pane <?= $report_type == 1 ? 'active show' : '' ?>" id="link7">
                        <div class="card pt-1 mt-1">
                            <div class="card-header p-0 m-0">
                                <h4 class="card-title p-0 m-0 text-dark">Parametros</h4>
                                <p class="card-category p-0 m-0 text-warning"> Reporte que muestra un resumen completo de los soportes en un rango de fecha.</p>
                            </div>
                            <div class="card-body pt-0 mt-0">
                                <form method="POST" action="<?= base_url ?>report/index" enctype="multipart/form-data" id="userForm">
                                    <input type="hidden" name="report_type" value="1">
                                    <div class="row justify-content-center">
                                        <div class="col-6 col-sm-4 col-md-3">
                                            <label class="p-0 m-0">Fecha de Inicio</label>
                                            <div class="p-0 m-0 form-group bmd-form-group is-filled">
                                                <input type="date" class="form-control datepicker" name="start_date" value="<?= $start_date ?>" max="<?= $start_date ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-3">
                                            <label class="p-0 m-0">Fecha de Final</label>
                                            <div class="p-0 m-0 form-group bmd-form-group is-filled">
                                                <input type="date" class="form-control datepicker" name="final_date" value="<?= $final_date ?>" max="<?= $final_date ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4 col-md-3" align="center">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-fill btn-success">Consultar</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- REPORTE #2 -->
                    <div class="p-0 tab-pane <?= $report_type === 2 ? 'active show' : '' ?>" id="link8">
                        <div class="card pt-1 mt-1">
                            <div class="card-header p-0 m-0">
                                <h4 class="card-title p-0 m-0 text-dark">Parametros</h4>
                                <p class="card-category p-0 m-0 text-warning"> Reporte que ayuda a visualizar las fechas en que cambiaron de estado.</p>
                            </div>
                            <div class="card-body pt-0 mt-0">
                                <form method="POST" action="<?= base_url ?>report/index" enctype="multipart/form-data" id="userForm">
                                <input type="hidden" name="report_type" value="2">
                                    <div class="row justify-content-center">
                                        <div class="col-6 col-sm-4 col-md-3">                                            
                                            <label class="p-0 m-0">Fecha de Inicio</label>
                                            <div class="p-0 m-0 form-group bmd-form-group is-filled">
                                                <input type="date" class="form-control datepicker" name="start_date" value="<?= $start_date ?>" max="<?= $start_date ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-3">
                                            <label class="p-0 m-0">Fecha de Final</label>
                                            <div class="p-0 m-0 form-group bmd-form-group is-filled">
                                                <input type="date" class="form-control datepicker" name="final_date" value="<?= $final_date ?>" max="<?= $final_date ?>" required>
                                            </div>
                                        </div>                                        
                                        <div class="col-6 col-sm-4 col-md-3" align="center">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-fill btn-success">Consultar</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- REPORTE #3 -->
                    <div class="p-0 tab-pane <?= $report_type == 3 ? 'active show' : '' ?>" id="link9">
                        <div class="card pt-1 mt-1">
                            <div class="card-header p-0 m-0">
                                <h4 class="card-title p-0 m-0 text-dark">Parametros</h4>
                                <p class="card-category p-0 m-0 text-warning"> Reporte que ayuda a visualizar los días transcurridos en cada estado.</p>
                            </div>
                            <div class="card-body pt-0 mt-0">
                                <form method="POST" action="<?= base_url ?>report/index" enctype="multipart/form-data" id="userForm">
                                    <input type="hidden" name="report_type" value="3">
                                    <div class="row justify-content-center">
                                        <div class="col-6 col-sm-4 col-md-3">
                                            <label class="p-0 m-0">Fecha de Inicio</label>
                                            <div class="p-0 m-0 form-group bmd-form-group is-filled">
                                                <input type="date" class="form-control datepicker" name="start_date" value="<?= $start_date ?>" max="<?= $start_date ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-3">
                                            <label class="p-0 m-0">Fecha de Final</label>
                                            <div class="p-0 m-0 form-group bmd-form-group is-filled">
                                                <input type="date" class="form-control datepicker" name="final_date" value="<?= $final_date ?>" max="<?= $final_date ?>" required>
                                            </div>
                                        </div>                                        
                                        <div class="col-6 col-sm-4 col-md-3" align="center">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-fill btn-success">Consultar</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>