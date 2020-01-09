<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo $this->lang->line('txt_Document_Help');?></title>

<link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css" />

</head>



<body>

<div class="help_body">

<a name="top"></a>

<table border="0" width="100%" cellpadding="6" cellspacing="6" class="help_topics_bg">

<tr>

	<td width="100%" colspan="2" valign="top">

    	<div class="heading-home"><?php echo $this->lang->line('txt_Document_Help');?></div>

    </td>

</tr>

<tr>

	<td width="100%" colspan="2" valign="top">

		<a href="#21">How to use Document tree?</a><br /><br />

    </td>

</tr>

<tr>

    <td width="100%" colspan="2" valign="top">

    	<div class="heading-home"><?php echo $this->lang->line('txt_Related_Help');?></div>

    </td>

</tr>

<tr>

    <td width="50%" valign="top">

        <div class="heading-search"><?php echo $this->lang->line('txt_General');?></div><br />

        <a href="#0">What does Teeme mean?</a><br />

		<a href="#1">The Teeme Basic Concepts</a><br />

		<a href="#2">Place</a><br />

		<a href="#3">Space</a><br />

		<a href="#4">My Space</a><br />

		<a href="#5">Leaf & Tree</a><br />

		<a href="#6">Tags</a><br />

		<a href="#7">Links</a><br />

		<a href="#8">Talk</a><br />

		<a href="#9">Tree Views</a><br />

		<a href="#10">Originator</a><br />

        <br /><div class="heading-search"><?php echo $this->lang->line('txt_Views');?></div><br />

        <a href="#11">What is tag view?</a><br />

        <a href="#12">What is link view?</a><br />

        <a href="#13">What is time view?</a><br />

        <br /><div class="heading-search"><?php echo $this->lang->line('txt_Editor');?></div><br />

        <a href="#22">How to use Editor?</a><br />

        <a href="#23">How to use photos/images?</a><br />

        <a href="#24">How to use videos?</a><br />



    </td>

    <td width="50%" valign="top">

        <div class="heading-search"><?php echo $this->lang->line('txt_Tags');?></div><br />

    	<a href="#14">What is tagging?</a><br />

		<a href="#15">How to apply Simple tags?</a><br />

		<a href="#16">How to apply Response tags?</a><br />

		<a href="#17">How to do Contact tagging?</a><br />

        <br /><div class="heading-search"><?php echo $this->lang->line('txt_Links');?></div><br />

		<a href="#18">What is linking?</a><br />
		<a href="#18.1">How to apply a link?</a><br />
		<a href="#18.2">How to access links?</a><br />

        <br /><div class="heading-search"><?php echo $this->lang->line('txt_Talk');?></div><br />

        <a href="#19">What is Talk tool?</a><br />

        <br /><div class="heading-search"><?php echo $this->lang->line('txt_Ad_Hoc');?></div><br />

        <a href="#20">What is Ad hoc collaboration? </a><br />

    </td>

</tr>

</table>



<a name="21"></a>

<p><b>How to use Document tree? </b><br />

<p>The document trees are used when team is collectively writing a business document. This can be a sales proposal, policy document, client requirements documentation, technical solutions etc. </p>

<p>Selecting Create menu from Document tree shows the following screen –</p>

<p><img src="<?php echo base_url();?>images/help/create_document.gif" alt="<?php echo $this->lang->line('txt_Create_Document');?>" title="<?php echo $this->lang->line('txt_Create_Document');?>" border="0"></p>

<p>John Hill is the originator of this document. The leaf of the Document tree is called an idea. A title and the first leaf can be edited in this screen. Clicking Done results in the creation of the document tree which can be collectively evolved by team members. </p>

<p>The created Document tree is shown in the following screen -</p>

<p><img src="<?php echo base_url();?>images/help/document_tree01.gif" alt="<?php echo $this->lang->line('txt_Document_Tree');?>" title="<?php echo $this->lang->line('txt_Document_Tree');?>" border="0"></p>

<p>Each tree has its logical view in this case a Document view. The Time View, Tag View and Links View are common to all trees. These are described separately. Clicking on the tab shows the respective view of the tree. </p>

