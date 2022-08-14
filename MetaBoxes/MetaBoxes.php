<?php namespace Sibiryak_Afisha\MetaBoxes;

use Sibiryak_Afisha\MetaBoxes\Traits\TimeSpending;

class MetaBoxes
{
    use TimeSpending;

    /**
     * Проверка валидности запроса
     */
    private static function isValid(int $post_id, string $namespace): bool
    {
        return !empty($_POST[$namespace])
            && wp_verify_nonce($_POST["{$namespace}_nonce"], __FILE__)
            && !wp_is_post_autosave($post_id)
            && !wp_is_post_revision($post_id);
    }

    /**
     * Получить поля мета бокса из запроса
     */
    private static function getPostFields(string $namespace): array
    {
        return array_map('sanitize_text_field', $_POST[$namespace]);
    }

    /**
     * Сохранить мета данные
     */
    private static function savePostFields(int $post_id, array $fields): void
    {
        foreach ($fields as $key => $value) {
            if (empty($value)) {
                delete_post_meta($post_id, $key);
            } else {
                update_post_meta($post_id, $key, $value);
            }
        }
    }
}