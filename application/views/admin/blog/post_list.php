<div class="adv-table table-responsive">
  <table id="example1" class="table table-bordered table-hover">
    <thead>
      <tr>
        <th> #</th>
        <th>Imagen</th>
        <th>Título</th>
        <th>Palabras clave</th>
        <th>Categoría</th>
        <th>Fecha de Publicación</th>
        <th>Acción</th>
      </tr>
    </thead>
    <tbody>
        <?php $counter = 1;
          foreach($posts as $record): 
        ?>
        <tr>
          <td><?= $counter; ?></td>
          <td><img src="<?= base_url($record['image_default'])?>" width="50"></td>
          <td><?= $record['title']; ?></td>
          <td><?= $record['keywords']; ?></td>
          <td><?= get_blog_categories_name($record['category_id']); ?></td>
          <td><?= date_time($record['created_at']) ?></td>
          <td>
            <a class="btn btn-xs btn-success" href="<?= base_url("admin/blog/edit/".$record['id'])?>" title="View" > 
           <i class="fa fa-eye"></i></a>&nbsp;&nbsp;

            <a class="edit btn btn-xs btn-warning" href="<?= base_url("admin/blog/edit/".$record['id']) ?>" title="Edit" > 
           <i class="fa fa-edit"></i></a>&nbsp;&nbsp;

           <a class="btn-delete btn btn-xs btn-danger" href="<?= base_url("admin/blog/del/".$record['id']) ?>" title="Delete" > 
           <i class="fa fa-remove"></i></a>
          </td>
        </tr>
      <?php $counter++; endforeach; ?>
    </tbody>
  </table>
</div>