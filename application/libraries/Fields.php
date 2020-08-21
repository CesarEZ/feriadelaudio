<?php

	class Fields 

	{

		function __construct()

		{

			$this->obj =& get_instance(); 

		}



		//--------------------------------------------------------

		// 

		public function category_fields($category) 

		{

			$this->obj->db->select('

				ci_fields_to_category.id as cat_id,

				ci_fields_to_category.field,

				ci_fields.id,

				ci_fields.name,

				ci_fields.slug,

				ci_fields.type,

				ci_fields.length,

				ci_fields.default_value,

				ci_fields.required,

				ci_fields.status,

			');

			$this->obj->db->join('ci_fields','ci_fields.id = ci_fields_to_category.field');

			$this->obj->db->where('ci_fields_to_category.category',$category);

			$this->obj->db->where('ci_fields.status',1);

			$data =  $this->obj->db->get('ci_fields_to_category')->result_array();



			$html = $this->get_fields($data);



			return $html;

		}



		//--------------------------------------------------------

		// 

		public function subcategory_fields($subcategory,$call_type = '') 

		{

			$this->obj->db->select('

				ci_fields_to_category.id as cat_id,

				ci_fields_to_category.field,

				ci_fields.id,

				ci_fields.name,

				ci_fields.slug,

				ci_fields.type,

				ci_fields.length,

				ci_fields.default_value,

				ci_fields.required,

				ci_fields.status,

			');

			$this->obj->db->join('ci_fields','ci_fields.id = ci_fields_to_category.field');

			$this->obj->db->where('ci_fields_to_category.subcategory',$subcategory);

			$this->obj->db->where('ci_fields.status',1);

			$data =  $this->obj->db->get('ci_fields_to_category')->result_array();



			$html = $this->get_fields($data,$call_type);



			return $html;

		}



		//--------------------------------------------------------

		// 

		public function get_fields($data,$call_type) 

		{

			$html = '';



			for ($i= 0; $i < count($data); $i++) { 



				$row = $data[$i];



				$field = $this->field_type($row);

				

				$required = ($row['required']) ? ' *' : '';

				if($call_type == '')
				{

					$html .= '<div class="row">

					<div class="col-md-12 col-sm-12">

		              <div class="submit-field">

		                <h5>'.$row['name'].$required.'</h5>

		                <input type="hidden" name="field[]" value="'.$row['id'].'" data-type="'.$row['name'].'">

		                '.$field.'

		              </div>

		              </div>

		            </div>';
		        }
		        else
		        {
		        	$html .= '<div class="row">

					<div class="col-md-12 col-sm-12">

		              <div class="form-group">

		                <h5>'.$row['name'].$required.'</h5>

		                <input type="hidden" name="field[]" value="'.$row['id'].'" data-type="'.$row['name'].'">

		                '.$field.'

		              </div>

		              </div>

		            </div>';
		        }



			}



			return $html;

		}



		//--------------------------------------------------------

		// 

		public function field_type($data)

		{

			$field_name = 'fd-'.$data['id'];



			switch ($data['type']) {



				case 'text':



					$others = array(

						'name' => $field_name,

						'value' => $data['default_value'],

						'class' => 'form-control',

						'placeholder' => $data['name'],

						'maxlength' => $data['length'],

						'required' => ($data['required']) ? TRUE : FALSE,

					);

					

					return form_input($others);



					break;



				case 'textarea':



					$others = array(

						'name' => $field_name,

						'value' => $data['default_value'],

						'class' => 'form-control',

						'placeholder' => $data['name']

					);



					return form_textarea($others);



					break;



				case 'checkbox':



					$others = array(

						'name' => $field_name,

						'value' => $data['default_value'],

						'checked' => FALSE,

						'class' => 'form-control',

					);



					return form_checkbox($others);

					 

					break;



				case 'dropdown':



					$others = array(

						'class' => 'form-control',

						'required' => ($data['required']) ? TRUE : FALSE,

					);



					$options = $this->field_options($data['id']);

					$options = array('' => 'Choose an Option') + array_column($options, 'name','id');



					return form_dropdown($field_name,$options,$data['default_value'],$others);

					

					break;



				case 'radio':

					

					$others = array(

						'name' => $field_name,

						'value' => $data['default_value'],

						'checked' => FALSE,

						'class' => 'form-control',

					);



					return form_radio($others);



					break;



				case 'multiple_checkbox':

					

					$options = $this->field_options($data['id']);



					$html = '';

					foreach($options as $op)

					{

						$others = array(

							'name' => $field_name.'[]',

							'value' => $op['id'],

							'checked' => FALSE,

						);

						$html .=  form_label($op['name'],$field_name).' '.form_checkbox($others);

					}



					return $html;



					break;



				case 'multiple_radio':

					

					$options = $this->field_options($data['id']);



					$html = '';

					foreach($options as $op)

					{

						$others = array(

							'name' => $field_name,

							'value' => $op['id'],

							'checked' => FALSE,

						);

						$html .=  form_label($op['name'],$field_name).' '.form_radio($others);

					}



					return $html;



					break;

				

				default:



					$others = array(

						'name' => $field_name,

						'value' => $data['default_value'],

						'class' => 'form-control',

						'placeholder' => 'default',

						'maxlength' => $data['length'],

						'required' => ($data['required']) ? TRUE : FALSE,

					);

					

					return form_input($others);



					break;

			}

		}



		public function feild_value($field_id,$value_id)

		{

			$type = $this->obj->db->get_where('ci_fields',array('id' => $field_id))->row_array()['type'];



			if($type == 'multiple_checkbox' || $type == 'multiple_checkbox' || $type == 'multiple_checkbox')

			{

				$multiple_checkbox = explode(',',$value_id);



				$value = '';



                foreach ($multiple_checkbox as $checkbox):



                $value .= '<span class="badge badge-light">'.get_feild_value($checkbox).'</span>';



	            endforeach;

			}

			elseif($type == 'text')

			{

				$value = $value_id;

			}

			else

			{

				$value = get_feild_value($value_id);

			}



            return $value;

		}



		//--------------------------------------------------------

		// 

		public function field_options($field_id)

		{

			$this->obj->db->select('*');

			$this->obj->db->group_by('name');

			$this->obj->db->order_by('name');

			$this->obj->db->where('parent_field',$field_id);

			return $this->obj->db->get('ci_field_options')->result_array();

		}



		/* EDIT FIELD / SELECTED FIELDS */



		// --------------------------------------------------------

		//

		public function fields_by_ad_id($ad_id)

		{

			$this->obj->db->select('

				ci_ad_detail.*,

				ci_fields.id as fid,

				ci_fields.name as fname,

				ci_fields.slug as fslug,

				ci_fields.type as ftype,

				ci_fields.length as flength,

				ci_fields.default_value as fdefault_value,

				ci_fields.required as frequired,

			');



			$this->obj->db->join('ci_fields','ci_fields.id = ci_ad_detail.field_id');



			$this->obj->db->where('ci_fields.status',1);

			$this->obj->db->where('ci_ad_detail.ad_id',$ad_id);



			return $this->obj->db->get('ci_ad_detail')->result_array();

		}



		//--------------------------------------------------------

		// Category ID

		// Pass admin as call type in case of Admin Call

		public function category_fields_by_ad_id($category,$call_type = '') 

		{



			$this->obj->db->select('

				ci_fields_to_category.id as cat_id,

				ci_fields_to_category.field,

				ci_fields.id,

				ci_fields.name,

				ci_fields.slug,

				ci_fields.type,

				ci_fields.length,

				ci_fields.default_value,

				ci_fields.required,

				ci_fields.status,

			');

			$this->obj->db->join('ci_fields','ci_fields.id = ci_fields_to_category.field');

			$this->obj->db->where('ci_fields_to_category.category',$category);

			$this->obj->db->where('ci_fields.status',1);

			$data =  $this->obj->db->get('ci_fields_to_category')->result_array();



			$html = $this->get_fields_by_ad_id($data,$call_type);



			return $html;

		}



		//--------------------------------------------------------

		// Subcategory ID 

		// Post ID

		// Pass admin as call type in case of Admin Call

		public function subcategory_fields_by_ad_id($subcategory,$ad_id,$call_type = '') 

		{

			$this->obj->db->select('

				ci_fields_to_category.id as cat_id,

				ci_fields_to_category.field,

				ci_fields.id,

				ci_fields.name,

				ci_fields.slug,

				ci_fields.type,

				ci_fields.length,

				ci_fields.default_value,

				ci_fields.required,

				ci_fields.status,

			');

			$this->obj->db->join('ci_fields','ci_fields.id = ci_fields_to_category.field');

			$this->obj->db->where('ci_fields_to_category.subcategory',$subcategory);

			$this->obj->db->where('ci_fields.status',1);

			$data =  $this->obj->db->get('ci_fields_to_category')->result_array();



			$html = $this->get_fields_by_ad_id($data,$ad_id,$call_type);



			return $html;

		}



		//--------------------------------------------------------

		// 

		public function get_fields_by_ad_id($data,$ad_id,$call_type = '') 

		{



			$html = '';



			for ($i= 0; $i < count($data); $i++) { 



				$row = $data[$i];



				$required = ($row['required']) ? ' *' : '';



				$field = $this->post_field_type($row,$ad_id);



				if(!empty($call_type) && $call_type == 'admin')

				{

					$html .= '<div class="row">

					<div class="col-md-12 col-sm-12">

		              <div class="form-group">

		                <h5>'.$row['name'].$required.'</h5>

		                <input type="hidden" name="field[]" value="'.$row['id'].'" data-type="'.$row['name'].'">

		                '.$field.'

		              </div>

		              </div>

		            </div>';

		        }

		        else

		        {

		        	$html .= '<div class="row">

					<div class="col-md-12 form-group">

		                <h5>'.$row['name'].$required.'</h5>

		                <input type="hidden" name="field[]" value="'.$row['id'].'" data-type="'.$row['name'].'">

		                '.$field.'

		              </div>

		            </div>';

		        }



			}



			return $html;

		}



		//--------------------------------------------------------

		// 

		public function post_field_type($data,$ad_id)

		{

			$field_name = 'fd-'.$data['id'];



			$field_value = $this->post_field_value($data['id'],$ad_id);



				switch ($data['type']) {



				case 'text':



					$others = array(

						'name' => $field_name,

						'value' => $field_value,

						'class' => 'form-control',

						'placeholder' => $data['name'],

						'maxlength' => $data['length'],

						'required' => ($data['required']) ? TRUE : FALSE,

					);

					

					return form_input($others);



					break;



				case 'textarea':



					$others = array(

						'name' => $field_name,

						'value' => $field_value,

						'class' => 'form-control',

						'placeholder' => $data['name']

					);



					return form_textarea($others);



					break;



				case 'checkbox':



					$others = array(

						'name' => $field_name,

						'value' => $field_value,

						'checked' => FALSE,

						'class' => 'form-control',

					);



					return form_checkbox($others);

					 

					break;



				case 'dropdown':



					$others = array(

						'class' => 'form-control',

						'required' => ($data['required']) ? TRUE : FALSE,

					);



					$options = $this->field_options($data['id']);

					$options = array('' => 'Choose an Option') + array_column($options, 'name','id');



					return form_dropdown($field_name,$options,$field_value,$others);

					

					break;



				case 'radio':

					

					$others = array(

						'name' => $field_name,

						'value' => $field_value,

						'checked' => FALSE,

						'class' => 'form-control',

					);



					return form_radio($others);



					break;



				case 'multiple_checkbox':

					

					$v = explode(',', $field_value);



					$options = $this->field_options($data['id']);



					$html = '';



					foreach($options as $op)

					{

						$others = array(

							'name' => $field_name.'[]',

							'value' => $op['id'],

							'checked' => (in_array($op['id'], $v)) ? TRUE : FALSE,

						);



						$html .=  form_label($op['name'],$field_name).' '.form_checkbox($others);

					}



					return $html;



					break;



				case 'multiple_radio':

					

					$v = explode(',', $field_value);



					$options = $this->field_options($data['id']);



					$html = '';

					

					foreach($options as $op)

					{

						$others = array(

							'name' => $field_name,

							'value' => $op['id'],

							'checked' => (in_array($op['id'], $v)) ? TRUE : FALSE,

						);



						$html .=  form_label($op['name'],$field_name).' '.form_radio($others);

					}



					return $html;



					break;

				

				default:



					$others = array(

						'name' => $field_name,

						'value' => $field_value,

						'class' => 'form-control',

						'placeholder' => 'default',

						'maxlength' => $data['length'],

						'required' => ($data['required']) ? TRUE : FALSE,

					);

					

					return form_input($others);



					break;

			}

		}



		//-------------------------------------------------------

		//

		public function post_field_value($field_id,$ad_id)

		{

			return $this->obj->db->get_where('ci_ad_detail',array('ad_id' => $ad_id,'field_id' => $field_id))->row_array()['field_value'];

		}



		/*-------------------- 

			FILTERS 

		---------------------*/



		//--------------------------------------------------------

		// 

		public function filter_subcategory_fields($subcategory) 

		{

			$this->obj->db->select('

				ci_fields_to_category.id as cat_id,

				ci_fields_to_category.field,

				ci_fields.id,

				ci_fields.name,

				ci_fields.slug,

				ci_fields.type,

				ci_fields.length,

				ci_fields.default_value,

				ci_fields.required,

				ci_fields.status,

			');

			$this->obj->db->join('ci_fields','ci_fields.id = ci_fields_to_category.field');

			$this->obj->db->where('ci_fields_to_category.subcategory',$subcategory);

			$this->obj->db->where('ci_fields.status',1);

			$data =  $this->obj->db->get('ci_fields_to_category')->result_array();



			$html = $this->filter_get_fields($data);



			return $html;

		}



		//--------------------------------------------------------

		// 

		public function filter_get_fields($data) 

		{

			$html = '';



			for ($i= 0; $i < count($data); $i++) { 



				$row = $data[$i];



				$field = $this->filter_field_type($row);



				$html .= '<div class="row">

				<div class="col-12 form-group">

	                '.$field.'

	              </div>

	            </div>';



			}



			return $html;

		}



		//--------------------------------------------------------

		// 

		public function filter_field_type($data)

		{

			$field_name = 'fd-'.$data['id'];



			if ($data['type'] == 'checkbox' || $data['type'] == 'dropdown' || $data['type'] == 'radio' || $data['type'] == 'multiple_checkbox' || $data['type'] == 'multiple_radio') {



				$options = $this->field_options($data['id']);

					$options = array('' => 'Select '.$data['name']) + array_column($options, 'name','id');



					return form_dropdown($field_name,$options,$data['default_value'],'class="form-control"');

			}

				

		}





	}

?>