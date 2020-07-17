<?php

class Post
{
    protected $erreurs = [],
        $post_id,
        $user_id,
        $title,
        $chapo,
        $create_at,
        $update_at,
        $content;

    const TITLE_INVALIDE = 1;

    /**
     * Constructeur de la classe qui assigne les données spécifiées en paramètre aux attributs correspondants.
     * @param $valeurs array Les valeurs à assigner
     * @return void
     */
    public function __construct($valeurs = [])
    {
        if (!empty($valeurs)) // Si on a spécifié des valeurs, alors on hydrate l'objet.
        {
            $this->hydrate($valeurs);
        }
    }

    /**
     * Méthode assignant les valeurs spécifiées aux attributs correspondant.
     * @param $donnees array Les données à assigner
     * @return void
     */
    public function hydrate($donnees)
    {
        foreach ($donnees as $attribut => $valeur) {
            $methode = 'set' . ucfirst($attribut);

            if (is_callable([$this, $methode])) {
                $this->$methode($valeur);
            }
        }
    }

    /**
     * Méthode permettant de savoir si post est nouveau
     * @return bool
     */
    public function isNew()
    {
        return empty($this->post_id);
    }

    /**
     * Méthode permettant de savoir si post est valide.
     * @return bool
     */
    public function isValid()
    {
        return !(empty($this->user_id) || empty($this->title));
    }


    // SETTERS //

    public function setId($id)
    {
        $this->post_id = (int)$id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = (int)$user_id;
    }

    public function setTitle($title)
    {
        if (!is_string($title) || empty($title)) {
            $this->erreurs[] = self::TITLE_INVALIDE;
        } else
            $this->title = $title;
    }

    public function setChapo($chapo)
    {
        $this->chapo = $chapo;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setCreateAt(DateTime $create_at)
    {
        $this->create_at = $create_at;
    }

    public function setUpdateAt(DateTime $create_at)
    {
        $this->create_at = $create_at;
    }

    // GETTERS //

    public function erreurs()
    {
        return $this->erreurs;
    }

    public function id()
    {
        return $this->post_id;
    }

    public function userID()
    {
        return $this->user_id;
    }

    public function title()
    {
        return $this->title;
    }


    public function chapo()
    {
        return $this->chapo;
    }

    public function content()
    {
        return $this->content;
    }

    public function createAt()
    {
        return $this->create_at;
    }

    public function updateAt()
    {
        return $this->update_at;
    }
}