<?php

use yii\db\Migration;

/**
 * Миграция пользователя
 *
 * Class m191017_042902_create_user_table
 */
class m191017_042902_create_user_table extends Migration
{
    /**
     * Имя таблицы
     *
     * @var string
     */
    protected $tableName = '{{%user}}';

    /**
     * Применения миграции
     *
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'email' => $this->string(150)->unique(),
            'name' => $this->string()->null(),
            'password' => $this->string()->notNull(),
            'image' => $this->string()->null(),
            'cityId' =>$this->integer()->null(),
            'description' => $this->text()->null(),
            'phone' => $this->string()->null(),
            'dateAdd' => $this->date(),
        ]);
    }

    /**
     * Откат миграции
     *
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
