<h3> Registered Restaurants </h3>

<table style="align: center; text-align: center; padding: 25px;">
	<tr>
		<th>id</th>
   		<th>restaurant <br> branches</th>
   		<th>manager</th>
   		<th>mobile</th>
   		<th>landline</th>
   		<th>status</th>
   		<th>auto<br>accept</th>
   		<th>address</th>
   		<th>city</th>
   		<th>cuisine</th>
   		<th>hq</th>
   		<th>edit</th>
   		<th>delete</th>
   	</tr>
   		<?php
   			foreach($restaurantResults as $restaurant) 
   			{
				$rowData = $this->HQ_Model->getById($restaurant->hq_id);
				
   				echo "<tr>";
			    echo "<td>".$restaurant->restaurant_id."</td>";
				echo "<td>".$restaurant->name."</td>";
				echo "<td>".$restaurant->owner."</td>";
				echo "<td>".$restaurant->mobile."</td>";
				echo "<td>".$restaurant->landline."</td>";
				echo "<td>".$restaurant->restostatus."</td>";
				echo "<td>".$restaurant->autoaccept."</td>";
				echo "<td>".$restaurant->address."</td>";
				echo "<td>".$restaurant->city."</td>";
				echo "<td>".$restaurant->cuisine."</td>";	
				echo "<td>". $rowData[0]->hqname ."</td>";
				echo "<td>". anchor('administrator/editResto?id='.$restaurant->restaurant_id, 'edit') ."</td>";
				echo "<td>". anchor('administrator/attemptDeleteRestaurant?id='.$restaurant->restaurant_id, 'delete') ."</td>";
				echo "</tr>";
			}
   		?>
</table>


