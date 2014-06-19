<?php
class Rating_Model extends MY_Model 
{
	public function __construct()
	{	
	}
	
	// fetches all row data
	public function getAll()
	{
		$query = $this->db->get('rating');
        return $this->multipleResults($query);
	}
	
	// fetches row data by ID
	public function getById($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('rating');
        return $this->singularResults($query);
	}
	
	// adds row
	public function addRating($rating, $title, $review, $customer_ID, $resto_ID, $datetime)
	{
		$data = array(
			   'rating' => $rating,
			   'title' => $title,
			   'review' => $review,
			   'customer_ID' => $customer_ID,
			   'resto_ID' => $resto_ID
			);
		$this->db->insert('customer', $data); 
	}
	
	// deletes rating by customer id
	public function deleteRating($id)
	{
		$this->db->delete('customer', array('id' => $id)); 
	}
	
	// fetches row by resto ID
	public function getByRestoID($id)
	{
		$this->db->where('resto_ID', $id);
		$query = $this->db->get('rating');
        return $this->multipleResults($query);
	}
	
	// fetches row by customer ID
	public function getByCustomerID($id)
	{
		$this->db->where('customer_ID', $id);
		$query = $this->db->get('rating');
        return $this->multipleResults($query);
	}
}