/**
 * @package WPZOOM Framework
 *
 * CSS Rules
 *
/* global jQuery, wp */

(function (wp, $, WPZOOM_Preview, _, vein) {
    'use strict';

    if ( ! wp || ! wp.customize || ! WPZOOM_Preview ) { return; }

    var api = wp.customize,
        themeName = WPZOOM_Preview.themeName,
        cssRules = WPZOOM_Preview.cssRules,
        fontParams = WPZOOM_Preview.fontParams;

    $(document).ready(function () {

        var $customCssSelector = $('#' + themeName+'-custom-css');

        var styleSheet = $customCssSelector.length ? $customCssSelector[0].sheet : undefined;

        var utils = {
            fontSize: function (current, value) {

                return parseFloat(value) + 'px';
            },
            display: function (current, value) {
                
                if ( value == 'yes' || value == 'on' )
                    value = true;

                if ( value == 'no' || value == 'off' )
                    value = false;

                return value ? 'block' : 'none';
            },
            backgroundGradient : function (current, value) {

                var gradients = [
                    {'background': '-moz-linear-gradient(left,  rgba(239,244,247,0) 27%, ' + value + ' 63%)'}, /* FF3.6+ */
                    {'background': '-webkit-linear-gradient(left,  rgba(239,244,247,0) 27%, ' + value + ' 63%)'}, /* Chrome10+,Safari5.1+ */
                    {'background': '-o-linear-gradient(left,  rgba(239,244,247,0) 27%, ' + value + ' 63%)'}, /* Opera 11.10+ */
                    {'background': '-ms-linear-gradient(left,  rgba(239,244,247,0) 27%, ' + value + ' 63%)'}, /* IE10+ */
                    {'background': 'linear-gradient(to right,  rgba(239,244,247,0) 27%, ' + value + '  63%)}'} /* W3C */
                ];
                _.each(gradients, function(gradient){
                    vein.inject(
                        current.style.selector.split(','),
                        gradient,
                        {'stylesheet': styleSheet}
                    );
                });
            },
            fontFamily: function (current, value) {

                var font_families = value;

                var fontInject = function (fontFamily) {
                    vein.inject(
                        current.style.selector.split(','),
                        {'font-family': fontFamily},
                        {'stylesheet': styleSheet}
                    );
                };

                // Standard Fonts
                _.each(fontParams[0].fonts, function (font, key) {

                    if ( font.label == value ) {
                        fontInject(font.stack);
                    }

                });

                // Google Fonts
                _.each(fontParams[1].fonts, function (font, key) {

                    if ( font.label == value ) {
                        if ( typeof font.variants != 'undefined' ) {
                            font_families += ':' + font.variants.join(',');
                        }

                        if ( typeof font.subsets != 'undefined' ) {
                            font_families += ':' + font.subsets.join(',');
                        }

                        WebFont.load({
                            google: {
                                families: [font_families]
                            },
                            fontactive: fontInject
                        });

                    }

                });

                return value;
            }
        };

        _.each(cssRules, function (current, key) {

            wp.customize(key, function (value) {

                value.bind(function (newval) {
                    var myObj = {};

                    if (_.isArray(current.style)) {
                        _.each(current.style, function (subcurrent) {
                            myObj[subcurrent.rule] = newval;

                            if (_.findKey(utils, function (value, key) {
                                    return key === $.camelCase(subcurrent.rule)
                                })) {
                                myObj[subcurrent.rule] = utils[$.camelCase(subcurrent.rule)](current, newval);

                                if (subcurrent.rule === 'font-family') {
                                    return;
                                }
                            }

                            if ( typeof subcurrent.selector != 'undefined' ) {
                                vein.inject(
                                    subcurrent.selector.split(','),
                                    myObj,
                                    {'stylesheet': styleSheet}
                                );
                            }
                            
                        });
                        return;
                    }

                    myObj[current.style.rule] = newval;

                    if ( _.findKey(utils, function (value, key) { return key === $.camelCase( current.style.rule ) }) ) {
                        myObj[current.style.rule] = utils[$.camelCase(current.style.rule)](current, newval);

                        if (current.style.rule === 'font-family') {
                            return;
                        }
                    }

                    if ( typeof current.style.selector != 'undefined' ) {
                        vein.inject(
                            current.style.selector.split(','),
                            myObj,
                            {'stylesheet': styleSheet}
                        );
                    }

                    // Sortable control reorder elements
                    if ( current.style.rule === 'reorder' ) {
                        var order = array_flip( newval.split('') );

                        _.each( current.style.choices, function( item ){

                            $(document).find( item.selector ).removeClass( remove_order_class ).addClass('order-' + (parseInt(order[ item.id ], 10) + 1));

                        });
                    }

                    // Toggle Class
                    if ( current.style.rule === 'toggleClass' ) {
                        _.each( current.style.choices, function( item ) {

                            var $element = $(document).find( item.selector );

                            if ( item.class === 'hidden' ) {

                                if ( item.id === newval ) {
                                    if ( $element.hasClass( item.class ) ) {
                                        $element.removeClass( item.class );
                                    } else {
                                        $element.addClass( item.class );
                                    }
                                } else {
                                    $element.addClass( item.class );
                                }

                                return;
                            }

                            if ( item.id === newval ) {
                                $element.addClass( item.class );
                            } else {
                                $element.removeClass( item.class );
                            }

                        });
                    }

                });
            });
        });
    });

})(wp, jQuery, WPZOOM_Preview, _, vein);


/**
 * @package WPZOOM Framework
 *
 * DOM Rules
 *
/* global jQuery, wp */

(function (wp, $, WPZOOM_Preview, _) {

    if ( ! wp || ! wp.customize || ! WPZOOM_Preview ) { return; }

    var api = wp.customize,
        domRules = WPZOOM_Preview.domRules;

    $(document).ready(function () {

        var utils = {
            toggleClass: function (object, newval, oldval) {
                $(object.dom.selector).removeClass(oldval);
                $(object.dom.selector).addClass(newval);
            },
            changeStylesheet: function (object, newval, oldval) {
                $('#' + object.dom.selector.replace('*', oldval)).attr('href', function (index, href) {
                    return href.replace(oldval, newval)
                }).attr('id', function (index, id) {
                    return id.replace(oldval, newval)
                });
            }
        };

        _.each(domRules, function (current, key) {
            wp.customize(key, function (value) {
                value.bind(function (newval, oldval) {

                    if (_.findKey(utils, function (value, key) {
                            return key === $.camelCase(current.dom.rule)
                        })) {
                        utils[$.camelCase(current.dom.rule)](current, newval, oldval);
                    }
                });
            });
        });
    });

})(wp, jQuery, WPZOOM_Preview, _);


function array_flip( trans ) {
    var key, tmp_ar = {};

    for ( key in trans ) {
        if ( trans.hasOwnProperty( key ) ) {
            tmp_ar[trans[key]] = key;
        }
    }

    return tmp_ar;
}

function remove_order_class( index, css ) {
    return ( css.match(/(^|\s)order-[1-3]/ig) || [] ).join(' ');
}
