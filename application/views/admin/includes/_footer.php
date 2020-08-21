<?php if(!isset($footer)): ?>

  <footer class="main-footer">
  </footer>

  <?php endif; ?>  

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  
</div>
<!-- ./wrapper -->


<script src="<?= base_url() ?>assets/admin/plugins/jQueryUI/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);  
</script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
 <!-- bootstrap datepicker -->
<script src="<?= base_url() ?>assets/admin/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Select2 -->
<script src="<?= base_url() ?>assets/admin/plugins/select2/select2.full.min.js"></script>

<script>
  $('.datepicker').datepicker({
      autoclose: true
  });

  $('.select2').select2();
</script>
<!-- Slimscroll -->
<script src="<?= base_url() ?>assets/admin/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?= base_url() ?>assets/admin/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>assets/admin/dist/js/adminlte.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="<?= base_url() ?>assets/admin/dist/js/demo.js"></script>

<!-- Notify JS -->
<script src="<?= base_url() ?>assets/admin/plugins/notify/notify.min.js"></script>

<?php $this->load->view('admin/includes/_js_footer'); ?>

</body>
</html>
