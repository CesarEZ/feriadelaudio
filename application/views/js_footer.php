<?php $countries = get_countries_list() ?>
<script type="text/javascript">

  var base_url = '<?php echo base_url(); ?>';
  var csfr_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
  var csfr_token_value = '<?php echo $this->security->get_csrf_hash(); ?>';
    //-------------------------------------------------------------------
    // Get sub category of category
    $(document).on('change','.category',function() {
     category = this.value;
     $('.pre-loader').removeClass('hidden');
     if(category == '')
     {
      $('.subcategory').html('');
      $('.subcategory-wrapper').addClass('hidden');
      $('.custom-field-wrapper').html('');
      $('.custom-field-wrapper').addClass('hidden');
      $('.pre-loader').addClass('hidden');
    }
    else
    {
      var data =  {
        parent : category,
      }
      data[csfr_token_name] = csfr_token_value;
      $.ajax({
        type: "POST",
        url: "<?= base_url('ads/get_subcategory') ?>",
        data: data,
        dataType: "json",
        success: function(obj) {
          $('.pre-loader').addClass('hidden');
          if(obj.status == 'success')
          {
            $('.custom-field-wrapper').addClass('hidden');
            $('.subcategory').html(obj.msg);
            $('.subcategory-wrapper').removeClass('hidden');
          }
          if(obj.status == 'fields')
          {
            $('.subcategory-wrapper').addClass('hidden');
            $('.custom-field-wrapper').html(obj.msg);
            $('.custom-field-wrapper').removeClass('hidden');
          }
        },

      });
    }
  });
  //-------------------------------------------------------------------
  // Get custom fields of subcategory
  $(document).on('change','.select-subcategory',function() {
    $('.pre-loader').removeClass('hidden');
    subcategory = this.value;
    if(subcategory == '')
    {
      $('.custom-field-wrapper').addClass('hidden');
      $('.pre-loader').addClass('hidden');
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
        url: "<?= base_url('ads/get_subcategory_custom_fields') ?>",
        data: data,
        dataType: "json",
        success: function(obj) {
          $('.pre-loader').addClass('hidden');
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
  // Check Field Type
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
  // Custom Field Options
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
      <label class="col-sm-3 control-label"><i class="fa fa-times"></i></label>\
      <div class="col-sm-7">\
      <p>'+value+'</p>\
      <input type="hidden" value="'+value+'" name="options[]">\
      </div>\
      </div>';
      $('.options').prepend(option);
      field.val('');
    }
  });
  //-------------------------------------------------------------------
  // Switch / Show Payment Method Fields
  $(document).on('change','.payment-method',function()
  {
    if(this.value == '')
    {
      $('.stripe').addClass('hidden');
      $('.paypal').addClass('hidden');
    }
    else
    {
      if(this.value == '1')
      {
        $('.stripe').addClass('hidden');
        $('.paypal').removeClass('hidden');
      }
      else
      {
        $('.stripe').removeClass('hidden');
        $('.paypal').addClass('hidden');
      }
    }
  });
  //-------------------------------------------------------------------
  // Country State & City Change
  $(document).on('change','.country',function()
  {
    $('.pre-loader').removeClass('hidden');
    if(this.value == '')
    {
      $('.state').html('<option value="">Seleccione un estado</option>');
      $('.city').html('<option value="">Seleccione una ciudad</option>');
      $('.pre-loader').addClass('hidden');
      return false;
    }
    
    var data =  {
      country : this.value,
    }
    data[csfr_token_name] = csfr_token_value;
    $.ajax({
      type: "POST",
      url: "<?= base_url('auth/get_country_states') ?>",
      data: data,
      dataType: "json",
      success: function(obj) {
        $('.state').html(obj.msg);
        $('.pre-loader').addClass('hidden');
      },
    });
  });
  $(document).on('change','.state',function()
  {
    $('.pre-loader').removeClass('hidden');
    
    var data =  {
      state : this.value,
    }
    data[csfr_token_name] = csfr_token_value;
    $.ajax({
      type: "POST",
      url: "<?= base_url('auth/get_state_cities') ?>",
      data: data,
      dataType: "json",
      success: function(obj) {
        $('.city').html(obj.msg);
        $('.pre-loader').addClass('hidden');
      },
    });
  });
  //-------------------------------------------------------------------
  // Delete Confirm Dialogue box
    //  Delete Button
    $(document).on('click','.btn-delete', function(){
      if (!confirm("¿Estás seguro?")){
        return false;
      }
    });
  //------------------------------------------------------------
  // Saved Post as favouite
  $(document).on('click', '.i-favorite', function(){
    $this = $(this);
    if($this.hasClass('fa-heart'))
    {
      c = confirm('are you sure?');
      if(!c) return false;
      $this.removeClass('fa-heart');
      $this.addClass('fa-heart-o');
    }
    else
    {
      $this.removeClass('fa-heart-o');
      $this.addClass('fa-heart');
    }
    var data = {
      ad_id : $this.data('post'),
    }
    data[csfr_token_name] = csfr_token_value;
    $.ajax({
      type: 'POST',
      url: base_url + 'seller/ads/save_favorite',
      data: data,
      success: function (response) {
        if($.trim(response) == "not_login"){
         $.notify("¡Alerta! Por favor ingresa primero", "danger");
       }
       if($.trim(response) == "removed"){
        $.notify("La publicación se ha eliminado de Favoritos", "success");
        $(this).closest('div.profile-notification').remove();
      }
      if($.trim(response) == "saved"){
        $.notify("La publicación se ha guardado correctamente.", "success");
      }
    }
  });
  });
  //-------------------------------------------------------------------
  // Sending Message
  $(document).on('click','.send_message', function()
  {
    msg = $('.message').val();
    receiver = $('.receiver').val();
    post = $('.post').val();
    if(msg === '')
    {
      $('.message').css('border','1px solid red');
      return false;
    }
    else
    {
      $('.message').css('border','1px solid #BABFC7');
    }
    var t = new Date($.now());
    time = t.getDate()+'-'+t.getMonth()+'-'+t.getFullYear()+' '+t.getHours()+':'+t.getMinutes();
    $new_msg = '<div class="container whiter">\
    <span class="user-left">You</span>\
    <p>'+msg+'</p>\
    <span class="time-right"><?= date('H:i F j, Y') ?></span>\
    </div>';
    var data = 
    {
      message : msg,
      receiver : receiver,
      post : post
    }
    data[csfr_token_name] = csfr_token_value;
    $('.inbox_body').append($new_msg);
    $('.message').val('');
    $.ajax({
      type: "POST",
      url: base_url+'inbox/send_message',
      data: data,
      dataType: "json",
      success: function(response) {
        $('.message').val('');
      }
    });
  });
  //-------------------------------------------------------------
  // Rating
  $(document).on('click','.star-rating .fa', function() 
  {
    $this = $(this);
    $('input.rating-value').val($this.data('rating'));
    var rating = $('input.rating-value').val();
    var user_id = $this.data('user');
    var ad_id = $this.data('post');
    children = $this.parent().children('.fa');
    parent = $this.parent('.star-rating').html();
    var i = 1;
    children.each(function() {
      if (parseInt($this.data('rating')) >= i) 
      {
        $(this).removeClass('fa-star-o').addClass('fa-star');
      } else {
        $(this).removeClass('fa-star').addClass('fa-star-o');
      }
      i++;
    });
    var data = 
    {
      user_id : user_id, 
      ad_id : ad_id, 
      rating_value : rating,
    }
    data[csfr_token_name] = csfr_token_value;
    $.post({
      url : '<?= base_url('seller/ads/update_rating') ?>',
      data : data,
      function(){
      }
    });
  });
  //--------------------------------------------------------
  // jsform
  $(document).on("submit",".jsform", function(event) {
    event.preventDefault();
    $('.pre-loader').removeClass('hidden');
    var $btn = $('input[type=submit]');
    var $txt = $btn.val();
    $btn.prop('disabled',true);
    $btn.val('Por favor espere...');
    $action = $(this).attr( 'action' );
    $method = $(this).attr( 'method' );
    $.ajax({
      type: $method,
      url: $action,
      data: new FormData(this),
      processData: false,
      contentType: false,
      dataType: "json",
      success: function(obj) {
        $('.pre-loader').addClass('hidden');
        $btn.prop('disabled',false);
        $btn.val($txt);
        if(obj.status == 'success')
        {
          swal("Exito!", obj.msg, obj.status);
          if (obj.redirect){
            setTimeout(function() {
              window.location = obj.redirect; 
            },1500);
          }
          else{
            location.reload();
          }
        }
        else
        {
          swal("Error!", obj.msg, obj.status);
        }
      },
    });
  }); 
  //--------------------------------------------------------
  // filter form
  $(document).on('click','.filter-submit',function(){
    var myForm = $('form.filterForm');
    var allInputs = $('.filterForm :input');
    var input, i;
    for(i = 0; input = allInputs[i]; i++) {
      if(input.getAttribute('name') && !input.value) {
        input.setAttribute('name', '');
      }
    }
    myForm.submit();
  });
  //-----------------------------------------------
  // Mark Users Notification View Status
  $(document).on('click','.i-notification-view',function()
  {
    notifications = parseInt($('.notification-number').text())-1;
    if(notifications > 0)
      $('.notification-number').text(notifications);
    else
      $('.notification-number').remove();
    $(this).closest('span.i-notification-view').remove();
    notification_id = $(this).data('notification');
    var data = 
    {
      notification_id : notification_id, 
    }
    data[csfr_token_name] = csfr_token_value;
    $.post({
      url : '<?= base_url('profile/mark_viewed_notification') ?>',
      data : data,
      function(response){
      }
    });
  });
  // FILTERS //
  //-------------------------------------------------------------------
  // Get sub category of category
  $(document).on('change','.filter-category',function() {
    $('.pre-loader').removeClass('hidden');
    category = this.value;
    if(category == '')
    {
      $('.filter-subcategory').html('');
      $('.filter-subcategory-wrapper').addClass('hidden');
      $('.filter-custom-field-wrapper').html('');
      $('.filter-custom-field-wrapper').addClass('hidden');
      $('.pre-loader').addClass('hidden');
    }
    else
    {
      var data =  {
        parent : category,
      }
      data[csfr_token_name] = csfr_token_value;
      $.ajax({
        type: "POST",
        url: "<?= base_url('ads/get_subcategory_for_filter') ?>",
        data: data,
        dataType: "json",
        success: function(obj) {
          $('.pre-loader').addClass('hidden');
          if(obj.status == 'success')
          {
            $('.filter-custom-field-wrapper').addClass('hidden');
            $('.filter-subcategory-wrapper').html(obj.msg);
            $('.filter-subcategory-wrapper').removeClass('hidden');
          }
          if(obj.status == 'fields')
          {
            $('.filter-subcategory-wrapper').addClass('hidden');
            $('.filter-custom-field-wrapper').html(obj.msg);
            $('.filter-custom-field-wrapper').removeClass('hidden');
          }
        },
      });
    }
  });
  //-------------------------------------------------------------------
  // Get custom fields of subcategory
  $(document).on('change','.filter-subcategory',function() {
   subcategory = this.value;
   $('.pre-loader').removeClass('hidden');
   if(subcategory == '')
   {
    $('.filter-custom-field-wrapper').addClass('hidden');
    $('.pre-loader').addClass('hidden');
  }
  else
  {
    var data =  {
      parent : subcategory,
    }
    data[csfr_token_name] = csfr_token_value;
    $.ajax({
      type: "POST",
      url: "<?= base_url('ads/get_subcategory_custom_fields_for_filter') ?>",
      data: data,
      dataType: "json",
      success: function(obj) {
        $('.pre-loader').addClass('hidden');
        
        if(obj.status == 'success')
        {
          $('.filter-custom-field-wrapper').html(obj.msg);
          $('.filter-custom-field-wrapper').removeClass('hidden');
        }
        if(obj.status == 'error')
        {
          $('.filter-custom-field-wrapper').html('');
          $('.filter-custom-field-wrapper').addClass('hidden');
        }
      },
      
    });
  }
});
  //-------------------------------------------------------------------
  // Country State & City Change
  $(document).on('change','.filter-country',function()
  {
    if(this.value == '')
    {
      $('.filter-city').html('<option value="">Seleccione una ciudad</option>');
      return false;
    }
    $('.pre-loader').removeClass('hidden');
    var data =  {
      country : this.value,
    }
    data[csfr_token_name] = csfr_token_value;
    $.ajax({
      type: "POST",
      url: "<?= base_url('ads/get_country_states') ?>",
      data: data,
      dataType: "json",
      success: function(obj) {
        $('.pre-loader').addClass('hidden');
        $('.filter-state-wrapper').html(obj.msg);
      },
    });
  });
  
  $(document).on('change','.filter-state',function()
  {
    $('.pre-loader').removeClass('hidden');
    var data =  {
      state : this.value,
    }
    data[csfr_token_name] = csfr_token_value;
    $.ajax({
      type: "POST",
      url: "<?= base_url('ads/get_state_cities') ?>",
      data: data,
      dataType: "json",
      success: function(obj) {  
        $('.pre-loader').addClass('hidden');
        $('.filter-city-wrapper').html(obj.msg);
      },
    });
  });
  $( "#slider-range" ).slider({
    range: true,
    min: 0,
    max: 10000,
    values: [ 0, 10000 ],
    slide: function( event, ui ) {
      $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      $('input[name=price-min]').val(ui.values[ 0 ]);
      $('input[name=price-max]').val(ui.values[ 1 ]);
    }
  });

  $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
    " - $" + $( "#slider-range" ).slider( "values", 1 ) );

  </script>