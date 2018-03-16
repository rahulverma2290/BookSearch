<?php
/*
Plugin Name: Library Book Search Plugin
Plugin URI: www.librarybooksearch.com
Author: Rahul Verma
Author URI: www.rahulverma.com
Version: 1.2.3
Description: Plugin for book search functionality. Where end users search books in the different parameter like Book Name, Author, and price etc.
*/
?>
<?php

/*
 Creating Custom Post Type For Books
*/

function custom_post_type() {

// Set UI labels for Books Custom Post Type

    $labels = array(
        'name'                => _x( 'Books', 'Post Type General Name', 'twentyseventeen_child' ),
        'singular_name'       => _x( 'Book', 'Post Type Singular Name', 'twentyseventeen_child' ),
        'menu_name'           => __( 'Books', 'twentyseventeen_child' ),
        'parent_item_colon'   => __( 'Parent Book', 'twentyseventeen_child' ),
        'all_items'           => __( 'All Book', 'twentyseventeen_child' ),
        'view_item'           => __( 'View Book', 'twentyseventeen_child' ),
        'add_new_item'        => __( 'Add New Book', 'twentyseventeen_child' ),
        'add_new'             => __( 'Add New', 'twentyseventeen_child' ),
        'edit_item'           => __( 'Edit Book', 'twentyseventeen_child' ),
        'update_item'         => __( 'Update Book', 'twentyseventeen_child' ),
        'search_items'        => __( 'Search Book', 'twentyseventeen_child' ),
        'not_found'           => __( 'Not Found', 'twentyseventeen_child' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentyseventeen_child' ),
    );
     
// Set other options for Books Custom Post Type
     
    $args = array(
        'label'               => __( 'books', 'twentyseventeen_child' ),
        'description'         => __( 'Book news and reviews', 'twentyseventeen_child' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        'taxonomies'          => array( '' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );

    register_post_type( 'books', $args );
 
}
 
add_action( 'init', 'custom_post_type', 0 );

/* Custom Taxonomoies For Authors*/

function themes_taxonomy() {
    register_taxonomy(  
        'authors',
         array('books'),
        array(
            'hierarchical' => true,
            'label' => 'Authors Tax',
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'authors',
                'with_front' => false
            )
        )
    );
}

add_action( 'init', 'themes_taxonomy');

/* Custom Taxonomoies For Publishers */

function custom_themes_taxonomy() {
    register_taxonomy(  
        '​publisher',
         array('books'),
        array(
            'hierarchical' => true,
            'label' => '​Publisher Tax',
            'query_var' => true,
            'rewrite' => array(
                'slug' => '​publisher',
                'with_front' => false
            )
        )
    );
}

add_action( 'init', 'custom_themes_taxonomy');


function actionnew(){

$pricepost = $_POST['price'];
$authorpost = $_POST['authors'];
$publisherpost = $_POST['publisher'];
$posttitle = $_POST['title'];

global $wpdb;

$taxonomies = get_object_taxonomies('books');

//print_r($taxonomies);

$categories = get_terms($taxonomies);

foreach($categories as $category){
	$term = $category->name;
}

$count = count($term);
global $post;
$year = get_post_meta(get_the_ID() , 'price', true); //custom field

global $wpdb;

$post_id = "SELECT DISTINCT $wpdb->posts.post_title, $wpdb->posts.ID FROM $wpdb->term_taxonomy AS $wpdb->term_taxonomy
INNER JOIN $wpdb->terms AS $wpdb->terms ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id
INNER JOIN $wpdb->term_relationships AS $wpdb->term_relationships ON $wpdb->term_taxonomy.term_taxonomy_id = $wpdb->term_relationships.term_taxonomy_id
INNER JOIN $wpdb->posts AS $wpdb->posts ON $wpdb->term_relationships.object_id = $wpdb->posts.ID
INNER JOIN $wpdb->postmeta AS meta ON $wpdb->posts.ID = meta.post_id
WHERE $wpdb->posts.post_status =  'publish'
AND meta.meta_key =  'price'
AND meta.meta_value =  '$pricepost'
AND $wpdb->posts.post_type =  'books'
OR $wpdb->terms.name =  '$authorpost' OR $wpdb->terms.name =  '$publisherpost' OR $wpdb->posts.post_title =  '$posttitle' ";

//echo "<pre>";print_r($post_id);
$my_posts = $wpdb->get_results($post_id);
// echo "<pre>";print_r($my_posts);
global $post;

if ( $my_posts )
{
	foreach ( $my_posts as $postnew )
	{
		$newid = $postnew->ID;
		$post = get_post( $newid );
		setup_postdata( $post );
		//echo "<pre>"; print_r($post);
		?>
		<h2>
			<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permalink: <?php the_title(); ?>">
				<?php the_title(); ?>
			</a>
		</h2>
		<?php
	}	
}
else
{
	?>
	<h2>Not Found</h2>
	<?php
}
wp_die();
}
add_action("wp_ajax_nopriv_actionnew", "actionnew");
add_action("wp_ajax_actionnew", "actionnew");


function frontend_form($form){
?>
	<h1>Search For Books.......</h1>

<?php

/* For Custom Field Price*/

$sm_query = new WP_Query( array( 'post_type' => 'books', 'posts_per_page' => '-1' ) );

// The Loop
if ( $sm_query->have_posts() ) {
    $prices = array();
    while ( $sm_query->have_posts() ) {
        $sm_query->the_post();
        $price = get_post_meta( get_the_ID(), 'price', true );

        if( !in_array( $price, $prices ) ){
            $prices[] = $price;    
        }
    }
  }
	 else{
       echo 'No accommodations yet!';
       return;
}

wp_reset_postdata();

if( count($prices) == 0){
    return;
}

$select_price = '<select name="price" id="price" style="width: 100%">';
$select_price .= '<option value="" selected="selected">' . __( 'Select Price', 'smashing_plugin' ) . '</option>';
foreach ($prices as $pricenew => $value) {
    $select_price .= '<option value="' . $value . '">' . $value . '</option>';
}
$select_price .= '</select>' . "\n";

/* For Custom Taxonomy */

function buildSelect($tax){
	$terms = get_terms($tax);

	$x = '<select id="booktax" name="'. preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $tax) .'">';
	$x .= '<option value="">Select '.preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $tax).'</option>';
	foreach ($terms as $term) {
	   $x .= '<option value="'.$term->slug.'">'.$term->name.'</option>';
	}
	$x .= '</select>';

	return $x;
}

?>

<form method="POST" id="searchform">
	<select id="booktitle" name="title" >
	<option value="">Select Title</option>
		 <?php
			 $posts = new WP_Query(array('post_type' => 'books', 'order' => 'ASC', 'posts_per_page' => '-1')); 
			 while($posts->have_posts()) : $posts->the_post();
		 ?>
			 <option id="selectiontitle" value="<?php echo the_title(); ?>"><?php echo get_the_title(); ?></option>
		 <?php endwhile; ?>
	</select>
		<?php
			$taxonomies = get_object_taxonomies('books');
			foreach($taxonomies as $tax){
				echo buildSelect($tax);
			}
		?>
		<?php echo $select_price; ?>
	<input type="hidden" name="s" value="" />
	<input type="button" name="submit" value="Search" class="button" />
</form>
<h1>Search Result Is :-</h1>
<div id="users_data"><h2></h2></div>
<?php
//return $output;

}

add_shortcode('book_search','frontend_form');

wp_enqueue_script('jquery', plugins_url('js/jquery.js', __FILE__), array('jquery'), '', true);

wp_enqueue_script('custom', plugins_url('js/customjs.js', __FILE__), array('jquery'), '', true); // ajax script file...

wp_localize_script( 'custom', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) ); //including admin-ajax.php in website html


?>