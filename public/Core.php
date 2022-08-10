<?php namespace Sibiryak_Afisha\Public;

/**
 * Ядро публичной части
 *
 * Определяет скрипты и стили
 *
 * @author m0nclous <m0nclous@vk.com>
 */
class Core
{
    /**
     * Регистрация CSS
     */
    public static function enqueue_styles(): void
    {
//        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-name-public.css', array(), $this->version, 'all' );
    }

    /**
     * Регистрация JavaScript
     */
    public static function enqueue_scripts(): void
    {
//        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-name-public.js', array( 'jquery' ), $this->version, false );
    }
}
