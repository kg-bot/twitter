<?php
namespace Models\Posts\Interfaces

interface PostsInterface
{
    public function onConstruct();

    public function getId();

    public function setId();

    public function getEmail();

    public function setEmail();

    public function getPost();

    public function setPost();
}