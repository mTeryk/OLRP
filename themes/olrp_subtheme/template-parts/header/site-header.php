<?php
/**
 * Displays the site header.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

$wrapper_classes  = 'site-header';
$wrapper_classes .= has_custom_logo() ? ' has-logo' : '';
$wrapper_classes .= ( true === get_theme_mod( 'display_title_and_tagline', true ) ) ? ' has-title-and-tagline' : '';
$wrapper_classes .= has_nav_menu( 'primary' ) ? ' has-menu' : '';
?>

<header id="masthead" class="<?php echo esc_attr( $wrapper_classes ); ?>" role="banner">
	<?php get_template_part( 'template-parts/header/site-branding' ); ?>
	<div class="tag_cloud_container">

	<?php
	/*
	 * TEST SQL Query
	 *
SELECT wp_terms.term_id,wp_terms.name,wp_terms.slug, wp_term_taxonomy.count FROM `wp_terms`
INNER JOIN wp_term_taxonomy ON wp_terms.term_id = wp_term_taxonomy.term_id
INNER JOIN wp_term_relationships ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id
WHERE wp_term_taxonomy.taxonomy = 'post_tag' AND wp_term_relationships.object_id = '135'

	https://developer.wordpress.org/reference/classes/wp_term_query/

*/
	$post_ids = array();
	while ( have_posts() ) :
		the_post();
		$post_ids[] = get_post()->ID;
	endwhile;

$args = array(
	'taxonomy'               => array( 'post_tag' ),
	'fields'                 => 'all',
	'object_ids'			 => $post_ids
);

$term_query = new WP_Term_Query( $args );
$terms = $term_query->get_terms();


foreach($terms as $term)
{
	$term->link = get_term_link($term);
}


$tags = wp_generate_tag_cloud($terms,array('order' => 'RAND'));
echo ($tags);
?>

</div>
	<div style="width:60%"><h3 style="float:right; text-align:right;width:100%;min-width:200px;"><a target="_blank" href="https://docs.google.com/document/d/1XtKeWG1KbtdJ0VqW2Ls9DAMlnycWj9oCP68wv9ghreU/edit?usp=sharing">About</a></h3></div>
	<?php get_template_part( 'template-parts/header/site-nav' ); ?>

</header><!-- #masthead -->