<p>The seed of document tree has following features – <br><br><ol><li>Create Version – A document when created has version 1. As the tree grows through collective contributions individual leaves go through their own versioning (refer to Edit this Idea feature of ideas below). At any point the Originator of the tree can create a new version of the Document taking only the top level leaves. This new version can again grow through collective edits and contributions.</li> <li>Add New Idea – This will create a new idea below the seed. Thus becoming the first leaf of the tree. </li><li>Links – We can add a link to external tree or file.</li><li>Tags – The seed can be tagged.</li><li>Talk – Team can have conversation about the whole Document. The seed represents the whole tree. </li><li>Export File – A Document tree can be exported as an HTML file so that we can open this in Microsoft Word or other editors including browsers.</li> <li>Edit – This allows us to change the title of the Document tree.</li><li>Update tree – As Documents are contributed and edited collectively by team members. A Document tree can changes at any time. Notifications are generated to let users know that the Document tree has changed from the copy in their browser. Clicking on this icon will update the tree. </li></ol></p>

<p>The ideas have the following features –<br><br><ol><li>Talk – This enables a team conversation around the idea.</li><li>Edit this Idea – The idea can be edited by any one and the edited idea is captured a second leaf or second version of the original idea. This is versioning of ideas. This way all the contributed ideas can be tracked. Only one user is allowed to edit an idea at a time. And only the latest idea can be edited. </li><li>Add New Idea – A new leaf is placed below this idea. </li><li>Links – A tree or imported file can be linked to the leaf. </li><li>Tags – Tags can be applied to this idea. </li></ol></p>

<p>The following screen shows Idea versions. Clicking on << will let user access previous idea. If new ideas are submitted or existing ideas are edited then the Document tree changes and Update tree notification is generated for connected users. If the Document tree itself goes through versioning other users get the notification as Update Version tab. Clicking on these two tabs fetches the updated copy of the tree for the user. </p>

<p><img src="<?php echo base_url();?>images/help/document_tree02.gif" alt="<?php echo $this->lang->line('txt_Document_Tree');?>" title="<?php echo $this->lang->line('txt_Document_Tree');?>" border="0"></p>

<a href="#top">Top</a></p>







<a name="0"></a>

<p><b>What does Teeme mean?</b><br />

<p>Teeme enables effective collaboration through co-creation within teams. The word Teeme is synthesized from the words - Team and Meme. 

A meme is defined as an idea which like gene can evolve and replicate. The word teeme means – enabling evolution of ideas within teams.</p>



<p>Teams work together – to deliver a project; to implement a business process or to acquire, retain and support customers. 

In general teams work together to achieve certain business outcomes and in most cases involve multiple teams with different expertise. 

The most collaborative sessions occur in meeting rooms – where members can table their ideas, collectively evolve the ideas, brain storm and communicate the progress 

and then agree on next steps and shared responsibilities. The reason these sessions are effective because the issues can be discussed and handled 

at idea level – the basic unit of collaboration! Teeme enables this idea level collaboration through a system which has adopted social networking and Web 2.0 concepts 

for enterprise use. This is very different from the current collaborative model of preparing and reviewing documents individually and sharing them through email. 

These cycles of sharing documents through emails – result in each member ending up with multiple versions of same documents and numerous copies of mails! </p>

<a href="#top">Top</a></p>



<a name="1"></a>

<p><b>The Teeme Basic Concepts </b><br />

Teeme is a tool for team work. Before we can start using the tool we need to define a community, its members and then form teams.

<br />

<a href="#top">Top</a></p>



<a name="2"></a>

<p><b>Place</b><br />

A community of members within Teeme is called a Place. For example - company X wishing to deploy Teeme for its employees – may create a Place called X and assign a Place Manager to manage memberships and other administrative tasks. 

<a href="#top">Top</a></p>



<a name="3"></a>

<p><b>Space</b><br />A Space is a shared work space for team work. The Place manager defines a Space and assigns a Space manager. The Space manager then can pick the members to form a team for a project. Typically a project involves multi-disciplinary team working for common goals. For example a proposal to client Acme may involve Sales team, Technical team, Business Assurance team and technical expert from a partner company – Zee Consultants. To help in modeling this team structure Teeme allows a Space to have sub-spaces. So in this case we can have a Space called Acme Proposal which can have subspace called Sales, Technical, Business Assurance and Zee. The team members can be assigned for these spaces and sub-spaces. The members working with multiple teams are assigned to multiple Spaces. 

<a href="#top">Top</a></p>



<a name="4"></a>

<p><b>My Space</b><br />

