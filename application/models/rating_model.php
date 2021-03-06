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
		$this->db->where('rating_id', $id);
		$query = $this->db->get('rating');
        return $this->singularResults($query);
	}
	
	// adds row
	public function addRating($rating, $title, $review, $customer_id, $restaurant_id)
	{
		$data = array(
			   'rating' => $rating,
			   'title' => $title,
			   'review' => $review,
			   'customer_id' => $customer_id,
			   'restaurant_id' => $restaurant_id
			);
		$this->db->insert('rating', $data); 
	}
	
	// deletes rating by customer id
	public function deleteRating($id)
	{
		$this->db->delete('customer', array('rating_id' => $id)); 
	}
	
	// fetches row by resto ID
	public function getByRestoID($id)
	{
		$this->db->where('restaurant_id', $id);
		$query = $this->db->get('rating');
        return $this->multipleResults($query);
	}
	
	// fetches row by customer ID
	public function getByCustomerID($id)
	{
		$sql = "SELECT c.name, r.rating, r.title, r.review
				FROM rating r JOIN restaurant c
				ON r.restaurant_id = c.restaurant_id
				WHERE r.customer_id = ?
				ORDER BY r.datetime desc;";
		$query = $this->db->query($sql,array($id));
        return $this->multipleResults($query);
	}
	
	public function getRatingByRestaurant($id)
	{
		$sql = "SELECT restaurant_id,AVG(rating) as rating
				FROM dineinlater.rating
				WHERE restaurant_id = ?
				GROUP BY restaurant_id;";
		$query = $this->db->query($sql,array($id));
        return $this->singularResults($query);
	}
}