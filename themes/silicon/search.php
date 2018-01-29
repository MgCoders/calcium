<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Silicon
 * @since 1.0
 * @version 1.0
 */

get_header();
global $wp_query;

$posts = get_posts([
    'posts_per_page' => -1
]);

// adds posts to corresponding cat key
$sorted_ids_by_cat = [];
foreach ($posts as $post) {
    $cats = wp_get_post_categories($post->ID);
    foreach ($cats as $cat) {
        $sorted_ids_by_cat[$cat][] = $post->ID;
    }
}



// foreach key merge it to the new post_ids array
$sorted_post_ids = [];
foreach ($sorted_ids_by_cat as $cat_array) {
    $sorted_post_ids = array_merge($sorted_post_ids, $cat_array);
}

// run it through wp_query so it works properly with a normal search page
$wp_query = new WP_Query([
    'posts_per_page' => -1,
    'posts__in' => $sorted_post_ids
]);

?>

    <div class="container-fluid si-light-grey">
        <div class="row">
            <div class="col"></div>
            <div class="col-md-9">
                <?php if (have_posts()) : ?>
                    <h2 class="si-text-purple titulo-resultado-busqueda"><?php printf(__('Resultados de Búsqueda', 'silicon'), '<span>' . get_search_query() . '</span>'); ?></h2>
                <?php else : ?>
                    <h2 class="si-text-purple titulo-resultado-busqueda"><?php _e('No hubo resultados', 'silicon'); ?></h2>
                <?php endif; ?>
            </div>
            <div class="col"></div>
        </div>


        <div class="row">
            <div class="col"></div>
            <div class="col-md-9">


                <?php
                if (have_posts()) :
                    /* Start the Loop */
                    //Categoria actual ninguna
                    $catid = -1;
                    while (have_posts()) : the_post();
                        //Busco categorias del post
                        $cats = wp_get_post_categories($post->ID);
                        //Me quedo con la primera
                        $postcat = -1;
                        if (count($cats) >= 1) {
                            $postcat = $cats[0];
                        }
                        //Si cambia la categoría o si es la primera imprimo.
                        if ($catid == -1 || $postcat != $catid) {
                            ?>
                            <div class="seccion-resultado-busqueda">
                            <h5 class="titulo-seccion-resultado-busqueda si-text-black"><?php echo get_cat_name($postcat) ?></h5>
                            </div>
                            <?php
                        }
                        //Categoria actual
                        $catid = $postcat;
                        /**
                         * Run the loop for the search to output the results.
                         * If you want to overload this in a child theme then include a file
                         * called content-search.php and that will be used instead.
                         */
                        ?>
                        <div class="post-resultado-busqueda">
                        <?php
                        get_template_part('template-parts/post/content', 'excerpt');
                        ?>
                        </div>
                        <?php

                    endwhile; // End of the loop.

                    the_posts_pagination(array(
                        'prev_text' => silicon_get_svg(array('icon' => 'arrow-left')) . '<span class="screen-reader-text">' . __('Previous page', 'silicon') . '</span>',
                        'next_text' => '<span class="screen-reader-text">' . __('Next page', 'silicon') . '</span>' . silicon_get_svg(array('icon' => 'arrow-right')),
                        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'silicon') . ' </span>',
                    ));

                else : ?>

                    <p><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'silicon'); ?></p>
                    <?php
                    get_search_form();

                endif;
                ?>


            </div>
            <div class="col"></div>
        </div>
        <div class="row"></div>
        <br/>
    </div>

<?php get_footer();
