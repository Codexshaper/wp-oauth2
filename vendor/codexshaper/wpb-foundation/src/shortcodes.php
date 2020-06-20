<?php

if (function_exists('wp_enqueue_style') && function_exists('wp_enqueue_script')) {
    if (function_exists('add_shortcode')) {
        add_shortcode('wpb-frontend', 'render_frontend');
        add_shortcode('wpb-spa', 'render_wpb_spa');
    }

    function render_frontend($atts, $content = '')
    {
        wp_enqueue_style('wpb-frontend');
        wp_enqueue_script('wpb-frontend');

        $content .= '<div id="wpb-frontend-app"></div>';

        return $content;
    }

    function render_wpb_spa($atts, $content = '')
    {
        wp_enqueue_style('wpb-spa');
        wp_enqueue_script('wpb-spa');

        $content .= '<div id="wpb-spa-app"></div>';

        return $content;
    }
}
