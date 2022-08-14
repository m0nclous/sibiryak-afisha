<?php namespace Sibiryak_Afisha\MetaBoxes\Traits;

trait TimeSpending
{
    static string $timePending = 'time_spending';

    /**
     * Форма редактирования
     */
    static function timeSpending($post): void
    { ?>
        <p>
            <label>
                Дата и время начала проведения
                <input type="datetime-local" name="<?= self::$timePending ?>[datetime-start]" value="<?= get_post_meta($post->ID, 'datetime-start', 1); ?>">
            </label>
        </p>

        <input type="hidden" name="<?= self::$timePending ?>_nonce" value="<?= wp_create_nonce(__FILE__); ?>"/>
    <?php }

    /**
     * Сохранение данных
     */
    static function timeSpendingSave($post_id): ?int
    {
        if (!self::isValid($post_id, self::$timePending)) return null;

        self::savePostFields($post_id, self::getPostFields(self::$timePending));

        return $post_id;
    }
}