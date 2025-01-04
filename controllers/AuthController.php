<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("../admin/modelClass.php");
// use Model;
class Authentication extends Model
{

    protected function table()
    {
        return 'users';
    }


    public function register($data = [])
    {
        $this->query('INSERT INTO ' . $this->table() . '(email, pass, first_name, last_name) VALUES(:email, :pass, :first_name, :last_name)');
        $this->bind(':email', $data['email']);
        $this->bind(':pass', $data['pass']);
        $this->bind(':first_name', $data['first_name']);
        $this->bind(':last_name', $data['last_name']);

        $this->execute();

        return true;
    }

public function login($data = [])
{
    // Start session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Prepare the query to check if the user exists
    $this->query('SELECT * FROM ' . $this->table() . ' WHERE email = :email');
    $this->bind(':email', $data['email']);
    
    $row = $this->single();

    // Check if the query returned a row and verify the password
    if (!empty($row) && password_verify($data['password'], $row['pass'])) {
        // User found and password verified, create session
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $row['id'];

        return true;
    } else {
        // Return false if login fails
        return false;
    }
}


    public function deleteMenu($id)
    {
        $id = $_SESSION['id'];

        $this->query('DELETE FROM ' . $this->table() . ' WHERE id = :id;');
        $this->bind(':id', $id);
        $this->execute();
    }
    public function find($email)
    {

        $this->query('SELECT * FROM ' . $this->table() . ' WHERE email = :email;');
        $this->bind(':email', $email);
        return $this->single();
    }
}

$auth = new Authentication();
