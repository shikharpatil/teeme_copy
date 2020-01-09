$(function() {              //For Drag leaf 
    $('.sortable').sortable({
        opacity: 0.7,
        handle: 'span',
		 update: function(event, ui) {
			 
		}
    });
});

function dragLeaf(leafid,treeId,position,nodeId,successors)                //Get successor and predecessor On Mouse Down       
{
	//$('#ID_'+nodeId).parent('div.handCursor').nextAll('.handCursor:first').children('.drag_span').css( "background-color", "orange" );
	//$('#ID_'+nodeId).parent('div.handCursor').prevAll('.handCursor:first').children('.drag_span').css( "background-color", "black" );
		
	var successor_nodeId = $('#ID_'+nodeId).parent('div.handCursor').nextAll('.handCursor:first').children('.nodeId').attr('id');
	
	var predecessor_nodeId = $('#ID_'+nodeId).parent('div.handCursor').prevAll('.handCursor:first').children('.nodeId').attr('id');
	
	console.log(successor_nodeId+','+predecessor_nodeId);
	
	$.ajax({                                   // change leaf order in the database using Ajax
       url: baseUrl+'leaf_order/set_leaf_order_onDrag',
       type: 'POST',
       data: {treeId:treeId,nodeId:nodeId,successor_nodeId:successor_nodeId,predecessor_nodeId:predecessor_nodeId},
       success: function(data) 
		{
			//console.log("result down= "+data);
		}
    });
	mouseDown = true;
	
}

function dropLeaf(leafid,treeId,position,nodeId,successors)                  //Get successor and predecessor On Mouse Up   
{
	if(mouseDown == true)
	{
	setTimeout(function(){
	//$('#ID_'+nodeId).parent('div.handCursor').nextAll('.handCursor:first').children('.drag_span').css( "background-color", "yellow" );
	//$('#ID_'+nodeId).parent('div.handCursor').prevAll('.handCursor:first').children('.drag_span').css( "background-color", "green" );
	
	var successor_nodeId = $('#ID_'+nodeId).parent('div.handCursor').nextAll('.handCursor:first').children('.nodeId').attr('id');
	
	var predecessor_nodeId = $('#ID_'+nodeId).parent('div.handCursor').prevAll('.handCursor:first').children('.nodeId').attr('id');
	
	console.log('successor= '+successor_nodeId+',predecessor= '+predecessor_nodeId);
	
	$.ajax({                                   // change leaf order in the database using Ajax
       url: baseUrl+'leaf_order/set_leaf_order_onDrop',
       type: 'POST',
       data: {treeId:treeId,nodeId:nodeId,successor_nodeId:successor_nodeId,predecessor_nodeId:predecessor_nodeId},
       success: function(data) 
		{
			//console.log("result up= "+data);
		}
    });
	}, 200);
	
	
	}
}