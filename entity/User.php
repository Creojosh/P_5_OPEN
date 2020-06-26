<?php

class User
{
    /** TODO explication protected */
    protected $erreurs = [],
        $user_id,
        $email,
        $role,
        $password,
        $create_at;

    const EMAIL_INVALIDE = 1;
    const ROLE_INVALIDE = 3;
    const PASSWORD_INVALIDE = 4;
    const ROLE_0 = ["user","admin", "super_admin"];
    const ROLE_1 = ["admin", "super_admin"];
    const ROLE_2 = ["super_admin"];

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
     * Méthode permettant de savoir si user est nouveau
     * @return bool
     */
    public function isNew()
    {
        return empty($this->user_id) || empty($this->email);
    }

    /**
     * Méthode permettant de savoir si user est valide.
     * @return bool
     */
    public function isValid()
    {
        return !(empty($this->email) || empty($this->password));
    }


    // SETTERS //

    public function setId($id)
    {
        $this->user_id = (int)$id;
    }

    public function setEmail($email)
    {
        if (!is_string($email) || empty($email)) {
            $this->erreurs[] = self::EMAIL_INVALIDE;
        } else {
            $this->email = $email;
        }
    }


    public function setRole($role)
    {
        if (!is_string($role) || empty($role)) {
            $this->erreurs[] = self::ROLE_INVALIDE;
        } else {
            $this->role = $role;
        }
    }

    public function setPassword($password)
    {
        if (empty($password)) {
            $this->erreurs[] = self::PASSWORD_INVALIDE;
        } else {
            $this->password = $password;
        }
    }


    public function setCreateAt(DateTime $create_at)
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
        return $this->user_id;
    }

    public function email()
    {
        return $this->email;
    }

    public function role()
    {
        return $this->role;
    }

    public function password()
    {
        return $this->password;
    }

    public function createAt()
    {
        return $this->create_at;
    }
}