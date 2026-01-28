<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Complaint Entity
 *
 * @property int $id
 * @property string $student_id
 * @property string $hostel_id
 * @property string $room_id
 * @property string $details
 * @property string $action
 * @property string $category
 * @property int $status
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Student $student
 * @property \App\Model\Entity\Room $room
 * @property \App\Model\Entity\Hostel $hostel
 */
class Complaint extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'student_id' => true,
        'hostel_id' => true,
        'room_id' => true,
        'details' => true,
        'action' => true,
        'category' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'student' => true,
        'room' => true,
        'hostel' => true,
    ];
}
