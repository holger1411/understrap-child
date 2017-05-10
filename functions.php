<?php
function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {

	// Get the theme data
	$the_theme = wp_get_theme();

    wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $the_theme->get( 'Version' ), true );


 
   $query_args = array(
		'family' => 'Open+Sans|Oswald|Dosis|Roboto+Slab|Roboto:100|Raleway|Biryani:200|Work+Sans:200|Rajdhani:400',
		'subset' => 'latin,latin-ext',
	);
	
	
	wp_enqueue_style( 'google_fonts', add_query_arg( $query_args, "//fonts.googleapis.com/css" ), array(), null );
	wp_enqueue_style( 'fontscom',  "//fast.fonts.net/cssapi/996199d0-ca5a-4ed0-97ce-87cc0efa7e8b.css" ,array(), null ); 
    

}

function get_wp_gallery_ids($post_content) {
	
			 //$post_content = $post->post_content;
			 preg_match('/\[gallery.*ids=.(.*).\]/', $post_content, $ids);
}


function title_header (){
	

	?>
	<span class="keyline"></span>
		    		<span class="navmnth">0</span>
		    		<span class="nav-point">.</span>
		    		<span id="article-number" class="navyr">62</span>
					<span class="keyline"></span>
		    		<span class="sub-article">
		    			<span class="subarticle"><?php the_title(); ?></span><span class="sub-article-wrap"><span class="sub-subarticle sub"></br></span></span>
		    		</span>
		 <?php
}

function digidol_site_title() {
    do_action('digidol_site_title');
} // end digidol_site_title

add_action('digidol_site_title','title_header');


function digidol_hero() {
    do_action('digidol_hero');
} // end digidol_hero
// my gallery function, add options to turn on or off caption. // add option to turn on cover text page fed from the post_content.
function digidol_gallery_carousel() {
	global $post;
	$the_content =  $post->post_content;
	$the_content = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $the_content);  # strip shortcodes, keep shortcode content
	//remove_shortcode( 'gallery' );
	//$new_content = apply_filters('the_content',$the_content);
	//echo $new_content;  

	
	
	
	preg_match('/\[gallery.*ids=.(.*).\]/', $post->post_content, $ids);
	if ($ids) {
	$attachments = explode(",", $ids[1]);
	?>
	
	
	<div class="wrapper" id="wrapper-hero">
	<div class="container-fluid" id="hero-slides">
		<div id="carouselExampleControls" class="carousel slide" data-interval="false">
		<div class="wrapper" id="month-wrap">
			<div class="container">
				<div class="monthind hidden-md-down">
		<div class="month"><?php echo date('m'); ?></div>
		<div class="counterkeyline"></div>
		<div class="yearicon"><?php echo date('y');?></div>
	</div>
			</div>
		</div>
		<div class="carousel-inner" role="listbox">	
			
			<?php
				
		$loopcount = 1;		
	if ($attachments) {
		foreach ( $attachments as $attachment ) {
	
		$imagethumbnail = wp_get_attachment_image_src($attachment, 'full');
		$imag_alt = get_post_meta($attachment, '_wp_attachment_image_alt', true);
		
		?>
	
				
					<div class="carousel-item <?php if ($loopcount == 1) { echo 'active'; }; ?>">			
						
							<img src="<?php echo $imagethumbnail[0]; ?>" alt="<?php echo $imag_alt;?>" />
							
						
					</div>		
					
							
						<?php $loopcount++;
		}
	}
						?>
										</div>


			</div>
		</div>
		
	</div>
						<?php
	
	}
}

add_action('digidol_hero','digidol_gallery_carousel');


function child_theme_setup() {

	// Make sure featured images are enabled
	
		
	// Add other useful image sizes for use through Add Media modal
	add_image_size( 'folio-image', 1110 );
	add_image_size( 'grid-image', 890,500, true );
	add_image_size('archive-thumb',208,116, true);
	
	
	// Register the three useful image sizes for use in Add Media modal
	add_filter( 'image_size_names_choose', 'wpshout_custom_sizes' );
	function wpshout_custom_sizes( $sizes ) {
	    return array_merge( $sizes, array(
	        'folio-image' => __( 'Folio Image 1110' ),
	    ) );
	}
}
add_action( 'after_setup_theme', 'child_theme_setup', 11 );

// Add the Month motif function

function month_motif(){
	
if (is_single()){
?>
	
	<div class="monthind">
		<div class="month"><?php echo the_date('m'); ?></div>
		<div class="counterkeyline"></div>
		<div class="yearicon"><?php echo the_time('y');?></div>
	</div>
<?php	}
else
{
?>
	<div class="wrapper-fluid monthmotif">
	<div class="container monthind">
		<div class="month"><?php echo date('m'); ?></div>
		<div class="counterkeyline"></div>
		<div class="yearicon"><?php echo date('y'); ?></div>
	</div>
	</div>
<?php
}
}

function insert_month_motif(){
	do_action('insert_month_motif');
}// insert month motif

add_action('insert_month_motif','month_motif');

function updateNumbers() {
/* numbering the published posts: preparation: create an array with the ID in sequence of publication date, /
/ save the number in custom field 'incr_number' of post with ID /
/ to show in post (within the loop) use <?php echo get_post_meta($post->ID,'incr_number',true); ?>
/ alchymyth 2010 */
global $wpdb;
$querystr = "SELECT $wpdb->posts.* FROM $wpdb->posts WHERE $wpdb->posts.post_status = 'publish' AND $wpdb->posts.post_type = 'post' ";
$pageposts = $wpdb->get_results($querystr, OBJECT);
$counts = 0 ;
if ($pageposts):
foreach ($pageposts as $post):
setup_postdata($post);
$counts++;
add_post_meta($post->ID, 'incr_number', $counts, true);
update_post_meta($post->ID, 'incr_number', $counts);
endforeach;
endif;
}
add_action ( 'publish_post', 'updateNumbers' );
add_action ( 'deleted_post', 'updateNumbers' );
add_action ( 'edit_post', 'updateNumbers' );
