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

class RegisterForm extends Form
{
    public function getCsrf()
    {
        return $this->security->getSessionToken();
    }

    public function initialize()
    {
        // Email
        $email = new Text('email', [
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
        $password = new Password('password', [
            'placeholder' => 'Password',
            'class' => 'form-control'
        ]);
        
        $password->addValidators([
            new PresenceOf([
                'message' => 'Password field is required.'
            ]),
            new Confirmation([
                'message' => 'Password must match confirmation.',
                'with' => 'confirmPassword'
            ])
        ]);

        $this->add($password);

        // Confirm Password
        $confirmPassword = new Password('confirmPassword', [
            'placeholder' => 'Password Confirm',
            'class' => 'form-control'
        ]);
        
        $confirmPassword->setLabel('Confirm Password');
        
        $confirmPassword->addValidators([
            new PresenceOf([
                'message' => 'The confirmation password is required'
            ])
        ]);

        $this->add($confirmPassword);

        // CSRF
        $csrf = new Hidden('csrf');

        $csrf->addValidator(new Identical([
            'value' => $this->getCsrf(),
            'message' => 'CSRF not correct.'
        ]));

        $csrf->clear();

        $this->add($csrf);

        // Submit button
        $submit = new Submit('Register', ['class' => 'btn btn-success']);

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