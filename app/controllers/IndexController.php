<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->acl = serialize($this->acl);
    }

}
