<?php
class Reservation_Model extends MY_Model 
{
	// loads local variables
	public function __construct()
	{	
	}
	
	// fetches all row data
	public function getAll()
	{
		$query = $this->db->get('reservation');
        return $this->multipleResults($query);
	}
	
	// fetches row data by ID
	public function getById($id)
	{
		$this->db->where('reservation_id', $id);
		$query = $this->db->get('reservation');
        return $this->singularResults($query);
	}
	
	// adds row
	public function addReservation($resto_ID, $customer_ID , $slots, $note, $date, $time)
	{
		//autoaccept check
		$this->load->model('Restaurant_Model');
		$nVal = $this->Restaurant_Model->isAutoAccept($resto_ID);
		if($nVal == true)
		{
			$confirmed = 1;
		}
		else 
		{
			$confirmed = 0;
		}
		
		$data = array(
			   'restaurant_id' => $resto_ID,
			   'customer_ID' => $customer_ID,
			   'slots' => $slots,
			   'confirmed' => '0',
			   'note' => $note,
			   'showup' => 'NOTYET',
			   'status' => 'O',
			   'date' => $date,
			   'time' => $time
			);
		$this->db->insert('reservation', $data); 
	}
	
	// deletes reservation
	public function deleteReservation($id)
	{
		$this->db->delete('reservation', array('reservation_id' => $id)); 
	}
	
	// updates reservation
	public function updateReservation($resto_ID, $customer_ID, $slots, $confirmed, $note, $showup, $status,  $date, $time)
	{
		$data = array(
			   'resto_ID' => $resto_ID,
			   'customer_ID' => $customer_ID,
			   'slots' => $slots,
			   'confirmed' => $confirmed,
			   'note' => $note,
			   'showup' => $showup,
			   'status' => $status,
			   'date' => $date,
			   'time' => $time
			);
		$this->db->where('reservation_id', $id);
		$this->db->update('reservation', $data); 
	}
	
	public function confirmReservation()
	{
		$data = array(
				'reservation_id' => $id,
			    'status' => $status
			);
		$this->db->where('reservation_id', $id);
		$this->db->update('reservation', $data); 
	}
	
	// fetches row data by restaurant ID 
	public function reservationByRestaurantID($resto_ID)
	{
		$this->db->where('restaurant_id', $resto_ID);
		$query = $this->db->get('reservation');
        return $this->multipleResults($query);
	}
	
	// fetches row data by restaurant ID and Status O
	public function reservationByRestaurantIDOpen($resto_ID)
	{
		$sql = "SELECT r.reservation_id, CONCAT(c.firstname,' ',c.lastname) as fullname, r.time, r.date, r.slots, r.reservationmade, r.note
				FROM reservation r JOIN customer c
				ON r.customer_id = c.customer_id
				WHERE r.confirmed = 0
				AND r.restaurant_id = ?
				AND r.status NOT IN ('C','R')";
		$query = $this->db->query($sql,array($resto_ID));
        return $this->multipleResults($query);
	}
	
	// fetches row data by Customer and Restaurant ID
	public function reservationByRestoIDandUserID($resto_ID,$customer_ID)
	{
		$this->db->where('restaurant_id', $resto_ID);
		$this->db->where('customer_id', $customer_ID);
		$query = $this->db->get('reservation');
        return $this->multipleResults($query);
	}
	
	public function approveReservation($reservation_id)
	{
		$data = array('confirmed' => '1');
        
		$this->db->update('reservation', $data, array('reservation_id' => $reservation_id));
	}
	
	public function rejectReservation($reservation_id)
	{
		$data = array('confirmed' => '1' ,
				      'status' => 'R');
        
		$this->db->update('reservation', $data, array('reservation_id' => $reservation_id));
	}
	
	public function reservationRestoToday($resto_ID)
	{
		/*
		$sql = "SELECT r.reservation_id, CONCAT(c.firstname,' ',c.lastname) as fullname,  r.time, r.date, r.slots, r.reservationmade, r.note
				FROM reservation r JOIN customer c
				ON r.customer_id = c.customer_id
				WHERE r.confirmed = 1
				AND r.restaurant_id = ?
				AND r.date = CURDATE()";
		 * 
		 */
		$sql = "
				SELECT * 
				FROM  `reservation` 
				WHERE date = CURDATE() 
				AND restaurant_id = ?
				AND confirmed = 1;
		";
		$query = $this->db->query($sql,array($resto_ID));
        return $this->multipleResults($query);
	}

	// fetches row data by Customer ID
	public function reservationByCustomerID($customer_ID)
	{
		$sql = "SELECT r.reservation_id, c.name,  r.time, r.date, r.slots, r.reservationmade, r.note,
				CASE confirmed
					WHEN 0 THEN 'NO'
					WHEN 1 THEN 'YES'
					ELSE -1
				END AS confirmed 
				FROM reservation r JOIN restaurant c
				ON r.restaurant_id = c.restaurant_id
				WHERE r.confirmed = 1
				AND r.restaurant_id = ?
				AND r.date = CURDATE()
				ORDER BY r.reservationmade desc";
		$query = $this->db->query($sql,array($customer_ID));
        return $this->multipleResults($query);
	}
	
	public function allReservationsByCustomerID($customer_ID)
	{
		$this->db->where('customer_id', $customer_ID);
		$this->db->where('status', 'O');
		$query = $this->db->get('reservation');
        return $this->multipleResults($query);
	}
	
	public function cancelReservationById($reservation_ID)
	{
		$data = array(
               'status' => 'C',
            );
		$this->db->where('reservation_id', $reservation_ID);
		$this->db->update('reservation',$data);
	}
	
	public function reservationByHQ($hqid, $limit = 250)
	{
		$sql = "SELECT restaurant.name, restaurant.reservation_slots, 
				CASE restaurant.restostatus
				    WHEN 'O' THEN 'Open'
				    WHEN 'F' THEN 'Full'
				    ELSE -1
				END as restostatus
				, restaurant.autoaccept, customer.firstname, customer.lastname, customer.cellphone, reservation.slots, 
				CASE reservation.confirmed
				    WHEN 1 THEN 'Yes'
				    WHEN 0 THEN 'No'
				    ELSE -1
				END as confirmed
				, reservation.note, reservation.time, reservation.date, reservation.reservationmade, 
				CASE reservation.status
				    WHEN 'O' THEN 'On the List'
				    WHEN 'C' THEN 'Completed'
				    ELSE -1
				END as status
				, reservation.showup
				FROM  `restaurant` 
				INNER JOIN  `reservation` ON restaurant.restaurant_id = reservation.restaurant_id
				INNER JOIN  `hq` ON restaurant.hq_id = hq.hq_id
				INNER JOIN  `customer` ON reservation.customer_id = customer.customer_id
				WHERE hq.hq_id = ".$hqid."
				LIMIT 0 , ".$limit."";
				
		$query = $this->db->query($sql);
        return $this->multipleResults($query);
	}
}