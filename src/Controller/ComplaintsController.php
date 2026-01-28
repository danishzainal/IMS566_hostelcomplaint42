<?php
declare(strict_types=1);

namespace App\Controller;

use AuditStash\Meta\RequestMetadata;
use Cake\Event\EventManager;
use Cake\Routing\Router;

/**
 * Complaints Controller
 *
 * @property \App\Model\Table\ComplaintsTable $Complaints
 */
class ComplaintsController extends AppController
{
	public function initialize(): void
	{
		parent::initialize();

		$this->loadComponent('Search.Search', [
			'actions' => ['index'],
		]);
	}
	
	public function beforeFilter(\Cake\Event\EventInterface $event)
	{
		parent::beforeFilter($event);
	}

	/*public function viewClasses(): array
    {
        return [JsonView::class];
		return [JsonView::class, XmlView::class];
    }*/
	
	public function json()
    {
		$this->viewBuilder()->setLayout('json');
        $this->set('complaints', $this->paginate());
        $this->viewBuilder()->setOption('serialize', 'complaints');
    }
	
	public function csv()
	{
		$this->response = $this->response->withDownload('complaints.csv');
		$complaints = $this->Complaints->find();
		$_serialize = 'complaints';

		$this->viewBuilder()->setClassName('CsvView.Csv');
		$this->set(compact('complaints', '_serialize'));
	}
	
	
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
		$this->set('title', 'Complaints List');
		$this->paginate = [
			'maxLimit' => 10,
        ];
        $query = $this->Complaints->find('search', search: $this->request->getQueryParams())
            ->contain(['Students', 'Rooms', 'Hostels']);
			//->where(['title IS NOT' => null])
        $complaints = $this->paginate($query);
		
		//count
		$this->set('total_complaints', $this->Complaints->find()->count());
		$this->set('total_complaints_archived', $this->Complaints->find()->where(['status' => 2])->count());
		$this->set('total_complaints_active', $this->Complaints->find()->where(['status' => 1])->count());
		$this->set('total_complaints_disabled', $this->Complaints->find()->where(['status' => 0])->count());
		
		//Count By Month
		$this->set('january', $this->Complaints->find()->where(['MONTH(created)' => date('1'), 'YEAR(created)' => date('Y')])->count());
		$this->set('february', $this->Complaints->find()->where(['MONTH(created)' => date('2'), 'YEAR(created)' => date('Y')])->count());
		$this->set('march', $this->Complaints->find()->where(['MONTH(created)' => date('3'), 'YEAR(created)' => date('Y')])->count());
		$this->set('april', $this->Complaints->find()->where(['MONTH(created)' => date('4'), 'YEAR(created)' => date('Y')])->count());
		$this->set('may', $this->Complaints->find()->where(['MONTH(created)' => date('5'), 'YEAR(created)' => date('Y')])->count());
		$this->set('jun', $this->Complaints->find()->where(['MONTH(created)' => date('6'), 'YEAR(created)' => date('Y')])->count());
		$this->set('july', $this->Complaints->find()->where(['MONTH(created)' => date('7'), 'YEAR(created)' => date('Y')])->count());
		$this->set('august', $this->Complaints->find()->where(['MONTH(created)' => date('8'), 'YEAR(created)' => date('Y')])->count());
		$this->set('september', $this->Complaints->find()->where(['MONTH(created)' => date('9'), 'YEAR(created)' => date('Y')])->count());
		$this->set('october', $this->Complaints->find()->where(['MONTH(created)' => date('10'), 'YEAR(created)' => date('Y')])->count());
		$this->set('november', $this->Complaints->find()->where(['MONTH(created)' => date('11'), 'YEAR(created)' => date('Y')])->count());
		$this->set('december', $this->Complaints->find()->where(['MONTH(created)' => date('12'), 'YEAR(created)' => date('Y')])->count());

		$query = $this->Complaints->find();

        $expectedMonths = [];
        for ($i = 11; $i >= 0; $i--) {
            $expectedMonths[] = date('M-Y', strtotime("-$i months"));
        }

