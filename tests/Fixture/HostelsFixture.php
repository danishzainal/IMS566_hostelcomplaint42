<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * HostelsFixture
 */
class HostelsFixture extends TestFixture
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
                'status' => 1,
                'created' => '2026-01-11 15:16:08',
                'modified' => '2026-01-11 15:16:08',
            ],
        ];
        parent::init();
    }
}
