<?php
/**
 * Silicon functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Silicon
 * @since 1.0
 */


/** WP_Widget_Recent_Posts class */
require_once('widgets/class-wp-widget-silicon-recent-posts.php' );


/*function my_custom_alm_before_button() {
    //if(is_page('custom-loader')){
        return '<p>LOS PEPES </p><div id="custom-alm-loader"></div>';
   // }
}
add_filter( 'alm_before_button', 'my_custom_alm_before_button' );*/

// custom menu example @ https://digwp.com/2011/11/html-formatting-custom-menus/
function clean_custom_menus() {
    $menu_name = 'middle'; // specify custom menu slug
    if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
        $menu = wp_get_nav_menu_object($locations[$menu_name]);
        $menu_items = wp_get_nav_menu_items($menu->term_id);


        $menu_list = '<div id="middle-group" class="menu-middle">' ."\n";

        $menu_list .= "\t\t\t\t". '<ul class="nav justify-content-center">' ."\n";
        foreach ((array) $menu_items as $key => $menu_item) {
            $title = $menu_item->title;
            $id_href = 'middle-key-' . $key;
            $menu_list .= "\t\t\t\t\t". '<li class="nav-item"><a class="nav-link menu-middle-link" data-toggle="collapse" aria-expanded="false" aria-controls="collapseExample" href="#'. $id_href .'"  data-parent="#middle-group"><span><b>'. mb_strtoupper($title,'utf-8') .'</b></span></a></li>' ."\n";
        }
        $menu_list .= "\t\t\t\t". '</ul>' ."\n";


        $menu_list .= ' <div class="accordion-group container-fluid">';

        foreach ((array) $menu_items as $key => $menu_item) {

            $url_parse = wp_parse_url($menu_item->url,-1);
            //str_replace('word', '', $sentence);
            $urlexact = (substr($url_parse['path'],0,9)=="/cudecoop") ? substr($url_parse['path'],9) : $url_parse['path'];
            $page = get_page_by_path($urlexact);
            $content = apply_filters('the_content', $page->post_content);



            $id_href = 'middle-key-' . $key;

            $menu_list .= '<div class="collapse collapse-style" id="' . $id_href . '">';
            $menu_list .=   '<div class="row justify-content-center"><div class="col-8">';
            $menu_list .=       $content;
            $menu_list .=   '</div></div>';
            $menu_list .= '</div>';

        }
        $menu_list .= "\t\t\t". '</div></div> <!-- middleGroup -->' . "\n";



    } else {
        // $menu_list = '<!-- no list defined -->';
    }
    echo $menu_list;
}


/*function my_post_thumbnail_html( $html ) {

    if ( empty( $html ) )
        $html = '<img src="' . trailingslashit( get_template_directory_uri() ) . '/resources/img/no-photo.png' . '" alt="no-photo" />';

    return $html;
}
add_filter( 'post_thumbnail_html', 'my_post_thumbnail_html' );*/


// thanks Andrija Naglic - https://developer.wordpress.org/reference/functions/wp_get_nav_menu_items/
function main_menu() {
    $menu_name = 'main'; // specify custom menu slug


    if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
        $menu = wp_get_nav_menu_object($locations[$menu_name]);
        $menu_items = wp_get_nav_menu_items($menu->term_id);


        $res_menu = array();
        // Esta recorrida se podria evitar pero nos aseguramos de no depender del orden
        foreach ((array) $menu_items as $key => $menu_item) {
            if ($menu_item->menu_item_parent == 0) { // soy padre
                $res_menu[$menu_item->ID] = array();
                $res_menu[$menu_item->ID]['ID'] = $menu_item->ID;
                $res_menu[$menu_item->ID]['title'] = $menu_item->title;
                $res_menu[$menu_item->ID]['url'] = $menu_item->url;
                $res_menu[$menu_item->ID]['childrens'] = array();
            }
        }

        foreach ((array) $menu_items as $key => $menu_item) {
            if ($menu_item->menu_item_parent != 0) { // soy padre
                $res_menu[$menu_item->menu_item_parent]['childrens'][$key] = array();
                $res_menu[$menu_item->menu_item_parent]['childrens'][$key]['ID'] = $menu_item->ID;
                $res_menu[$menu_item->menu_item_parent]['childrens'][$key]['title'] = $menu_item->title;
                $res_menu[$menu_item->menu_item_parent]['childrens'][$key]['url'] = $menu_item->url;
                // Vemos el tipo de objeto, si es una categoría guardamos true. 
                $postMetadataCategory = get_post_meta( $menu_item->ID, '_menu_item_object', true ) == "category";
                $res_menu[$menu_item->menu_item_parent]['childrens'][$key]['category'] = $postMetadataCategory;
            }
        }


        $menu_list = '<div id="main-menu-group" class="row justify-content-md-center">';
        foreach ((array) $res_menu as $key => $menu_item) {
            $menu_list .= '<div class="col">';
            $menu_list .= '<div class="item-header-main-menu">';
            $menu_list .= '<div id="maskUp"></div>';
            $menu_list .= '<div id="maskDown"></div>';
            $menu_list .= '<div class="colcentrada-cabezal"><a class="nav-link si-text-purple text-uppercase" href="'. $menu_item['url'].'"><b>'. ($menu_item['title']) .'</b></a></div>';
            if($menu_item['title'] == 'Contacto') {
                $menu_list .= '<div id="maskDownR"></div>';
            }
            $menu_list .= '</div>';
            $res_childs =  $menu_item['childrens'];
            $menu_list .= '<nav class="nav flex-column">';
            foreach ((array) $res_childs as $key2 => $menu_subitem) {
                $post_id = url_to_postid( $menu_subitem['url'] );  
                // Si el item del menu no es una categoria se coloca el link al item padre + la seccion. De lo contrario el link del menu hijo.
                if($menu_subitem['category'] == false)
                    $menu_list .= '<div class="colcentrada"><a class="nav-link subitem si-text-black" href="'. $menu_item['url'] . "#section". $post_id . '">' . $menu_subitem['title'] .'</a></div>';
                else
                    $menu_list .= '<div class="colcentrada"><a class="nav-link subitem si-text-black" href="'. $menu_subitem["url"] . '">' . $menu_subitem['title'] .'</a></div>';

            }
            $menu_list .= '</nav>';
            $menu_list .= '</div>';

        }



        $menu_list .= '</div>';

    } else {
        // $menu_list = '<!-- no list defined -->';
    }
    echo $menu_list;
}




