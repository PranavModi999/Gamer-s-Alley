<?php

class Cart
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllCarts()
    {
        $query = "SELECT * FROM cart";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCartById($userId)
    {
        $query = "SELECT * FROM cart WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function addCart($user_id, $product_id, $qty)
    {
        // Hash the password before storing it

        $query = "INSERT INTO cart (user_id, product_id, qty) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iii", $user_id, $product_id, $qty);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateCart($cart_id, $user_id, $product_id, $qty)
    {
        // Initialize an empty array to store the fields to update
        $fieldsToUpdate = array();

        // Hash the password before updating
        if ($product_id !== null) {
            $fieldsToUpdate[] = "product_id = '$product_id'";
        }

        if ($qty !== null) {
            $fieldsToUpdate[] = "qty = '$qty'";
        }

        // Check if there are fields to update
        if (!empty($fieldsToUpdate)) {
            // Build the SET part of the SQL query
            $setClause = implode(', ', $fieldsToUpdate);

            // Build the full SQL query
            $query = "UPDATE cart SET $setClause WHERE user_id = ?";

            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $cart_id);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    public function deleteCart($cart_id)
    {
        $query = "DELETE FROM cart WHERE id=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $cart_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
