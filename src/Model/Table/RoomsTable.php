<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Rooms Model
 *
 * @property \App\Model\Table\HostelsTable&\Cake\ORM\Association\BelongsTo $Hostels
 * @property \App\Model\Table\RoomsTable&\Cake\ORM\Association\BelongsTo $Rooms
 * @property \App\Model\Table\ComplaintsTable&\Cake\ORM\Association\HasMany $Complaints
 * @property \App\Model\Table\HostelsTable&\Cake\ORM\Association\HasMany $Hostels
 * @property \App\Model\Table\RoomsTable&\Cake\ORM\Association\HasMany $Rooms
 *
 * @method \App\Model\Entity\Room newEmptyEntity()
 * @method \App\Model\Entity\Room newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Room> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Room get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Room findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Room patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Room> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Room|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Room saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Room>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Room>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Room>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Room> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Room>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Room>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Room>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Room> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RoomsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('rooms');
        $this->setDisplayField('hostel_id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Hostels', [
            'foreignKey' => 'hostel_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Rooms', [
            'foreignKey' => 'room_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Complaints', [
            'foreignKey' => 'room_id',
        ]);
        $this->hasMany('Hostels', [
            'foreignKey' => 'room_id',
        ]);
        $this->hasMany('Rooms', [
            'foreignKey' => 'room_id',
        ]);
		$this->addBehavior('AuditStash.AuditLog');
		$this->addBehavior('Search.Search');
		$this->searchManager()
			->value('id')
				->add('search', 'Search.Like', [
					//'before' => true,
					//'after' => true,
					'fieldMode' => 'OR',
					'multiValue' => true,
					'multiValueSeparator' => '|',
					'comparison' => 'LIKE',
					'wildcardAny' => '*',
					'wildcardOne' => '?',
					'fields' => ['id'],
				]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('hostel_id')
            ->maxLength('hostel_id', 20)
            ->notEmptyString('hostel_id');

        $validator
            ->scalar('room_id')
            ->maxLength('room_id', 20)
            ->notEmptyString('room_id');

        $validator
            ->integer('level')
            ->requirePresence('level', 'create')
            ->notEmptyString('level');

        $validator
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['hostel_id'], 'Hostels'), ['errorField' => 'hostel_id']);
        $rules->add($rules->existsIn(['room_id'], 'Rooms'), ['errorField' => 'room_id']);

        return $rules;
    }
}
