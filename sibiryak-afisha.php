<?php namespace Sibiryak_Afisha;

use Sibiryak_Afisha\Includes\Activator;
use Sibiryak_Afisha\Includes\Core;
use Sibiryak_Afisha\Includes\Deactivator;

/**
 * Стартовый файл плагина
 *
 * Этот файл читается WordPress для создания информации о плагине в области администрирования плагина.
 * Этот файл также включает все зависимости, используемые подключаемым модулем,
 * регистрирует функции активации и деактивации и определяет функцию,
 * которая запускает подключаемый модуль.
 *
 * @wordpress-plugin
 * Plugin Name: Сибиряк — Афиша
 * Plugin URI:  https://github.com/m0nclous
 * Description: Афиша, бронирование и покупка билетов.
 * Version:     1.0.0
 *
 * Author:      m0nclous
 * Author URI:  https://t.me/m0nclous
 *
 * License:     GPL-3.0
 * License URI: https://www.gnu.org/licenses/gpl-3.0.txt
 *
 * Requires at least: 6.0.1
 * Requires PHP: 8.1
 */

// Если этот файл вызывается напрямую - выходим
if (!defined('WPINC')) die;

/**
 * Текущая версия плагина
 */
const VERSION = '1.0.0';

/**
 * Slug плагина
 */
const SLUG = 'sibiryak-afisha';

// Автоматический загрузчик файлов php по namespace
spl_autoload_register(function ($class) {
    $path = explode('\\', $class);
    if (array_shift($path) === __NAMESPACE__) require_once __DIR__ . '/' . implode('/', $path) . '.php';
});

// Код, который запускается во время активации плагина
register_activation_hook(__FILE__, [Activator::class, 'activate']);

// Код, который запускается во время деактивации плагина
register_deactivation_hook(__FILE__, [Deactivator::class, 'deactivate']);

// Начало выполнения плагина
(new Core)->run();
