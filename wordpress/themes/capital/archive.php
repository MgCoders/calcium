<?php get_header();
    if (is_author()) {
        $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
    }
?>

<div class="inner-wrap">

    <main id="main" class="site-main" role="main">

        <h2 class="section-title"><?php /* category archive */ if (is_category()) { ?> <?php single_cat_title(); ?>
                <?php /* tag archive */ } elseif( is_tag() ) { ?><?php _e('Post Tagged with:', 'wpzoom'); ?> "<?php single_tag_title(); ?>"
                <?php /* daily archive */ } elseif (is_day()) { ?><?php _e('Archive for', 'wpzoom'); ?> <?php the_time('F jS, Y'); ?>
                <?php /* monthly archive */ } elseif (is_month()) { ?><?php _e('Archive for', 'wpzoom'); ?> <?php the_time('F, Y'); ?>
                <?php /* yearly archive */ } elseif (is_year()) { ?><?php _e('Archive for', 'wpzoom'); ?> <?php the_time('Y'); ?>
                <?php /* author archive */ } elseif (is_author()) { ?><?php _e( ' Articles by: ', 'wpzoom' ); echo $curauth->display_name; ?>
                <?php /* paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?><?php _e('Archives', 'wpzoom'); ?>
                <?php /* home page */ } elseif (is_front_page()) { ?><?php _e('Recent Posts','wpzoom');?> <?php } ?></h2>

        <section class="recent-posts">

            <?php if ( have_posts() ) : ?>

                <?php while ( have_posts() ) : the_post(); ?>

                    <?php

                    get_template_part( 'content', get_post_format() );
                    ?>

                <?php endwhile; ?>

                <?php get_template_part( 'pagination' ); ?>

            <?php else: ?>

                <?php get_template_part( 'content', 'none' ); ?>

            <?php endif; ?>

        </section><!-- .recent-posts -->

        <?php get_sidebar(); ?>

    </main><!-- .site-main -->

</div>
<?php
get_footer();
