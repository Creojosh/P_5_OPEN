<?php

class UserManagerPDO extends UserManager
{
    /**
     * @type PDO
     */
    protected $db;

    /**
     * @var SessionObject
     */
    private $session;

    /**
     * @param $db PDO
     * @param SessionObject $session
     */
    public function __construct(PDO $db, SessionObject $session)
    {
        $this->db = $db;
        $this->session = $session;
    }

    /**
     * @param User $user
     * @see UserManager::add()
     */
    protected function add(User $user)
    {
        $request = $this->db->prepare('INSERT INTO user( email, password, role, create_at) 
VALUES(:email, :password, :role, NOW())');
        $request->bindValue(':email', $user->email());
        $request->bindValue(':password', $user->password());
        $request->bindValue(':role', $user->role());
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
        $this->db->exec('DELETE FROM user WHERE user_id = ' . (int)$id);
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
        $sql = 'SELECT user_id, email, role, create_at FROM user ORDER BY user_id DESC';

        if ($debut != -1 || $limite != -1) {
            $sql .= ' LIMIT ' . (int)$limite . ' OFFSET ' . (int)$debut;
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
        $request = $this->db->prepare('SELECT  user_id, email, role, create_at FROM user WHERE user_id = :id');
        $request->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $request->execute();

        $request->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');

        $user = $request->fetch();

        return $user;
    }

    /**
     * @param $email
     * @return mixed
     * @throws Exception
     * @see UserManager::getUnique()
     */
    public function getUniqueEmail($email)
    {
        $request = $this->db->prepare('SELECT  user_id, email, role, password, create_at FROM user WHERE email = :email');
        $request->bindValue(':email', (string)$email, PDO::PARAM_STR);
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
SET email = :email, role = :role, password = :password WHERE user_id = :id');

        $request->bindValue(':email', $user->email());
        $request->bindValue(':role', $user->role());
        $request->bindValue(':password', $user->password());
        $request->bindValue(':id', $user->id(), PDO::PARAM_INT);

        $request->execute();
    }

    public function userIsConnect()
    {
        $ID_Session = $this->session->get('id');
        if (isset($ID_Session)) {
            $session_user = $this->getUnique($ID_Session);
            if (!(in_array($session_user->role(), User::ROLE_1, true))) {
                header('Location: login');
            }else{
                return $session_user;
            }
        } else {
            header('Location: login');
        }
    }
}