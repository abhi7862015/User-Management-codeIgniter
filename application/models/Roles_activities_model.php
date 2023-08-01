<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Roles_activities_model extends CI_Model
{


    public function addRoleActivities($data)
    {
        $activities_name = $this->db->escape($data['activities_name']);
        $activities_description = $this->db->escape($data['activities_description']);
        $activities_keywords = $this->db->escape($data['activities_keywords']);
        $redirection_url = $this->db->escape($data['redirection_url']);
        $message_to_user = $this->db->escape($data['message_to_user']);
        $user_type_at_creation_time = $this->db->escape($data['user_type_at_creation_time']);
        $created_by = $this->db->escape($data['created_by']);


        if ($data['redirection_url']!='' && $data['message_to_user']!='') {
            $query = "INSERT INTO 
                        roles_activities_details(
                            activities_name, 
                            activities_description,
                            activities_keywords,
                            redirection_url,
                            message_to_user,
                            created_by,
                            user_type_at_creation_time
                            ) 
                        values(
                            " . $activities_name . ", 
                            " . $activities_description . ", 
                            " . $activities_keywords . ", 
                            " . $redirection_url . ",
                            " . $message_to_user . ",
                            " . $created_by . ",
                            " . $user_type_at_creation_time . "
                            )";
        } else if ($data['redirection_url']!='') {
            $query = "INSERT INTO 
                            roles_activities_details(
                                activities_name, 
                                activities_description,
                                activities_keywords,
                                redirection_url,
                                created_by,
                                user_type_at_creation_time
                                ) 
                        values(
                            " . $activities_name . ", 
                            " . $activities_description . ", 
                            " . $activities_keywords . ", 
                            " . $redirection_url . ",
                            " . $created_by . ",
                            " . $user_type_at_creation_time . "
                            )";
        } else if ($data['message_to_user']!='') {
            $query = "INSERT INTO 
                        roles_activities_details(
                            activities_name, 
                            activities_description,
                            activities_keywords,
                            message_to_user,
                            created_by,
                            user_type_at_creation_time
                            ) 
                        values(
                            " . $activities_name . ", 
                            " . $activities_description . ", 
                            " . $activities_keywords . ", 
                            " . $message_to_user . ",
                            " . $created_by . ",
                            " . $user_type_at_creation_time . "
                            )";
        } else {
            $query = "INSERT INTO 
                        roles_activities_details(
                            activities_name, 
                            activities_description,
                            activities_keywords,
                            created_by,
                            user_type_at_creation_time
                            ) 
                        values(
                            " . $activities_name . ", 
                            " . $activities_description . ", 
                            " . $activities_keywords . ", 
                            " . $created_by . ",
                            " . $user_type_at_creation_time . "
                            )";
        }
        $this->db->query($query);

        return $this->db->insert_id();
    }

    public function editRoleActivities($data, $roles_activities_id)
    {
        $activities_name = $this->db->escape($data['activities_name']);
        $activities_description = $this->db->escape($data['activities_description']);
        $activities_keywords = $this->db->escape($data['activities_keywords']);
        $roles_activities_id = $this->db->escape($roles_activities_id);
        $edited_by = $this->db->escape($data['edited_by']);
        $user_type = $this->db->escape($data['user_type_at_creation_time']);

        $query = "UPDATE 
                        roles_activities_details
                    SET
                        activities_name = $activities_name, 
                        activities_description = $activities_description,
                        activities_keywords = $activities_keywords,
                        edited_by = $edited_by,
                        user_type_at_creation_time = $user_type,
                        updated_date = CURRENT_TIMESTAMP
                    WHERE 
                        roles_activities_id = $roles_activities_id
                    ";

        $this->db->query($query);
        return $this->db->affected_rows() > 0;
    }

    public function getAllRolesActivities()
    {

        $sql = "SELECT * FROM roles_activities_details";
        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }

    public function getAllRolesActivitiesByStatus($activities_status)
    {
        $activities_status = $this->db->escape($activities_status);
        $sql = "SELECT * FROM roles_activities_details WHERE activities_status = $activities_status";
        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }


    public function getRoleActivitiesById($roles_activities_id)
    {
        $roles_activities_id = $this->db->escape($roles_activities_id);
        $sql = "SELECT * FROM roles_activities_details WHERE roles_activities_id = " . $roles_activities_id;
        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }

    public function enabledDisabledRoleActivities($roles_activities_id, $activities_status)
    {
        $roles_activities_id = $this->db->escape($roles_activities_id);
        $activities_status = $this->db->escape($activities_status);
        $edited_by = $this->db->escape($_SESSION['user_id']);
        $query = "UPDATE    
                        roles_activities_details
                    SET    
                        edited_by = " . $edited_by . ",
                        activities_status = " . $activities_status . ",
                        updated_date = CURRENT_TIMESTAMP
                    WHERE 
                        roles_activities_id = $roles_activities_id
                ";
        $this->db->query($query);
        return $this->db->affected_rows();
    }

    public function deleteRoleActivities($roles_activities_id)
    {
        $roles_activities_id = $this->db->escape($roles_activities_id);
        $query = "DELETE FROM    
                        roles_activities_details
                    WHERE 
                        roles_activities_id = $roles_activities_id
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

    public function getRoleActivtiesByKeywords($activities_keywords,  $activities_status = 'Active')
    {
        $activities_keywords = $this->db->escape($activities_keywords);
        $activities_status = $this->db->escape($activities_status);

        $query = "SELECT * FROM 
                            roles_activities_details 
                        WHERE 	
                            activities_keywords =  $activities_keywords
                        AND 
                            activities_status =  $activities_status
                        ";
        $query = $this->db->query($query);
        $result = $query->result_array();

        return $result;
    }

    public function checkRelationWithRoles($roles_activities_id)
    {
        $roles_activities_id = $this->db->escape($roles_activities_id);
        $sql = "SELECT * FROM roles_to_activities WHERE roles_activities_id = $roles_activities_id";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
}
