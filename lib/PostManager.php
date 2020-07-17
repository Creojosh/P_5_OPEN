<?php

abstract class PostManager
{
    abstract protected function add(Post $post);

    abstract public function count();

    abstract public function delete($id);

    abstract public function getList($debut = -1, $limite = -1);

    abstract public function getUnique($id);

    abstract public function getUniqueByUserId($user_id);

    public function save(Post $post)
    {
        if ($post->isValid())
            $post->isNew() ? $this->add($post) : $this->update($post);

        else
            throw new RuntimeException('Post doit être valide pour être enregistrée');

    }

    abstract protected function update(Post $post);
}