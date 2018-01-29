<?php get_header(); ?>

<div class="inner-wrap">

    <main id="main" class="site-main" role="main">

        <h2 class="section-title"><?php _e('Error 404', 'wpzoom'); ?></h2>

        <section class="recent-posts">

            <?php get_template_part( 'content', 'none' ); ?>

        </section><!-- .recent-posts -->

        <?php get_sidebar(); ?>

    </main><!-- .site-main -->

</div>
<?php
get_footer();
