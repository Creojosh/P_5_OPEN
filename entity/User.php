<?php

class User
{
    protected $erreurs = [],
        $user_id,
        $username,
        $email,
        $role,
        $password,
        $isActive,
        $active_token,
        $create_at;
    
    const EMAIL_INVALIDE = 1;
    const USERNAME_INVALIDE = 2;
    const ROLE_INVALIDE = 3;
    const PASSWORD_INVALIDE = 4;
    const ISACTIVE_INVALIDE = 5;
    const ACTIVE_TOKEN_INVALIDE = 6;


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
        foreach ($donnees as $attribut => $valeur)
        {
            $methode = 'set'.ucfirst($attribut);

            if (is_callable([$this, $methode]))
            {
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
        return empty($this->id);
    }

    /**
     * Méthode permettant de savoir si user est valide.
     * @return bool
     */
    public function isValid()
    {
        return !(empty($this->username) || empty($this->email) || empty($this->role)
            || empty($this->password)| empty($this->create_at));
    }


    // SETTERS //

    public function setId($id)
    {
        $this->user_id = (int) $id;
    }

    public function setEmail($email)
    {
        if (!is_string($email) || empty($email))
        {
            $this->erreurs[] = self::EMAIL_INVALIDE;
        }
        else
        {
            $this->email = $email;
        }
    }

    public function setUsername($username)
    {
        if (!is_string($username) || empty($username))
        {
            $this->erreurs[] = self::USERNAME_INVALIDE;
        }
        else
        {
            $this->username = $username;
        }
    }

    public function setRole($role)
    {
        if ($role != 'user' || $role != 'admin' || empty($role))
        {
            $this->erreurs[] = self::ROLE_INVALIDE;
        }
        else
        {
            $this->role = $role;
        }
    }

    public function setPassword($password)
    {
        if (empty($password))
        {
            $this->erreurs[] = self::PASSWORD_INVALIDE;
        }
        else
        {
            $pass_hache = password_hash($password, PASSWORD_DEFAULT);
            $this->password = $pass_hache;
        }
    }

    public function setIsActive($isActive)
    {
        if(!is_bool($isActive)){
            $this->erreurs[] = self::ISACTIVE_INVALIDE;
        }else{
            $this->isActive = $isActive;

        }

    }

    public function setActiveToken($active_token)
    {
        if (!is_string($active_token) || empty($active_token))
        {
            $this->erreurs[] = self::ACTIVE_TOKEN_INVALIDE;
        }
        else
        {
            $this->active_token = $active_token;
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

    public function username()
    {
        return $this->username;
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

    public function isActive()
    {
        return $this->isActive;
    }
    public function activeToken()
    {
        return $this->active_token;
    }
    public function createAt()
    {
        return $this->create_at;
    }
}