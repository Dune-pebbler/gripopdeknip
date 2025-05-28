<?php
# DEFINES
define('GRIP_OP_DE_KNIP_PATH', get_template_directory());
define('GRIP_OP_DE_KNIP_URL', get_template_directory_uri());
# REQUIRES

# ACTIONS
add_action('admin_enqueue_scripts', 'ds_admin_theme_style');
add_action('login_enqueue_scripts', 'ds_admin_theme_style');
add_action('wp_enqueue_scripts', 'theme_enqueue_jquery');
# FILTERS
add_filter('wp_page_menu_args', 'home_page_menu_args');
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10);
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10);
add_filter('the_content', 'remove_thumbnail_dimensions', 10);
add_filter('the_content', 'add_image_responsive_class');
add_filter('upload_mimes', 'cc_mime_types');
add_filter('use_block_editor_for_post', '__return_false');
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');
add_filter('acf/settings/save_json', 'my_acf_json_save_point');
add_filter('acf/settings/load_json', 'my_acf_json_load_point');

# THEME SUPPORTS
add_theme_support('menus');
add_theme_support('post-thumbnails'); // array for post-thumbnail support on certain post-types.

# IMAGE SIZES
add_image_size('default-thumbnail', 128, 128, true); // true: hard crop or empty if soft crop

set_post_thumbnail_size(128, 128, true);

# FUNCTIONS
register_nav_menus(array(
    'primary' => __('Primary Menu', 'THEME'),
    'top-header-1' => __('Top Header Menu', 'THEME'),
    'footer-1' => __('Footer 1 Menu', 'THEME'),
    'footer-2' => __('Footer 2 Menu', 'THEME'),
    'footer-3' => __('Footer 3 Menu', 'THEME'),
    'footer-4' => __('Footer 4 Menu', 'THEME'),
));

if( !function_exists('get_svg') ) {
  function get_svg( $stylesheet_path ){
    $template_directory = get_template_directory();

    if( strpos($stylesheet_path, get_template_directory_uri() ) !== false ){
      $stylesheet_path = str_replace( get_template_directory_uri(), '', $stylesheet_path );
    }

    if( strpos($stylesheet_path, '/uploads/') !== false ){
      if( file_exists(str_replace(site_url(), getcwd(), $stylesheet_path)) )
        return file_get_contents(str_replace(site_url(), getcwd(), $stylesheet_path));
    } 

    return file_get_contents( "{$template_directory}/{$stylesheet_path}" );
  }
}

// a function that check if an url is an svg file
function is_svg($url) {
  $extension = pathinfo($url, PATHINFO_EXTENSION);
  return $extension == 'svg';
}

if( !function_exists('get_webp')){
  function get_webp($url){
    if( !file_exists( 
      str_replace(site_url(), getcwd(),
        str_replace([".jpg", ".png"], [".webp", ".webp"], $url) 
      )
      ) ){
      return $url;
    }
  
    return str_replace([".jpg", ".png"], [".webp", ".webp"], $url);
  }
}
 
if( !function_exists('dump') ){
  // I use this function in all my plugins, so better check if it already exists.
  function dump(){
      $numargs = func_num_args();
      $arg_list = func_get_args();
     
      echo "
      <style>
      .debugger{
        position: fixed; 
        top: 0; 
        left: 0; 
        width: 100%; 
        height: 100%; 
        background-color: rgba(0, 0, 0, .5); 
        z-index: 9000000;
        overflow: auto;
      }

      .debugger > code{
        max-width: 768px; margin: 0 auto;
        display: block;
        padding: 25px;
        background-color: #fff;
        overflow: hidden;
      }

      .debugger code span{
        white-space: normal; 
      }
      </style>
      ";
      echo "<pre class='debugger'>";
      for ($i = 0; $i < $numargs; $i++) {
        ob_start();
        // dump arg
        var_dump( $arg_list[$i] );
        // append highlight to dump
        echo highlight_string( "<?php " . ob_get_clean() . " ?>", true );
      }
      
      echo "</pre>";
  }
  
}


if( !function_exists('print_pre') ){
  function print_pre() {
    $numargs = func_num_args();
    $arg_list = func_get_args();
   
    // clean the output buffer before we start.
    // ob_clean();
    // restart the output buffer
    ob_start();

    echo "<pre>";

    for ($i = 0; $i < $numargs; $i++) {    
        // dump arg
        print_r( $arg_list[$i] );
    }

    echo ob_get_clean() . "</pre>";
  }
}

function theme_enqueue_jquery(){
  wp_enqueue_script('jquery');
}

function my_acf_json_save_point( $path ) {
    // update path
    $path = get_stylesheet_directory() . '/acf';
    
    
    // return
    return $path;  
}

function my_acf_json_load_point( $paths ) {
    
  // remove original path (optional)
  unset($paths[0]);
  
  
  // append path
  $paths[] = get_stylesheet_directory() . '/acf';
  
  
  // return
  return $paths;
  
}


function home_page_menu_args($args) {
  $args['show_home'] = true;
  return $args;
}

function remove_thumbnail_dimensions($html) {
  $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
  return $html;
}

function remove_width_attribute($html) {
  $html = preg_replace('/(width|height)="\d*"\s/', "", $html);
  return $html;
}

function add_image_responsive_class($content) {
  global $post;
  $pattern = "/<img(.*?)class=\"(.*?)\"(.*?)>/i";
  $replacement = '<img$1class="$2 img-responsive"$3>';
  $content = preg_replace($pattern, $replacement, $content);
  return $content;
}

function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}

function ds_admin_theme_style() {
  if (!current_user_can('manage_options')) {
    echo '<style>.update-nag, .updated, .error, .is-dismissible { display: none; }</style>';
  }
}

function get_faq_query( $category = null ){
  $args = [
    'post_type' => 'faq',
    'posts_per_page' => -1,
    'orderby' => 'post_title',
  ];

  $query = new WP_Query($args);

  return $query;
}

function get_titels_by_content( $id = null){
  return extract_titels( get_the_content($id) );
}

function extract_titels( $html ){
  $document = new DOMDocument();
  $document->loadHTML("<html><body>{$html}</body></html>");
  $titels = [];

  foreach($document->getElementsByTagName('h2') as $element){
    $titels[] = $element->nodeValue;
  }

  return $titels;
}

// Method 1: Filter.
function my_acf_google_map_api( $api ){
  $api['key'] = '';
  return $api;
}

# Random code

// add editor the privilege to edit theme
// get the the role object
$role_object = get_role('editor');
// add $cap capability to this role object
$role_object->add_cap('edit_theme_options');

if( function_exists('acf_add_options_sub_page') ){
  acf_add_options_page();
  acf_add_options_sub_page( 'Footer' );
//     acf_add_options_sub_page( 'Side Menu' );
}
?>
