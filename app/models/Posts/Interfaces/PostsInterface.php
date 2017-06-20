<?php
namespace Twitter\Models\Posts\Interfaces;

interface PostsInterface
{
    public function onConstruct();

    public function getId();

    public function setId(int $id);

    public function getEmail();

    public function setEmail(string $email);

    public function getPost();

    public function setPost(string $post);
}