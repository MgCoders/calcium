<?php /* Template Name: Contacto */
get_header(); ?>


<div class="entry-content">
    <div class="container-fluid seccion-violeta">
        <div class="row" style="margin-bottom: 72px">
            <div class="col-sm-1"></div>
            <div class="col-sm-11">
                <h3 style="margin-top: 72px">CONTACTANOS</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-5">
                <?php
                echo do_shortcode( '[contact-form-7 id="254" title="Contactanos"]' );
                ?>
            </div>
            <div class="col-sm-1"></div>
            <div class="col-sm-3">
                <div class="row">
                    <div class="col-sm-12">
                        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Social Icons Area - Contacto")) ; ?>

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                    <h5>CUDECOOP</h5>
                    Confederación Uruguaya de Entidades Cooperativas</p>
                    <br/>
                    <div>
                        <p>Dirección: Av. 18 de Julio 948 - Oficina 602<br>
                            C.P. 11100 - Montevideo, Uruguay<br>
                            Teléfonos: +(598) 2902 9355 | 2902 5339<br>
                            Telefax: +(598) 2902 1330<br>
                            E-mail: cudecoop@cudecoop.coop
                    </div>

                    </div>
                </div>
            </div>
        </div>
    </div
    <div class="row">
        <iframe style="border: 0;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3272.0075125052413!2d-56.19805128422548!3d-34.906260981076805!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x959f802cc4aaa87d%3A0x321a6d4fc4f0b3fd!2sAv.+18+de+Julio+948%2C+11100+Montevideo!5e0!3m2!1sen!2suy!4v1506387532772" width="100%" height="450" frameborder="0" allowfullscreen="allowfullscreen"></iframe>
    </div>
</div>
