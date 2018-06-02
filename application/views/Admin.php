

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Panel de administración</h1>
                </div>
                <!-- /.col-lg-12 --> <!-- Header con el título de la sección -->
            </div>
            <!-- /.row --> 
            <div class="row">
                <!-- Cada div col-lg-3 col-md-6 es uno de los botones de cada activo -->
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="glyphicon glyphicon-apple fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <!-- Así mostramos el número de activos existentes en la BD -->
                                    <div class="huge"><?php echo($productos[0]['cantidad'])?></div>
                                    <div>Productos</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo site_url() ?>Gestion/ver_producto">
                            <div class="panel-footer">
                                <span class="pull-left">Ver detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-cutlery fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo($materiales[0]['cantidad'])?></div>
                                    <div>Materiales</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo site_url() ?>Gestion/ver_material">
                            <div class="panel-footer">
                                <span class="pull-left">Ver detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="glyphicon glyphicon-glass fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo($bebidas[0]['cantidad'])?></div>
                                    <div>Bebidas</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo site_url() ?>Gestion/ver_bebida">
                            <div class="panel-footer">
                                <span class="pull-left">Ver detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="glyphicon glyphicon-list-alt fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo($recetas[0]['cantidad'])?></div>
                                    <div>Recetas</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo site_url() ?>Gestion/ver_receta">
                            <div class="panel-footer">
                                <span class="pull-left">Ver detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-purple">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-newspaper-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo($noticias[0]['cantidad'])?></div>
                                    <div>Noticias</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo site_url() ?>Gestion/ver_noticia">
                            <div class="panel-footer">
                                <span class="pull-left">Ver detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-orange">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="glyphicon glyphicon-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo($menus[0]['cantidad'])?></div>
                                    <div>Menús</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo site_url() ?>Gestion/ver_menu">
                            <div class="panel-footer">
                                <span class="pull-left">Ver detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-light_blue">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="glyphicon glyphicon-calendar fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo($eventos[0]['cantidad'])?></div>
                                    <div>Eventos</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo site_url() ?>Gestion/ver_evento">
                            <div class="panel-footer">
                                <span class="pull-left">Ver detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-pink" color="pink">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-group fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo($trabajadores[0]['cantidad'])?></div>
                                    <div>Trabajadores</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo site_url() ?>Gestion/ver_trabajador">
                            <div class="panel-footer">
                                <span class="pull-left">Ver detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

    </div>

</div>

