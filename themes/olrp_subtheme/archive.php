<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

$description = get_the_archive_description();
?>

<?php if ( have_posts() ) : ?>

	<header class="page-header alignwide">
		<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
		<?php if ( $description ) : ?>
			<div class="archive-description"><?php echo wp_kses_post( wpautop( $description ) ); ?></div>
		<?php endif; ?>
	</header><!-- .page-header -->

	<div class="olrp_resource_archive">  <table class="olrp_display_table display compact" style="width:100%"><thead><th>Title</th><th>URL</th><th>Creator</th><th>Summary</th><th>Tags</th></thead>

		<?php while ( have_posts() ) : ?>

			<?php
			//TODO Replace this with shortcodes
			the_post();
			$post = get_post();
			$output = "";
			$meta = get_post_meta($post->ID);
			$url = $meta['olrp-resource-url'][0];
			$creators = get_the_term_list($post->ID,'creator');
			$summary = $meta['olrp-resource-summary'][0];
			$title = get_the_title($post);
			$tags_obj = get_the_tags($post);
			$tags_str = "";
			if ($tags_obj) {
				foreach ($tags_obj as $tag) {
					$name = $tag->name;
					$tags_str .= "<a href=\"?tag=$name\"> $name </a> , ";
				}
			}
			$discussion = get_permalink($post);


			$output .= "<tr>";
			//$output .= "<td><a target=\"_blank\" href=\" $discussion \"> $title </a></td>";
			$output .= "<td><a href=\" $discussion \"> $title </a></td>";
			$output .= "<td>$url</td>";
			$output .= "<td> $creators </td>";
			$output .= "<td> $summary </td>";
			$output .= "<td> $tags_str </td>";
			//$output .= "<td><a href=\" $discussion \"> More Info</a></td>";
			$output .= "</tr>";

			echo ($output);
			?>
		<?php endwhile; ?>

	</table> </div> <!-- olrp_resource_archive-->

	<?php twenty_twenty_one_the_posts_navigation(); ?>

<?php else : ?>
	<?php get_template_part( 'template-parts/content/content-none' ); ?>
<?php endif; ?>

<?php get_footer(); ?>
