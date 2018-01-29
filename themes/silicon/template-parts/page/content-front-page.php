<?php
/**
 * Displays content for front page
 *
 * @package WordPress
 * @subpackage Silicon
 * @since 1.0
 * @version 1.0
 */

?>

    <?php get_header(); ?>

    <?php if (WP_DEBUG) echo "I'm content-front-page.php" ?>

    <div id="news" class="container-fluid si-light-grey sec-gris">


        <div class="row justify-content-end">
            <div class="col-sm-12 col-md-6 col-md-offset-3">
                <h1 class="si-text-purple">NOTICIAS</h1>
            </div>
            <div class="hidden-xs hidden-sm col-sm-12 col-md-3 notInst">

                <?php
                // Get the ID of a given category
                $idCategoryInst = get_cat_ID( 'institucionales' );
                $idCategoryCoop = get_cat_ID( 'cooperativas' );

                // Get the URL of this category
                $linkCategoryInst = get_category_link( $idCategoryInst );
                $linkCategoryCoop = get_category_link( $idCategoryCoop );
                ?>

                <h4  class="center-align-text si-a"><a href="<?php echo esc_url( $linkCategoryInst ); ?>" title="INSTITUCIONALES">INSTITUCIONALES</a> | <a href="<?php echo esc_url( $linkCategoryCoop ); ?>" title="COOPERATIVAS">COOPERATIVAS</a></h4>
            </div>
        </div>

        <?php carrousel_news(); ?>



            
    </div>
</div>


<div id="sec_prog" class="container-fluid">
    <?php
    carrousel_sec_prog();
    ?>
</div>


<div id="sec_middle" class="seccion-violeta container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-4">
            <div class="col-sm-12">
                <h5><b>SUSCRIPCIÓN BOLETÍN</b></h5>
                <?php if(dynamic_sidebar('mid-sec-purple-1')) : else : endif; ?>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="col-sm-12">

                <h5><b>SEGUINOS EN TWITTER</b></h5>
                <?php if(dynamic_sidebar('mid-sec-purple-2')) : else : endif; ?>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="col-sm-12">
                <h5><b>AGENDA</b></h5>
                <?php if(dynamic_sidebar('mid-sec-purple-3')) : else : endif; ?>
            </div>
        </div>
    </div>
</div>


<div id="partners" class="container-fluid">
    <h1 class="si-text-purple"><?php echo mb_strtoupper('Nuestras socias','utf-8') ?></h1>

    <?php
    print_socias_imgs();
    ?>
</div> <!-- #partners -->

