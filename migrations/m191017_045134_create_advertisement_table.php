<?php

use yii\db\Migration;

/**
 * Миграции объявлений
 *
 * Class m191017_045134_create_advertisement_table
 */
class m191017_045134_create_advertisement_table extends Migration
{
    /**
     * Имя таблицы
     *
     * @var string
     */
    protected $tableName = '{{%advertisement}}';

    /**
     * Применения миграции
     *
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'cityId' => $this->integer()->defaultValue(null),
            'amount' => $this->integer()->defaultValue(null),
            'mainImage' => $this->string()->defaultValue(null),
            'categoryId' => $this->integer()->notNull(),
            'statusId'=> $this->integer()->defaultValue(1),
            'userId' => $this->integer()->notNull(),
            'dateAdd' => $this->dateTime(),
        ]);
        $this->addForeignKey('ad_category_key',
            $this->tableName,
            'categoryId',
            'categories',
            'id',
            'CASCADE'
        );
        $this->addForeignKey('ad_user_key',
            $this->tableName,
            'userId',
            'user',
            'id',
            'CASCADE'
        );
        $this->addForeignKey('ad_city_key',
            $this->tableName,
            'cityId',
            'towns',
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
        $this->dropForeignKey('ad_category_key', $this->tableName);
        $this->dropForeignKey('ad_user_key', $this->tableName);
        $this->dropForeignKey('ad_city_key', $this->tableName);
        $this->dropTable('{{%advertisement}}');
    }
}
