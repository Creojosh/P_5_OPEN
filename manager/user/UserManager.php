<?php
abstract class UserManager
{
    abstract protected function add(User $user);
    abstract public function count();
    abstract public function delete($id);
    abstract public function getList($debut = -1, $limite = -1);
    abstract public function getUnique($id);
    public function save(User $user)
    {
        if ($user->isValid())
        {
            $user->isNew() ? $this->add($user) : $this->update($user);
        }
        else
        {
            throw new RuntimeException('User doit être valide pour être enregistrée');
        }
    }
    abstract protected function update(User $user);
}