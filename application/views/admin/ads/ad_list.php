<div class="adv-table table-responsive">

  <table id="example1" class="table table-bordered table-hover">

    <thead>

      <tr>

        <th>#</th>

        <th>Título</th>

        <th>Vendedor</th>

        <th>Categorías</th>

        <th>Subcategorías</th>

        <th>Precio</th>

        <th>Estado</th>

        <?php           
        $payment = $this->setting_model->get_stripe_settings();
        $statusPayment = $payment['stripe_status'];

        if ($statusPayment == "1") { ?>
          <th>Pago</th>

        <?php } ?>

        <th width="100" class="text-right">Acción</th>

      </tr>

    </thead>

    <tbody>

      <?php $counter = 1;
      foreach($ads as $record): 

        $status = ($record['is_status'] == 1)? 'checked': '';

        ?>

        <tr>

          <td><?= $counter; ?></td>

          <td><?= $record['title']; ?></td>

          <td><?php $email = $this->ad_model->get_user_by_id($record['seller']); echo $email['email']; ?></td>

          <td><?= $record['category_name']; ?></td>

          <td><?= $record['subcategory_name']; ?></td>

          <td><?= number_format($record['price']) ?></td>

          <td>

            <span class="btn btn-success btn-sm">

              <?php if($record['is_status'] == 0)  echo 'Inactivo'; ?>

              <?php if($record['is_status'] == 1) echo 'Activo'; ?>

              <?php if($record['is_status'] == 2) echo 'Expirado'; ?>

              <?php if($record['is_status'] == 3) echo 'Vendido'; ?>

              <?php if($record['is_status'] == 4) echo 'No Aprobado'; ?>

            </span>

          </td>
          <?php           
          $payment = $this->setting_model->get_stripe_settings();
          $statusPayment = $payment['stripe_status'];

          if ($statusPayment == "1") { ?>
            <td>

              <span class="btn btn-success btn-sm">

                <?php if($record['is_payment'] == 0)  echo 'Pendiente'; ?>

                <?php if($record['is_payment'] == 1) echo 'Pagado'; ?>

              </span>

            </td>
          <?php } ?>
          <td>

            <a style="width: 32px;" class="btn btn-sm btn-success" href="<?= base_url("admin/ads/edit/".$record['id'])?>" title="View" > 

             <i class="fa fa-eye"></i></a>&nbsp;&nbsp;



             <a style="width: 32px;" class="edit btn btn-sm btn-warning" href="<?= base_url("admin/ads/edit/".$record['id']) ?>" title="Edit" > 

               <i class="fa fa-edit"></i></a>&nbsp;&nbsp;



               <a style="width: 32px;" class="btn btn-sm btn-danger btn-delete" href="<?= base_url("admin/ads/del/".$record['id']) ?>" title="Delete"> 

                 <i class="fa fa-remove"></i></a>

               </td>

             </tr>

             <?php $counter++; endforeach; ?>

           </tbody>

         </table>

       </div>



       <script>

        $(function () {

          $("#example1").DataTable();

        });

      </script>