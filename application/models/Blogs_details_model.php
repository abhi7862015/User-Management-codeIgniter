<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Blogs_details_model extends CI_Model
{


    public function addBlog($data)
    {
        $blog_title = $this->db->escape($data['blog_title']);
        $short_desc = $this->db->escape($data['short_desc']);
        $blog_content = $this->db->escape($data['blog_content']);
        $blog_keywords = $this->db->escape($data['blog_keywords']);
        $blogs_categories_id = $this->db->escape($data['blogs_categories_id']);
        $created_by = $this->db->escape($data['created_by']);
        $user_type_at_creation_time = $this->db->escape($data['user_type_at_creation_time']);

        $query = "INSERT INTO 
                    blogs_details(
                        blog_title, 
                        blog_short_description,
                        blog_content,
                        blog_keywords, 
                        blogs_categories_id,
                        user_type_at_creation_time,
                        created_by
                        ) 
					values(
                        " . $blog_title . ", 
                        " . $short_desc . ", 
                        " . $blog_content . ", 
                        " . $blog_keywords . ", 
                        " . $blogs_categories_id . ", 
                        " . $user_type_at_creation_time . ",
                        " . $created_by . "
                       
                        )";
        $this->db->query($query);

        return $this->db->insert_id();
    }

    public function editBlog($data, $blog_id)
    {
        $blog_title = $this->db->escape($data['blog_title']);
        $short_desc = $this->db->escape($data['short_desc']);
        $blog_content = $this->db->escape($data['blog_content']);
        $blog_keywords = $this->db->escape($data['blog_keywords']);
        $blogs_categories_id = $this->db->escape($data['blogs_categories_id']);
        $user_type_at_creation_time = $this->db->escape($data['user_type_at_creation_time']);
        $edited_by = $this->db->escape($data['edited_by']);
        $blog_id = $this->db->escape($blog_id);

        $query = "UPDATE 
                        blogs_details
                    SET
                        blog_title = $blog_title, 
                        blog_short_description = $short_desc,
                        blog_content = $blog_content,
                        blog_keywords = $blog_keywords, 
                        blogs_categories_id = $blogs_categories_id,
                        user_type_at_creation_time = $user_type_at_creation_time,
                        edited_by = $edited_by,
                        updated_date = CURRENT_TIMESTAMP
                    WHERE 
                            blog_id = $blog_id
                    ";

        $this->db->query($query);
        return $this->db->affected_rows() > 0;
    }

    public function getAllBlogs()
    {

        $sql = "SELECT * FROM blogs_details";
        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }

    public function getBlogById($blog_id)
    {
        $blog_id = $this->db->escape($blog_id);
        $sql = "SELECT * FROM blogs_details WHERE blog_id = "  . $blog_id;
        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }

    public function enabledDisabledBlog($blog_id, $blog_status)
    {
        $blog_status = $this->db->escape($blog_status);
        $edited_by = $this->db->escape($_SESSION['user_id']);
        $blog_id = $this->db->escape($blog_id);
        $query = "UPDATE    
                        blogs_details
                    SET    
                        blog_status = " . $blog_status . ",
                        edited_by = " . $edited_by . ",
                        updated_date = CURRENT_TIMESTAMP
                    WHERE 
                        blog_Id = $blog_id
                ";
        $this->db->query($query);
        return $this->db->affected_rows();
    }

    public function deleteBlog($blog_id)
    {
        $blog_id = $this->db->escape($blog_id);
        $query = "DELETE FROM    
                        blogs_details
                    WHERE 
                        blog_id = $blog_id
                ";
        $this->db->query($query);
        return $this->db->affected_rows();
    }

    public function getUserDetailsById($user_id)
    { 
        $user_id = $this->db->escape($user_id);
        $sql = "SELECT * FROM user_details WHERE user_id = $user_id";
        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }

    public function getBlogCategoriesDetailsById($categories_Id)
    {
        $categories_Id = $this->db->escape($categories_Id);
        $sql = "SELECT * FROM blogs_categories WHERE blogs_categories_id = " . $categories_Id;
        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }
}
