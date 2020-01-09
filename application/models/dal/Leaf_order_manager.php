<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/

class leaf_order_manager extends CI_Model
{	
	//update leaf order on drag
	function update_order_onDrag($current_treeId,$current_nodeId,$successor_nodeId,$predecessor_nodeId)
	{
		    if($predecessor_nodeId == "")
			{ 
				$this->db->query("update teeme_node set predecessor ='0' where id=".$successor_nodeId);			
			}
			if($successor_nodeId == "")
			{ 
				$this->db->query("update teeme_node set successors ='0' where id=".$predecessor_nodeId);
			}
			if(!empty($predecessor_nodeId) && !empty($successor_nodeId) && $predecessor_nodeId !=$current_nodeId && $successor_nodeId != $current_nodeId)
			{
				$this->db->query("update teeme_node set successors ='".$successor_nodeId."' where id=".$predecessor_nodeId);
				$this->db->query("update teeme_node set predecessor ='".$predecessor_nodeId."' where id=".$successor_nodeId);
			}
			return true;
	}
	
	//update leaf order on drop 
	function update_order_onDrop($current_treeId,$current_nodeId,$successor_nodeId,$predecessor_nodeId)
	{
			if($predecessor_nodeId == "")
			{ 
				$this->db->query("update teeme_node set successors ='".$successor_nodeId."' where id=".$current_nodeId);
				$this->db->query("update teeme_node set predecessor ='0' where id=".$current_nodeId);
				
				$this->db->query("update teeme_node set predecessor ='".$current_nodeId."' where id=".$successor_nodeId);			
			}
			if($successor_nodeId == "")
			{ 
				$this->db->query("update teeme_node set successors ='0' where id=".$current_nodeId);
				$this->db->query("update teeme_node set predecessor ='".$predecessor_nodeId."' where id=".$current_nodeId);
				
				$this->db->query("update teeme_node set successors ='".$current_nodeId."' where id=".$predecessor_nodeId);
			}
			if(!empty($predecessor_nodeId) && !empty($successor_nodeId) && $predecessor_nodeId != $current_nodeId && $successor_nodeId != $current_nodeId)
			{
				$this->db->query("update teeme_node set successors ='".$successor_nodeId."' where id=".$current_nodeId);
				$this->db->query("update teeme_node set predecessor ='".$predecessor_nodeId."' where id=".$current_nodeId);
				
				$this->db->query("update teeme_node set successors ='".$current_nodeId."' where id=".$predecessor_nodeId);
				$this->db->query("update teeme_node set predecessor ='".$current_nodeId."' where id=".$successor_nodeId);
				
			}
			return true;
	}
}