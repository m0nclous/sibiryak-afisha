<?php namespace Sibiryak_Afisha\Includes;

use Sibiryak_Afisha\Admin\Core as AdminCore;
use Sibiryak_Afisha\Public\Core as PublicCore;
use const Sibiryak_Afisha\SLUG;
use const Sibiryak_Afisha\VERSION;

/**
 * Ядро класса плагина.
 *
 * Используется для администраторских и публичных хуков.
 * Также поддерживает уникальный идентификатор этого плагина и текущую версию плагина.
 *
 * @author m0nclous <m0nclous@vk.com>
 */
class Core
{
    /**
     * Загрузчик, который отвечает за поддержку и регистрацию всех хуков плагина
     */
    protected Loader $loader;

    /**
     * Запуск базовых функций ядра
     */
    public function __construct()
    {
        $this->loader = new Loader();

        $this->define_global_hooks();

        // Подключение bundle.js (генерирует webpack)
        wp_enqueue_script(SLUG . '-bundle', plugin_dir_url(__FILE__) . '../dist/bundle.js', [], VERSION);

        if (is_admin()) {
            $this->define_admin_hooks();
        } else {
            $this->define_public_hooks();
        }
    }

    /**
     * Регистрация всех хуков, связанных с администраторской функциональностью
     */
    private function define_admin_hooks(): void
    {
        $this->loader->add_action('admin_enqueue_scripts', [AdminCore::class, 'enqueue_styles']);
        $this->loader->add_action('admin_enqueue_scripts', [AdminCore::class, 'enqueue_scripts']);
    }

    /**
     * Регистрация всех хуков, связанных с публичной функциональностью
     */
    private function define_public_hooks(): void
    {
        $this->loader->add_action('wp_enqueue_scripts', [PublicCore::class, 'enqueue_styles']);
        $this->loader->add_action('wp_enqueue_scripts', [PublicCore::class, 'enqueue_scripts']);
    }

    /**
     * Регистрация всех общих хуков
     */
    private function define_global_hooks(): void
    {
        $this->loader->add_action('init', [$this, 'register_post_type_afisha']);
        $this->loader->add_action('init', [$this, 'register_taxonomy_afisha']);
    }

    /**
     * Регистрация типа поста "Афиша"
     */
    public function register_post_type_afisha(): void
    {
        register_post_type('afisha', [
            'label' => null,
            'labels' => [
                'name' => 'Афиша',
                'singular_name' => 'Элемент',
                'add_new' => 'Добавить',
                'add_new_item' => 'Добавление',
                'edit_item' => 'Редактирование',
                'new_item' => 'Новое',
                'view_item' => 'Смотреть',
                'search_items' => 'Искать',
                'not_found' => 'Не найдено',
                'not_found_in_trash' => 'Не найдено в корзине',
                'parent_item_colon' => '',
                'menu_name' => 'Афиша',
            ],
            'description' => '',
            'public' => true,
            'show_in_menu' => null,
            'show_in_rest' => null,
            'rest_base' => null,
            'menu_position' => null,
            'menu_icon' => null,
            'hierarchical' => false,
            'supports' => ['title', 'editor', 'thumbnail'],
            'taxonomies' => [],
            'has_archive' => false,
            'rewrite' => true,
            'query_var' => true,
        ]);
    }

    /**
     * Регистрация таксономий для типа поста "Афиша"
     */
    public function register_taxonomy_afisha(): void
    {
        // Регистрация таксономии "Категории"
        register_taxonomy('afisha_cat', 'afisha', [
            'labels' => [
                'name' => 'Категории',
                'singular_name' => 'Категория',
                'search_items' => 'Искать категорию',
                'all_items' => 'Все категории',
                'view_item' => 'Просмотреть категорию',
                'parent_item' => 'Родительская категория',
                'parent_item_colon' => 'Родительская категория:',
                'edit_item' => 'Редактировать категорию',
                'update_item' => 'Обновить категорию',
                'add_new_item' => 'Добавить новую категорию',
                'menu_name' => 'Категории',
                'back_to_items' => '← Назад к категориям',
                'name_admin_bar' => 'Категорий не найдено'
            ],
            'description' => '',
            'public' => true,
            'hierarchical' => true,

            'rewrite' => true,
            'capabilities' => [],
            'meta_box_cb' => null,
            'show_admin_column' => true,
            'show_in_rest' => null,
            'rest_base' => null
        ]);

        // Регистрация таксономии "Возрастные рейтинги"
        register_taxonomy('afisha_age-rating', 'afisha', [
            'labels' => [
                'name' => 'Возрастные рейтинги',
                'singular_name' => 'Возрастной рейтинг',
                'search_items' => 'Искать возрастной рейтинг',
                'all_items' => 'Все возрастные рейтинги',
                'view_item' => 'Просмотреть возрастной рейтинг',
                'edit_item' => 'Редактировать возрастной рейтинг',
                'update_item' => 'Обновить возрастной рейтинг',
                'add_new_item' => 'Добавить возрастной рейтинг',
                'menu_name' => 'Возрастные рейтинги',
                'back_to_items' => '← Назад к возрастным рейтингам',
                'not_found' => 'Возрастных рейтингов не найдено'
            ],
            'description' => '',
            'public' => true,
            'hierarchical' => false,

            'rewrite' => true,
            'capabilities' => [],
            'meta_box_cb' => null,
            'show_admin_column' => true,
            'show_in_rest' => null,
            'rest_base' => null
        ]);

        // Регистрация таксономии "Залы"
        register_taxonomy('afisha_hall', 'afisha', [
            'labels' => [
                'name' => 'Залы',
                'singular_name' => 'зал',
                'search_items' => 'Искать зал',
                'all_items' => 'Все залы',
                'view_item' => 'Просмотреть зал',
                'edit_item' => 'Редактировать зал',
                'update_item' => 'Обновить зал',
                'add_new_item' => 'Добавить зал',
                'menu_name' => 'Залы',
                'back_to_items' => '← Назад к залам',
                'not_found' => 'Залов не найдено'
            ],
            'description' => '',
            'public' => true,
            'hierarchical' => false,

            'rewrite' => true,
            'capabilities' => [],
            'meta_box_cb' => null,
            'show_admin_column' => true,
            'show_in_rest' => null,
            'rest_base' => null
        ]);
    }

    /**
     * Запуск загрузчика, чтобы выполнить все хуки
     */
    public function run(): void
    {
        $this->loader->run();
    }
}