<?php
namespace Twitter\Models\Users;

use Twitter\Models\Users\Interfaces\UsersInterface;
use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use InvalidArgumentException;

class Users extends Model implements UsersInterface
{
    protected $id;

    protected $email;

    protected $password;

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
        if (count($this->validator->validate(['email' => $email]))) {
            throw new InvalidArgumentException(
                'Invalid email address'
            );
        }

        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
}