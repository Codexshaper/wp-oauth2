<?php

namespace CodexShaper\WP\Admin\Menus;

/**
 * Menu Generator.
 */
class SubMenu
{
    public $parent_slug;

    public $page_title;

    public $menu_title;

    public $capability;

    public $slug;

    public $callback;

    public $position;

    public function save()
    {
        add_action('admin_menu', [$this, 'create_submenu']);
    }

    public static function make($options = [])
    {
        foreach ($options as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
        add_action('admin_menu', [$this, 'create_submenu']);
    }

    /**
     * Register our menu page.
     *
     * @return void
     */
    public function create_submenu()
    {
        if (current_user_can($this->capability)) {
            $hook = add_submenu_page(
                $this->parent_slug,
                $this->page_title,
                $this->menu_title,
                $this->capability,
                $this->slug,
                $this->callback,
                $this->icon
            );
        }

        // if ( current_user_can( $this->capability ) ) {
        //     $submenu[ $this->slug ][] = array( __( 'Clients', 'textdomain' ), $this->capability, 'admin.php?page=' . $this->slug . '#/clients' );
        //     $submenu[ $this->slug ][] = array( __( 'Settings', 'textdomain' ), $this->capability, 'admin.php?page=' . $this->slug . '#/settings' );
        // }

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
