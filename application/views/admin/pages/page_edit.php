<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="<?= base_url() ?>assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

<section class="content-wrapper">
  <section class="content">
    <div class="card card-default">
      <div class="card-header">
        <div class="d-inline-block">
            <h3 class="card-title"> <i class="fa fa-list"></i>
            &nbsp; Edit Page </h3>
        </div>
        <div class="d-inline-block float-right">
          <a href="<?= base_url('admin/pages'); ?>" class="btn btn-success"><i class="fa fa-list"></i> Page List</a>
        </div>
      </div>

      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <div class="box border-top-solid">
              <!-- /.box-header -->
              <!-- form start -->
              <div class="box-body">
                  <?php echo validation_errors(); ?>           
                  <?php echo form_open(base_url('admin/pages/edit/'.$page['id']), 'class="form-horizontal"');  ?> 
                    <div class="form-group">
                      <label for="name" class="col-sm-3 control-label">Title</label>
                      <div class="col-sm-12">
                        <input type="text" name="title" value="<?= $page['title']; ?>" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="name" class="col-sm-3 control-label">Description (Meta Tag)</label>
                      <div class="col-sm-12">
                        <input type="text" name="description" value="<?= $page['description']; ?>" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="name" class="col-sm-3 control-label">Keywords (Meta Tag)</label>
                      <div class="col-sm-12">
                        <input type="text" name="keywords" value="<?= $page['keywords']; ?>" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="name" class="col-sm-3 control-label">Page Content</label>
                      <div class="col-sm-12">
                        <textarea name="content" class="textarea form-control" rows="10"><?= $page['content']; ?>"</textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="name" class="col-sm-3 control-label">Sort Order</label>
                      <div class="col-sm-12">
                        <input type="number" name="sort_order"  value="<?= $page['sort_order']; ?>" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12">
                        <input type="submit" name="submit" value="Update Page" class="btn btn-primary pull-right">
                      </div>
                    </div>
                  <?php echo form_close( ); ?>
                </div>
                <!-- /.box-body -->
            </div>
          </div>
        </div>  
      </div>

    </div>
  </section> 
</section>

<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url() ?>assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<script>
  $(function () {
    // bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5({
      toolbar: { fa: true }
    })
  })
</script>
<script>
  $("#pages").addClass('active');
</script>