<!-- DataTables -->

<link rel="stylesheet" href="<?= base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap4.css"> 

<!-- bootstrap wysihtml5 - text editor -->

<link rel="stylesheet" href="<?= base_url() ?>assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">



<div class="content-wrapper">

  <section class="content">

    <!-- For Messages -->

    <?php $this->load->view('admin/includes/_messages.php') ?>

    <div class="card card-default">



      <div class="card-header">

        <div class="d-inline-block">

            <h3 class="card-title"> <i class="fa fa-list"></i>

            &nbsp; Lista de suscriptores</h3>

        </div>

        <div class="d-inline-block float-right">

          <button class="btn btn-success" data-toggle="modal" data-target="#subscriberModal"><i class="fa fa-list"></i> &nbsp;Escribir correo</button>

        </div>

      </div>



      <div class="card-body table-responsive">

        <table id="na_datatable" class="table table-bordered table-striped">

          <thead>

            <tr>

              <th><input type="checkbox" class="all-subscribers-checkbox"></th>

              <th>Email</th>

              <th>Fecha</th>

              <th class="width-150p">Acción</th>

            </tr>

          </thead>

        </table>

      </div>

      <!-- /.card-body -->

    </div>

    <!-- /.card -->

  </section>  

</div>  

<!-- Modal -->
<div id="subscriberModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Escribir correo</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <?php echo form_open(base_url('admin/newsletter/'));  ?> 
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="name" class="control-label">Sujeto</label>
                  <input type="text" name="title"  class="form-control" placeholder="Subject">
                  <input type="hidden" name="recepients" class="subscriber-recepients" value="">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="name" class="control-label">Contenido</label>
                  <textarea name="content" class="textarea form-control" rows="10"></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <input type="submit" name="submit" value="Send Email" class="btn btn-primary pull-right">
                &nbsp;&nbsp;
                <input type="button" value="Preview" class="btn btn-warning pull-right mr-1" id="btn_preview_email">
              </div>
            </div>
          </div>
        <?php echo form_close( ); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>

  </div>


<!-- Bootstrap WYSIHTML5 -->

<script src="<?= base_url() ?>assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<!-- DataTables -->

<script src="<?= base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.js"></script>

<script src="<?= base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap4.js"></script>



<script>

  //---------------------------------------------------

  var table = $('#na_datatable').DataTable( {

    "processing": true,

    "serverSide": false,

    "ajax": "<?=base_url('admin/newsletter/subscribers_datatable_json')?>",

    "columnDefs": [

    { "targets": 0, "name": "checkbox", 'searchable':false, 'orderable':false},

    { "targets": 1, "name": "email", 'searchable':true, 'orderable':true},

    { "targets": 2, "name": "created_at", 'searchable':false, 'orderable':false},

    { "targets": 3, "name": "Action", 'searchable':false, 'orderable':false,'width':'150px'}

    ]

  });

</script>

<script>
  $(function () {

    // 
    $('.all-subscribers-checkbox').on('click',function(){
      if($(this).is(':checked'))
      {
        $('.subscriber-checkbox').prop('checked',true);
        $('input[name=recepients]').val('all');
      }
      else
      {
        $('.subscriber-checkbox').prop('checked',false);
        $('input[name=recepients]').val('');
      }
    });

    $(document).on('click','.subscriber-checkbox',function(){
      if($('.subscriber-checkbox:checked').length == $('.subscriber-checkbox').length)
      {
        $('.all-subscribers-checkbox').prop('checked',true);
        $('input[name=recepients]').val('all');
      }
      else
      {
        $('.all-subscribers-checkbox').prop('checked',false);
        var checkedVals = $('.subscriber-checkbox:checkbox:checked').map(function() {
            return this.value;
        }).get();
        $('input[name=recepients]').val(checkedVals.join(","));
      }
    });

    // Preview Email
    $('#btn_preview_email').on('click',function(){
      $.post('<?=base_url("admin/newsletter/email_preview")?>',
      {
        '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
        head : $('input[name=title]').val(),
        content : $('.textarea').val(),
      },
      function(data){
        var w = window.open();
        w.document.open();
        w.document.write(data);
        w.document.close();
      });
    });
  })
</script>

<script>
  // bootstrap WYSIHTML5 - text editor

    $('.textarea').wysihtml5({

      toolbar: { fa: true }

    });
</script>

<script>

$("#newsletter").addClass('active');

</script>