Each member has a personal space called MySpace. The user can use this to manage their personal tasks and activities. MySpace is also used for sharing information among other members on ad-hoc basis. <a href="#top">Top</a></p>



<a name="5"></a>

<p><b>Leaf & Tree</b><br />

Team work can be considered as growing a tree collectively. A member contributes an idea which is captured as a leaf within Teeme. The collective contribution of 

ideas or leaves then forms a tree. A tree also has a seed which governs how the tree can be grown. Within Teeme we provide 6 types of trees which govern how these 

contributed leaves interconnect with each other. The types of trees provided are – Document, Discussion, Chat, Notes, Contact and Tasks. These types of trees provide 

a better way to capture the team work for wide ranging situation. <br />

<img src="<?php echo base_url();?>images/help/tree.jpg" alt="<?php echo $this->lang->line('txt_Tree');?>" title="<?php echo $this->lang->line('txt_Tree');?>" border="0">

<br />

Apart from the content a leaf also captures –<br />

1.	Team interactions through Tag tool.<br />

2.	References to other related trees through Link tool.<br />

3.	Relevant team conversations on the content through Talk tool. <br />

Thus we can capture an idea, related team interactions, contextual links and team conversations on the content together as a leaf. This is the basic unit of 

collaboration in Teeme. And using this we can grow a tree capturing all the aspects of team work on a specific context. Let us look at these in more details. <br />

<img src="<?php echo base_url();?>images/help/leaf.jpg" alt="<?php echo $this->lang->line('txt_Leaf');?>" title="<?php echo $this->lang->line('txt_Leaf');?>" border="0">

<br />

<a href="#top">Top</a></p>



<a name="6"></a>

<p><b>Tags</b><br />

Folksonomy or tagging is used within communities for classification and categorization purposes. Tags in Teeme can be applied at seed or leaf level. 

There are 3 types of tagging provided –<br />

1.	Simple tags – these are the tags used for Folksonomy. These tags are defined at the Place level ensuring consistency in classification for the whole community.<br />

2.	Response tags – Member interactions are captured using Response tags. For example John may ask Mary to review the sales forecast contained in the leaf. 

Both the request from John and response from Mary are captured using the Response tag which is visible to others in the Space. 

This way we fuse the content and user interactions together through response tagging. Each user within Teeme has a unique tag and these tags are used to identify the 

user and request any specific responses from them. There are 4 types of Response tags to capture user interactions – <br />

a.	Todo – Any specific request can be made. For example reviewing the financial forecast. <br />

b.	Select – From a list of multiple items. <br />

c.	Vote – On specific choices. <br />

d.	Authorize – For seeking permission from others. <br />

3.	Contact tags – The external decision makers or clients are also defined within Teeme as Contact trees and are also defined as unique Contact tags. 

These tags can be applied to contents for further book marking from client perspective. <br />

<a href="#top">Top</a></p>





<a name="7"></a>

<p><b>Links</b><br />

As teams work together for common goals; a number of trees get seeded and evolved. The content from a leaf in document tree may trigger a team discussion captured separately as a tree. In Tasks tree – a leaf contains a task but a separate document tree may contain the full scope of the task. These are logical related trees and these relationships are captures though a feature called – Links. 

<p>A link can de defined from the seed and the leaves of tree to other trees. Thus the teams are not only evolving various trees they are also forming logical relationships among trees. External files can imported within Teeme and these imported files can also be linked to the seeds or leaves. </p>

<a href="#top">Top</a></p>





<a name="8"></a>

<p><b>Talk</b><br />

Within Teeme trees can be broadly categorized as –<br />

1.	Content oriented – These trees aid in content creation. For example the design specifications are captured as Document tree, factual content like minutes of the 

meeting or status reports are captured as Notes tree, task allocation is captured through Tasks tree and client interactions are captured as Contact tree. <br />

2.	Communication oriented – Deeper and longer discussions are captured through Discussion tree while short, focused and real-time conversation among a few members 

can be captured as a Chat tree. <br />

<p>For the content oriented trees - there is a need among members to clarify and evolve the content through focused conversations. This may be about clarification, suggestion, confirmation or changes required for the content in the leaf. This is a focused context based conversation which is best captured with the leaf itself.  Talk is the feature which enables these focused conversations. </p>

<p>A leaf along with the content also has Tags, Links and Talk is the basic unit of collaboration in Teeme and collective contributions from members grow a tree capturing all the aspects of team creation and interactions. </p>