        $query->select([
            'count' => $query->func()->count('*'),
            'date' => $query->func()->date_format(['created' => 'identifier', "%b-%Y"]),
            'month' => 'MONTH(created)',
            'year' => 'YEAR(created)'
        ])
            ->where([
                'created >=' => date('Y-m-01', strtotime('-11 months')),
                'created <=' => date('Y-m-t')
            ])
            ->groupBy(['year', 'month'])
            ->orderBy(['year' => 'ASC', 'month' => 'ASC']);

        $results = $query->all()->toArray();

        $totalByMonth = [];
        foreach ($expectedMonths as $expectedMonth) {
            $found = false;
            $count = 0;

            foreach ($results as $result) {
                if ($expectedMonth === $result->date) {
                    $found = true;
                    $count = $result->count;
                    break;
                }
            }

            $totalByMonth[] = [
                'month' => $expectedMonth,
                'count' => $count
            ];
        }

        $this->set([
            'results' => $totalByMonth,
            '_serialize' => ['results']
        ]);

        //data as JSON arrays for report chart
        $totalByMonth = json_encode($totalByMonth);
        $dataArray = json_decode($totalByMonth, true);
        $monthArray = [];
        $countArray = [];
        foreach ($dataArray as $data) {
            $monthArray[] = $data['month'];
            $countArray[] = $data['count'];
        }

