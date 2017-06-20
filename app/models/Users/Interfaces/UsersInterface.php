<?php
namespace Twitter\Models\Users\Interfaces;

interface UsersInterface
{
    public function onConstruct();

    public function getId();

    public function setId(int $id);

    public function getEmail();

    public function setEmail(string $email);

    public function getPassword();

    public function setPassword($password);
}