<a href="#top">Top</a></p>





<a name="9"></a>

<p><b>Tree Views</b><br />

As trees evolve they contain contents, tags and links. The evolution of the tree happens over a period of time. The trees can be viewed from 4 different perspectives –

<br />

1.	Logical view – this the normal view of the tree from the content perspective. This view may vary from the type of the tree but helps users navigate and browse 

the tree from the logical evolution - maintaining the context. The user can fully interact with the tree in this view only. Other views below are navigational aid 

only.<br /> 

2.	Time View – This helps is finding out the leaves/talks contributed within a defined time period. A user may want to see the contributions for yesterday, 

this week or for a specified date range. <br />

3.	Tag View – The tags applied for the tree are listed in this view –this is the tag cloud for the tree. Using these tags user can browse the corresponding leaves 

and the user interactions (requests as well as responses). <br />

4.	Link View – this view contains the list of all the linked trees. <br />

<img src="<?php echo base_url();?>images/help/tree_view.jpg" alt="<?php echo $this->lang->line('txt_Tree');?>" title="<?php echo $this->lang->line('txt_Tree');?>" border="0">

<br />

These views help users navigate through the tree from different perspectives.  These four views are common to all the trees. A tree can have additional views to assist in further navigation. 

<br />

<a href="#top">Top</a></p>



<a name="10"></a>

<p><b>Originator</b><br />

An originator is the user who starts a tree. The properties of the tree can only be defined and edited by originators. Each member of the Space can interact with the tree but only Originator have certain special privileges – (1) renaming of the tree, (2) copying of tree (3) versioning of document trees etc. Similarly in Response tagging a user assigns task to others user(s). Only Originator can make edit, delete or modify the tag further.

<br />

<img src="<?php echo base_url();?>images/help/originator.gif" alt="<?php echo $this->lang->line('txt_Originator');?>" title="<?php echo $this->lang->line('txt_Originator');?>" border="0">

<br />

This screen shows a Document tree called “Requirements for Acme proposal”. The Document seed with its menu items are shown on top. It also shows the other elements of Document tree – The views tab, originator and leaves containing ideas/content. This is a typical tree view. 

<br />

<a href="#top">Top</a></p>



<a name="11"></a>

<p><b>What is a Tag View?</b><br />

<p><img src="<?php echo base_url();?>images/help/tag_view.gif" alt="<?php echo $this->lang->line('txt_Tag_View');?>" title="<?php echo $this->lang->line('txt_Tag_View');?>" border="0"></p>

<p>The Tag View is common to all the tree types. The screen shows the tag view for a Document tree. The applied tags are listed and hyperlinked. The example shows that clicking on Review Presentation tag results in display of the leaf where it has been applied. Clicking on the leaf will navigate the user to Document view and highlight the leaf for further actions (in the case of Response tags). </p>

<a href="#top">Top</a></p>



<a name="12"></a>

<p><b>What is Link View?</b><br />

<p><img src="<?php echo base_url();?>images/help/link_view.gif" alt="<?php echo $this->lang->line('txt_Link_View');?>" title="<?php echo $this->lang->line('txt_Link_View');?>" border="0"></p>

<p>The Link View is common to all the trees. This Link View shows the list of trees and imported files which have been linked from the current tree. In our example there is a Discussion and an Imported File linked to the Contact tree. Clicking on the linked tree displays the list of leaves which contain this link. You can open the linked tree or imported file by selecting it from the leaf’s Links menu item. </p>

<a href="#top">Top</a></p>



<a name="13"></a>

<p><b>What is Time View?</b><br />

<p><img src="<?php echo base_url();?>images/help/time_view.gif" alt="<?php echo $this->lang->line('txt_Time_View');?>" title="<?php echo $this->lang->line('txt_Time_View');?>" border="0"></p>

<p>The Time View is common to all the trees. The Time View shows how the tree has grown in a defined time period.  A predefined period can be selected for example “This Month” as below and the leaves contributed during the month get listed below. A user can also define the period of interest by selecting From Date and To Date fields.  Clicking on a leaf will result in highlighting the leaf in Notes View. </p>

<a href="#top">Top</a></p>



<a name="14"></a>

<p><b>What is tagging?</b><br />

