<?php

use Twitter\Models\Users\Users;
use Twitter\Library\Forms\RegisterForm;

class RegisterController extends ControllerBase
{
    protected $email;
    protected $password;

    public function initialize()
    {
        $this->view->setTemplateAfter('errors/registerError');
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
            $user = Users::findFirst(
                [
                    'conditions' => 'email = ?1',
                    'bind' => [
                        1 => $this->getEmail(),
                    ]
                ]
            );
            if ($user !== false) {
                return true;
            } else {
                return false;
            }
        } else {
            return null;
        }
    }

    private function __addNewUser()
    {
        if($this->getEmail() !== null && $this->getPassword() !== null) {

            $user = new Users();

            $user->setEmail($this->getEmail());
            $user->setPassword($this->getPassword());

            return $user->save();
        } else {
            return null;
        }
    }

    public function indexAction()
    {
        if ($this->request->isPost()) {
            $form = new RegisterForm();
            if ($form->isValid($this->request->getPost()) != false) {
                $this->setEmail($this->request->getPost('email', 'email', null));
                $this->setPassword($this->request->getPost('password', 'striptags', null));
                if ($this->__isUserRegistered() === false) {
                    $newUser = $this->__addNewUser();

                    if ($newUser === null) {
                        $this->view->error = 'Email and/or password can\'t be null.';
                    } elseif ($newUser === false) {
                        $this->view->error = 'There was some error when adding new user.';
                    } else {
                        $this->session->set('auth', true);
                        $this->session->set('email', $this->getEmail());
                        
                        $this->response->redirect();
                    }
                } else {
                    $this->view->error = 'User is already registered';
                }
            } else {
                $this->view->error = $form->messages();
            }
        } else {
            $this->response->redirect();
        }
    }
}