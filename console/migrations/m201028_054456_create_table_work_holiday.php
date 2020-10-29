<?php
use common\models\WorkHoliday;

use yii\db\Migration;

/**
 * Class m201028_054456_create_table_work_holidays
 */
class m201028_054456_create_table_work_holiday extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%work_holiday}}', [

            'id' => $this->primaryKey(),

            'name' => $this->string()->notNull(),
            'stock' => $this->string(10)->notNull(),
            'holiday' => $this->smallInteger()->notNull()->defaultValue(1),
            'begin' => $this->dateTime(),
            'end' =>  $this->dateTime(),

            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'user' => $this->integer()->notNull(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ], $tableOptions);

        $this->createIndex(
            '{{%idx-work_holiday-stock}}',
            '{{%work_holiday}}',
            'stock'
        );

        $this->createIndex(
            '{{%idx-work_holiday-holiday}}',
            '{{%work_holiday}}',
            'holiday'
        );

        $this->createIndex(
            '{{%idx-work_holiday-begin}}',
            '{{%work_holiday}}',
            'begin'
        );

        $this->createIndex(
            '{{%idx-work_holiday-end}}',
            '{{%work_holiday}}',
            'end'
        );

        $this->insert('{{%work_holiday}}',[
            'name' => 'Новый Год',
            'stock' => 'nyse',
            'holiday' => WorkHoliday::HOLIDDAY,
            'begin' => date('Y-m-d H:i:s',strtotime('01.01.2020 00:00:00')),
            'end' =>  date('Y-m-d H:i:s',strtotime('07.01.2020 23:59:59')),
            'status' => WorkHoliday::ENABLE_DAY,
            'user' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%work_holiday}}',[
            'name' => '23 февраля',
            'stock' => 'nyse',
            'holiday' => WorkHoliday::HOLIDDAY,
            'begin' => date('Y-m-d H:i:s',strtotime('23.02.2020 00:00:00')),
            'end' =>  date('Y-m-d H:i:s',strtotime('23.02.2020 23:59:59')),
            'status' => WorkHoliday::ENABLE_DAY,
            'user' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%work_holiday}}',[
            'name' => '8 марта',
            'stock' => 'nyse',
            'holiday' => WorkHoliday::HOLIDDAY,
            'begin' => date('Y-m-d H:i:s',strtotime('08.03.2020 00:00:00')),
            'end' =>  date('Y-m-d H:i:s',strtotime('08.03.2020 23:59:59')),
            'status' => WorkHoliday::ENABLE_DAY,
            'user' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%work_holiday}}',[
            'name' => '1 мая',
            'stock' => 'nyse',
            'holiday' => WorkHoliday::HOLIDDAY,
            'begin' => date('Y-m-d H:i:s',strtotime('01.05.2020 00:00:00')),
            'end' =>  date('Y-m-d H:i:s',strtotime('01.05.2020 23:59:59')),
            'status' => WorkHoliday::ENABLE_DAY,
            'user' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%work_holiday}}',[
            'name' => 'Новый Год',
            'stock' => 'tse',
            'holiday' => WorkHoliday::HOLIDDAY,
            'begin' => date('Y-m-d H:i:s',strtotime('01.01.2020 00:00:00')),
            'end' =>  date('Y-m-d H:i:s',strtotime('07.01.2020 23:59:59')),
            'status' => WorkHoliday::ENABLE_DAY,
            'user' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%work_holiday}}',[
            'name' => '23 февраля',
            'stock' => 'tse',
            'holiday' => WorkHoliday::HOLIDDAY,
            'begin' => date('Y-m-d H:i:s',strtotime('23.02.2020 00:00:00')),
            'end' =>  date('Y-m-d H:i:s',strtotime('23.02.2020 23:59:59')),
            'status' => WorkHoliday::ENABLE_DAY,
            'user' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%work_holiday}}',[
            'name' => '8 марта',
            'stock' => 'tse',
            'holiday' => WorkHoliday::HOLIDDAY,
            'begin' => date('Y-m-d H:i:s',strtotime('08.03.2020 00:00:00')),
            'end' =>  date('Y-m-d H:i:s',strtotime('08.03.2020 23:59:59')),
            'status' => WorkHoliday::ENABLE_DAY,
            'user' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%work_holiday}}',[
            'name' => '1 мая',
            'stock' => 'tse',
            'holiday' => WorkHoliday::HOLIDDAY,
            'begin' => date('Y-m-d H:i:s',strtotime('01.05.2020 00:00:00')),
            'end' =>  date('Y-m-d H:i:s',strtotime('01.05.2020 23:59:59')),
            'status' => WorkHoliday::ENABLE_DAY,
            'user' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            '{{%idx-work_holiday-stock}}',
            '{{%work_holiday}}'
        );

        $this->dropIndex(
            '{{%idx-work_holiday-holiday}}',
            '{{%work_holiday}}'
        );

        $this->dropIndex(
            '{{%idx-work_holiday-begin}}',
            '{{%work_holiday}}'
        );

        $this->dropIndex(
            '{{%idx-work_holiday-end}}',
            '{{%work_holiday}}'
        );

        $this->dropTable('{{%work_holiday}}');
    }

}
