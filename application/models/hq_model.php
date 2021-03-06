<?php
class HQ_Model extends MY_Model 
{
	public function __construct()
	{	
	}
	
	public function getAll()
	{
		$query = $this->db->get('hq');
        return $this->multipleResults($query);
	}
	
	public function getByID($id)
	{
		$this->db->where('hq_id', $id);
		$query = $this->db->get('hq');
        return $this->singularResults($query);
	}
	
	public function getByUsername($hq_username)
	{
		//getByUsername
		$this->db->where('username', $hq_username);
		$query = $this->db->get('hq');
        return $this->singularResults($query);
	}
	
	public function addHQ($username, $password, $hqname)
	{
			$data = array(
			   'username' => $username,
			   'password' => $this->encrypt->encode($password),
			   'hqname' => $hqname
			);
		$this->db->insert('hq', $data); 
	}
	
	public function deleteHQ($id)
	{
		$this->db->delete('hq', array('hq_id' => $id)); 
	}
	
}