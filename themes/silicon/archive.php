<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Silicon
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<?php if (WP_DEBUG) echo  "I'm archive.php" ?>

    <div class="container-fluid">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">

	<?php if ( have_posts() ) : ?>
        <div class="row">
            <div class="col-12">
                <h2 class="si-h2 row-title-news si-text-purple">&nbsp;<?php _e(single_term_title(), 'silicon' ); ?></h2>
            </div>
        </div>
        <div id="news" class="row justify-content-end">
            <div class="col-lg-3 col-md-5 col-sm-8 align-self-end notInst">

                <?php
                // Get the ID of a given category
                $idCategoryInst = get_cat_ID( 'institucionales' );
                $idCategoryCoop = get_cat_ID( 'cooperativas' );

                // Get the URL of this category
                $linkCategoryInst = get_category_link( $idCategoryInst );
                $linkCategoryCoop = get_category_link( $idCategoryCoop );
                ?>

                <h4  class="right-align-text si-a"><a href="<?php echo esc_url( $linkCategoryInst ); ?>" title="INSTITUCIONALES">INSTITUCIONALES</a> | <a href="<?php echo esc_url( $linkCategoryCoop ); ?>" title="COOPERATIVAS">COOPERATIVAS</a></h4>
            </div>
        </div>
	<?php endif; ?>



		<?php
		if ( have_posts() ) : ?>
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

        if ( $wp_query->current_post != 0 and $wp_query->current_post % 4 == 0    ) {
        ?> </div>  <!-- .row --> <?php
    }


    if ($wp_query->current_post % 4 == 0) {
    ?> <div class="row"> <?php

            }

            show_posts_lists();

			endwhile;

			the_posts_pagination( array(
				'prev_text' => silicon_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'silicon' ) . '</span>',
				'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'silicon' ) . '</span>' . silicon_get_svg( array( 'icon' => 'arrow-right' ) ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'silicon' ) . ' </span>',
			) );

		else :

			get_template_part( 'template-parts/post/content', 'none' );

		endif; ?>

		</main><!-- #main -->
        </div><!-- #primary -->
	<?php //get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();
