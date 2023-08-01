<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User_details_model extends CI_Model
{

	public function addUsers($data)
	{

		$first_name = $this->db->escape($data['first_name']);
		$middle_name = $this->db->escape($data['middle_name']);
		$last_name = $this->db->escape($data['last_name']);
		$email = $this->db->escape($data['email']);
		$user_name = $this->db->escape($data['username']);
		$password = $this->db->escape($data['password']);
		$user_type_at_creation_time = $this->db->escape($data['user_type_at_creation_time']);
		$created_by = $this->db->escape($data['created_by']);

		if ($_SESSION['user_id']) {
			$query = "INSERT INTO 
			user_details(
					first_name, 
					middle_name, 
					last_name, 
					email, 
					user_name, 
					password,
					user_type_at_creation_time,
					created_by) 
			values(
				" . $first_name . ", 
				" . $middle_name . ", 
				" . $last_name . ", 
				" . $email . ",
				" . $user_name . ", 
				'" . md5($password) . "',
				" . $user_type_at_creation_time . ",
				" . $created_by . "
				)";
			$this->db->query($query);
		} else {

			$query = "INSERT INTO 
					user_details(
							first_name, 
							middle_name, 
							last_name, 
							email, 
							user_name, 
							password) 
					values(
						" . $first_name . ", 
						" . $middle_name . ", 
						" . $last_name . ", 
						" . $email . ",
						" . $user_name . ", 
						'" . md5($password) . "'
						)";
			$this->db->query($query);
		}
		return $this->db->insert_id();
	}

	public function UpdateUserByID($data, $user_id)
	{
		$user_id = $this->db->escape($user_id);
		$first_name = $this->db->escape($data['first_name']);
		$middle_name = $this->db->escape($data['middle_name']);
		$last_name = $this->db->escape($data['last_name']);
		$email = $this->db->escape($data['email']);
		$username = $this->db->escape($data['username']);
		$editedby = $this->db->escape($_SESSION['user_id']);
		$query = "UPDATE 
						user_details 
					SET  
						first_name = " . $first_name . ", 
						middle_name = " . $middle_name . ",  
						last_name = " . $last_name . ",  
						email = " . $email . ",  
						user_name = " . $username . ",  
						edited_by =" . $editedby . ",
						updated_date = CURRENT_TIMESTAMP
		 			WHERE 
						user_id = $user_id";
		$this->db->query($query);
		return $this->db->affected_rows();
	}

	public function assignRoles($data, $user_id)
	{
		$edited_by = $this->db->escape($data['edited_by']);
		$user_type = $this->db->escape($data['user_type']);
		$role_id = $this->db->escape($data['role_id']);
		$user_id = $this->db->escape($user_id);
		$query = "UPDATE 
                        user_details
                    SET
						role_id = $role_id,
						user_type = $user_type,
                        edited_by = $edited_by,
                        updated_date = CURRENT_TIMESTAMP
                    WHERE 
						user_id = $user_id
                    ";

		$this->db->query($query);
		return $this->db->affected_rows() > 0;
	}

	public function getAllUsers()
	{

		$sql = "SELECT * FROM user_details";
		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}

	public function getUserByID($user_id)
	{
		$user_id = $this->db->escape($user_id);

		$sql = "SELECT * FROM user_details WHERE user_id = $user_id";
		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}




	public function enabledDisabledUser($user_status, $user_id)
	{
		$user_status = $this->db->escape($user_status);
		$user_id = $this->db->escape($user_id);
		$edited_by = $this->db->escape($_SESSION['user_id']);
		$query = "UPDATE 
						user_details 
					SET   
						user_status = $user_status,
						edited_by = $edited_by
		 			WHERE 
						user_id = $user_id
					";
		$this->db->query($query);
		return $this->db->affected_rows();
	}

	public function deleteUserByID($user_id)
	{
		$user_id = $this->db->escape($user_id);
		$query = "DELETE FROM user_details WHERE user_id=$user_id";
		$this->db->query($query);
		return $this->db->affected_rows();
	}

	public function getUserBySearched($data)
	{
		$sql = "SELECT * FROM user_details " . $data['all_filter'] . $data['search_status'] . $data['search_type'] .
			$data['status_type'] . $data['search_cond'] . $data['status_cond'] . $data['type_cond'];
		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}

	public function getUserByUsernamePassword($username, $password)
	{
		$username = $this->db->escape($username);
		$password = $this->db->escape($password);

		$sql = "SELECT * FROM user_details WHERE user_name = $username AND password = '" . md5($password) . "'";
		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}
}
