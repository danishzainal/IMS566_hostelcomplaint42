<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StudentsFixture
 */
class StudentsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'matrics_id' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'phone_id' => 'Lorem ipsum dolor ',
                'status' => 1,
                'created' => '2026-01-11 15:14:43',
                'modified' => '2026-01-11 15:14:43',
            ],
        ];
        parent::init();
    }
}
