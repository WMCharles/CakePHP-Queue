<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Mailer\MailerAwareTrait;

class UsersController extends AppController
{

    use MailerAwareTrait;

    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('user'));
    }

    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function notify()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $usersIds = $data['users'];

            unset($data['users']);

            if (is_array($usersIds)) {
                foreach ($usersIds as $id) {
                    # get user
                    $user = $this->Users->get($id);
                    # send to queue
                    /**
                     * @var \App\Mailer\NotifyMailer $mailer
                     */
                    $mailer = $this->getMailer('Notify');
                    $mailer->push('notify', [$user->email, $user->username, $data]);
                }
            }
        }
        $users = $this->Users->find('list')->all();
        $this->set(compact('users'));
    }
}
