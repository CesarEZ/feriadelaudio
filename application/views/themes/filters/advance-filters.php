<?php 
  $attributes = array('method' => 'get','class' => 'filterForm filter-form'); 
  echo form_open(base_url('ads'),$attributes);
?>

<!-- Locations -->
<div class="single-slidebar">
  <h4>Ubicación</h4>

  <div class="row">
    <div class="col-12 form-group">
      <select class="filter-country form-control" name="country" >
        <option value="">Seleccione un país</option>
        <?php foreach($countries as $country):?>
          <option value="<?= $country['id']?>"><?= $country['name']?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>


  <div class="row">
    <div class="col-12 form-group filter-state-wrapper">
      <select class="filter-state form-control" name="state" >
        <option value="">Seleccione un estado</option>
      </select>
    </div>
  </div>

  <div class="row">
    <div class="col-12 form-group filter-city-wrapper">
      <select class="filter-city form-control" name="city" >
        <option value="">Seleccione una ciudad</option>
      </select>
    </div>
  </div>

</div>

<!-- Category & sub Category & fields-->
<div class="single-slidebar">
  <h4>Categorias</h4>
  <!--  -->
  <div class="row">
    <div class="col-12 form-group">
      <?php
        $where = array('status' => 1);
        $rows = get_records_where('ci_categories',$where);
        $options = array('' => trans('all_categories')) + array_column($rows,'name','id');
        echo form_dropdown('category',$options,'','class="filter-category form-control"');
      ?>
    </div>
  </div>

    <div class="filter-subcategory-wrapper hidden"></div>
    <div class="filter-custom-field-wrapper hidden"></div>
</div>

<!-- Price -->
<div class="single-slidebar">
  <h4>Precio</h4>
  <div class="row">
    <div class="col-12">
      <p>
        <label for="amount">Rango de precio:</label>
        <input type="text" id="amount" class="price-range" readonly>
      </p>
      <div id="slider-range"></div>
    </div>

    <input type="hidden" name="price-min" class="form-control" value="">
    <input type="hidden" name="price-max" class="form-control" value="">
    
  </div>
</div>

<!-- Keyward -->
<div class="single-slidebar">
  <h4>Palabra clave</h4>
  <div class="row">
    <div class="col-12 ">
      <input type="text" name="q" class="form-control" placeholder="Ingresa la palabra clave" value="<?= (isset($_GET['q'])) ? $_GET['q'] : '' ?>">
    </div>
  </div>
</div>

<!-- Type -->
<!-- <div class="single-slidebar">
  <h4>Ad Type</h4>
   <div class="row">
    <div class="col-12 form-group">
      <select name="ad_type" class="form-control">
        <option value="">All</option>
        <option value="0">Free Ads</option>
        <option value="1">Featured Ads</option>
        <option value="2">Hot Ads</option>
      </select>
    </div>
  </div>
</div> -->

<!-- Button -->
<div class="single-slidebar">
  <div class="row">
    <button type="button" class="btn btn-success full-width filter-submit">Buscar</button>
  </div>
</div>

<?php echo form_close(); ?>