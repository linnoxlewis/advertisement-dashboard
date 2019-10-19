<?php

use yii\db\Migration;

/**
 * Миграция категории
 *
 * Class m191017_045157_create_categories_table
 */
class m191017_045133_create_categories_table extends Migration
{
    /**
     * Имя таблицы
     *
     * @var string
     */
    protected $tableName= '{{%categories}}';

    /**
     * Применения миграции
     *
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()
        ]);
        $this->insert($this->tableName,[
            'name' => 'Недвижимость'
        ]);
        $this->insert($this->tableName,[
            'name' => 'Транспорт'
        ]);
        $this->insert($this->tableName,[
            'name' => 'Личные вещи'
        ]);
        $this->insert($this->tableName,[
            'name' => 'Хобби'
        ]);
        $this->insert($this->tableName,[
            'name' => 'Услуги'
        ]);
        $this->insert($this->tableName,[
            'name' => 'Бытовая техника'
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
