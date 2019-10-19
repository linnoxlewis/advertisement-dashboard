<?php

use yii\db\Migration;

/**
 * Заполнение тестовыми данными объявлений
 *
 * Class m191017_055504_seed_ads
 */
class m191017_055504_seed_ads extends Migration
{
    protected $tableName = '{{%advertisement}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i< 40; $i++)
        {
            $date= rand(mktime(0,0,0,2006,1,1),time());
            $city = rand(1,150);
            $user = rand(1,8);
            $category = rand(1,6);
            $this->insert($this->tableName,[
                'title' => $faker->text(25),
                'description' => $faker->text,
                'cityId' => $city,
                'amount' => $faker->numberBetween(100,10000),
                'mainImage' => $faker->imageUrl(),
                'categoryId' => $category,
                'statusId'=> 1,
                'userId' => $user,
                'dateAdd' =>  date('Y-m-d H:i:s',$date)
            ]);
        }
    }
}
