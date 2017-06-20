<?php

use Twitter\Models\Users\Users;
use Twitter\Library\Forms\LoginForm;
use Twitter\Library\Helpers\IsUserRegistered;

class LoginController extends ControllerBase
{
    protected $email;
    protected $password;

    public function initialize()
    {
        $this->view->setTemplateAfter('errors/loginError');
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $this->security->hash($password);
    }


    private function __isUserRegistered()
    {
        if ($this->getEmail() !== null) {
            return IsUserRegistered::isUserRegistered($this->getEmail());
        } else {
            return null;
        }
    }

    private function __authUser()
    {
        if($this->getEmail() !== null && $this->getPassword() !== null) {
            if ($this->getEmail() === $this->config->adminEmail) {
                // This is admin user
                $this->session->set('role', 'admin');
            } else {
                // This is normal user
                $this->session->set('role', 'user');
            }

            $this->session->set('auth', true);
            $this->session->set('email', $this->getEmail());

            return true;
        } else {
            return null;
        }
    }

    public function indexAction()
    {
        if ($this->request->isPost()) {
            $form = new LoginForm();
            if ($form->isValid($this->request->getPost()) != false) {
                $this->setEmail($this->request->getPost('loginEmail', 'email', null));
                $this->setPassword($this->request->getPost('loginPassword', 'striptags', null));
                if ($this->__isUserRegistered() === true) {
                    // Email is registered, we need to check password hash
                    $user = Users::findFirst(
                        [
                            'conditions' => 'email = ?1',
                            'bind' => [
                                1 => $this->getEmail(),
                            ]
                        ]
                    );
                    if ($this->security->checkHash($this->request->getPost('loginPassword', 'striptags'), $user->password)) {
                        if ($this->__authUser() !== null) {
                            // User is authenticated
                            $this->response->redirect('/');
                        } else {
                            $this->view->error = 'There was some error while authenticating user.';
                        }
                    }
                    
                } else {
                    $this->view->error = 'You are not registered.';
                }
            } else {
                $this->view->error = $form->messages();
            }
        } else {
            $this->response->redirect();
        }
    }
}