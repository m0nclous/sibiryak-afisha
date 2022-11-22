<?php namespace Sibiryak_Afisha\Admin;

use Sibiryak_Afisha\MetaBoxes\MetaBoxes;

/**
 * Ядро администраторской части
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

    /**
     * Добавление мета блоков для афиши
     */
    public static function add_meta_boxes_afisha(): void
    {
        add_action('add_meta_boxes', function () {
            add_meta_box('time_spending', 'Настройка времени проведения', [MetaBoxes::class, 'timeSpending'], 'afisha', 'normal', 'high');
        }, 1);

        add_action('save_post', [MetaBoxes::class, 'timeSpendingSave'], 0);
    }
}
