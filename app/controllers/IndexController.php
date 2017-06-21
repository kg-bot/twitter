<?php
use Twitter\Library\Forms\RegisterForm;
use Twitter\Library\Forms\LoginForm;

use Twitter\Models\Posts\Posts;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        if (!$this->session->has('auth')) {
            
            $this->view->setTemplateAfter('partials/authForms');
            $this->view->form = new RegisterForm();
            $this->view->loginForm = new LoginForm();
        } else {
            $this->view->posts = Posts::find();
        }
    }

    public function logoutAction()
    {
        $this->session->destroy();
        $this->response->redirect();
    }

}