Tagging or Folksonomy is common for group categorization – this is called Simple tagging. In Teeme users and contacts are defined as unique tags. We have extended the use of tagging to capture user interactions on content through Response tagging. We can also apply Contact tags on content. 

<br />

<a href="#top">Top</a></p>



<a name="15"></a>

<p><b>How to apply Simple tags?</b><br />

<p><img src="<?php echo base_url();?>images/help/simple_tags_01.gif" alt="<?php echo $this->lang->line('txt_Simple_Tags');?>" title="<?php echo $this->lang->line('txt_Simple_Tags');?>" border="0"></p>

<p>Clicking on an idea/leaf shows the menu items containing Tags. Step 1 – click on menu Tags. </p>

<p><img src="<?php echo base_url();?>images/help/simple_tags_02.gif" alt="<?php echo $this->lang->line('txt_Simple_Tags');?>" title="<?php echo $this->lang->line('txt_Simple_Tags');?>" border="0"></p>

<p>This shows an example of Simple tagging. You can:<br />

1.	Define a new simple tag. These words are defined for the whole community of the users in Place. This ensures that tagging is common across the community. <br />

2.	You can then selects one or many tags. <br />

3.	Apply them using the button. <br />

4.	Once the list of defined tags grows – Search enables to filter through the list. 

</p>

<a href="#top">Top</a></p>



<a name="16"></a>

<p><b>How to apply Response tags?</b><br />

<p><img src="<?php echo base_url();?>images/help/response_tags01.gif" alt="<?php echo $this->lang->line('txt_Response_Tags');?>" title="<?php echo $this->lang->line('txt_Response_Tags');?>" border="0"></p>

<p>The Responses tagging is for specifying specific requests from team members and capturing their responses. There are 4 types of Response tags – <ul><li>ToDo – Asking for any specific request for example review. </li><li>Select – From a list of options you can request members to select the favorite option</li><li>Vote – Request a Yes/No type of response from a question.</li><li>Authorize – Seek permission of any specific request.</li></ul></p>

<p>The example shows a ToDo tag being applied. The steps are –<ol><li>Select the tag type – ToDo</li><li>Give this tag a name – in this example “Review presentation”.</li><li>Select users who will be responsible for performing this request. </li><li>4.	Specify the time frame within which a response is sought or specify a date. </li></ol></p>

<p>Once a tag has been applied – the tag editor can later edit it and change certain parameters. An applied tag can also be deleted within the specified action time. After the period the tag can not be changed. </p>

<p><img src="<?php echo base_url();?>images/help/response_tags02.gif" alt="<?php echo $this->lang->line('txt_Response_Tags');?>" title="<?php echo $this->lang->line('txt_Response_Tags');?>" border="0"></p>

<a href="#top">Top</a></p>





<a name="17"></a>

<p><b>How to do Contact tagging?</b><br />

<p>Teeme creates a Contact tag for each defined Contact tree. To apply the Contact tag simply select from the list and press Apply button. </p>

<p><img src="<?php echo base_url();?>images/help/contact_tags01.gif" alt="<?php echo $this->lang->line('txt_Contact_Tags');?>" title="<?php echo $this->lang->line('txt_Contact_Tags');?>" border="0"></p>

<p>The following screen shows the tags applied to a leaf.</p>

<p><img src="<?php echo base_url();?>images/help/contact_tags02.gif" alt="<?php echo $this->lang->line('txt_Contact_Tags');?>" title="<?php echo $this->lang->line('txt_Contact_Tags');?>" border="0"></p>

<a href="#top">Top</a></p>





<a name="18"></a>

<p><b>What is Linking?</b><br />

<p>A leaf or tree can contain links to external objects such as other trees, imported files and URLs.  These links provide a way to connect external information to the context of the leaf or tree.</p>

<a href="#top">Top</a></p>


<a name="18.1"></a>
<p><b>How to apply a Link?</b></p>

<p><img src="<?php echo base_url();?>images/help/linking05.png" alt="<?php echo $this->lang->line('txt_Linking');?>" title="<?php echo $this->lang->line('txt_Linking');?>" border="0"></p>

