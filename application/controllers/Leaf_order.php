<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/

class Leaf_order extends CI_Controller {

	public function __construct() {
        parent:: __construct();
        $this->load->helper(array('form','url'));
		$this->load->library(array('session', 'form_validation'));
		$this->load->database();
		$this->load->model('dal/leaf_order_manager');
    }	
	
	function set_leaf_order_onDrag()
	{
		$current_treeId = $this->input->post('treeId');
		$current_nodeId = $this->input->post('nodeId');
	
		$successor_nodeId = $this->input->post('successor_nodeId');
		
		$predecessor_nodeId = $this->input->post('predecessor_nodeId');
		echo ($current_treeId.','.$current_leafId.','.$current_nodeId.','.$successor_leafId.','.$successor_nodeId.','.$predecessor_leafId.','.$predecessor_nodeId);
		$result = $this->leaf_order_manager->update_order_onDrag($current_treeId,$current_nodeId,$successor_nodeId,$predecessor_nodeId);	
	}
	
	function set_leaf_order_onDrop()
	{
		$current_treeId = $this->input->post('treeId');
		$current_nodeId = $this->input->post('nodeId');
	
		$successor_nodeId = $this->input->post('successor_nodeId');
		
		$predecessor_nodeId = $this->input->post('predecessor_nodeId');
		echo ($current_treeId.','.$current_leafId.','.$current_nodeId.','.$successor_leafId.','.$successor_nodeId.','.$predecessor_leafId.','.$predecessor_nodeId);
		$result = $this->leaf_order_manager->update_order_onDrop($current_treeId,$current_nodeId,$successor_nodeId,$predecessor_nodeId);
	}
}
	