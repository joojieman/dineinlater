<?php
class Restogallery_Model extends MY_Model 
{
	public function __construct()
	{	
	}
	
	public function getAll()
	{
		$query = $this->db->get('restogallery');
        return $this->multipleResults($query);
	}
	
	public function getById($id)
	{
		$this->db->where('restotag_id', $id);
		$query = $this->db->get('restogallery');
        return $this->singularResults($query);
	}
	
	public function addPicture($picURL, $restoID)
	{
		$data = array(
			   'picURL' => $picURL,
			   'restaurant_id' => $restoID
			);
		$this->db->insert('restogallery', $data); 
	}
	
	public function deletePicture($id)
	{
		$this->db->delete('restogallery', array('restotag_id' => $id)); 
	}
}