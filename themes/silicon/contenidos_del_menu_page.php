<?php /* Template Name: ContenidosDelMenu */
get_header(); ?>


<?php
$childpages = wpb_list_child_pages();
?>

    <body data-spy="scroll" data-target="#sidemenu" data-offset="20">

    <div class="pagina-sola container-fluid">
        <div class="row">
            <div id="content" class="paginas-hija col">

                <?php
                if ($childpages) {
                    $array = array("G", "V", "G", "V", "B", "G", "B", "V");
                    $index = 0;
                    $class = 'seccion-par';
                    foreach ($childpages as $child) {                        
                        if ($array[$index] == "G") {
                            $class = 'seccion-gris';
                        } else if ($array[$index] == "V") {
                            $class = 'seccion-violeta';
                        } else {
                            $class = 'seccion-blanca';
                        }
                        $index = $index + 1;



                        ?>
                        <div class="row <?php echo $class; ?>">
                            <div class="col"></div>
                            <div class="col-8">
                                <section class="seccion-pagina-hija" id="section<?php echo $child->ID; ?>">
                                    <h2 class="titulo-pagina-hija"><?php echo mb_strtoupper($child->post_title, 'utf-8'); ?></h2>
                                    <p class="/*texto-pagina-hija*/"><?php echo apply_filters('the_content', $child->post_content); ?></p>

                                </section>
                            </div>
                            <div class="col"></div>
                        </div>

                    <?php }
                }
                ?>
            </div><!-- /#content -->
            <div class="menu-lateral-acompana-texto col col-md-3" style="background-color: <?php echo get_field("color", $post->ID); ?>">
                <div id="sidemenu" class="sticky-top sticky-offset">
                    <ul class="nav flex-column" role="tablist">
                        <?php
                        if ($childpages) {
                            foreach ($childpages as $child) { ?>
                                <li class="nav-item"><a class="nav-link"
                                                        href="#section<?php echo $child->ID; ?>"><?php echo mb_strtoupper($child->post_title, 'utf-8') ?></a>
                                </li>
                            <?php }
                        }
                        ?>
                    </ul>
                </div><!-- /sidebar -->
            </div>
        </div>
    </div><!-- /.container -->
    </body>
<?php get_footer();



