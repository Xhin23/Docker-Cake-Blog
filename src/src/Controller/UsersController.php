<?php
namespace App\Controller;

use App\Controller\AppController;

class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        if (($action == 'login' && !$auth->user('id')) || $action == 'logout')
        {
          return true;
        }
        return false;
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('Your username or password is incorrect.');
        }
    }

    public function logout()
    {
        $this->Flash->success('You are now logged out.');
        return $this->redirect($this->Auth->logout());
    }
}
