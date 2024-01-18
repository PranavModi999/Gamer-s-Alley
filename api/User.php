<?php

class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllUsers() {
        $query = "SELECT * FROM users";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserById($userId) {
        $query = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function addUser($first_name, $last_name, $email, $password, $user_type) {
        // Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (user_first_name, user_last_name, user_email, user_password, user_type) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sssss", $first_name, $last_name, $email, $hashedPassword, $user_type);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function login($email, $password) {
        $query = "SELECT * FROM users WHERE user_email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Check if a user with the provided email exists
        if (!$user) {
            return json_encode(array('error' => 'Invalid email or password'));
        }

        // Verify the password with hashed password
        if (password_verify($password, $user['user_password'])) {
            unset($user['user_password']);
            return json_encode(array('success' => true, 'user' => $user));
        } else {
            return json_encode(array('error' => 'Invalid email or password'));
        }
    }

    public function updateUser($userId, $first_name, $last_name, $password, $email, $user_type) {
        // Initialize an empty array to store the fields to update
        $fieldsToUpdate = array();

        // Hash the password before updating
        if ($password !== null) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $fieldsToUpdate[] = "user_password = '$hashedPassword'";
        }
        
        if ($first_name !== null) {
            $fieldsToUpdate[] = "user_first_name = '$first_name'";
        }

        if ($last_name !== null) {
            $fieldsToUpdate[] = "user_last_name = '$last_name'";
        }

        if ($email !== null) {
            $fieldsToUpdate[] = "user_email = '$email'";
        }

        if ($user_type !== null) {
            $fieldsToUpdate[] = "user_type = '$user_type'";
        }

        // Check if there are fields to update
        if (!empty($fieldsToUpdate)) {
            // Build the SET part of the SQL query
            $setClause = implode(', ', $fieldsToUpdate);

            // Build the full SQL query
            $query = "UPDATE users SET $setClause WHERE user_id = ?";
            
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $userId);
            
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    public function deleteUser($userId) {
        $query = "DELETE FROM users WHERE user_id=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
