<?php
use Twitter\Library\Forms\RegisterForm;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        if (!$this->session->has('auth')) {
            $this->view->setTemplateAfter('forms/registerForm');
            $this->view->form = new RegisterForm();
        }
    }

}