// Print Link a Socias.
function print_socias_imgs(){
	$linksDiv = '';
	$iter = 0;
	$menu_name = 'partners-info';

	if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
		$menu = wp_get_nav_menu_object($locations[$menu_name]);
		$menu_items = wp_get_nav_menu_items($menu->term_id);
	
		foreach ((array) $menu_items as $key => $menu_item) {
			$iter++;

			if($iter % 12 == 1){
				#$linksDiv .= "\t" . '<div class="row h-100 justify-content-center align-items-center">' ."\n";
                $linksDiv .= "";
			}

			$title = $menu_item->title;
			$postName = $menu_item->post_name;
			$postId = $menu_item->ID;
			$postMetadataId = get_post_meta( $menu_item->ID, '_thumbnail_id', true );
			$postLink = get_post_meta( $menu_item->ID, '_menu_item_url', true );
			$postMetadata = get_post( $postMetadataId );
			$URLImg = $postMetadata->guid;

			$linksDiv .= "\t\t" . '<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">';
			$linksDiv .= "\t\t\t" . '<a href="' . $postLink . '">' ."\n";			
			$linksDiv .= "\t\t\t\t" . '<div class="divImageContainer justify-content-center align-items-center">' . "\n";			
			$linksDiv .= "\t\t\t\t\t" . '<span class="helper"></span><img class="displayed linksImgSocias" alt="' . $title . '" src="' . $URLImg . '">' ."\n";
			$linksDiv .= "\t\t\t\t" . '</div>';
			$linksDiv .= "\t\t\t" . '</a>' ."\n";
			$linksDiv .= "\t\t" . '</div>';

			if($iter % 12 == 0){
				#$linksDiv .= "\t" . '</div>' ."\n";
                $linksDiv .= "";
			}
		}

		if($iter != 0){
			#$linksDiv .= "\t" . '' ."\n";
            $linksDiv .= "";
		}
	}
	else{
		// No se encontraron las socias.
	}

    ?>
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center">        
            <?php echo($linksDiv); ?>
        </div>
    </div>

<?php
}

function print_socias_desc($menu){
	$linksDiv = '';
	$iter = 0;
	$menu_name = $menu;
	$ImgGrupo = '';

	if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
		$menu = wp_get_nav_menu_object($locations[$menu_name]);
		$menu_items = wp_get_nav_menu_items($menu->term_id);

		foreach ((array) $menu_items as $key => $menu_item) {
			$iter++;

			$title = $menu_item->title;
			$postName = $menu_item->post_name;
			$postId = $menu_item->ID;
			$postMetadataId = get_post_meta( $menu_item->ID, '_thumbnail_id', true );
			$postLink = get_post_meta( $menu_item->ID, '_menu_item_url', true );
			$postMetadata = get_post( $postMetadataId );
			$URLImg = $postMetadata->guid;
			$ImgDescription = $postMetadata->post_content;
			$ImgGrupo_aux = $postMetadata->post_title;

			$paddingClass = 'paddingLeft15';
			$marginClass = '';
			$grupoAImprimir = '<h4>&nbsp;</h4>';
			$withDivider = 'width100';

			if($iter % 3 == 1){
                /*
				$linksDiv .= "\t" . '<div class="row">' ."\n";
				$grupoAImprimir = '<h4>' . $ImgGrupo_aux . '</h4>';
				$paddingClass = '';
				$marginClass = 'margingLeft15';
				$withDivider = 'width100Menos15';
                */

                $linksDiv .= "";
                $grupoAImprimir = '<h4>' . $ImgGrupo_aux . '</h4>';
                $paddingClass = '';
                $marginClass = 'margingLeft15';
                $withDivider = 'width100Menos15';
			}



			if($ImgGrupo_aux != $ImgGrupo){
				$grupoAImprimir = '<h4>' . $ImgGrupo_aux . '</h4>';
				$paddingClass = '';
				$marginClass = 'margingLeft15';
				$ImgGrupo = $ImgGrupo_aux;
				$withDivider = 'width100Menos15';
			}

			$linksDiv .= "\t\t" . '<div class="noPaddingSide col-sm-12 col-md-6 col-xl-4">' . "\n";

			$linksDiv .= "\t\t\t" . '<div class="dividerSociasDescCard ' . $withDivider . ' heigth60 ' . $marginClass . ' ' . $paddingClass . '">' . $grupoAImprimir . '</div>' . "\n";

			$linksDiv .= "\t\t\t" . '<div class="card padding15">' . "\n";
			$linksDiv .= "\t\t\t\t" . '<div class="divImageContainer_plenos justify-content-center align-items-center">' . "\n";
			$linksDiv .= "\t\t\t\t\t" . '<span class="helper"></span><img class="displayed linksImgSocias" alt="' . $title . '" src="' . $URLImg . '">' ."\n";
			$linksDiv .= "\t\t\t\t" . '</div>';
			$linksDiv .= "\t\t\t\t" . '<div class="card-body">' . "\n";
			$linksDiv .= "\t\t\t\t" . '<div class="row h-100 justify-content-center align-items-center">';
			$linksDiv .= "\t\t\t\t\t" . '<div class="col-3">';
			$linksDiv .= "\t\t\t\t\t\t" . '<div class="si-purple dividerSocias dividerSociasDesc"></div>';
			$linksDiv .= "\t\t\t\t\t" . '</div>';
			$linksDiv .= "\t\t\t\t\t" . '<div class="col-9"></div>';
			$linksDiv .= "\t\t\t\t" . '</div>';

			$linksDiv .= "\t\t\t\t\t" . '<h4 class="card-title">' . $title . '</h4>' . "\n";
			$linksDiv .= "\t\t\t\t\t" . '<p class="card-text">' . nl2br($ImgDescription) . '</p>' . "\n";
			$linksDiv .= "\t\t\t\t\t" . '<a href="' . $postLink . '"> Ir al Sitio</a>' . "\n";
			$linksDiv .= "\t\t\t\t" . '</div>' . "\n";
			$linksDiv .= "\t\t\t" . '</div>' . "\n";

			$linksDiv .= "\t\t" . '</div>' . "\n";

			if($iter % 3 == 0){
				//$linksDiv .= "\t" . '</div>' ."\n";
                $linksDiv .= "";
			}
		}

		if($iter != 0){
			#$linksDiv .= "\t" . '</div>' ."\n";
            $linksDiv .= "";
		}
	}
	else{
		// No se encontraron las socias.
	}
	//$linksDiv .= '</div>' ."\n";
    $linksDiv .= "";
    ?>
    La Confederación está integrada por 13 entidades socias.
	<div class="container">
        <div class="row">        
            <?php echo($linksDiv); ?>
        </div>
    </div>
    <?php
}

