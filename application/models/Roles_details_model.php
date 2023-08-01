<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Roles_details_model extends CI_Model
{


    public function addRole($data)
    {
        $role_name = $this->db->escape($data['role_name']);
        $role_description = $this->db->escape($data['role_description']);
        $query = "INSERT INTO 
                    roles_details(
                        role_name, 
                        role_description,
                        created_by,
                        user_type
                        ) 
					values(
                        " . $role_name . ", 
                        " . $role_description . ", 
                        '" . $data['created_by'] . "',
                        '" . $data['user_type'] . "'
                        )";
        $this->db->query($query);

        return $this->db->insert_id();
    }

    public function editRole($data, $role_id)
    {
        $role_name = $this->db->escape($data['role_name']);
        $role_description = $this->db->escape($data['role_description']);
        $role_status = $this->db->escape($data['role_status']);
        $edited_by = $this->db->escape($data['edited_by']);
        $user_type = $this->db->escape($data['user_type']);

        $query1 = "UPDATE 
                        roles_details
                    SET
                        role_name = $role_name, 
                        role_description = $role_description,
                        edited_by = $edited_by,
                        user_type = $user_type,
                        role_status = $role_status,
                        updated_date = CURRENT_TIMESTAMP
                    WHERE 
                        role_id=$role_id
                    ";

        $query2 = "UPDATE 
                        user_details
                    SET
                        user_type = $role_name
                    WHERE 
                        role_id=$role_id
                    ";

        $this->db->query($query1);
        $this->db->query($query2);
        $this->db->affected_rows() > 0;
        return true;
    }

    public function getAllRoles()
    {

        $sql = "SELECT * FROM roles_details";
        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }

    public function getRoleById($role_id)
    {
        $sql = "SELECT * FROM roles_details WHERE role_id=" . $role_id;
        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }



    public function enabledDisabledRole($role_id, $role_status)
    {
        $query = "UPDATE    
                        roles_details
                    SET    
                        edited_by = '" . $_SESSION['user_id'] . "',
                        role_status = '" . $role_status . "',
                        updated_date = CURRENT_TIMESTAMP
                    WHERE 
                        role_id=$role_id
                ";
        $this->db->query($query);
        return $this->db->affected_rows();
    }

    public function deleteRole($role_id)
    {
        $query = "DELETE FROM    
                        roles_details
                    WHERE 
                        role_id=$role_id
                ";
        $this->db->query($query);
        return $this->db->affected_rows();
    }

    public function getUserDetailsById($user_id)
    {
        $sql = "SELECT * FROM user_details WHERE user_id=$user_id";
        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }

    public function assignRoleActivities($data)
    {
        $role_id = $this->db->escape($data['roleId']);
        $roles_activities_id = $this->db->escape($data['roles_activities_id']);
        $query = "INSERT INTO 
                    roles_to_activities(
                        role_id, 
                        roles_activities_id
                        ) 
					values(
                        " . $role_id . ", 
                        " . $roles_activities_id . "
                        )";
        $this->db->query($query);

        return $this->db->insert_id();
    }

    public function deleteAssignedRoleActivities($data)
    {
        $role_id = $this->db->escape($data['roleId']);
        $roles_activities_id = $this->db->escape($data['roles_activities_id']);
        $query = "DELETE 
                    FROM 
                        roles_to_activities
                    WHERE 
                        role_id = " . $role_id . "
                    AND     
                        roles_activities_id = " . $roles_activities_id . "
                        ";
        $this->db->query($query);
    }

    public function checkAssignedRoleActivities($role_id)
    {
        $role_id = $this->db->escape($role_id);
        $sql = "SELECT 
                        * 
                FROM 
                    roles_to_activities ra 
                INNER JOIN 
                    roles_activities_details rad 
                ON 
                    ra.roles_activities_id = rad.roles_activities_id
                WHERE 
                    role_id = $role_id";
        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }

    public function getAllRolesByActivtiesKeywords($activities_keywords, $activities_status = 'Active', $role_status = 'Active')
    {
        $activities_keywords = $this->db->escape($activities_keywords);
        $activities_status = $this->db->escape($activities_status);
        $role_status = $this->db->escape($role_status);
        $query = "SELECT * FROM 
						roles_activities_details  AS rad 
					INNER JOIN 
						roles_to_activities AS ra 
					ON 
						rad.roles_activities_id = ra.roles_activities_id
					INNER JOIN 
						roles_details AS rd 
					ON 
						ra.role_id = rd.role_id
					WHERE 	
                        rad.activities_keywords =  $activities_keywords
                    AND 
                        rad.activities_status =  $activities_status
                    AND
                        rd.role_status = $role_status
                    ";
        $query = $this->db->query($query);
        $result = $query->result_array();

        return $result;
    }

    public function getRoleByRoleName($user_type)
    {
        $user_type = $this->db->escape($user_type);
        $sql = "SELECT * FROM roles_details WHERE role_name=" . $user_type;
        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }

    public function getRoleActivitiesByRoleId($role_id)
    {
        $role_id = $this->db->escape($role_id);
        $sql = "SELECT * FROM roles_to_activities WHERE role_id=" . $role_id;
        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }
    public function checkRelationWithUsers($role_id)
    {
        $role_id = $this->db->escape($role_id);
        $sql = "SELECT * FROM user_details WHERE role_id=" . $role_id;
        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }
}
