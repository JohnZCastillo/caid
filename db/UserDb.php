<?php

namespace db;

require_once 'autoload.php';

use Exception;
use model\user\Role;
use model\user\User;

class UserDb
{

    public static function login($username, $password)
    {
        try {
            $user = self::getUserByUsername($username);
            return  $user->getPassword() ===  $password && $user->getUsername() === $username;
        } catch (Exception $ex) {
            return false;
        }
    }

    //register user to db
    public static function addUser(User $user)
    {

        //check if id is taken
        if (self::isIdTaken($user->getId())) {
            throw new Exception('ID is alredy present');
        }

        //check if email is available
        if (self::isEmailTaken($user->getEmail())) {
            throw new Exception('Email is already present');
        }

        //check if username is available
        if (self::isUsernameTaken($user->getUsername())) {
            throw new Exception('Username is already taken');
        }

        $id = $user->getId();
        $role = $user->getRole();
        $username = $user->getUsername();
        $password = $user->getPassword();
        $email = $user->getEmail();
        $fName = $user->getFName();
        $mName = $user->getMName();
        $lName = $user->getLName();
        $gender = $user->getGender();
        $course = $user->getCourse();
        $year = $user->getYear();
        $birthdate = $user->getBirthdate();
        $profile = $user->getProfile();

        $connection = Database::open();

        $stmt = $connection->prepare("INSERT INTO user values(?,?,?,?,?,?,?,?,?,?,?,?,?)");

        $stmt->bind_param(
            "ssssssssssdss",
            $id,
            $role,
            $username,
            $password,
            $email,
            $fName,
            $mName,
            $lName,
            $gender,
            $course,
            $year,
            $birthdate,
            $profile,
        );

        $stmt->execute();

        $error = mysqli_error($connection);

        Database::close($connection);

        return $error;
    }

    //check if email is taken    
    public static function isEmailTaken($email)
    {
        try {

            // open database connecti/on
            $conn = Database::open();

            $stmt = $conn->prepare("SELECT username FROM user where email = ?");

            // set the ?'s mark data to parameter's data
            $stmt->bind_param("s", $email);

            // execute prepared statement
            $stmt->execute();

            //get result
            $result = $stmt->get_result();

            // store result in array
            $data = $result->fetch_assoc();

            // throw an exception data is null that means email is not present in db
            if ($data == null) {
                Database::close($conn);
                throw new Exception('Username not found | Invalid Connection');
            }

            Database::close($conn);
        } catch (Exception $ex) {
            return false;
        }

        return true;
    }

    //check if username is present
    public static function isUsernameTaken($username)
    {
        try {

            // open database connecti/on
            $conn = Database::open();

            $stmt = $conn->prepare("SELECT username FROM user where username = ?");

            // set the ?'s mark data to parameter's data
            $stmt->bind_param("s", $username);

            // execute prepared statement
            $stmt->execute();

            //get result
            $result = $stmt->get_result();

            // store result in array
            $data = $result->fetch_assoc();

            // throw an exception data is null that means email is not present in db
            if ($data == null) {
                Database::close($conn);
                throw new Exception('Username not found | Invalid Connection');
            }

            Database::close($conn);
        } catch (Exception $ex) {
            return false;
        }

        return true;
    }

    //check if id is present
    public static function isIdTaken($id)
    {
        try {

            // open database connecti/on
            $conn = Database::open();

            $stmt = $conn->prepare("SELECT username FROM user where student_number = ?");

            // set the ?'s mark data to parameter's data
            $stmt->bind_param("s", $id);

            // execute prepared statement
            $stmt->execute();

            //get result
            $result = $stmt->get_result();

            // store result in array
            $data = $result->fetch_assoc();

            // throw an exception data is null that means email is not present in db
            if ($data == null) {
                Database::close($conn);
                throw new Exception('Username not found | Invalid Connection');
            }

            Database::close($conn);
        } catch (Exception $ex) {
            return false;
        }

        return true;
    }

    //get user by username    
    public static function getUserByUsername($username)
    {

        // open database connection
        $conn = Database::open();

        $stmt = $conn->prepare("SELECT * FROM user where username = ?");

        // set the ?'s mark data to parameter's data
        $stmt->bind_param("s", $username);

        // execute prepared statement
        $stmt->execute();

        //get result
        $result = $stmt->get_result();

        // store result in array
        $data = $result->fetch_assoc();

        // throw an exception data is null that means username is not present in db
        if ($data == null) {
            Database::close($conn);
            throw new Exception('Incorrect username or password');
        }

        Database::close($conn);

        //create a user object
        $user = new User(
            $data["student_number"],
            $data["username"],
            $data["password"],
            $data["email"],
            $data["first_name"],
            $data["middle_name"],
            $data["last_name"],
            $data["gender"],
            $data["course_id"],
            $data["year"],
            $data["birthdate"]
        );

        // update user base on db
        $user->setRole($data['role']);

        // update user profile base on db
        $user->setProfile($data['profile']);

        return $user;
    }

    //get user by username    
    public static function getUsers()
    {

        // open database connection
        $conn = Database::open();

        $stmt = $conn->prepare("SELECT * FROM user");

        // execute prepared statement
        $stmt->execute();

        $users = array();

        //get result
        $result = $stmt->get_result();

        while ($data = $result->fetch_assoc()) {
            //crete user base on collected data | more like format 
            //create a user object
            $user = new User(
                $data["student_number"],
                $data["username"],
                $data["password"],
                $data["email"],
                $data["first_name"],
                $data["middle_name"],
                $data["last_name"],
                $data["gender"],
                $data["course_id"],
                $data["year"],
                $data["birthdate"]
            );

            // update user base on db
            $user->setRole($data['role']);

            // update user profile base on db
            $user->setProfile($data['profile']);;

            array_push($users, $user);
        }

        // throw an exception data is null that means username is not present in db
        if ($users == null) {
            Database::close($conn);
            throw new Exception('data null');
        }

        Database::close($conn);

        return $users;
    }

    //get user by username    
    public static function getStudents()
    {

        $student = Role::$STUDENT;

        // open database connection
        $conn = Database::open();

        $stmt = $conn->prepare("SELECT * FROM user where role = ?");

        // set the ?'s mark data to parameter's data
        $stmt->bind_param("s", $student);

        // execute prepared statement
        $stmt->execute();

        $users = array();

        //get result
        $result = $stmt->get_result();

        while ($data = $result->fetch_assoc()) {
            //crete user base on collected data | more like format 
            //create a user object
            $user = new User(
                $data["student_number"],
                $data["username"],
                $data["password"],
                $data["email"],
                $data["first_name"],
                $data["middle_name"],
                $data["last_name"],
                $data["gender"],
                $data["course_id"],
                $data["year"],
                $data["birthdate"]
            );

            // update user base on db
            $user->setRole($data['role']);

            // update user profile base on db
            $user->setProfile($data['profile']);;

            array_push($users, $user);
        }

        // throw an exception data is null that means username is not present in db
        if ($users == null) {
            Database::close($conn);
            throw new Exception('data null');
        }

        Database::close($conn);

        return $users;
    }

    // upaate products details on db
    static function updateUserProfile($id, $link)
    {
        $connection = Database::open();

        $stmt = $connection->prepare("UPDATE user set profile = ? WHERE student_number = ?");

        $stmt->bind_param("ss", $link, $id);
        $stmt->execute();

        $error = mysqli_error($connection);

        Database::close($connection);

        if ($error !== null && $error !== '') {
            throw new Exception("Update Failed ");
        }
    }
}
