<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Panel de administración</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url() ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url() ?>assets/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url() ?>assets/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href=".<?php echo base_url() ?>assets/vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url() ?>assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- DataTables CSS -->
    <link href="<?php echo base_url() ?>assets/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="<?php echo base_url() ?>assets/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url() ?>Gestion">Panel de gestión</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right col-xs-offset-9">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?= base_url() ?>Gestion/Perfil"><i class="fa fa-user fa-fw"></i> Perfil de usuario</a></li>
                        <li class="divider"></li>
                        <li><a href="<?= base_url() ?>Gestion/Desconectarse"><i class="fa fa-sign-out fa-fw"></i> Desconectarse</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="<?php echo base_url() ?>Gestion"><i class="fa fa-dashboard fa-fw"></i> Panel de administración</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>Gestion/ver_producto"><i class="glyphicon glyphicon-apple fa-fw"></i> Productos</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>Gestion/ver_material"><i class="fa fa-cutlery fa-fw"></i> Materiales</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>Gestion/ver_bebida"><i class="glyphicon glyphicon-glass fa-fw"></i> Bebidas</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>Gestion/ver_receta"><i class="glyphicon glyphicon-list-alt fa-fw"></i> Recetas</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>Gestion/ver_noticia"><i class="fa fa-newspaper-o fa-fw"></i> Noticias</a>
                        </li>
                        <li>
                            <a href="#"><i class="glyphicon glyphicon-list fa-fw"></i> Menús<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url() ?>Gestion/ver_menu"><i class="glyphicon glyphicon-list fa-fw"></i> Menús</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url() ?>Gestion/ver_tipomenu"><i class="glyphicon glyphicon-th fa-fw"></i> Tipos de menú</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>Gestion/ver_evento"><i class="glyphicon glyphicon-calendar fa-fw"></i> Eventos</a>
                        </li>
                        <li>
                            <a href="#"><i class="glyphicon glyphicon-list fa-fw"></i> Trabajadores<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url() ?>Gestion/ver_trabajador"><i class="glyphicon glyphicon-list fa-fw"></i> Trabajadores</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url() ?>Gestion/ver_tipotrabajador"><i class="glyphicon glyphicon-th fa-fw"></i> Roles</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>