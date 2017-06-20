<?php
use Models\Posts\Interfaces\PostsInterface;
use Models\Posts\Posts;
use Phalcon\Http\Response;

class DeleteController extends ControllerBase
{
    protected $postId;
    protected $email = null;
    protected $who;

    public function setPostId(int $postId)
    {
        $this->postId = $postId;
    }
    public function getPostId()
    {
        return $this->postId;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }
    public function getEmail()
    {
        return $this->email;
    }

    public function setWho(string $who)
    {
        $this->who = $who;
    }
    public function getWho()
    {
        return $this->who;
    }

    public function indexAction()
    {
        $this->view->disable();
        
        if ($this->request->isPost() && $this->request->isAjax()) {
            // We need to check if user is authenticated
            if ($this->session->has('auth')) {
                $this->setPostId($this->request->getPost('post_id', 'int', 1));
                $this->setEmail($this->session->get('email'));
                echo json_encode( $this->__deletePost());
            } else {
                $this->response->redirect();
            }
        } else {
            $this->response->redirect();
        }
    }

    private function __deletePost()
    {
        // If user is not admin we must provide email
        if ($this->getWho() === 'user' && $this->getEmail() !== null) {
            $post = Posts::findFirst(
                [
                    'conditions' => 'id = ?1 AND email = ?2',
                    'bind' => [
                        1 => $this->getPostId(),
                        2 => $this->getEmail(),
                    ]
                ]
            );
            if ($post !== false) {
                // Post is own, we can delete it
                if ($post->delete() === false) {
                    $data = ['error' => 'There was some error while deleting your post'];
                } else {
                    $data = ['success' => 'Your post is deleted'];
                }
            } else {
                $data = ['error' => 'This post is not your\'s, you can\'t delete it.'];
            }
        } elseif ($who === 'admin') {
            // If user is admin we don't need email becuase admin can delete everything
            $post = Posts::findFirst(
                [
                    'conditions' => 'id = ?1',
                    'bind' => [
                        1 => $this->getPostId(),
                    ]
                ]
            );

            if ($post !== false) {
                // Post is own, we can delete it
                if ($post->delete() === false) {
                    $data = ['error' => 'There was some error while deleting your post'];
                } else {
                    $data = ['success' => 'Your post is deleted'];
                }
            } else {
                $data = ['error' => 'This post does not exist.'];
            }
        } else {
            $data = ['error' => 'You are not allowed to modify posts.'];
        }

        return $data;
    }

}

