  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Inicio</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $active_users; ?></h3>

                <p>Usuarios activos</p>
              </div>
              <div class="icon">
                <i class="fa fa-user"></i>
              </div>
              <a href="<?= base_url('admin/users') ?>" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $deactive_users; ?></h3>

                <p>Usuarios inactivos</p>
              </div>
              <div class="icon">
                <i class="fa fa-user"></i>
              </div>
              <a href="<?= base_url('admin/users') ?>" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?= $active_ads ?></h3>
                <p>Anuncios activos</p>
              </div>
              <div class="icon">
                <i class="fa fa-list-alt"></i>
              </div>
              <a href="<?= base_url('admin/ads') ?>" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= $pending_ads; ?></h3>

                <p>Anuncios pendientes</p>
              </div>
              <div class="icon">
                <i class="fa fa-list-alt"></i>
              </div>
              <a href="<?= base_url('admin/ads') ?>" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-6 connectedSortable">
            <!-- DIRECT CHAT -->
            <div class="card direct-chat direct-chat-primary">
              <div class="card-header">

                <h3 class="card-title"><i class="ion ion-clipboard mr-1"></i> Últimos anuncios</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 <!-- ads -->
                 <table class="table table-striped">
                   <thead>
                     <tr>
                       <th>Título</th>
                       <th>Tipo</th>
                       <th>Estado</th>
                     </tr>
                   </thead>
                   <tbody>

                    <?php foreach($ads as $ad): ?>
                     <tr>
                       <td><?= $ad['title'] ?></td>
                       <td><small class="badge badge-primary"><?= (empty(get_featured_label($ad['is_featured']))) ? 'Free' : get_featured_label($ad['is_featured']); ?></small></td>
                       <td><small class="badge badge-success"><?= get_ad_status($ad['is_status']) ?></small></td>
                     </tr>
                   <?php endforeach; ?>

                   </tbody>
                 </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <a href="<?= base_url('admin/ads') ?>" class="pull-right">Ver todo</a>
              </div>
              <!-- /.card-footer-->
            </div>
            <!--/.direct-chat -->
          </section>
          <!-- /.Left col -->

          <!-- Left col -->
          <section class="col-lg-6 connectedSortable">
            <!-- DIRECT CHAT -->
            <div class="card direct-chat direct-chat-primary">
              <div class="card-header">

                <h3 class="card-title"><i class="ion ion-clipboard mr-1"></i> Últimos usuarios registrados</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 <!-- ads -->
                 <table class="table table-striped">
                   <thead>
                     <tr>
                       <th>Usuario</th>
                       <th>Email</th>
                       <th>Desde</th>
                     </tr>
                   </thead>
                   <tbody>

                    <?php foreach($users as $user): ?>
                     <tr>
                       <td><?= $user['username'] ?></td>
                       <td><?= $user['email'] ?></td>
                       <td><?= date_time($user['created_date']) ?></td>
                     </tr>
                   <?php endforeach; ?>

                   </tbody>
                 </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <a href="<?= base_url('admin/users') ?>" class="pull-right">Ver todo</a>
              </div>
              <!-- /.card-footer-->
            </div>
            <!--/.direct-chat -->
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->