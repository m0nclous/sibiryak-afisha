<?php namespace Sibiryak_Afisha\Public;

use const Sibiryak_Afisha\SLUG;
use const Sibiryak_Afisha\VERSION;

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
        wp_enqueue_script(SLUG . '-bundle', plugin_dir_url(__FILE__) . '../dist/public-bundle.js', [], VERSION, true);
    }

    /**
     * Добавление фильтра для the_content, который добавляет шорткод
     */
    public static function add_filter_the_content(): void
    {
        add_filter('the_content', function (string $content) {
            return strtr('[afisha-element id="$id"]$content[/afisha-element]', [
                '$id' => get_the_ID(),
                '$content' => $content
            ]);
        });
    }

    /**
     * Добавление шорткода элемента афиши
     */
    public static function add_shortcode_afisha_element(): void
    {
        add_shortcode('afisha-element', function (array|string $attributes, string $content) {
            if ($attributes === '') $attributes = [];
            if (!$attributes || !$attributes['id']) return 'Элемент афиши не найден';

            $afishaPost = get_post($attributes['id']);
            if (!$afishaPost) return 'Элемент афиши не найден';

            $afishaElement = [
                'id' => $afishaPost->ID,
                'title' => $afishaPost->post_title,
                'content' => $afishaPost->post_content,
                'category' => wp_get_post_terms($afishaPost->ID, 'afisha_cat', ['fields' => 'names'])[0] ?? [],
                'ageRating' => wp_get_post_terms($afishaPost->ID, 'afisha_age-rating', ['fields' => 'names'])[0] ?? [],
                'hall' => wp_get_post_terms($afishaPost->ID, 'afisha_hall')[0] ?? [],
                'thumbnailUrl' => get_the_post_thumbnail_url($afishaPost->ID, 'full'),
                'datetimeStart' => get_post_meta($afishaPost->ID, 'datetime-start', true)
            ];

            add_action('wp_head', fn() => print('<script>window.afishaElement = ' . json_encode($afishaElement, JSON_UNESCAPED_UNICODE) . '</script>'));

            return '<div id="afisha-app" style="display: grid;gap: 30px;"><afisha-element></afisha-element></div>';
        });
    }
}