<ol>
<li>Select the type of Link - all 5 tress can be applied as link. The example shows an imported file is being linked.</li>
<li>Select the file to be linked.</li>
<li>Press Apply.</li>
</ol>
<ul>
<li> Import New File - allows the user to import a new file into the space and then a link is applied.</li>
<li> Import URL - An external web object is linked through its URL. The URL is given a name.</li>
</ul>
<p>Mouse over on Link icon shows the applied links -</p>
<p><img src="<?php echo base_url();?>images/help/linking06.png" alt="<?php echo $this->lang->line('txt_Linking');?>" title="<?php echo $this->lang->line('txt_Linking');?>" border="0"></p>
<!--<p>To link an external tree to a leaf:<ol><li>Select the Links menu item. <br><br><img src="<?php echo base_url();?>images/help/linking01.gif" alt="<?php echo $this->lang->line('txt_Linking');?>" title="<?php echo $this->lang->line('txt_Linking');?>" border="0"></li><li>Click on the Link tab. <br><br><img src="<?php echo base_url();?>images/help/linking02.gif" alt="<?php echo $this->lang->line('txt_Linking');?>" title="<?php echo $this->lang->line('txt_Linking');?>" border="0"></li><li>Select the type and the name of the tree to be Linked.<br><br><img src="<?php echo base_url();?>images/help/linking03.gif" alt="<?php echo $this->lang->line('txt_Linking');?>" title="<?php echo $this->lang->line('txt_Linking');?>" border="0"> </li></ol></p>

<p>The Linked tree now is shown with the leaf. First the icon appears and then clicking on the icon details of the linked trees are shown.</p>

<p><br><br><img src="<?php echo base_url();?>images/help/linking04.gif" alt="<?php echo $this->lang->line('txt_Linking');?>" title="<?php echo $this->lang->line('txt_Linking');?>" border="0"></p>-->

<a href="#top">Top</a></p>


<a name="18.2"></a>
<p><b>How to access links?</b></p>

<p>To access applied links open the Link tool by clicking on the icon.</p>
<p><img src="<?php echo base_url();?>images/help/linking07.png" alt="<?php echo $this->lang->line('txt_Linking');?>" title="<?php echo $this->lang->line('txt_Linking');?>" border="0"></p>
<p>You can click on the links to open them in separate tabs. You can also access the Links for the Dashboard.</p>
<a href="#top">Top</a></p>

<a name="19"></a>

<p><b>What is Talk tool?</b><br />

<p>The Talk tool enables conversations around content in the leaf. The trees which help in content creation namely Document, Notes, Contact and Tasks have Talk tool. To use Talk – click on the Talk menu item of the leaf. </p>

<p><img src="<?php echo base_url();?>images/help/talk01.gif" alt="<?php echo $this->lang->line('txt_Talk');?>" title="<?php echo $this->lang->line('txt_Talk');?>" border="0"></p>

<p>This will open the Talk tool in a separate window. </p>

<p><img src="<?php echo base_url();?>images/help/talk02.gif" alt="<?php echo $this->lang->line('txt_Talk');?>" title="<?php echo $this->lang->line('txt_Talk');?>" border="0"></p>

<p>The type and the name of the tree are identified on the top. As all the leaves can have Talk – we refer to the leaf by capturing the part of text contained in the leaf. This provides the context for the conversations to evolve. A topic can be added for the conversations to start. A Talk can have multiple topics. The tab labeled Show Leaf will display the full content of the leaf in separate browser window/tab. </p>

<p><img src="<?php echo base_url();?>images/help/talk03.gif" alt="<?php echo $this->lang->line('txt_Talk');?>" title="<?php echo $this->lang->line('txt_Talk');?>" border="0"></p>

<p>A reply to a topic can have further replies. This enables a Talk to grow side ways.  There are indicators to reflect the way user has traversed the Talk. The << and >> arrow buttons help the user in navigation. </p>

<p><img src="<?php echo base_url();?>images/help/talk04.gif" alt="<?php echo $this->lang->line('txt_Talk');?>" title="<?php echo $this->lang->line('txt_Talk');?>" border="0"></p>

<a href="#top">Top</a></p>



<a name="20"></a>

<p><b>What is ad hoc collaboration? </b><br />

<p>Ad hoc collaboration can be used for short term, temporary and impromptu collaboration among members on a specific tree. For example a change in purchase policy documentation can involve relevant members without starting a formal project. Using MySpace a user can set up this ad hoc collaboration with any member(s) in the Place. A user can create a tree in his MySpace and then share this tree among others members. All shared members access this tree in their MySpaces. The following example demonstrates how a  document tree can be shared.</p>