function print_socias_locales_desc(){
	print_socias_desc('partners-info');
}
add_shortcode('socias_locales', 'print_socias_locales_desc');

function print_socias_internacionales_desc(){
	print_socias_desc('partners-internacionales-info');
}
add_shortcode('socias_internacionales', 'print_socias_internacionales_desc');


/**
 * Remove customize options
 *
 * @param $wp_customize
 */
function themename_customize_register($wp_customize)
{
    //$wp_customize->remove_section('title_tagline');
   // $wp_customize->remove_section('nav');
    // $wp_customize->remove_section('static_front_page');
}
add_action('customize_register', 'themename_customize_register');

/**
 * Despues de comentar que vuelva al origen
 */
add_filter('comment_post_redirect', 'redirect_after_comment');
function redirect_after_comment($location)
{
    return $_SERVER["HTTP_REFERER"];
}

/* Compara dos usuarios segun su campo posicion. */
function cmpUsersByPosicion($a, $b)
{
    if ($a->posicion == $b->posicion) {
        return 0;
    }
    return ($a->posicion < $b->posicion) ? -1 : 1;
}


/**
 * Lista de integrantes del comite ejecutivo
 */
function lista_usuarios_foto($atts = []) {
    ob_start();
    // normalize attribute keys, lowercase
    if ($atts['role']=='') {
        $atts['role'] = 'comit_ejecutivo';
    }
    if ($atts['title']=='') {
        $atts['title'] = '';
    }
    if ($atts['subtitle']=='') {
        $atts['subtitle'] = '';
    }
    $users = get_users( 'role='.$atts['role'] );
    ?>
    <h5 class="subtitulo-pagina-hija"><?php echo $atts['title']?></h5>
    <br>
    <h5><?php echo $atts['subtitle']?></h5>
    <div class="container-fluid lista-comite-ejecutivo">
    <?php

    // Se le asigna a todos los usuarios el campo posicion. 
    foreach ( $users as $user ) {
        $user->posicion = get_the_author_meta( 'posicion',  $user->ID );
    }

    // Si el primer usuario del array tiene una posicion asignada
    // ordenamos los usuarios por este campo, de lo contrario el 
    // orden queda como estaba.
    if(sizeof($users) > 0 && $users[0]->posicion > 0){
        //echo '<span>entro!</span>';  
        usort($users, "cmpUsersByPosicion");
    }

    foreach ( $users as $user ) {
        ?>
        <div class="row align-items-center lista-comite-ejecutivo-row">
            <div class="col-md-3 lista-comite-ejecutivo-img">
                <img class="img-fluid rounded-circle" src="<?php echo get_wp_user_avatar_src( $user->ID )?>" />
            </div>
            <div class="col">
                <span class="lista-comite-ejecutivo-nombre nombre-integrante"><?php echo $user->display_name ?></span>
                <div class="si-purple dividerAutoridades dividerAutoridadesDesc"></div>
                <br/>
                <span class="lista-comite-ejecutivo-rol"><?php echo get_the_author_meta( 'cargo',  $user->ID ) ?></span>
                <br/>
                <span><b><a class="linkMailAutoridades" href="<?php echo $user->user_email ; ?>"><?php echo $user->user_email ; ?></a></b></span>
                <br/>
                <span class="lista-comite-ejecutivo-bio"><?php echo wpautop(get_the_author_meta( 'description',  $user->ID ));?></span>
            </div>
        </div>

        <?php
    }
    ?>
    </div>
    <?php
    echo ob_get_clean();
}
add_shortcode('lista_usuarios_foto','lista_usuarios_foto');


function get_id_by_slug($page_slug) {
    $page = get_page_by_path($page_slug);
    if ($page) {
        return $page->ID;
    } else {
        return null;
    }
}



/**
 * Mostar Páginas child en página Parent
 */
function wpb_list_child_pages() {

    global $post;

    if ( is_page() && $post->post_parent )

        $childpages = get_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->post_parent . '&echo=0' );

    else
        $childpages = get_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->ID . '&echo=0' );

    return $childpages;
}

/**
 * Mostrar carrousel para categoria "noticias"
 */
