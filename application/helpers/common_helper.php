<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	// -----------------------------------------------------------------------------
    // Get General Setting
if (!function_exists('get_general_settings')) {
    function get_general_settings()
    {
        $ci =& get_instance();
        $ci->load->model('admin/setting_model');
        return $ci->setting_model->get_general_settings();
    }
}

    // -----------------------------------------------------------------------------
    //get recaptcha
if (!function_exists('generate_recaptcha')) {
    function generate_recaptcha()
    {
        $ci =& get_instance();
        if ($ci->recaptcha_status) {
            $ci->load->library('recaptcha');
            echo '<div class="form-group mt-2">';
            echo $ci->recaptcha->getWidget();
            echo $ci->recaptcha->getScriptTag();
            echo ' </div>';
        }
    }
}

    //print old form data
if (!function_exists('old')) {
    function old($field)
    {
        $ci =& get_instance();
        return html_escape($ci->session->flashdata('form_data')[$field]);
    }
}

    //-----------------------------------------------------------------------------
    // Get record general function

function get_record($table,$where = NULL)
{
    $ci = & get_instance();
    $ci->db->select('*');

    if($where)
        $ci->db->where($where);

    return $ci->db->get($table)->result_array();
}

    // -----------------------------------------------------------------------------
    // Get category name by id
function get_pages()
{
    $ci = & get_instance();
    return $ci->db->get_where('ci_pages', array('is_active' => 1))->result_array();
}

    // -----------------------------------------------------------------------------
    // Get category name by id
function get_category_name($id)
{
   $ci = & get_instance();
   return $ci->db->get_where('ci_categories', array('id' => $id))->row_array()['name'];
}

    // -----------------------------------------------------------------------------
    // Get category name by id
function get_subcategory_name($id)
{
    $ci = & get_instance();
    return $ci->db->get_where('ci_subcategories', array('id' => $id))->row_array()['name'];
}

    // ------------------------------------------------------
    // get languages
function get_languages_list()
{
    $ci = & get_instance();
    return $ci->db->get('ci_language')->result_array();
}

    // ------------------------------------------------------
    // get languages
function get_language_by_id($id)
{
    $ci = & get_instance();
    return $ci->db->get_where('ci_language',array('id' => $id))->row_array();
}

    // Currency
function get_currency_list()
{
    $ci = & get_instance();
    return $ci->db->get('ci_currency')->result_array();
}

    // -----------------------------------------------------------------------------
    // Get category ID by title
function get_category_id($category_name)
{
    $ci = & get_instance();
    return $ci->db->get_where('ci_categories', array('slug' => $category_name))->row_array()['id'];
}

    // -----------------------------------------------------------------------------
    // Get category ID by title
function get_category_by_slug($slug)
{
    $ci = & get_instance();
    return $ci->db->get_where('ci_categories', array('slug' => $slug))->row_array()['name'];
}

    // -----------------------------------------------------------------------------
    // Get country name by ID
function get_country_name($id)
{
   $ci = & get_instance();
   return $ci->db->get_where('ci_countries', array('id' => $id))->row_array()['name'];
}

    // -----------------------------------------------------------------------------
    // Get country 
function get_countries_list()
{
    $ci = & get_instance();
    return $ci->db->get('ci_countries')->result_array();
}

    // -----------------------------------------------------------------------------
    // Get country's states
function get_country_states($country_id)
{
    $ci = & get_instance();
    return $ci->db->select('*')->where('country_id',$country_id)->get('ci_states')->result_array();
}

    // -----------------------------------------------------------------------------
    // Get state's cities
function get_state_cities($state_id)
{
    $ci = & get_instance();
    return $ci->db->select('*')->where('state_id',$state_id)->get('ci_cities')->result_array();
}

    // -----------------------------------------------------------------------------
    // Get city name by ID
function get_city_name($id)
{
    $ci = & get_instance();
    return $ci->db->get_where('ci_cities', array('id' => $id))->row_array()['name'];
}

    // Get state name by ID
function get_state_name($id)
{
    $ci = & get_instance();
    return $ci->db->get_where('ci_states', array('id' => $id))->row_array()['name'];
}

    // -----------------------------------------------------------------------------
    // Get city ID by title
