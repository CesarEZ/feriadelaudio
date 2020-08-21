<script>

(function($) {

// General Variables

var base_url = '<?php echo base_url(); ?>';

var csfr_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';

var csfr_token_value = '<?php echo $this->security->get_csrf_hash(); ?>';

//  Delete Button
$(document).on('click','.btn-delete', function(){



    if (!confirm("¿Estás seguro?")){



      return false;



    }
});

/* Footer Widget Script */

// Remove Widget
$(document).on('click','.remove-footer-widget',function()
{
  a = confirm('are you sure?');
  (a) ? $(this).closest('div.widget').remove() : '';
});

// Add new widget
$(document).on('click','.btn-add-widget',function()
{
  widget = '<div class="widget">\
    <div class="row">\
        <div class="col-md-3">\
            <input type="text" class="form-control" name="widget_field_title[]" >\
        </div>\
        <div class="col-md-2">\
        <select class="form-control" name="widget_field_column[]">\
        <option value="4">1/4</option>\
        <option value="3">1/3</option>\
        <option value="2">1/3</option>\
        </select>\
        </div>\
        <div class="col-md-6">\
            <textarea class="form-control" name="widget_field_content[]"></textarea>\
        </div>\
        <div class="col-md-1">\
            <button type="button" class="btn btn-danger remove-footer-widget"><i class="fa fa-trash"></i></button>\
        </div>\
    </div>\
  </div>';

  $('.footer-widget-body').append(widget);
});

//-------------------------------------------------------------------
// Get sub category of category

$(document).on('change','.admin-category',function() {

 category = this.value;

  if(category == '')
  {
    $('.admin-subcategory-wrapper').addClass('hidden');
    $('.admin-subcategory').html('<select name="subsubcategory"  class="form-control select2">\<option value="">Seleccione una opción</option>\ </select>');
  }
  else
  {
    var data =  {

      parent : category,

    }

    data[csfr_token_name] = csfr_token_value;

    $.ajax({

    type: "POST",

    url: "<?= base_url('admin/ads/get_subcategory') ?>",

    data: data,

    dataType: "json",

    success: function(obj) {
      if(obj.status == 'success')
      {
        $('.admin-subcategory-wrapper').removeClass('hidden');
        $('.admin-subcategory').html(obj.msg);

      }
      else
      {
        $('.admin-subcategory').html('<select name="subcategory"  class="form-control select2">\<option value="">Seleccione una opción</option>\ </select>');
      }
    },
    
    });
  }
});

//-------------------------------------------------------------------
// Get custom fields of subcategory

$(document).on('change','.select-subcategory',function() {

 subcategory = this.value;

  if(subcategory == '')
  {
    $('.custom-field-wrapper').addClass('hidden');

    return false;
  }
  else
  {
    var data =  {

      parent : subcategory,

    }

    data[csfr_token_name] = csfr_token_value;

    $.ajax({

    type: "POST",

    url: "<?= base_url('admin/ads/get_subcategory_custom_fields') ?>",

    data: data,

    dataType: "json",

    success: function(obj) {

      if(obj.status == 'success')
      {
        $('.custom-field-wrapper').html(obj.msg);
        $('.custom-field-wrapper').removeClass('hidden');
      }
      if(obj.status == 'error')
      {
        $('.custom-field-wrapper').html('');
        $('.custom-field-wrapper').addClass('hidden');
      }
    },
    
    });
  }
});

// ------------------------------------------------------------------
// 
$(document).on('change','.field-type',function(){
    if(this.value == 'dropdown' || this.value == 'multiple_checkbox' || this.value == 'multiple_radio')
    {
      $('.options-wrapper').removeClass('hidden');
    }
    else
    {
      $('.options-wrapper').addClass('hidden');
    }
  });

//---------------------------------------------
//
$(document).on('click','.btn-add-option',function(){
    field = $('.new-option');
    value = field.val();
    if(value == '')
    {
      field.css('border','1px solid red'); 
      return false;
    }
    else
    {
      field.css('border','1px solid #ccc'); 
      option = '<div class="form-group">\
                <div class="row">\
                  <label class="col-sm-1"><i class="fa fa-times btn-delete-option"></i></label>\
                  <div class="col-sm-7">\
                    <span>'+value+'</span>\
                    <input type="hidden" value="'+value+'" name="options[]">\
                  </div>\
                </div>\
              </div>';
      $('.options').prepend(option);
      field.val('');
    }
});

// -----------------------------------------
// remvoe option

$(document).on('click','.btn-delete-option',function(){
  $(this).closest('.form-group').remove();
});

}); // EOF
</script>