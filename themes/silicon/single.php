<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Silicon
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>


            <div class="container">




                    <div class="row">


                            <h2 class="si-h2 row-title-news si-text-purple"">NOTICIAS</h2>


                    </div>


                    <div class="row">

                        <div class="col-8">
                            <?php
                            /* Start the Loop */
                            while ( have_posts() ) : the_post();

                                get_template_part( 'template-parts/post/content', get_post_format() );

                                // FIXME comentarios ponerlos lindos !!!
                                // If comments are open or we have at least one comment, load up the comment template.
                                //if ( comments_open() || get_comments_number() ) :
                                //	comments_template();
                                //endif;


                            // FIXME esto permite moverse entre posts
                            //	the_post_navigation( array(
                            //		'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'silicon' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'silicon' ) . '</span> <span class="nav-title"><span class="nav-title-icon-wrapper">' . silicon_get_svg( array( 'icon' => 'arrow-left' ) ) . '</span>%title</span>',
                            //		'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'silicon' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'silicon' ) . '</span> <span class="nav-title">%title<span class="nav-title-icon-wrapper">' . silicon_get_svg( array( 'icon' => 'arrow-right' ) ) . '</span></span>',
                            //	) );

                            endwhile; // End of the loop.
                            ?>
                        </div>
                        <div class="col-1"></div>
                        <div class="col-3  blog-sidebar">
                            <?php  get_sidebar(); ?>
                        </div>
                    </div>




                </div><!-- .container -->

<?php get_footer();