function get_city_slug($id)
{
    $ci = & get_instance();
    return $ci->db->get_where('ci_cities', array('id' => $id))->row_array()['slug'];
}

    // -----------------------------------------------------------------------------
    // Get country slug
function get_country_slug($id)
{
    $ci = & get_instance();
    return $ci->db->get_where('ci_countries', array('id' => $id))->row_array()['slug'];
}

    // -----------------------------------------------------------------------------
    // Get category by ID
function get_category_slug($id)
{
    $ci = & get_instance();
    return $ci->db->get_where('ci_categories', array('id' => $id))->row_array()['slug'];
}


    // -----------------------------------------------------------------------------
    // Get City ID by Name
function get_city_id($title)
{
    $ci = & get_instance();
    return $ci->db->get_where('ci_cities', array('name' => $title))->row_array()['id'];
}

    // -----------------------------------------------------------------------------
    // Get City ID by Name
function get_country_id($title)
{
    $ci = & get_instance();
    return $ci->db->get_where('ci_countries', array('name' => $title))->row_array()['id'];
}

    // -----------------------------------------------------------------------------
    // Get Education by ID
function get_education_level($id)
{
    $ci = & get_instance();
    return $ci->db->get_where('ci_education', array('id' => $id))->row_array()['type'];
}

    // ------------------------
    // get payment methods
function get_payment_methods()
{
    $ci = & get_instance();
    $ci->db->select('*');
    return $ci->db->get('ci_payment_methods')->result_array();
}

    // -----------------------------------------------------------------------------
    // Get User Full Name
function get_user_full_name($user_id)
{
    $ci = & get_instance();
    $result = $ci->db->get_where('ci_users', array('id' => $user_id))->row_array();
    return $result['firstname'].' '.$result['lastname'];
}

     // -----------------------------------------------------------------------------
    // Get User Name
function get_user($user_id)
{
    $ci = & get_instance();
    return $ci->db->get_where('ci_users', array('id' => $user_id))->row_array();
}

    // -----------------------------------------------------------------------------
    // Get User Full Name
function get_user_email($user_id)
{
    $ci = & get_instance();
    $result = $ci->db->get_where('ci_users', array('id' => $user_id))->row_array();
    return $result['email'];
}

    // -----------------------------------------------------------------------------
    // Check User Favorite
function is_favorite($ad_id,$user_id)
{
    $ci = & get_instance();
    $where =  array('ad_id' => $ad_id,'user_id' => $user_id);
    $result = $ci->db->get_where('ci_ad_favorite',$where);

    if($result->num_rows() > 0)
        return true;
    else
        return false;
}

    // Message VIEW Status Update
function update_message_notification_view($message_id)
{
    $ci = & get_instance();
    $ci->db->where('receiver',$ci->session->user_id);
    $ci->db->where('id',$message_id);
    $ci->db->update('ci_inbox',array('receiver_view' => 1));
    return true;
}

    // ------------------------------
    // Get all records by table

function get_all_records($table)
{
    $ci = & get_instance();
    $ci->db->select('*');
    return $ci->db->get($table)->result_array();
}

    // ------------------------------
    // Get selected records by table

function get_records_where($table,$where)
{
    $ci = & get_instance();
    $ci->db->select('*');
    $ci->db->where($where);
    return $ci->db->get($table)->result_array();
}

    // ------------------------------
    // Get currency symbol by ID

function get_currency_symbol($id)
{
    $ci = & get_instance();
    $ci->db->select('symbol');
    $ci->db->where('id',$id);
    return $ci->db->get('ci_currency')->row_array()['symbol'];
}

    // ------------------------------
    // Get currency symbol by ID

function get_currency_short_code($id)
{
    $ci = & get_instance();
    $ci->db->select('code');
    $ci->db->where('id',$id);
    return $ci->db->get('ci_currency')->row_array()['code'];
}

    // get user profile photo by id
    // ------------------------------------------

function get_user_profile_photo($id)
{
    $ci =& get_instance();
    $ci->db->select('profile_picture');
    $ci->db->where('id',$id);
    $photo =  $ci->db->get('ci_users')->row_array()['profile_picture'];
    if($photo)
        return $photo;
    else
        return 'assets/img/user.jpg';
}

    // get ad thumbnail photo
    // ------------------------------------------

