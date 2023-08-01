<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Blogs_categories_details_model extends CI_Model
{

    public function addCategories($data)
    {
        $categories_name = $this->db->escape($data['categories_name']);
        $categories_desc = $this->db->escape($data['categories_desc']);
        $categories_keywords = $this->db->escape($data['categories_keywords']);
        $user_type_at_creation_time = $this->db->escape($data['user_type_at_creation_time']);
        $created_by = $this->db->escape($data['created_by']);
        $query = "INSERT INTO 
                    blogs_categories(
                        categories_name, 
                        categories_description, 
                        categories_keywords, 
                        user_type_at_creation_time,
                        created_by
                        ) 
					values(
                        " . $categories_name . ", 
                        " . $categories_desc . ", 
                        " . $categories_keywords . ", 
                        " . $user_type_at_creation_time . ",
                        " . $created_by . "
                        )";
        $this->db->query($query);

        return $this->db->insert_id();
    }

    public function editCategories($data, $categories_Id)
    {
        $categories_name = $this->db->escape($data['categories_name']);
        $categories_desc = $this->db->escape($data['categories_desc']);
        $categories_keywords = $this->db->escape($data['categories_keywords']);
        $edited_by = $this->db->escape($data['edited_by']);
        $categories_Id = $this->db->escape($categories_Id);
        $query = "UPDATE 
                            blogs_categories
                        SET    
                            categories_name = " . $categories_name . ", 
                            categories_description = " . $categories_desc . ", 
                            categories_keywords = " . $categories_keywords . ", 
                            edited_by = " . $edited_by . ",
                            updated_date = CURRENT_TIMESTAMP
                        WHERE 
                            blogs_categories_id = $categories_Id
                    ";

        $this->db->query($query);
        return $this->db->affected_rows() > 0;
    }

    public function getAllCategories()
    {

        $sql = "SELECT * FROM blogs_categories";
        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }

    public function getCategoriesById($categories_Id)
    {
        $categories_Id = $this->db->escape($categories_Id);
        $sql = "SELECT * FROM blogs_categories WHERE blogs_categories_id = $categories_Id";
        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }

    public function enabledDisabledCategories($categories_Id, $categories_status)
    {
        $categories_status = $this->db->escape($categories_status);
        $edited_by = $this->db->escape($_SESSION['user_id']);
        $categories_Id = $this->db->escape($categories_Id);
        $query = "UPDATE    
                        blogs_categories
                    SET    
                        categories_status = " . $categories_status . ",
                        edited_by = " . $edited_by . ",
                        updated_date = CURRENT_TIMESTAMP
                    WHERE 
                        blogs_categories_id = $categories_Id
                ";
        $this->db->query($query);
        return $this->db->affected_rows();
    }

    public function deleteCategories($categories_Id)
    {
        $categories_Id = $this->db->escape($categories_Id);
        $query = "DELETE FROM    
                        blogs_categories
                    WHERE 
                        blogs_categories_id = $categories_Id
                ";
        $this->db->query($query);
        return $this->db->affected_rows();
    }

    public function getUserNameById($user_id)
    {
        $user_id = $this->db->escape($user_id);
        $sql = "SELECT * FROM user_details WHERE user_id = $user_id";
        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }

    public function checkRelationWithBlogs($categories_Id)
    {
        $categories_Id = $this->db->escape($categories_Id);
        $sql = "SELECT * FROM blogs_details WHERE blogs_categories_id = $categories_Id";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
}
