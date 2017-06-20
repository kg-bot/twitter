<?php
namespace Twitter\Library\Helpers;

use \Twitter\Models\Users\Users;

class IsUserRegistered
{
    public static function isUserRegistered(string $email)
    {
        $user = Users::findFirst(
            [
                'conditions' => 'email = ?1',
                'bind' => [
                    1 => $email,
                ]
            ]
        );
        if ($user !== false) {
            return true;
        } else {
            return false;
        }
    }
}