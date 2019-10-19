<?php

use yii\db\Migration;

/**
 * Заполнение данными фото объявлений
 *
 * Class m191017_150003_images_seed
 */
class m191017_150003_images_seed extends Migration
{
    protected $tableName = '{{%ad_images}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $faker = Faker\Factory::create();
        for ($i = 1; $i< 40; $i++)
        {
            $this->insert($this->tableName,[
                'adId' => $i,
                'path' => $faker->imageUrl(),
            ]);
            $this->insert($this->tableName,[
                'adId' => $i,
                'path' => $faker->imageUrl(),
            ]);
        }
    }
}
