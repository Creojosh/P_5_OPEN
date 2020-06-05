<?php


class User
{
    /**
     * @var Database
     */
    private $_db;

    public function __construct()
    {
        $this->_db = new Database();
    }

    public function createUser($username, $email, $password)
    {
        try {
            $pass_hache = password_hash($password, PASSWORD_DEFAULT);

            $request = $this->_db->dbConnect()
                ->prepare
                ('INSERT INTO user(username, email, password, role, isActive, active_token, create_at) 
VALUES(:username, :email, :password, :role, :isActive, :active_token, :create_at)');
            $request->execute(array(
                    'username' => $username,
                    'email' => $email,
                    'password' => $pass_hache,
                    'role' => 'user',
                    'isActive' => null,
                    'active_token' => null,
                    'create_at' => date("Y-m-d H:i:s")
                )
            );
            return 'success';
        } catch (Exception $e) {
            return 'error';
        }
    }
}