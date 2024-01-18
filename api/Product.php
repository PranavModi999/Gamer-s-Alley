<?php

class Product
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllProducts($filter)
    {
        $catQuery = "SELECT * FROM category WHERE category_name = ?";
        $stmtCat = $this->db->prepare($catQuery);
        $stmtCat->bind_param("s", $filter);
        $stmtCat->execute();
        $categoryIdResult = $stmtCat->get_result();
        $categoryIdRow = $categoryIdResult->fetch_assoc();

        $categoryId = $categoryIdRow['category_id'];
        $query = "";
        if ($categoryId == 1) {
            $query = "SELECT * FROM products";
            $stmtProd = $this->db->prepare($query);
            $stmtProd->execute();
        } else {
            $query = "SELECT * FROM products WHERE product_category = ?";
            $stmtProd = $this->db->prepare($query);
            $stmtProd->bind_param("i", $categoryId);
            $stmtProd->execute();
        }
        $productsResult = $stmtProd->get_result();

        return $productsResult->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductById($productId)
    {
        $query = "SELECT * FROM products WHERE product_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function addProduct($name, $detail, $price, $ratings, $rating_count, $category)
    {

        $query = "INSERT INTO products (product_name, product_detail, product_price, product_ratings, product_rating_count, product_category) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssdddd", $name, $detail, $price, $ratings, $rating_count, $category);

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

    public function updateProduct($productId, $name, $detail, $price, $ratings, $rating_count, $category)
    {
        // Initialize an empty array to store the fields to update
        $fieldsToUpdate = array();

        // Update each field if it's not null
        if ($name !== null) {
            $fieldsToUpdate[] = "product_name = '$name'";
        }

        if ($detail !== null) {
            $fieldsToUpdate[] = "product_detail = '$detail'";
        }

        if ($price !== null) {
            $fieldsToUpdate[] = "product_price = $price";
        }

        if ($ratings !== null) {
            $fieldsToUpdate[] = "product_ratings = $ratings";
        }

        if ($rating_count !== null) {
            $fieldsToUpdate[] = "product_rating_count = $rating_count";
        }

        if ($category !== null) {
            $fieldsToUpdate[] = "product_category = $category";
        }

        // Check if there are fields to update
        if (!empty($fieldsToUpdate)) {
            // Build the SET part of the SQL query
            $setClause = implode(', ', $fieldsToUpdate);

            // Build the full SQL query
            $query = "UPDATE products SET $setClause WHERE product_id = ?";

            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $productId);

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

        return json_encode(array('error' => 'No fields to update'));
    }

    public function deleteProduct($productId)
    {
        $query = "DELETE FROM products WHERE product_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("d", $productId);

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