<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Room $room
 */
?>
<!--Header-->
<div class="row text-body-secondary">
	<div class="col-10">
		<h1 class="my-0 page_title"><?php echo $title; ?></h1>
		<h6 class="sub_title text-body-secondary"><?php echo $system_name; ?></h6>
	</div>
	<div class="col-2 text-end">
		<div class="dropdown mx-3 mt-2">
			<button class="btn p-0 border-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fa-solid fa-bars text-primary"></i>
			</button>
				<div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
							<li><?= $this->Html->link(__('Edit Room'), ['action' => 'edit', $room->id], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?></li>
				<li><?= $this->Form->postLink(__('Delete Room'), ['action' => 'delete', $room->id], ['confirm' => __('Are you sure you want to delete # {0}?', $room->id), 'class' => 'dropdown-item', 'escapeTitle' => false]) ?></li>
				<li><hr class="dropdown-divider"></li>
				<li><?= $this->Html->link(__('List Rooms'), ['action' => 'index'], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?></li>
				<li><?= $this->Html->link(__('New Room'), ['action' => 'add'], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?></li>
							</div>
		</div>
    </div>
</div>
<div class="line mb-4"></div>
<!--/Header-->

<div class="row">
	<div class="col-md-9">
		<div class="card rounded-0 mb-3 bg-body-tertiary border-0 shadow">
			<div class="card-body text-body-secondary">
            <h3><?= h($room->hostel_id) ?></h3>
    <div class="table-responsive">
        <table class="table">
                <tr>
                    <th><?= __('Hostel Id') ?></th>
                    <td><?= h($room->hostel_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Room Id') ?></th>
                    <td><?= h($room->room_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($room->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Level') ?></th>
                    <td><?= $this->Number->format($room->level) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $this->Number->format($room->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($room->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($room->modified) ?></td>
                </tr>
            </table>
            </div>

			</div>
		</div>
		

            
            

            <div class="card rounded-0 mb-3 bg-body-tertiary border-0 shadow">
            <div class="card-body text-body-secondary">
                <h4><?= __('Related Hostels') ?></h4>
                <?php if (!empty($room->hostels)) : ?>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Hostel Id') ?></th>
                            <th><?= __('Room Id') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($room->hostels as $hostels) : ?>
                        <tr>
                            <td><?= h($hostels->id) ?></td>
                            <td><?= h($hostels->hostel_id) ?></td>
                            <td><?= h($hostels->room_id) ?></td>
                            <td><?= h($hostels->status) ?></td>
                            <td><?= h($hostels->created) ?></td>
                            <td><?= h($hostels->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Hostels', 'action' => 'view', $hostels->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Hostels', 'action' => 'edit', $hostels->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Hostels', 'action' => 'delete', $hostels->id], ['confirm' => __('Are you sure you want to delete # {0}?', $hostels->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
            <div class="card rounded-0 mb-3 bg-body-tertiary border-0 shadow">
            <div class="card-body text-body-secondary">
                <h4><?= __('Related Rooms') ?></h4>
                <?php if (!empty($room->rooms)) : ?>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Hostel Id') ?></th>
                            <th><?= __('Room Id') ?></th>
                            <th><?= __('Level') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($room->rooms as $rooms) : ?>
                        <tr>
                            <td><?= h($rooms->id) ?></td>
                            <td><?= h($rooms->hostel_id) ?></td>
                            <td><?= h($rooms->room_id) ?></td>
                            <td><?= h($rooms->level) ?></td>
                            <td><?= h($rooms->status) ?></td>
                            <td><?= h($rooms->created) ?></td>
                            <td><?= h($rooms->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Rooms', 'action' => 'view', $rooms->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Rooms', 'action' => 'edit', $rooms->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Rooms', 'action' => 'delete', $rooms->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rooms->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
            <div class="card rounded-0 mb-3 bg-body-tertiary border-0 shadow">
            <div class="card-body text-body-secondary">
                <h4><?= __('Related Complaints') ?></h4>
                <?php if (!empty($room->complaints)) : ?>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Hostel Id') ?></th>
                            <th><?= __('Room Id') ?></th>
                            <th><?= __('Complaintaction Id') ?></th>
                            <th><?= __('Complaintcategory Id') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($room->complaints as $complaints) : ?>
                        <tr>
                            <td><?= h($complaints->id) ?></td>
                            <td><?= h($complaints->hostel_id) ?></td>
                            <td><?= h($complaints->room_id) ?></td>
                            <td><?= h($complaints->complaintaction_id) ?></td>
                            <td><?= h($complaints->complaintcategory_id) ?></td>
                            <td><?= h($complaints->status) ?></td>
                            <td><?= h($complaints->created) ?></td>
                            <td><?= h($complaints->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Complaints', 'action' => 'view', $complaints->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Complaints', 'action' => 'edit', $complaints->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Complaints', 'action' => 'delete', $complaints->id], ['confirm' => __('Are you sure you want to delete # {0}?', $complaints->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>

		
	</div>
	<div class="col-md-3">
	  Column
	</div>
</div>




