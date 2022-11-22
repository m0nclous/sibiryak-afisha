<?php namespace Sibiryak_Afisha\Includes;

/**
 * Регистрация всех хуков и фильтров плагина.
 *
 * Поддержка списка всех хуков, которые зарегистрированы в плагине, и регистрация их с помощью WordPress API.
 * Вызовов функцию запуска, выполняет список хуков и фильтров.
 *
 * @author m0nclous <m0nclous@vk.com>
 */
class Loader
{
    /**
     * Actions для регистрации в WordPress
     */
    protected array $actions = [];

    /**
     * Фильтры для регистрации в WordPress
     */
    protected array $filters = [];

    /**
     * Добавить новый action в массив для регистрации в WordPress
     *
     * @param string $hook Название action WordPress, которое регистрируется
     * @param array $callback [$component, $callback] Имя функции в $component
     * @param int $priority Необязательно. Приоритет, при котором должна запускаться функция. По умолчанию 10
     * @param int $accepted_args Необязательно. Количество аргументов, которые должны быть переданы в $callback. По умолчанию 1
     *
     */
    public function add_action(string $hook, array $callback, int $priority = 10, int $accepted_args = 1): void
    {
        $this->actions = $this->add($this->actions, $hook, $callback, $priority, $accepted_args);
    }

    /**
     * Вспомогательная функция, которая используется для регистрации actions и хуков в одной коллекции.
     *
     * @param array $hooks Массив хуков для регистрации (actions и фильтры)
     * @param string $hook Имя регистрируемого хука WordPress.
     * @param array $callback [$component, $callback] Имя функции в $component
     * @param int $priority Приоритет, при котором должна запускаться функция
     * @param int $accepted_args Количество аргументов, которые должны быть переданы в $callback
     */
    private function add(array $hooks, string $hook, array $callback, int $priority, int $accepted_args): array
    {
        $hooks[] = [
            'hook' => $hook,
            'callback' => $callback,
            'priority' => $priority,
            'accepted_args' => $accepted_args
        ];

        return $hooks;
    }

    /**
     * Add a new filter to the collection to be registered with WordPress.
     *
     * @param string $hook Название фильтра WordPress, которое регистрируется
     * @param array $callback [$component, $callback] Имя функции в $component
     * @param int $priority Необязательно. Приоритет, при котором должна запускаться функция. По умолчанию 10
     * @param int $accepted_args Необязательно. Количество аргументов, которые должны быть переданы в $callback. По умолчанию 1
     */
    public function add_filter(string $hook, array $callback, int $priority = 10, int $accepted_args = 1): void
    {
        $this->filters = $this->add($this->filters, $hook, $callback, $priority, $accepted_args);
    }

    /**
     * Регистрация фильтров и actions при помощи WordPress
     */
    public function run(): void
    {
        foreach ($this->filters as $hook) {
            add_filter($hook['hook'], $hook['callback'], $hook['priority'], $hook['accepted_args']);
        }

        foreach ($this->actions as $hook) {
            add_action($hook['hook'], $hook['callback'], $hook['priority'], $hook['accepted_args']);
        }
    }
}