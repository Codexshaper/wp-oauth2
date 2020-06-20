<?php

namespace CodexShaper\WP\Admin\Menus;

/**
 * Admin Pages Handler.
 */
class Admin
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'admin_menu']);
    }

    /**
     * Register our menu page.
     *
     * @return void
     */
    public function admin_menu()
    {
        global $submenu;

        $capability = 'manage_options';
        $slug = 'wp-oauth';

        $hook = add_menu_page(__('WP OAuth2 Server', 'textdomain'), __('WP OAuth2 Server', 'textdomain'), $capability, $slug, [$this, 'plugin_page'], 'dashicons-text');

        if (current_user_can($capability)) {
            $submenu[$slug][] = [__('Clients', 'textdomain'), $capability, 'admin.php?page='.$slug.'#/clients'];
            $submenu[$slug][] = [__('Settings', 'textdomain'), $capability, 'admin.php?page='.$slug.'#/settings'];
        }

        add_action('load-'.$hook, [$this, 'init_hooks']);
    }

    /**
     * Initialize our hooks for the admin page.
     *
     * @return void
     */
    public function init_hooks()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    /**
     * Load scripts and styles for the app.
     *
     * @return void
     */
    public function enqueue_scripts()
    {
        wp_enqueue_style('wpb-vendors');
        wp_enqueue_style('wpb-admin');
        wp_enqueue_script('wpb-admin');
    }

    /**
     * Render our admin page.
     *
     * @return void
     */
    public function plugin_page()
    {
        echo '<div class="wrap"><div id="wpb-admin" csrf-token="'.csrf_token().'"></div></div>';
    }
}
