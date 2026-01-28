<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RoomsFixture
 */
class RoomsFixture extends TestFixture
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
                'hostel_id' => 'Lorem ipsum dolor ',
                'room_id' => 'Lorem ipsum dolor ',
                'level' => 1,
                'status' => 1,
                'created' => '2026-01-11 15:15:41',
                'modified' => '2026-01-11 15:15:41',
            ],
        ];
        parent::init();
    }
}