<p><img src="<?php echo base_url();?>images/help/sharing01.gif" alt="<?php echo $this->lang->line('txt_Sharing');?>" title="<?php echo $this->lang->line('txt_Sharing');?>" border="0"></p>

<p>The Share tab in only available in the trees created in My Space. Using this tab we can share the tree with others. </p>

<p><img src="<?php echo base_url();?>images/help/sharing02.gif" alt="<?php echo $this->lang->line('txt_Sharing');?>" title="<?php echo $this->lang->line('txt_Sharing');?>" border="0"></p>

<p>The tree now will be shared with Ken and Mary. This tree is listed in their My Spaces.  The following screen shows how Mary sees this document tree shared by Paul. </p>

<p><img src="<?php echo base_url();?>images/help/sharing03.gif" alt="<?php echo $this->lang->line('txt_Sharing');?>" title="<?php echo $this->lang->line('txt_Sharing');?>" border="0"></p>

<p>Now all the users can work on this shared document tree. </p>

<p>From the share tab we can select all the users and in this case every member within the Place will have access to the tree. </p>

<a href="#top">Top</a></p>





<a name="22"></a>

<p><b>How to use Editor? </b><br />

<p>The editor provided with Teeme let users edit text. Teeme provides full editor as well as small editor. The following screen shows the editor and its features available through the icons. For editing larger content you can toggle the editor to full screen mode by using the last icon in second row - <img src="<?php echo base_url();?>images/help/editor01.gif" alt="<?php echo $this->lang->line('txt_Editor');?>" title="<?php echo $this->lang->line('txt_Editor');?>" border="0"></p>

<p>The following key combinations provide useful features for – <ul><li>Cut: <Ctrl>+x</li><li>Copy: <Ctrl>+c</li><li>Paste: <Ctrl>+v</li><li>Undo: <Ctrl>+z</li><li>Redo: <Ctrl>+y</li></ul></p>

<p><img src="<?php echo base_url();?>images/help/editor02.gif" alt="<?php echo $this->lang->line('txt_Editor');?>" title="<?php echo $this->lang->line('txt_Editor');?>" border="0"></p>

<p>Done button updates the edited content while Cancel button will not update the content in the editor box. </p><p>The following screen shows the small editor –</p>

<p><img src="<?php echo base_url();?>images/help/editor03.gif" alt="<?php echo $this->lang->line('txt_Editor');?>" title="<?php echo $this->lang->line('txt_Editor');?>" border="0"></p>

<p>The features supported through the icons are described below- </p>

<p><img src="<?php echo base_url();?>images/help/editor04.jpg" alt="<?php echo $this->lang->line('txt_Editor');?>" title="<?php echo $this->lang->line('txt_Editor');?>" border="0"></p>

<a href="#top">Top</a></p>





<a name="23"></a>

<p><b>How to use photos/images?</b><br />

<p>To insert a photo in the editor; you need to first import the file in the current space by using <a href="<?php echo base_url();?>help/import/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>" target="_blank">Import File feature</a>. Copy the url of the file. Now click on Insert Image icon to see the following screen –</p>

<p><img src="<?php echo base_url();?>images/help/photos01.gif" alt="<?php echo $this->lang->line('txt_Photos_Images');?>" title="<?php echo $this->lang->line('txt_Photos_Images');?>" border="0"></p>

<p><img src="<?php echo base_url();?>images/help/photos02.gif" alt="<?php echo $this->lang->line('txt_Photos_Images');?>" title="<?php echo $this->lang->line('txt_Photos_Images');?>" border="0"></p>

<p>Paste the url in the Image url filed and click Insert.</p>

<p><img src="<?php echo base_url();?>images/help/photos03.gif" alt="<?php echo $this->lang->line('txt_Photos_Images');?>" title="<?php echo $this->lang->line('txt_Photos_Images');?>" border="0"></p>

<p>Click OK. Optionally you may provide the description of the image.</p>

<a href="#top">Top</a></p>



<a name="24"></a>

<p><b>How to use videos?</b><br />

<p>The best way to use videos within Teeme is to use the link provided by websites like <a href="http://www.youtube.com" title="youtube">www.youtube.com</a>. You can setup an account with these sites and import the video contents. Then use the url provided by the sites in Teeme editor to link the content. This is the recommended way to use the videos.</p>

<a href="#top">Top</a></p>



</div>

</body>

</html>

