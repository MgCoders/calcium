<?php
/**
 * Template for displaying search forms in Silicon
 *
 * @package WordPress
 * @subpackage Silicon
 * @since 1.0
 * @version 1.0
 */

?>

<?php $unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo $unique_id; ?>" style="display: none">
		<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'silicon' ); ?></span>
	</label>
	<input type="search" id="<?php echo $unique_id; ?>" class="search-field full-width" placeholder="Buscar en el sitio_" value="<?php echo get_search_query(); ?>" name="s" />
    <button type="submit" class="search-submit"><span class="screen-reader-text"><b>Buscar</b></span></button>
</form>
