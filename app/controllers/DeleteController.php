<?php
use Models\Posts\Interfaces\PostsInterface;
use Models\Posts\Posts;
use Phalcon\Http\Response;

class DeleteController extends ControllerBase
{

    public function indexAction()
    {

    }

    public function ownAction(int $postId = null)
    {
        $this->view->disable();

        if ($this->request->isPost() && $this->request->isAjax()) {
            // We need to check if user is authenticated and has required role and $postId is not null
            if ($this->session->has('auth') && $this->acl->isAllowed($this->session->get('role'), 'Delete', 'own') && $postId !== null) {
                // We need to query database and see if this is own post
                $email = $this->session->get('email');
                $post = Posts::findFirst(
                    [
                        'conditions' => 'id = ?1 AND email = ?2',
                        'bind' => [
                            1 => $postId,
                            2 => $email,
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

                echo json_encode($data);
            } else {
                $this->response->redirect();
            }
        } else {
            $this->response->redirect();
        }
    }

    public function adminAction()
    {
        if ($this->request->isPost() && $this->request->isAjax()) {
            // We need to check if user is authenticated and has required role and $postId is not null
            if ($this->session->has('auth') && $this->acl->isAllowed($this->session->get('role'), 'Delete', 'admin') && $postId !== null) {
                // We need to query database and see if this is own post
                $post = Posts::findFirst(
                    [
                        'conditions' => 'id = ?1',
                        'bind' => [
                            1 => $postId,
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

                echo json_encode($data);
            } else {
                $this->response->redirect();
            }
        } else {
            $this->response->redirect();
        }
    }

}