function wpb_carrousel_aux()
{
    ob_start();
    $myposts = get_posts(array(
        'tag' => 'destacada' // category name parameter
    ));
    ?>
    <div>
        <div id="carrouselPrincipal" class="carousel slide hidden-xs-down" data-ride="carousel">
            <div class="carousel-inner full-height" role="listbox">
                <ol class="carousel-indicators" style="list-style: circle">
                    <?php
                    $first = true;
                    $count = 0;
                    foreach ($myposts as $post) :
                    $class = '';
                    if ($first == true) {
                        $class = 'active';
                        $first = false;
                    }
                    ?>
                    <li data-target="#carrouselPrincipal" data-slide-to="<?php echo $count ?>"
                        class="<?php echo $class ?>"></li>
                        <?php
                        $count = $count + 1;
                    endforeach;
                    ?>
                </ol>

                <?php
                $first = true;
                foreach ($myposts as $post) : setup_postdata($post);
                    $class = '';
                    if ($first == true) {
                        $class = 'active';
                        $first = false;
                    }
                    ?>
                    <div class="carousel-item full-height <?php echo $class ?> ">
                        <div class="col-12 noPadding">
                            <div class="row">
                                <div class="col-8 seccion-gris" style="padding: 0px;
                                    background-image: url('<?php echo wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'thumbnail'); ?>');
                                    background-size: cover;
                                    background-repeat: no-repeat;
                                    background-position: 50% 50%;">
                                </div>
                                <div class="col-4 carrouselMainPanel"
                                     style="background-color: <?php echo get_field("color", $post->ID); ?>">
                                    <p class="post-title">
                                        <b><?php echo mb_strtoupper($post->post_title, 'utf-8'); ?></b></p>
                                    <p><?php echo get_the_excerpt($post->ID) ?></p>
                                    <p><a href="<?php echo get_permalink($post->ID) ?>">+ Leer más </a></p>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                endforeach;
                wp_reset_postdata();
                ?>


            </div>

        </div>
    </div>
    <?php
    echo ob_get_clean();
}
add_shortcode( 'carrousel_main', 'wpb_carrousel_aux' );


/**
 * trims text to a space then adds ellipses if desired
 * @param string $input text to trim
 * @param int $length in characters to trim to
 * @param bool $ellipses if ellipses (...) are to be added
 * @param bool $strip_html if html tags are to be stripped
 * @return string
 *
 * http://www.ebrueggeman.com/blog/abbreviate-text-without-cutting-words-in-half
 */
function trim_text($input, $length, $ellipses = true, $strip_html = true) {
    //strip tags, if desired
    if ($strip_html) {
        $input = strip_tags($input);
    }

    //no need to trim, already shorter than trim length
    if (strlen($input) <= $length) {
        return $input;
    }

    //find last space within length
    $last_space = strrpos(substr($input, 0, $length), ' ');
    $trimmed_text = substr($input, 0, $last_space);

    //add ellipses (...)
    if ($ellipses) {
        $trimmed_text .= '...';
    }

    return $trimmed_text;
}



/*prigramas de cudecoop*/
function carrousel_sec_prog()
{

    $progPost = get_posts(array(
        'category_name' => 'programas'
    ));

    ?>


    <!-- Owl Stylesheets
        <script src="https://use.fontawesome.com/a3030ab34f.js"></script>

    <link rel="stylesheet" href="/wp-content/themes/silicon/owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="/wp-content/themes/silicon/owlcarousel/owl.theme.default.min.css">


    <!-- javascript
    <script src="/wp-content/themes/silicon/owlcarousel/owl.carousel.min.js"></script>
    -->
    <main id="main" class="site-main" role="main">

        <div class="container-fluid">
            <div class="row">
                <div id="carousel_sec_prog" class="owl-carousel">
                    <?php
                        foreach ($progPost as $i => $p) {

                            ?>
                            <a href="<?php echo get_permalink($p->ID)  ?>" >
                            <?php
                            if (has_post_thumbnail($p->ID)): ?>                                    
                                        <div style="height: 20rem; background-position: 50% 50%; background-size:cover; background-image:url('<?php echo get_the_post_thumbnail_url($p->ID); ?>')"></div>                                    
                            <?php else: ?>
                                   <div style="height: 20rem; background-position: 50% 50%; background-size:cover; background-image:url('<?php echo trailingslashit( get_template_directory_uri() ) . '/resources/img/no-photo.png' ?>')"></div>
                            <?php endif;

                            ?> 
                            </a>
                            <?php
                        }
                    ?>
                </div>
            </div>
        </div>

    </main>






<?php /*

    <div id="row_carousel_prog" class="justify-content-center">
        <div  id="carousel_prog" class="carousel slide" data-ride="carousel_3">
            <div class="carousel-inner" role="listbox">

    <?php
    $cant_noticias = count($progPost); //creo noticias
    //echo $cant_noticias;
    foreach ($progPost as $i => $p) {
        //echo "asd".$i;
        $deck = $i % 3; //cada cuatro hago una nueva fila


        if ($deck == 0 and $i != 0) { ?>
            </div>
            <?php
        }


        if ($deck == 0) { ?>

            <div class="carousel-item <?php echo ($i == 0) ? "active" : ""; ?>">
        <?php } ?>


                <div class="col-lg-4 divImageProg">
                    <span class="helper"></span>
                    <?php if (has_post_thumbnail($p->ID)): ?>
                        <img class="img_centrada" src="<?php echo get_the_post_thumbnail_url($p->ID); ?>" alt="no-photo" />
                    <?php else: ?>
                        <img class="img_centrada" src="<?php echo trailingslashit( get_template_directory_uri() ) . '/resources/img/no-photo.png' ?>" alt="no-photo" />
                    <?php endif; ?>
                </div>
    <?php } ?>

            </div>

        </div>

        <a class="carousel-control-prev" href="#carousel_prog" role="button" data-slide="prev">
                    <span class="" aria-hidden="true">
                              <i class="material-icons">chevron_left</i>
                    </span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel_prog" role="button" data-slide="next">
                    <span class="" aria-hidden="true">
                              <i class="material-icons">chevron_right</i>
                    </span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>
    <? */ 
}


/**
 *
 */




