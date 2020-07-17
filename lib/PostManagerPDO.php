<?php

class PostManagerPDO extends PostManager
{
    /**
     * @type PDO
     */
    protected $db;

    /**
     * @param $db PDO
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @param Post $post
     * @see PostManager::add()
     */
    protected function add(Post $post)
    {
        $request = $this->db->prepare('INSERT INTO post( title, chapo, create_at, update_at,content,user_id) 
VALUES(:title, :chapo, NOW(),NOW(), :content, :user_id )');
        $request->bindValue(':title', $post->title());
        $request->bindValue(':chapo', $post->chapo());
        $request->bindValue(':content', $post->content());
        $request->bindValue(':user_id', $post->userID());
        $request->execute();
    }

    /**
     * @see PostManager::count()
     */
    public function count()
    {
        return $this->db->query('SELECT COUNT(*) FROM post')->fetchColumn();
    }

    /**
     * @param $id
     * @see PostManager::delete()
     */
    public function delete($id)
    {
        $this->db->exec('DELETE FROM post WHERE post_id = ' . (int)$id);
    }

    /**
     * @param int $debut
     * @param int $limite
     * @return array
     * @throws Exception
     * @see PostManager::getList()
     */
    public function getList($debut = -1, $limite = -1)
    {
        $sql = 'SELECT post_id, title,content, chapo, create_at,update_at FROM post ORDER BY post_id DESC';

        if ($debut != -1 || $limite != -1) {
            $sql .= ' LIMIT ' . (int)$limite . ' OFFSET ' . (int)$debut;
        }

        $request = $this->db->query($sql);
        $request->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Post');

        $listPost = $request->fetchAll();

        $request->closeCursor();

        return $listPost;
    }

    /**
     * @param $id
     * @return mixed
     * @throws Exception
     * @see PostManager::getUnique()
     */
    public function getUnique($id)
    {
        $request = $this->db->prepare('SELECT post_id, title, content, chapo, update_at, user_id FROM post WHERE post_id = :id');
        $request->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $request->execute();

        $request->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Post');

        return $request->fetch();
    }

    /**
     * @param $email
     * @return mixed
     * @throws Exception
     * @see PostManager::getUnique()
     */
    public function getUniqueByUserId($user_id)
    {
        $request = $this->db->prepare('SELECT post_id, title, chapo, update_at, user_id FROM post WHERE user_id = :id');
        $request->bindValue(':id', (int)$user_id, PDO::PARAM_INT);
        $request->execute();

        $request->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Post');

        return $request->fetch();
    }

    /**
     * @param Post $post
     * @see PostManager::update()
     */
    protected function update(Post $post)
    {
        $request = $this->db->prepare('UPDATE post 
SET title = :title, chapo = :chapo, content = :content, update_at = NOW() WHERE post_id = :id');

        $request->bindValue(':title', $post->title());
        $request->bindValue(':chapo', $post->chapo());
        $request->bindValue(':content', $post->content());
        $request->bindValue(':id', $post->id(), PDO::PARAM_INT);
        $request->execute();
    }
}