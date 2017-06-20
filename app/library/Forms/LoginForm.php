<?php
namespace Twitter\Library\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Submit;

use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation\Validator\Identical;

class LoginForm extends Form
{
    public function getCsrf()
    {
        return $this->security->getSessionToken();
    }

    public function initialize()
    {
        // Email
        $email = new Text('loginEmail', [
            'placeholder' => 'Email address',
            'class' => 'form-control'
        ]);
        
        $email->addValidators([
            new PresenceOf([
                'message' => 'Email is required.'
            ]),
            new Email([
                'message' => 'Email is not valid.'
            ])
        ]);

        $this->add($email);

        // Password
        $password = new Password('loginPassword', [
            'placeholder' => 'Password',
            'class' => 'form-control'
        ]);
        
        $password->addValidators([
            new PresenceOf([
                'message' => 'Password field is required.'
            ]),
            new StringLength([
                'min' => 5,
                'max' => 255,
                'message' => 'Password must be between 5 and 255 characters.'
            ])
        ]);

        $this->add($password);

        // CSRF
        $csrf = new Hidden('csrf');

        $csrf->addValidator(new Identical([
            'value' => $this->getCsrf(),
            'message' => 'CSRF not correct.'
        ]));

        $csrf->clear();

        $this->add($csrf);

        // Submit button
        $submit = new Submit('Login', ['class' => 'btn btn-success']);

        $this->add($submit);

    }

    public function messages()
    {
        if (count($this->getMessages()) > 0) {
            foreach ($this->getMessages() as $message) {
                return $message;
            }
        }
    }
}