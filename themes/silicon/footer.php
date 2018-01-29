<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Silicon
 * @since 1.0
 * @version 1.2
 */

?>




</div> <!--. album text-muted -->


</div> <!-- -container -->

</div>

<footer>
	<div class="seccion-violeta">
	<?php	
	/*if( ! is_front_page() ){*/
	?>
		<div id="div-footer">
	       	<!-- <div class="col-md-1"> </div> -->
			<div class="col-md-3">				 
                
				<img class="logo-footer" src="<?php echo get_template_directory_uri(); ?>/../../uploads/2017/10/cudecoop_min.png" />
				<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Social Icons Area - Contacto")) ; ?>	             
				<img class="logo-bottom-footer" src="<?php echo get_template_directory_uri(); ?>/../../uploads/2017/10/coop-min.png" />
			</div>

	        <div class="col-md-3">
	            <div class="row">	               
	                <div class="col-sm-12">
	                    <h4><b>CUDECOOP</b></h4>
	                    <b>Confederación Uruguaya de<br>
						Entidades Cooperativas</b>
						<br><br><br>
	                    <div>
							Dirección: Av. 18 de Julio 948 - Oficina 602<br>
							C.P. 11100 - Montevideo, Uruguay<br>
							Teléfonos: +(598) 2902 9355 | 2902 5339<br>
							Telefax: +(598) 2902 1330<br>
	                    </div>
	                </div>
	            </div>
	        </div>
	        <div class="col-md-6">
	            <div class="col-sm-12">
	                <h3>CONTACTANOS</h3>
	            </div>
	            <div class="col-sm-12">
	                <?php
	                echo do_shortcode( '[contact-form-7 id="254" title="Contactanos"]' );
	                ?>
	        	</div>
	        </div>
	    </div>
    </div>
	<?php
	/*}*/
	?>
</footer>

<!--footer class="text-muted">
    <div class="container">
        <p class="float-right">
            <a href="#">Back to top</a>
        </p>
        <p>Album example is &copy; Bootstrap, but please download and customize it for yourself!</p>
        <p>New to Bootstrap? <a href="../../">Visit the homepage</a> or read our <a href="../../getting-started/">getting started guide</a>.</p>
    </div>
</footer-->

<!-- Bootstrap core JavaScript
================================================== -->
<?php wp_footer(); ?>
</body>
</html>

</body>
</html>
