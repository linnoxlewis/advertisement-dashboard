<?php

use yii\db\Migration;

/**
 * Заполнение данными пользователей
 *
 * Class m191017_055905_seed_user
 */
class m191017_055503_seed_user extends Migration
{
    protected $tableName = '{{%user}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i< 8; $i++)
        {
            $date= rand(mktime(0,0,0,2006,1,1),time());
            $city = rand(1,150);
            $this->insert($this->tableName,[
                'name' => $faker->name,
                'email' => $faker->email,
                'image' => $faker->imageUrl(320,240),
                'password' => \Yii::$app->security->generatePasswordHash($faker->password),
                'cityId' => $city,
                'description' => $faker->text,
                'phone' => $faker->phoneNumber,
                'dateAdd' =>  date('Y-m-d',$date)
            ]);
        }
    }
}
