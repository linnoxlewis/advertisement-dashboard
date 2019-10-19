<?php

use yii\db\Migration;

/**
 * Миграция фото объявленеия
 *
 * Class m191017_045147_create_ad_images
 */
class m191017_045147_create_ad_images extends Migration
{
    /**
     * Имя таблицы
     *
     * @var string
     */
    protected $tableName = '{{%ad_images}}';

    /**
     * Применения миграции
     *
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'adId' => $this->integer()->notNull(),
            'path' => $this->string(),
            'dateAdd' => $this->date(),
        ]);
        $this->addForeignKey('ad_image_key',
            $this->tableName,
            'adId',
            'advertisement',
            'id',
            'CASCADE'
        );
    }

    /**
     * Откат миграции
     *
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropForeignKey('ad_image_key', $this->tableName);
        $this->dropTable($this->tableName);
    }
}
