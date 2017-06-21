<?php
use Models\Posts\Interfaces\PostsInterface;
use Models\Posts\Posts;
use Phalcon\Http\Response;

class InsertController extends ControllerBase
{
    protected $postContent;

    public function getPostContent()
    {
        return $this->postContent;
    }
    public function setPostContent($postContent)
    {
        $this->postContent = substr($postContent, 0, 255);
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }
    public function getEmail()
    {
        return $this->email;
    }

    public function indexAction()
    {
        $this->view->disable();
        
        if ($this->request->isPost() && $this->request->isAjax()) {
            // We need to check if user is authenticated
            if ($this->session->has('auth')) {
                $this->setPostContent($this->request->getPost('postContent', 'striptags'));
                $this->setEmail($this->session->get('email'));
                
                echo json_encode( $this->__insertPost());
            } else {
                $this->response->redirect();
            }
        } else {
            $this->response->redirect();
        }
    }

    private function __insertPost()
    {
        if ($this->getEmail() !== null) {
            
            $post = new Posts();
            $post->setEmail($this->getEmail());
            $post->setPost((string) $this->getPostContent());

            if ($post->create() === false) {
                $data = ['error' => 'Couldn\'t create new post.'];
            } else {
                $this->response->redirect();
            }
        }

        return $data;
    }

}

