<?php /* Template Name: Logueados */
get_header();
$posts_list = array();
ob_start(); ?>


    <body>
    <div class="si-light-grey full-height" id="my-accordian">

        <?php
        if (current_user_can('logueadoscudecoop')) {
        ?>
        <div class="row lista-descargas">
            <div class="col-md-1"></div>
            <div class="col-md-4 ">

                <?php
                //Busco categorias
                $taxonomy_args = array(
                    'hide_empty' => true,
                );
                $categories = get_terms('sdm_categories', $taxonomy_args);
                if (count($categories) > 0) {
                    ?>
                    <h2 class="si-text-purple logueados-titulo-archivos">Archivos</h2>
                    <?php
                    foreach ($categories as $c) : ?>
                        <h5 class="si-text-black logueados-titulo-categoria"><?php echo $c->name; ?></h5>

                        <?php
                        $slugcategoria = $c->slug;
                        $query_args = array(
                            'post_type' => 'sdm_downloads',
                            'post_status' => 'publish',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'sdm_categories',
                                    'field' => 'slug',
                                    'terms' => $slugcategoria,
                                )
                            )
                        );
                        // Run query
                        $downloads_list = new WP_Query($query_args);
                        // Begin output
                        if ($downloads_list->have_posts()) {
                            ?>
                            <ul class="logueados-lista">
                                <?php
                                while ($downloads_list->have_posts()) {
                                    $downloads_list->the_post();
                                    $post_id = get_the_ID();
                                    $post_url = get_post_meta($post_id, 'sdm_upload', true);
                                    $post_desc = get_post_meta($post_id, 'sdm_description', true);
                                    $post_author = get_the_author_meta('display_name');
                                    $post_title = get_the_title();
                                    $post_date = get_the_date();
                                    $post_data = array(
                                        'id' => $post_id,
                                        'url' => $post_url,
                                        'title' => $post_title,
                                        'desc' => $post_desc,
                                        'author' => $post_author,
                                        'date' => $post_date
                                    );
                                    array_push($posts_list, $post_data);

                                    ?>
                                    <li>
                                        <a class="si-text-black boton-elegir-descarga" data-toggle="collapse"
                                           data-parent="#my-accordian"
                                           href="#collapse<? echo $post_id ?>">
                                            <?php echo $post_title; ?>
                                        </a>
                                    </li>

                                    <?
                                    wp_reset_postdata();
                                }
                                ?>
                            </ul>
                            <?php
                        } else {
                            return 'NO';
                        }
                    endforeach;
                }
                }
                ?>
            </div>
            <div class="col">
                <div class="full-height full-width detalle-descarga">
                    <?php
                    foreach ($posts_list as $post_data):
                        ?>
                        <div id="collapse<?php echo $post_data['id'] ?>" class="collapse">
                            <div>
                                <h5 class="si-text-purple"><b><?php echo $post_data['title'] ?></b></h5>
                                <h6>Autor <b><?php echo $post_data['author'] ?></b></h6>
                                <h6>Fecha <b><?php echo $post_data['date'] ?></b></h6>
                                <br/>
                                <h6><b>Descripción</b></h6>
                                <p><?php echo $post_data['desc'] ?></p>
                                <div class="full-width">
                                    <a class="btn btn-info boton-descarga"
                                       href="<?php echo $post_data['url'] ?>">
                                        Descargar
                                    </a>
                                </div>
                                <div class="full-width" style="padding-top: 2%">
                                    <a class="btn btn-info boton-descarga" data-toggle="collapse"
                                       data-parent="#espacio-comentarios<?php echo $post_data['id'] ?>"
                                       href="#formulario-comentario<?php echo $post_data['id'] ?>">
                                        Comentar
                                    </a>
                                </div>
                                <div id="espacio-comentarios">
                                    <div id="formulario-comentario<?php echo $post_data['id'] ?>"
                                         class="descarga-formulario-comentario collapse">
                                        <?php comment_form(array('post_id' => $post_data['id']), $post_data['id']); ?>
                                    </div>
                                    <div id="descarga-comentarios" class="collapse descarga-comentarios show">
                                        <?php
                                        $args = array(
                                            'post_id' => $post_data['id']
                                        );
                                        $comments = get_comments($args);
                                        foreach ($comments as $comment) :
                                            ?>
                                            <div>
                                                <h6><b><?php echo $comment->comment_author ?></b></h6>
                                                <p class="descarga-comentario">
                                                    <?php echo $comment->comment_content ?>
                                                </p>
                                            </div>
                                            <?php
                                        endforeach;
                                        ?>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    endforeach;
                    ?>
                </div>
            </div>
        </div>


    </div><!-- /.container -->
    <script>
        (function ($) {
            $('.boton-elegir-descarga[data-toggle="collapse"]').click(function () {
                $('.detalle-descarga > div.collapse.show').collapse('hide');
                $('.descarga-comentarios.collapse').collapse('show');
                $('.descarga-formulario-comentario.collapse.show').collapse('hide');

            });
            $('.boton-descarga[data-toggle="collapse"]').click(function () {
                //console.info("hola");
                $('.descarga-comentarios.collapse.show').collapse('hide')
            });
        })(jQuery);

    </script>
    </body>

<?php
echo ob_get_clean();
get_footer();





