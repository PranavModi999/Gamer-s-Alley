<?php

class Category
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllCategories()
    {
        $query = "SELECT * FROM category";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCategoryById($categoryId)
    {
        $query = "SELECT * FROM category WHERE category_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function getCategoryIdByName($categoryName)
    {
        $query = "SELECT * FROM category WHERE category_name = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $categoryName);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function addCategory($name)
    {

        $query = "INSERT INTO category (category_name) VALUES (?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $name,);

        try {
            if ($stmt->execute()) {
                return json_encode(array('success' => true));
            } else {
                $errorMessage = "Error executing query: " . $stmt->error;
                return json_encode(array('error' => $errorMessage));
            }
        } catch (Exception $e) {
            return json_encode(array('error' => $e->getMessage()));
        }
    }

    public function updateCategory($categoryId, $name)
    {
        $query = "UPDATE category SET category_name=? WHERE category_id=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sd", $name, $categoryId);

        try {
            if ($stmt->execute()) {
                return json_encode(array('success' => true));
            } else {
                $errorMessage = "Error executing query: " . $stmt->error;
                return json_encode(array('error' => $errorMessage));
            }
        } catch (Exception $e) {
            return json_encode(array('error' => $e->getMessage()));
        }
    }

    public function deleteCategory($categoryId)
    {
        $query = "DELETE FROM category WHERE category_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("d", $categoryId);

        try {
            if ($stmt->execute()) {
                return json_encode(array('success' => true));
            } else {
                $errorMessage = "Error executing query: " . $stmt->error;
                return json_encode(array('error' => $errorMessage));
            }
        } catch (Exception $e) {
            return json_encode(array('error' => $e->getMessage()));
        }
    }
    
}