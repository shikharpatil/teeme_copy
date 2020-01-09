<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/**

* A PHP class keep the document Information into the Class variable and return it according to their need.

* @author Ideavate Solutions (www.ideavate.com)

*/

class discussion_container extends CI_Model

{

   /**

	* This variable will be used to store the title tag of the document.

	*/

	private  $titleTag = 'title';



	/**

	* This variable will be used to store the sub title tag of the document.

	*/

	private  $subTitleTag = 'subTitle';

  

   /**

	* This variable will be used to store the node tag of the document.

	*/

	private $nodeTag = 'node';

	/**

	* This variable will be used to store the idea tag of the document.

	*/

	private $leafTag = 'Idea';

	

	

   /**

	* This method will be used to retrieve the title tag of the document.

	* @return The title tag of the document

 	*/

	public function getTitleTag()

	{

		return $this->titleTag;

 	}



	/**

	* This method will be used to retrieve the sub title of the document.

	* @return The sub title of the document

 	*/

	public function getSubTitleTag()

	{

		return $this->subTitleTag;

 	}

  

   /**

	* This method will be used to retrieve the node tag of the document.

	* @return The node tag of the document

 	*/

	public function getNodeTag()

	{

		return $this->nodeTag;

 	}

 	

  	/**

	* This method will be used to retrieve idea tag of the document.

	* @return the idea tag of the document

 	*/

	public function getLeafTag()

	{

		return $this->leafTag;

 	} 	  

}

?>