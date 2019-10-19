<?php

use yii\db\Migration;

/**
 * Миграция города
 *
 * Class m160707_103919_towns
 */
class m160707_103919_towns extends Migration
{
    /**
     * Имя таблицы
     *
     * @var string
     */
    protected $tableName = '{{%towns}}';

    /**
     * Применения миграции
     *
     * @return bool|void
     */
    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);
        $this->execute(file_get_contents(__DIR__ .'/sql/towns.sql'));
    }

    /**
     * Откат миграции
     *
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable('{{%towns}}');
    }
}
