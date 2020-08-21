<div class="content-wrapper">
  <section class="content">
    <!-- For Messages -->
    <?php $this->load->view('admin/includes/_messages.php') ?>
    <div class="card card-default">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title"> <i class="fa fa-list"></i>&nbsp; Estados </h3>
        </div>
        <div class="d-inline-block pull-right">
          <a href="<?= base_url('admin/misc/state/add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Agregar nuevo estado</a>
        </div>
      </div>
      <div class="card-body table-responsive">
        <?php echo form_open(base_url('admin/misc/state/edit/'.$state['id']), 'class="form-horizontal"');  ?> 
          <div class="form-group">
            <label for="name" class="col-sm-3 control-label">País</label>
            <div class="col-sm-12">
              <select class="form-control select2" required name="country">
               <option value="">Seleccione un país</option>
                <?php foreach($countries as $country):?>
                  <?php if($state['country_id'] == $country['id']): ?>
                  <option value="<?= $country['id']; ?>" selected> <?= $country['name']; ?> </option>
                <?php else: ?>
                  <option value="<?= $country['id']; ?>"> <?= $country['name']; ?> </option>
              <?php endif; endforeach; ?>
            </select>
            </div>
          </div>
          <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Nombre del estado</label>
            <div class="col-sm-12">
              <input type="text" name="state" class="form-control" value="<?= $state['name']; ?>" id="name" placeholder="Nombre del estado" required>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
              <input type="submit" name="submit" value="Actualizar estado" class="btn btn-primary pull-right">
            </div>
          </div>
        <?php echo form_close( ); ?>
      </div>
   
  </section> 
</div>

<script>
  $("#country").addClass('active');
  </script>