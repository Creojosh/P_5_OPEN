<?php
class UserManagerPDO extends UserManager
{
    /**
     * @type PDO
     */
    protected $db;

    /**
     * @param $db PDO
     * @return void
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @see UserManager::add()
     */
    protected function add(User $user)
    {
        $request = $this->db->prepare('INSERT INTO user(username, email, password, role, isActive, active_token, create_at) 
VALUES(:username, :email, :password, :role, :isActive, :active_token, NOW())');
        $request->bindValue(':username', $user->username());
        $request->bindValue(':email', $user->email());
        $request->bindValue(':password', $user->password());
        $request->bindValue(':role', $user->role());
        $request->bindValue(':isActive', null);
        $request->bindValue(':active_token', null);

        $request->execute();
    }

    /**
     * @see UserManager::count()
     */
    public function count()
    {
        return $this->db->query('SELECT COUNT(*) FROM user')->fetchColumn();
    }

    /**
     * @param $id
     * @see UserManager::delete()
     */
    public function delete($id)
    {
        $this->db->exec('DELETE FROM user WHERE user_id = '.(int) $id);
    }

    /**
     * @param int $debut
     * @param int $limite
     * @return array
     * @throws Exception
     * @see UserManager::getList()
     */
    public function getList($debut = -1, $limite = -1)
    {
        $sql = 'SELECT user_id, username, email, role, isActive, create_at FROM user ORDER BY user_id DESC';

        if ($debut != -1 || $limite != -1)
        {
            $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
        }

        $request = $this->db->query($sql);
        $request->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');

        $listUser = $request->fetchAll();

        $request->closeCursor();

        return $listUser;
    }

    /**
     * @param $id
     * @return mixed
     * @throws Exception
     * @see UserManager::getUnique()
     */
    public function getUnique($id)
    {
        $request = $this->db->prepare('SELECT  user_id, username, email, role, isActive, create_at FROM user WHERE user_id = :id');
        $request->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $request->execute();

        $request->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');

        $user = $request->fetch();

        return $user;
    }

    /**
     * @param User $user
     * @see UserManager::update()
     */
    protected function update(User $user)
    {
        $request = $this->db->prepare('UPDATE user 
SET username = :username, email = :email, role = :contenu, password = :contenu, isActive = :isActive, active_token = :active_token WHERE user_id = :id');

        $request->bindValue(':username', $user->username());
        $request->bindValue(':email', $user->email());
        $request->bindValue(':role', $user->role());
        $request->bindValue(':password', $user->password());
        $request->bindValue(':username', $user->username());
        $request->bindValue(':isActive', $user->isActive());
        $request->bindValue(':active_token', $user->activeToken());
        $request->bindValue(':id', $user->id(), PDO::PARAM_INT);

        $request->execute();
    }
}