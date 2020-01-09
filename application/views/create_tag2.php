<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

$sequenceTags = array();

$sequenceOrder = 0;	

$styleDisplay = '';

$sequence = 0;

if($sequenceTagId > 0)

{

	$styleDisplay = '';

	$sequence = 1;

	$sequenceTags = $this->tag_db_manager->getSequenceTagsBySequenceId($sequenceTagId);

	//print_r($sequenceTags);

}

?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<META HTTP-EQUIV="CACHE-CONTROL">

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

	<title>Teeme</title>

    <link href="<?php echo base_url();?>css/jquery.alerts.css" rel="stylesheet" type="text/css" />

	<link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css" />

	<script language="javascript">

		var baseUrl 		= '<?php echo base_url();?>';	

		var workSpaceId		= '<?php echo $workSpaceId;?>';

		var workSpaceType	= '<?php echo $workSpaceType;?>';

	</script>

    <script type="text/javascript" Language="JavaScript" src="<?php echo base_url();?>js/jquery/jquery1.6.1.js"></script>

    <!--<script type="text/javascript" src="<?php //echo base_url();?>ckeditor/ckeditor.js"></script>-->

	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.alerts.js"></script>

    

	<script language="javascript" src="<?php echo base_url();?>js/validation.js"></script>

	<script language="javascript" src="<?php echo base_url();?>js/identity.js"></script>

	<script language="javascript" src="<?php echo base_url();?>js/ajax.js"></script>

	<script language="javascript" src="<?php echo base_url();?>js/tag.js"></script>

		

</head>



<body>

<table width="825" border="0" align="center" cellpadding="0" cellspacing="0">

  

  <tr>

    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">

      <tr>

        <td height="250" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="8">

          <tr>

            <td valign="top">

			<!-- body-->

			<?php 

			$option = $this->uri->segment(6);		

			?>

			<table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

             

                <td align="right"><ul class="rtabs">

                  <li><a href="<?php echo base_url()?>add_tag/index/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/<?php echo $artifactId;?>/<?php echo $artifactType;?>/0/1"><span><?php echo $this->lang->line('txt_Time');?></span></a></li>

                  <li><a href="<?php echo base_url()?>add_tag/index/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/<?php echo $artifactId;?>/<?php echo $artifactType;?>/0/2"><span><?php echo $this->lang->line('txt_View');?></span></a></li>

                  <li><a href="<?php echo base_url()?>add_tag/index/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/<?php echo $artifactId;?>/<?php echo $artifactType;?>/0/3"><span><?php echo $this->lang->line('txt_Act');?></span></a></li>

                  <li><a href="<?php echo base_url()?>add_tag/index/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/<?php echo $artifactId;?>/<?php echo $artifactType;?>/0/4"><span><?php echo $this->lang->line('txt_Create');?></span></a></li>

                  <li><a href="<?php echo base_url()?>add_tag/index/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/<?php echo $artifactId;?>/<?php echo $artifactType;?>/0/5"><span><?php echo $this->lang->line('txt_Contact');?></span></a></li>

                  <li><a href="<?php echo base_url()?>add_tag/index/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/<?php echo $artifactId;?>/<?php echo $artifactType;?>/0/6"><span><?php echo $this->lang->line('txt_User');?></span></a></li>

                </ul></td>

              </tr>

              <tr>

                <td>

				<?php

					$arrTagDetails	= array();

					switch($tagOption)

					{

						case 1:			

							$this->load->view('common/tags/time_tag', $arrTagDetails); 				

							break;	

						case 2:	

							$this->load->view('common/tags/view_tag', $arrTagDetails); 				

							break;					

						case 3:		

							$this->load->view('common/tags/act_tag', $arrTagDetails); 								

							break;	

						case 4:		

							$this->load->view('common/tags/create_tag', $arrTagDetails); 								

							break;	

						case 5:		

							$this->load->view('common/tags/contact_tag', $arrTagDetails); 								

							break;	

						case 6:		

							$this->load->view('common/tags/user_tag', $arrTagDetails); 								

							break;

						default:	

							$this->load->view('common/tags/act_tag', $arrTagDetails); 								

							break;	

					}			

				?>

				</td>

				<td>&nbsp;</td>

              </tr>

            </table>

			

			<!-- body-->			

			<!-- Right Part-->			

			<!-- Right Part --></td>

            </tr>

        </table></td>

      </tr>

    </table></td>

  </tr>

  <tr>

    <td align="center" class="txtwhite">&nbsp;</td>

  </tr>

 

</table>

</body>

</html>