function carrousel_news()
{


    $instPost = get_posts(array(
        'category_name' => 'institucionales'
    ));

    $coopPost = get_posts(array(
        'category_name' => 'cooperativas'
    ));

    $mergePost = array_merge($instPost, $coopPost);

    ?>
            
                <div class="container-fluid">
                    <div class="row">
                        <div id="carousel_news" class="owl-carousel">
                            <?php
                            foreach ($mergePost as $i => $p) { 
                            ?>
                                <div class="card si-light-grey">
                                    <div class="si-purple si-text-white title-news-front">Noticia <?php echo get_the_category($p->ID)[0]->cat_name ?></div>
                                    <a href="<?php echo get_permalink($p->ID) ?>">
                                        <?php if (has_post_thumbnail($p->ID)): ?>
                                            <div style="height: 150px;background-image:url('<?php echo get_the_post_thumbnail_url($p->ID); ?>');background-size:cover"></div>
                                        <?php else: ?>
                                            <div style="height: 150px;background-image:url('<?php echo trailingslashit( get_template_directory_uri() )."/resources/img/no-photo.png"; ?>');background-size:cover"></div>
                                        <?php endif; ?>
                                    </a>
                                    <div class="card-block">
                                        <a href="<?php echo get_permalink($p->ID) ?>">
                                            <h5 class="card-title si-text-purple si-h5 uppercase"><?php echo ($p->post_title); ?></h5>
                                        </a>
                                        <p class="card-text"><?php if (has_excerpt($p->ID)) echo get_the_excerpt($p->ID); else echo trim_text($p->post_content, 300); ?></p>
                                    </div>
                                    <div class="card-footer si-light-grey">
                                        <small class="text-muted si-text-purple si-a"><a href="<?php echo get_permalink($p->ID) ?>"> + Leer más</a></small>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>

 <?php /*
    $cant_noticias = count($mergePost); //creo noticias
    foreach ($mergePost as $i => $p) {

        $deck = $i % 4; //cada cuatro hago una nueva fila


        if ($deck == 0 and $i != 0) { ?>
            </div>
            <?php
        }


        if ($deck == 0) { ?>

            <div class="card-deck carousel-item <?php echo ($i == 0) ? "active" : ""; ?>">
        <?php } ?>


                <div class="card si-light-grey col-lg-3 col-md-6 col-sm-12">
                    <div class="si-purple si-text-white title-news-front">Noticia <?php echo get_the_category($p->ID)[0]->cat_name ?></div>

                    <?php if (has_post_thumbnail($p->ID)): ?>
                        <img class="img_centrada" src="<?php echo get_the_post_thumbnail_url($p->ID); ?>" alt="no-photo" />                        
                    <?php else: ?>
                        <img class="img_centrada" src="<?php echo trailingslashit( get_template_directory_uri() ) . '/resources/img/no-photo.png' ?>" alt="no-photo" />
                    <?php endif; ?>

                    <div class="card-block">
                        <h5 class="card-title si-text-purple si-h5"><?php echo mb_strtoupper($p->post_title, 'utf-8'); ?></h5>
                        <p class="card-text"><?php if (has_excerpt($p->ID)) echo get_the_excerpt($p->ID); else echo trim_text($p->post_content, 300); ?></p>
                    </div>
                    <div class="card-footer si-light-grey">
                        <small class="text-muted si-text-purple si-a"><a href="<?php echo get_permalink($p->ID) ?>"> + Leer más</a></small>
                    </div>
                </div>


    <?php } */?>


    <div class="row justify-content-end">
        <div class="col-4 align-self-end">
            <a class="si-h5 si-text-purple right-align-text" href="<?php echo home_url(); ?>/noticias"> + VER MÁS</a>
        </div>
    </div>
    <?
}
add_shortcode( 'carrousel_news','carrousel_news');

function show_posts_lists()
{

    ?>
    <?php
    //echo get_the_category()[0]->cat_name;

    if ( get_the_category()[0]->cat_name != "Programas"){ ?>
    <div class="col-lg-3 col-md-6 col-sm-12 newsPage">



       <div class="card-deck ">
        <div class="card ">
            <div class="si-purple si-text-white title-news-front">
                Noticia <?php echo get_the_category()[0]->cat_name ?></div>
<a href="<?php echo get_permalink() ?>">
                <?php if (has_post_thumbnail()) { ?>
                    <div class="div-img-post" style="height: 150px; background-size: cover; background-image: url('<?php echo get_the_post_thumbnail_url(); ?>') "></div>
                <?php 
                } else { 
                ?>
                    <div class="div-img-post" style="height: 150px; background-size: cover; background-image: url('<?php echo get_bloginfo('template_url') ?>/resources/img/no-photo.png') "></div>
                <?php } ?>
<a>
                <div class="card-block">
                    <a href="<?php echo get_permalink() ?>">
                        <h5 class="card-title si-text-purple"><?php echo mb_strtoupper(trim_text(get_the_title(), 60), 'utf-8'); ?></h5>
                        <h5 class="card-title si-text-purple si-h4"><?php echo get_the_date('d/m/y'); ?></h5>
                    </a>
                    <p class="card-text"><?php if (has_excerpt()) {
                        echo get_the_excerpt();
                    } else {
                        $content_aux = get_the_content();
                        echo trim_text($content_aux, 250);
                    } ?></p>

                </div>
                <div class="card-footer si-none">
                    <small class="text-muted si-text-purple si-a"><a href="<?php echo get_permalink() ?>"> +
                        Leer más</a></small>
                    </div>
                </div>
            </div>
            

        </div>

        <?php
    }
    ?>

    <?
}

add_shortcode('show_posts_lists', 'show_posts_lists');


/**
 * Mostrar seccion para logueados rol "loagueadoscudecoop"
 */
function wpb_mostrar_texto_boton_ingreso(){
    ob_start();
    if (current_user_can('logueadoscudecoop')) {
        $current_user = wp_get_current_user();
        ?>
        <b><?php echo strtoupper($current_user->display_name);?></b>
        <?php
    } else {

        echo 'INGRESO';

    }
    echo ob_get_clean();

}

function wpb_mostrar_download_elegido($id){
    ob_start();
    ?>
    <div id="post_elegido">
        Hola! <?php echo $id ?>
    </div>
    <?php
    echo ob_get_clean();
}



/** thank to https://wordpress.stackexchange.com/questions/67498/how-to-include-line-breaks-in-the-excerpt */
function wpse67498_wp_trim_excerpt( $text = '' ) {

    $num_words = 100;

    $raw_excerpt = $text;

    if ( '' == $text ) {
        $text = get_the_content( '' );
        $text = strip_shortcodes( $text );
        $text = apply_filters( 'the_content', $text );
        $text = str_replace( ']]>', ']]&gt;', $text );
        $excerpt_length = apply_filters( 'excerpt_length', 55 );
        $excerpt_more = apply_filters( 'excerpt_more', ' ' . '[...]' );

        $allowable = '<br>';
        $text = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $text );
        $text = trim( strip_tags( $text, $allowable ) );

        if ( 'characters' == _x( 'words', 'word count: words or characters?' )
            && preg_match( '/^utf\-?8$/i', get_option( 'blog_charset' ) ) )
        {
            $text = trim( preg_replace( "/[\n\r\t ]+/", ' ', $text ), ' ' );
            preg_match_all( '/./u', $text, $words_array );
            $words_array = array_slice( $words_array[0], 0, $num_words + 1 );
            $sep = '';
        } else {
            $words_array = preg_split( "/[\n\r\t ]+/", $text, $num_words + 1, PREG_SPLIT_NO_EMPTY );
            $sep = ' ';
        }

        if ( count( $words_array ) > $excerpt_length ) {
            array_pop( $words_array );
            $text = implode( $sep, $words_array );
            $text = $text . $excerpt_more;
        } else {
            $text = implode( $sep, $words_array );
        }
    }


    return apply_filters( 'wp_trim_excerpt', $text, $raw_excerpt );
}