        $this->set(compact('complaints', 'monthArray', 'countArray'));
    }

    /**
     * View method
     *
     * @param string|null $id Complaint id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->set('title', 'Complaints Details');
        $complaint = $this->Complaints->get($id, contain: ['Students', 'Rooms', 'Hostels']);
        $this->set(compact('complaint'));

        $this->set(compact('complaint'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
   
  public function add()
{
    $this->set('title', 'New Complaints');
    EventManager::instance()->on('AuditStash.beforeLog', function ($event, array $logs) {
        foreach ($logs as $log) {
            $log->setMetaInfo($log->getMetaInfo() + ['a_name' => 'Add']);
            $log->setMetaInfo($log->getMetaInfo() + ['c_name' => 'Complaints']);
            $log->setMetaInfo($log->getMetaInfo() + ['ip' => $this->request->clientIp()]);
            $log->setMetaInfo($log->getMetaInfo() + ['url' => Router::url(null, true)]);
            $log->setMetaInfo($log->getMetaInfo() + ['slug' => $this->Authentication->getIdentity('slug')->getIdentifier('slug')]);
        }
    });
    $complaint = $this->Complaints->newEmptyEntity();
    $complaint->status = 'Pending'; // ADD THIS LINE
    
    if ($this->request->is('post')) {
        $data = $this->request->getData();
        
        // Set default status if empty or 0
        if (empty($data['status']) || $data['status'] === '0' || $data['status'] === 0) {
            $data['status'] = 'Pending';
        }
        
        $complaint = $this->Complaints->patchEntity($complaint, $data);
        if ($this->Complaints->save($complaint)) {
            $this->Flash->success(__('The complaint has been saved.'));

            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('The complaint could not be saved. Please, try again.'));
    }
    $students = $this->Complaints->Students->find('list', ['limit' => 200])->all();
    $rooms = $this->Complaints->Rooms->find('list', [
        'keyField' => 'id',
        'valueField' => 'room_id',
        'limit' => 200
    ])->all();
    $hostels = $this->Complaints->Hostels->find('list', ['limit' => 200])->all();
    $this->set(compact('complaint', 'students', 'rooms', 'hostels'));
}

    /**
     * Edit method
     *
     * @param string|null $id Complaint id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->set('title', 'Complaints Edit');
		EventManager::instance()->on('AuditStash.beforeLog', function ($event, array $logs) {
			foreach ($logs as $log) {
				$log->setMetaInfo($log->getMetaInfo() + ['a_name' => 'Edit']);
				$log->setMetaInfo($log->getMetaInfo() + ['c_name' => 'Complaints']);
				$log->setMetaInfo($log->getMetaInfo() + ['ip' => $this->request->clientIp()]);
				$log->setMetaInfo($log->getMetaInfo() + ['url' => Router::url(null, true)]);
				$log->setMetaInfo($log->getMetaInfo() + ['slug' => $this->Authentication->getIdentity('slug')->getIdentifier('slug')]);
			}
		});
        $complaint = $this->Complaints->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $complaint = $this->Complaints->patchEntity($complaint, $this->request->getData());
            if ($this->Complaints->save($complaint)) {
                $this->Flash->success(__('The complaint has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The complaint could not be saved. Please, try again.'));
        }
		$students = $this->Complaints->Students->find('list', limit: 200)->all();
		$rooms = $this->Complaints->Rooms->find('list', [ 'keyField' => 'id', 'valueField' => 'room_id', 'limit' => 200])->all();
		$hostels = $this->Complaints->Hostels->find('list', limit: 200)->all();
        $this->set(compact('complaint', 'students', 'rooms', 'hostels'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Complaint id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
		EventManager::instance()->on('AuditStash.beforeLog', function ($event, array $logs) {
			foreach ($logs as $log) {
				$log->setMetaInfo($log->getMetaInfo() + ['a_name' => 'Delete']);
				$log->setMetaInfo($log->getMetaInfo() + ['c_name' => 'Complaints']);
				$log->setMetaInfo($log->getMetaInfo() + ['ip' => $this->request->clientIp()]);
				$log->setMetaInfo($log->getMetaInfo() + ['url' => Router::url(null, true)]);
				$log->setMetaInfo($log->getMetaInfo() + ['slug' => $this->Authentication->getIdentity('slug')->getIdentifier('slug')]);
			}
		});
        $this->request->allowMethod(['post', 'delete']);
        $complaint = $this->Complaints->get($id);
        if ($this->Complaints->delete($complaint)) {
            $this->Flash->success(__('The complaint has been deleted.'));
        } else {
            $this->Flash->error(__('The complaint could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
 public function pdf($id = null)
    {
        $this->viewBuilder()->disableAutoLayout();
        $complaint = $this->Complaints->get($id, ['contain' => ['Students']]);

        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption('pdfConfig', [
            'orientation' => 'portrait',
            'download' => true,
            'filename' => 'Complaint_' . $id . '.pdf'
        ]);

        $this->set(compact('complaint'));
    }

    public function pdfList()
    {
        $this->viewBuilder()->disableAutoLayout();
        $this->paginate = ['contain' => ['Students'], 'maxLimit' => 10];
        $complaints = $this->paginate($this->Complaints);

        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption('pdfConfig', [
            'orientation' => 'portrait',
            'download' => true,
            'filename' => 'complaints_List.pdf'
        ]);

        $this->set(compact('complaints'));
    }
	public function archived($id = null)
    {
		$this->set('title', 'Complaints Edit');
		EventManager::instance()->on('AuditStash.beforeLog', function ($event, array $logs) {
			foreach ($logs as $log) {
				$log->setMetaInfo($log->getMetaInfo() + ['a_name' => 'Archived']);
				$log->setMetaInfo($log->getMetaInfo() + ['c_name' => 'Complaints']);
				$log->setMetaInfo($log->getMetaInfo() + ['ip' => $this->request->clientIp()]);
				$log->setMetaInfo($log->getMetaInfo() + ['url' => Router::url(null, true)]);
				$log->setMetaInfo($log->getMetaInfo() + ['slug' => $this->Authentication->getIdentity('slug')->getIdentifier('slug')]);
			}
		});
        $complaint = $this->Complaints->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $complaint = $this->Complaints->patchEntity($complaint, $this->request->getData());
			$complaint->status = 2; //archived
            if ($this->Complaints->save($complaint)) {
                $this->Flash->success(__('The complaint has been archived.'));

				return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The complaint could not be archived. Please, try again.'));
        }
        $this->set(compact('complaint'));
    }
}
