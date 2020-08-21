<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Dashboard - <?= $this->general_settings['application_name']; ?></title>
  
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/plugins/font-awesome/css/font-awesome.min.css">
  
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/plugins/ionicons/ionicons.min.css">
  
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/plugins/iCheck/flat/blue.css">
  
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/plugins/morris/morris.css">
  
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/plugins/datepicker/datepicker3.css">
  
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/plugins/daterangepicker/daterangepicker-bs3.css">
  
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/admin/plugins/select2/select2.min.css">
  
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/dist/css/adminlte.css">
  
  <!-- custom style -->
  <link rel="stylesheet" href="<?= base_url()?>assets/admin/dist/css/admin-style.css">
  
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <!-- jQuery -->
  <script src="<?= base_url()?>assets/admin/plugins/jquery/jquery.min.js"></script>

</head>
<body class="hold-transition sidebar-mini">

  <!-- Main Wrapper Start -->
  <div class="wrapper">

    <!-- Navbar -->

    <?php if(!isset($navbar)): ?>

      <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= base_url('admin') ?>" class="nav-link">Inicio</a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= base_url('admin/profile') ?>" class="nav-link">Perfil</a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= base_url('admin/change_pwd') ?>" class="nav-link">Cambiar contraseña</a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= base_url('admin/auth/logout') ?>" class="nav-link">Cerrar sesión</a>
          </li>
        </ul>

        <!-- SEARCH FORM -->
        <form class="form-inline ml-3">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Buscar" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fa fa-search"></i>
              </button>
            </div>
          </div>
        </form>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

          <?php 
        // NEW USERS
          $users = get_record('ci_users',array('admin_view' => 0));
          $new_users = count($users);

        // PENDING ADS APROVAL
          $ad = get_record('ci_ads',array('is_status' => 0));
          $new_ads = count($ad);

        // NEW CONTACT FORM
          $contact = get_record('ci_contact_us',array('admin_view' => 0));
          $new_contact = count($contact);

         // TOTAL
          $total =  $new_users + $new_contact + $new_ads;
          ?>

          <!-- Notifications Dropdown Menu -->
          <li class="nav-item dropdown">

            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="fa fa-bell-o"></i>
              <?php if($total > 0) 
              echo '<span class="badge badge-danger navbar-badge">'.$total.'</span>';
              ?>
            </a>

            <div style="min-width: 315px !important;" class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <span class="dropdown-item dropdown-header"><?= $total ?> Notificationes</span>

              <div class="dropdown-divider"></div>
              <a href="<?= base_url('admin/contact') ?>" class="dropdown-item">
                <i class="fa fa-envelope mr-2"></i> <?= $new_contact ?> Contactos nuevos
              </a>

              <div class="dropdown-divider"></div>
              <a href="<?= base_url('admin/users') ?>" class="dropdown-item">
                <i class="fa fa-users mr-2"></i> <?= $new_users ?> Usuarios nuevos
              </a>

              <div class="dropdown-divider"></div>
              <a href="<?= base_url('admin/ads') ?>" class="dropdown-item">
                <i class="fa fa-file mr-2"></i> <?= $new_ads ?> Anuncios pendientes por aprobación
              </a>

            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
              class="fa fa-th-large"></i></a>
            </li>
          </ul>
        </nav>

      <?php endif; ?>

      <!-- /.navbar -->


      <!-- Sideabr -->

      <?php if(!isset($sidebar)): ?>

        <?php $this->load->view('admin/includes/_sidebar'); ?>

      <?php endif; ?>

  <!-- / .Sideabr -->