remove_filter( 'get_the_excerpt', 'wp_trim_excerpt');
add_filter( 'get_the_excerpt', 'wpse67498_wp_trim_excerpt' );

/*
    $args = array(
        'category_name'    => 'featured',
        'orderby'          => 'date',
        'order'            => 'DESC',
        'post_type'        => 'post',
        'post_status'      => 'publish',
        'suppress_filters' => true
    );



    $posts_array = new WP_Query( $args );
    $result = '<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">'.
    '<div class="carousel-inner" role="listbox">';
    foreach ( $posts_array as $post ) :
        setup_postdata( $post );
    echo $post->post_title;
    echo get_field( "color", $post->ID );
        $result = $result .
            '<div class="carousel-item">'.
            '<p>HOLA</p>'.
            '<img class="d-block img-fluid" src="..." alt="Second slide">'.
            '</div>';
    endforeach;
    $result = $result .
    '</div>'.
    '</div>';
    echo $result;
}*/

/**
 * Boostrap scripts
 */
function bootstrap_scripts()
{
    //wp_register_script( 'jquery-slim', get_template_directory_uri() . '/bootstrap/assets/js/vendor/jquery-slim.min.js', array( 'jquery' ) );
    //wp_register_script( 'jquery', get_template_directory_uri() . '/bootstrap/assets/js/vendor/jquery.min.js', array( 'jquery' ) );
    wp_register_script( 'tether', get_template_directory_uri() . '/bootstrap/assets/js/vendor/tether.min.js', false );
    wp_register_script( 'holder', get_template_directory_uri() . '/bootstrap/assets/js/vendor/holder.min.js', false);
    wp_register_script( 'boostrap', get_template_directory_uri() . '/bootstrap/dist/js/bootstrap.min.js', false );
    wp_register_script( 'ie10', get_template_directory_uri() . '/bootstrap/assets/js/ie10-viewport-bug-workaround.js', false );
    wp_register_script( 'custom', get_template_directory_uri() . '/bootstrap/assets/js/custom.js', false );


    //wp_enqueue_script( 'jquery-slim' );
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'tether' );
    wp_enqueue_script( 'holder' );
    wp_enqueue_script( 'ie10' );
    wp_enqueue_script( 'boostrap' );
    wp_enqueue_script( 'custom' );

}
add_action( 'wp_enqueue_scripts', 'bootstrap_scripts' );

/**
 * Silicon only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function silicon_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/silicon
	 * If you're building a theme based on Silicon, use a find and replace
	 * to change 'silicon' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'silicon' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'silicon-featured-image', 2000, 1200, true );

	add_image_size( 'silicon-thumbnail-avatar', 100, 100, true );

	// Set the default content width.
	$GLOBALS['content_width'] = 525;

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'top'    => __( 'Top Menu', 'silicon' ),
        'main'    => __( 'Main Menu', 'silicon' ),
		'social' => __( 'Social Links Menu', 'silicon' ),
        'middle' => __( 'Middle Sections Menu', 'silicon' ),
        'partners' => __( 'Partners Menu', 'silicon' ),
		'partners-info' => __( 'Partners Info Menu', 'silicon' ),
		'partners-internacionales-info' => __( 'Integración internacional', 'silicon' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'assets/css/editor-style.css', silicon_fonts_url() ) );

	// Define and register starter content to showcase the theme on new sites.
	$starter_content = array(
		'widgets' => array(
			// Place three core-defined widgets in the sidebar area.
			'sidebar-1' => array(
				'text_business_info',
				'search',
				'text_about',
			),

			// Add the core-defined business info widget to the footer 1 area.
			'sidebar-2' => array(
				'text_business_info',
			),

			// Put two core-defined widgets in the footer 2 area.
			'sidebar-3' => array(
				'text_about',
				'search',
			),
		),

		// Specify the core-defined pages to create and add custom thumbnails to some of them.
		'posts' => array(
			'home',
			'about' => array(
				'thumbnail' => '{{image-sandwich}}',
			),
			'contact' => array(
				'thumbnail' => '{{image-espresso}}',
			),
			'blog' => array(
				'thumbnail' => '{{image-coffee}}',
			),
			'homepage-section' => array(
				'thumbnail' => '{{image-espresso}}',
			),
		),

		// Create the custom image attachments used as post thumbnails for pages.
		'attachments' => array(
			'image-espresso' => array(
				'post_title' => _x( 'Espresso', 'Theme starter content', 'silicon' ),
				'file' => 'assets/images/espresso.jpg', // URL relative to the template directory.
			),
			'image-sandwich' => array(
				'post_title' => _x( 'Sandwich', 'Theme starter content', 'silicon' ),
				'file' => 'assets/images/sandwich.jpg',
			),
			'image-coffee' => array(
				'post_title' => _x( 'Coffee', 'Theme starter content', 'silicon' ),
				'file' => 'assets/images/coffee.jpg',
			),
		),

		// Default to a static front page and assign the front and posts pages.
		'options' => array(
			'show_on_front' => 'page',
			'page_on_front' => '{{home}}',
			'page_for_posts' => '{{blog}}',
		),

		// Set the front page section theme mods to the IDs of the core-registered pages.
		'theme_mods' => array(
			'panel_1' => '{{homepage-section}}',
			'panel_2' => '{{about}}',
			'panel_3' => '{{blog}}',
			'panel_4' => '{{contact}}',
		),

		// Set up nav menus for each of the two areas registered in the theme.
		'nav_menus' => array(
			// Assign a menu to the "top" location.
			'top' => array(
				'name' => __( 'Top Menu', 'silicon' ),
				'items' => array(
					'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
					'page_about',
					'page_blog',
					'page_contact',
				),
			),

            'main' => array(
                'name' => __( 'Main Menu', 'silicon' ),
                'items' => array(
                    'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
                    'page_about',
                    'page_blog',
                    'page_contact',
                ),
            ),

			// Assign a menu to the "social" location.
			'social' => array(
				'name' => __( 'Social Links Menu', 'silicon' ),
				'items' => array(
					'link_yelp',
					'link_facebook',
					'link_twitter',
					'link_instagram',
					'link_email',
				),
			),
            // Assign a menu to the "middle" location.
            'middle' => array(
                'name' => __( 'Middle Sections Menu', 'silicon' ),
                'items' => array(
                    'link_quienes_somos',
                    'link_co_gestion',
                    'link_coop_uruguay',
                ),
            ),
            'partners' => array(
                'name' => __( 'Partners Menu', 'silicon' ),
                'items' => array(
                    'link_quienes_somos',
                ),
            ),
            'partners-info' => array(
                'name' => __( 'Partners Info Menu', 'silicon' ),
                'items' => array(
                    'link_quienes_somos',
                ),
            ),
		),
	);

	/**
	 * Filters Silicon array of starter content.
	 *
	 * @since Silicon 1.1
	 *
	 * @param array $starter_content Array of starter content.
	 */
	$starter_content = apply_filters( 'silicon_starter_content', $starter_content );

	add_theme_support( 'starter-content', $starter_content );
}
add_action( 'after_setup_theme', 'silicon_setup' );



