<?php
class Customer_Model extends MY_Model 
{
	 // loads local variables
	public function __construct()
	{	
	}
	
	// fetches all row data
	public function getAll()
	{
		$query = $this->db->get('customer');
        return $this->multipleResults($query);
	}
	
	// gets customer by Id
	public function getById($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('customer');
        return $this->singularResults($query);
	}
	
	// get customer by username
	public function getByUsername($username)
	{
		$this->db->where('username', $username);
		$query = $this->db->get('customer');
        return $this->singularResults($query);
	}
	
	// get customer by email
	public function getByEmail($email)
	{
		$this->db->where('emailadd', $email);
		$query = $this->db->get('customer');
        return $this->singularResults($query);
	}
	
	// add customer
	public function addCustomer($firstname,$lastname,$emailadd,$username,$password)
	{
		$data = array(
			   'firstname' => $firstname,
			   'lastname' => $lastname,
			   'emailadd' => $emailadd,
			   'username' => $username,
			   'password' => $password
			);
		$this->db->insert('customer', $data); 
	}
	
	// delete customer
	public function deleteCustomer($id)
	{
		$this->db->delete('customer', array('id' => $id)); 
	}
	
	// update customer email
	public function updateEmail($id)
	{
		$this->db->where('id', $id);
		$this->db->update('emailadd', $emailadd); 
	}
	
	// update customer username
	public function updateUsername($id)
	{
		$this->db->where('id', $id);
		$this->db->update('username', $username); 
	}
	
	// update customer password
	public function updatePassword($id)
	{
		$this->db->where('id', $id);
		$this->db->update('password', $password); 
	}
}