function get_ad_thumbnail_photo($ad_id)
{
    $ci =& get_instance();
    $ci->db->select('img_1');
    $ci->db->where('id',$ad_id);
    $photo =  $ci->db->get('ci_ads')->row_array()['img_1'];
    if($photo)
        return $photo;
    else
        return 'assets/img/user.jpg';
}

function get_tnc()
{
    $ci =& get_instance();
    $ci->db->select('terms_and_conditions');
    $ci->db->where('id',1);
    return $ci->db->get('ci_general_settings')->row_array()['terms_and_conditions'];
}

    // blog


    //  get blog categories
function get_blog_categories_list()
{
    $ci = & get_instance();
    return $ci->db->get('ci_blog_categories')->result_array();
}

    //  get blog posted categories
function get_blog_posted_categories_list()
{
    $ci = & get_instance();
    $ci->db->select('
        ci_blog_posts.category_id,
        ci_blog_categories.id,
        ci_blog_categories.slug,
        ci_blog_categories.name
        ');
    $ci->db->join('ci_blog_posts','ci_blog_posts.category_id = ci_blog_categories.id');
    $ci->db->group_by('ci_blog_posts.category_id');
    return $ci->db->get('ci_blog_categories')->result_array();
}

    // -----------------------------------------------------------------------------
    // 
function get_blog_categories_name($id)
{
    $ci = & get_instance();
    return $ci->db->get_where('ci_blog_categories', array('id' => $id))->row_array()['name'];
}

function get_post_tags_by_id($ad_id)
{
    $ci = & get_instance();
    return $ci->db->select('*')
    ->where(array('post_id' => $ad_id))
    ->get('ci_blog_tags')
    ->result_array();
}

function get_tags_list()
{
    $ci = & get_instance();
    return $ci->db->select('*')
    ->group_by('tag')
    ->get('ci_blog_tags')
    ->result_array();
}

function get_recent_blog_post()
{
    $ci = & get_instance();
    return $ci->db->select('*')
    ->order_by('created_at','desc')
    ->limit(4)
    ->get('ci_blog_posts')
    ->result_array();
}

function get_next_post($current_ad_id)
{
    $ci = & get_instance();
    return $ci->db->select('*')
    ->where('id >',$current_ad_id)
    ->limit(1)
    ->get('ci_blog_posts')
    ->row_array();
}

function get_previous_post($current_ad_id)
{
   $ci = & get_instance();
   return $ci->db->select('*')
   ->where('id <',$current_ad_id)
   ->limit(1)
   ->get('ci_blog_posts')
   ->row_array();
}

    // Custom fields

function get_feild_name_by_id($id)
{
    $ci = & get_instance();
    return $ci->db->select('name')
    ->where('id',$id)
    ->get('ci_fields')
    ->row_array()['name'];
}

function get_feild_slug_by_id($id)
{
    $ci = & get_instance();
    return $ci->db->select('slug')
    ->where('id',$id)
    ->limit(1)
    ->get('ci_fields')
    ->row_array()['slug'];
}

    // Just for Filters 
    //
function get_field_options_for_filter($field_id)
{
    $ci = & get_instance();
    $ci->db->select('*');
    $ci->db->where('parent_field',$field_id);
    return $ci->db->get('ci_field_options')->result_array();
}

    // if field type contain options then get selected value by field id 
    //otherwise return value

function get_feild_value($field_value_id)
{
    $ci = & get_instance();
    $result = $ci->db->select('*')
    ->where('id',$field_value_id)
    ->get('ci_field_options');
    if($result->num_rows() > 0)
    {
        return $result->row_array()['name'];
    }
    else
    {
        return $field_value_id;
    }
}
    /*---------------------------
        SIDE WIDGETS FUNCTIONS
        /---------------------------*/

        function posts_by_user_location($country_id)
        {
            $ci = & get_instance();

            $ci->db->select('state as state_id, COUNT(state) as total_posts');

            $ci->db->from('ci_ads');

            $ci->db->where('is_status',1);

            $ci->db->where('country',$country_id);

            $ci->db->group_by('state');

            $query = $ci->db->get();

            return $query->result_array();
        }

        function posts_by_countries()
        {
            $ci = & get_instance();

            $ci->db->select('country as country_id, COUNT(country) as total_posts');

            $ci->db->from('ci_ads');

            $ci->db->where('is_status',1);

            $ci->db->group_by('country');

            $query = $ci->db->get();

            return $query->result_array();
        }

        function posts_by_category()
        {
            $ci = & get_instance();

            $ci->db->select('category as category_id, COUNT(category) as total_posts');

            $ci->db->from('ci_ads');

            $ci->db->where('is_status',1);

            $ci->db->group_by('category');

            $query = $ci->db->get();

            return $query->result_array();
        }

        function posts_by_subcategory($id)
        {
            $ci = & get_instance();

            $ci->db->select('subcategory as subcategory_id, COUNT(subcategory) as total_posts');

            $ci->db->from('ci_ads');

            $ci->db->where('is_status',1);

            $ci->db->where('subcategory',$id);

            $ci->db->group_by('category');

            $query = $ci->db->get();

            return $query->result_array();
        }

    // print post type
        function get_featured_label($is_featured)
        {
            if($is_featured == 1)
            {
                return 'Destacados';
            }
            else if($is_featured == 2)
            {
                return 'Hot Item';
            }
            else
            {
                return false;
            }
        }

    // print ad status
        function get_ad_status($status)
        {
            if($status == 1)
            {
                return 'Active';
            }
            else if($status == 2)
            {
                return 'Expired';
            } 
            else if($status == 3)
            {
                return 'Sold';
            }
            else
            {
                return 'Inactive';
            }
        }

    // Packages

        function is_featured_package($package_id)
        {
            $ci = & get_instance();

            $ci->db->select('MAX(price) as mprice');

            $ci->db->from('ci_packages');

            $ci->db->where('is_active',1);

            $max_price = $ci->db->get()->row_array()['mprice'];

        //

            $ci->db->select('price');

            $ci->db->from('ci_packages');

            $ci->db->where('id',$package_id);

            $ci->db->where('is_active',1);

            $result = $ci->db->get()->row_array();


            if($result['price'] > 0 && $result['price'] < $max_price)
            {
                return 1;
            }
            elseif($result['price'] == $max_price)
            {
                return 2;
            }
            else
            {
                return 0;
            }
        }

        function create_package_expiry_date($package_id)
        {
            $ci = & get_instance();

            $ci->db->select('no_of_days');

            $ci->db->from('ci_packages');

            $ci->db->where('id',$package_id);

            $days = $ci->db->get()->row_array()['no_of_days'];

            return date('Y-m-d H:i:s',strtotime('+'.$days.' days'));
        }

    // Rating

        function get_post_rating($ad_id, $place="")
        {
            $ci = & get_instance();

            $ci->db->select('SUM(rating) as rating_sum, COUNT(rating) as total_ratings');

            if ($place=="users") {

                $ci->db->from('ci_users_rating');

                $ci->db->where('profile_id',$ad_id);
            } else {

                $ci->db->from('ci_ad_rating');

                $ci->db->where('ad_id',$ad_id);
            }

            $query = $ci->db->get();

            if($query->num_rows() > 0)
            {
                $result = $query->row_array();
                $sum = $result['rating_sum'];
                $total = ($result['total_ratings']) ? $result['total_ratings'] : 1;
                return $sum / $total;
            }
            else
            {
                return 0;
            }
        }

        function get_post_rating_by_user($user_id,$ad_id)
        {
            $ci = & get_instance();

            $ci->db->select('rating');

            $ci->db->from('ci_ad_rating');

            $ci->db->where('ad_id',$ad_id);

            $ci->db->where('user_id',$user_id);

            $query = $ci->db->get();

            if($query->num_rows() > 0)
            {
                return $query->row_array()['rating'];
            }
            else
            {
                return 0;
            }
        }

        function update_admin_view_status($table,$id)
        {
            $ci = & get_instance();

            $ci->db->where('id',$id);

            $ci->db->update($table,array('admin_view' => 1));
        }

        function get_chat_buyer_and_seller($ad_id)
        {
            $ci = & get_instance();
            $ci->db->select('sender,receiver')
            ->where('ad',$ad_id)
            ->order_by('id','asc')
            ->limit(1);
            $row = $ci->db->get('ci_inbox');
            if($row->num_rows() > 0)
                return $row->row_array();
            else
                return false;
        }
        ?>