/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function silicon_content_width() {

	$content_width = $GLOBALS['content_width'];

	// Get layout.
	$page_layout = get_theme_mod( 'page_layout' );

	// Check if layout is one column.
	if ( 'one-column' === $page_layout ) {
		if ( silicon_is_frontpage() ) {
			$content_width = 644;
		} elseif ( is_page() ) {
			$content_width = 740;
		}
	}

	// Check if is single post and there is no sidebar.
	if ( is_single() && ! is_active_sidebar( 'sidebar-1' ) ) {
		$content_width = 740;
	}

	/**
	 * Filter Silicon content width of the theme.
	 *
	 * @since Silicon 1.0
	 *
	 * @param int $content_width Content width in pixels.
	 */
	$GLOBALS['content_width'] = apply_filters( 'silicon_content_width', $content_width );
}
add_action( 'template_redirect', 'silicon_content_width', 0 );

/**
 * Register custom fonts.
 */
function silicon_fonts_url() {
	$fonts_url = '';

	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Libre Franklin, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$libre_franklin = _x( 'on', 'Libre Franklin font: on or off', 'silicon' );

	if ( 'off' !== $libre_franklin ) {
		$font_families = array();

		$font_families[] = 'Libre Franklin:300,300i,400,400i,600,600i,800,800i';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Silicon 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function silicon_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'silicon-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'silicon_resource_hints', 10, 2 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function silicon_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'silicon' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'silicon' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );



	register_sidebar( array(
		'name'          => __( 'Footer 1', 'silicon' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'silicon' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'silicon' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your footer.', 'silicon' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

    register_sidebar( array(
        'name'          => __( 'Silicon Floating Area', 'silicon' ),
        'id'            => 'floating-area',
        'description'   => __( 'Add widgets here to appear in your floating area.', 'silicon' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar(array(
            'name'          => __( 'Social Icons Area', 'silicon' ),
            'id'            => 'social-icons-area',
            'description'   => __( 'Add widgets here to appear in your social  area.', 'silicon' ),
            'before_widget' => '<div class = "widget social-icons %2$s ">',
            'after_widget' => '</div>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        )
    );
    register_sidebar(array(
            'name'          => __( 'News Carousel', 'silicon' ),
            'id'            => 'news-carousel-area',
            'description'   => __( 'Add widgets here to appear in your carousel area.', 'silicon' ),
            'before_widget' => '<div class = "widget social-icons %2$s ">',
            'after_widget' => '</div>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        )
    );

    register_sidebar(array(
            'name'          => __( 'Social Icons Area - Contacto', 'silicon' ),
            'id'            => 'social-icons-area',
            'description'   => __( 'Add widgets here to appear in your social  area.', 'silicon' ),
            'before_widget' => '<div class = "widget social-icons %2$s ">',
            'after_widget' => '</div>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        )
    );

    register_sidebar( array(
        'name'          => __( 'Mid Sec purple 1', 'silicon' ),
        'id'            => 'mid-sec-purple-1',
        'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'silicon' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Mid Sec purple 2', 'silicon' ),
        'id'            => 'mid-sec-purple-2',
        'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'silicon' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Mid Sec purple 3', 'silicon' ),
        'id'            => 'mid-sec-purple-3',
        'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'silicon' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Youtube Channel ', 'silicon' ),
        'id'            => 'youtube-channel ',
        'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'silicon' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_widget('WP_Widget_Silicon_Recent_Posts');
}
add_action( 'widgets_init', 'silicon_widgets_init' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Silicon 1.0
 *
 * @param string $link Link to single post/page.
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
//function silicon_excerpt_more( $link ) {
//	if ( is_admin() ) {
//		return $link;
//	}
//
//	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
//		esc_url( get_permalink( get_the_ID() ) ),
//		/* translators: %s: Name of current post */
//		sprintf( __( 'Continuar leyendo en <span class="screen-reader-text"> "%s"</span>', 'silicon' ), get_the_title( get_the_ID() ) )
//	);
//	return ' &hellip; ' . $link;
//}
//add_filter( 'excerpt_more', 'silicon_excerpt_more' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Silicon 1.0
 */
function silicon_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'silicon_javascript_detection', 0 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function silicon_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'silicon_pingback_header' );

/**
 * Display custom color CSS.
 */
function silicon_colors_css_wrap() {
	if ( 'custom' !== get_theme_mod( 'colorscheme' ) && ! is_customize_preview() ) {
		return;
	}

	require_once( get_parent_theme_file_path( '/inc/color-patterns.php' ) );
	$hue = absint( get_theme_mod( 'colorscheme_hue', 250 ) );
?>
	<style type="text/css" id="custom-theme-colors" <?php if ( is_customize_preview() ) { echo 'data-hue="' . $hue . '"'; } ?>>
		<?php echo silicon_custom_colors_css(); ?>
	</style>
<?php }
add_action( 'wp_head', 'silicon_colors_css_wrap' );

/**
 * Enqueue scripts and styles.
 */
function silicon_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'silicon-fonts', silicon_fonts_url(), array(), null );

	// Theme stylesheet.
	wp_enqueue_style( 'silicon-style', get_stylesheet_uri() );

	// Load the dark colorscheme.
	if ( 'dark' === get_theme_mod( 'colorscheme', 'light' ) || is_customize_preview() ) {
		wp_enqueue_style( 'silicon-colors-dark', get_theme_file_uri( '/assets/css/colors-dark.css' ), array( 'silicon-style' ), '1.0' );
	}

	// Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
	if ( is_customize_preview() ) {
		wp_enqueue_style( 'silicon-ie9', get_theme_file_uri( '/assets/css/ie9.css' ), array( 'silicon-style' ), '1.0' );
		wp_style_add_data( 'silicon-ie9', 'conditional', 'IE 9' );
	}

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'silicon-ie8', get_theme_file_uri( '/assets/css/ie8.css' ), array( 'silicon-style' ), '1.0' );
	wp_style_add_data( 'silicon-ie8', 'conditional', 'lt IE 9' );

	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'silicon-skip-link-focus-fix', get_theme_file_uri( '/assets/js/skip-link-focus-fix.js' ), array(), '1.0', true );

	$silicon_l10n = array(
		'quote'          => silicon_get_svg( array( 'icon' => 'quote-right' ) ),
	);

	if ( has_nav_menu( 'top' ) ) {
		wp_enqueue_script( 'silicon-navigation', get_theme_file_uri( '/assets/js/navigation.js' ), array( 'jquery' ), '1.0', true );
		$silicon_l10n['expand']         = __( 'Expand child menu', 'silicon' );
		$silicon_l10n['collapse']       = __( 'Collapse child menu', 'silicon' );
		$silicon_l10n['icon']           = silicon_get_svg( array( 'icon' => 'angle-down', 'fallback' => true ) );
	}

	wp_enqueue_script( 'silicon-global', get_theme_file_uri( '/assets/js/global.js' ), array( 'jquery' ), '1.0', true );

	wp_enqueue_script( 'jquery-scrollto', get_theme_file_uri( '/assets/js/jquery.scrollTo.js' ), array( 'jquery' ), '2.1.2', true );

    wp_enqueue_script( 'silicon-custom', get_theme_file_uri( '/assets/js/silicon-custom.js' ), array( 'jquery' ), '1.0', true );


    wp_localize_script( 'silicon-skip-link-focus-fix', 'siliconScreenReaderText', $silicon_l10n );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

    //OWL

    /*
    <script src="https://use.fontawesome.com/a3030ab34f.js"></script>

    <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="/wp-content/themes/silicon/owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="/wp-content/themes/silicon/owlcarousel/owl.theme.default.min.css">


    <!-- javascript -->
    <script src="/wp-content/themes/silicon/owlcarousel/owl.carousel.min.js"></script>*/
    wp_enqueue_style( 'owl-carrousel-css', get_template_directory_uri() .'/owlcarousel/owl.carousel.min.css', array(), 'all' );
    wp_enqueue_style( 'owl-theme-css', get_template_directory_uri() .'/owlcarousel/owl.theme.default.min.css', array(), 'all' );

    wp_enqueue_script( 'fontawesome', 'https://use.fontawesome.com/a3030ab34f.js', array ( 'jquery' ), 1.1, true);
    wp_enqueue_script( 'owl-carrousel-js', get_template_directory_uri() .'/owlcarousel/owl.carousel.min.js', array ( 'jquery' ), 1.1, true);
    




}
add_action( 'wp_enqueue_scripts', 'silicon_scripts' );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @since Silicon 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function silicon_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 740 <= $width ) {
		$sizes = '(max-width: 706px) 89vw, (max-width: 767px) 82vw, 740px';
	}

	if ( is_active_sidebar( 'sidebar-1' ) || is_archive() || is_search() || is_home() || is_page() ) {
		if ( ! ( is_page() && 'one-column' === get_theme_mod( 'page_options' ) ) && 767 <= $width ) {
			 $sizes = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
		}
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'silicon_content_image_sizes_attr', 10, 2 );

/**
 * Filter the `sizes` value in the header image markup.
 *
 * @since Silicon 1.0
 *
 * @param string $html   The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array  $attr   Array of the attributes for the image tag.
 * @return string The filtered header image HTML.
 */
function silicon_header_image_tag( $html, $header, $attr ) {
	if ( isset( $attr['sizes'] ) ) {
		$html = str_replace( $attr['sizes'], '100vw', $html );
	}
	return $html;
}
add_filter( 'get_header_image_tag', 'silicon_header_image_tag', 10, 3 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @since Silicon 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function silicon_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( is_archive() || is_search() || is_home() ) {
		$attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
	} else {
		$attr['sizes'] = '100vw';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'silicon_post_thumbnail_sizes_attr', 10, 3 );

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @since Silicon 1.0
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function silicon_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template',  'silicon_front_page_template' );

/**
 * Implement the Custom Header feature.
 */
require get_parent_theme_file_path( '/inc/custom-header.php' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer.php' );

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );
