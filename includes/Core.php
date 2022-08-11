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

        wp_enqueue_script(SLUG . '-vue', plugin_dir_url(__FILE__) . '../assets/js/vue.js', [], VERSION);

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
     * Запуск загрузчика, чтобы выполнить все хуки
     */
    public function run(): void
    {
        $this->loader->run();
    }
}