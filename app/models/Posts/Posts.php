<?php
namespace Models\Posts

use Models\Posts\Interfaces\PostsInterface
use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use InvalidArgumentException;

class Posts extends Model implements PostsInterface
{
    protected $id;

    protected $email;

    protected $post;

    protected $validator;

    public function onConstruct()
    {
        $this->validator = new Validation();
        $this->validator->add(
            'email',
            new Email(
                [
                    'message' => 'Email is not valid',
                ]
            )
        );
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        if (count($this->validator->validate($email))) {
            throw new InvalidArgumentException(
                'Invalid email address'
            );
        }

        $this->email = $email;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function setPost(string $post)
    {
        if (strlen($post) < 5) {
            throw new InvalidArgumentException(
                'Post can\'t be less than 5 characters long.'
            );
        } elseif (strlen($post) > 255) {
            throw new InvalidArgumentException(
                'Post can\'t be more than 255 characters long.'
            );
        }

        $this->post = $post;
    }
}