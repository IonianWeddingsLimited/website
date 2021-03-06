<?

class main_template {

	function topHTML() {
	global $site_url, $meta_title, $meta_keywords, $meta_description,  $sql_command, $database_navigation, $current_page, $add_header, $_SERVER;
	
	
	if(!$meta_title) { $meta_title = "Ionian Weddings"; }
	if(!$meta_keywords) { $meta_keywords = ""; }
	if(!$meta_description) { $meta_description = ""; }
	


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $meta_title; ?></title>
<meta name="keywords" content="<?php echo $meta_keywords; ?>" />
<meta name="description" content="<?php echo $meta_description; ?>" />
<?php if($current_page == "notfound.php") { ?>
<meta name="robots" content="noindex, nofollow" />	

<?php } else { ?>
<meta name="robots" content="index, follow" />
<?php } ?>

<link href="<?php echo $site_url; ?>/css/content.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $site_url; ?>/css/iw.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $site_url; ?>/css/ddlevelsmenu-base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $site_url; ?>/css/ddlevelsmenu-topbar.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $site_url; ?>/skins/tn3/tn3.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $site_url; ?>/js/jquery.tn3.min.js"></script>
<script src="<?php echo $site_url; ?>/js/ddlevelsmenu.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $site_url; ?>/js/js_ddaccordion.js"></script>
<script type="text/javascript" src="<?php echo $site_url; ?>/js/js_ddaccordion_config.js"></script>
<meta property="og:title" content="<?php echo $meta_title; ?>" />
<meta property="og:url" content="http://www.ionianweddings.co.uk<?php echo  $_SERVER["REQUEST_URI"]; ?>" />
<meta property="og:image" content="http://www.ionianweddings.co.uk/images/interface/i_logo_ionian_weddings.gif" />
<meta property="og:type" content="company" />
<meta property="og:site_name" content="Ionian Weddings" />
<meta property="fb:app_id" content="179394783501" />
<?php echo $add_header; ?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-2321991-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>

<body>
<div class="site">

	<div class="header">
	<div class="logo">
   <h1><a href="<?php echo $site_url; ?>/" target="_self" title=""><img src="<?php echo $site_url; ?>/images/interface/i_logo_ionian_weddings.gif" alt="Ionian Weddings" border="0" title="Ionian Weddings" /></a> </h1>
				<h2><img src="<?php echo $site_url; ?>/images/interface/i_exclusively_mediterranean_weddings.gif" alt="Exclusively Mediterranean Weddings" border="0" title="Exclusively Mediterranean Weddings" /></h2>
       </div>
	   <div class="headersm">
	   	<ul>
			<li class="headersmitem"><a href="https://www.facebook.com/IonianWeddings" target="_blank" title="facebook"><img src="<?php echo $site_url; ?>/images/interface/b_header_facebook.gif" alt="facebook" border="0" title="facebook" /></a></li>
			<li class="headersmitem"><a href="https://twitter.com/#!/ionianweddings" target="_blank" title="twitter"><img src="<?php echo $site_url; ?>/images/interface/b_header_twitter.gif" alt="twitter" border="0" title="twitter" /></a></li>
			<li class="headersmitem"><a href="https://pinterest.com/ionianweddings/" target="_blank" title="Pinterest"><img src="<?php echo $site_url; ?>/images/interface/b_header_pinterest.gif" alt="Pinterest" border="0" title="Pinterest" /></a></li>
			<div class="clear"></div>
		</ul>
	   </div>
	<div class="headernavigation">
<div class="fblike">
<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js#appId=179394783501&amp;xfbml=1"></script>
<fb:like href="http://www.ionianweddings.co.uk<?php echo  $_SERVER["REQUEST_URI"]; ?>" send="false" layout="button_count" width="0" show_faces="false" font=""></fb:like>
</div>
<div style="clear:both; margin-bottom:10px;"></div>
<h1>Call us today on 020 8894 1991 / 020 8898 9917</h1>
<?
		
$main_result = $sql_command->select($database_navigation,"hide_page","WHERE id='6' or id='7' or id='8' or id='9' or id='10' or id='16'");
$main_record = $sql_command->results($main_result);


		?>
        <ul>
       		<?php if($main_record[0][0] != "Yes") { ?>
            <li class="headernavigationlink"><a href="<?php echo $site_url; ?>/planning-advice/" target="_self" title="Planning advice">Planning advice</a></li>
            <?php } ?>
            <?php if($main_record[1][0] != "Yes") { ?>
			<li class="headernavigationlink"><a href="<?php echo $site_url; ?>/our-story/" target="_self" title="Our Story">Our Story</a></li>
			<?php } ?>
            <?php if($main_record[2][0] != "Yes") { ?>
			<li class="headernavigationlink"><a href="<?php echo $site_url; ?>/our-team/" target="_self" title="Our Team">Our Team</a></li>
			<?php } ?>
            <?php if($main_record[3][0] != "Yes") { ?>
			<li class="headernavigationlink"><a href="<?php echo $site_url; ?>/faqs/" target="_self" title="FAQs">FAQs</a></li>
			<?php } ?>
            <?php if($main_record[4][0] != "Yes") { ?>
			<li class="headernavigationlink"><a href="<?php echo $site_url; ?>/site-map/" target="_self" title="Site map">Site map</a></li>
			<?php } ?>
            <?php if($main_record[5][0] != "Yes") { ?>
			<li class="headernavigationlink"><a href="<?php echo $site_url; ?>/contact-us/" target="_self" title="Contact us">Contact us</a></li>
			<?php } ?>
			<li class="headernavigationlink"><a href="<?php echo $site_url; ?>/search/" target="_self" title="Planning advice">Search</a></li>
			<li class="clear"></li>
		</ul>
	</div>

	<div class="clear"></div>
</div>	


<div class="main">
<div id="ddtopmenubar" class="mattblackmenu">
	<ul>
	<li><a href="<?php echo $site_url; ?>/packages/" rel="ddsubmenu5" target="_self" title="Packages">Packages</a></li>  
     <li><a href="<?php echo $site_url; ?>/testimonials/" target="_self" title="Testimonials">Testimonials</a></li>
       <li><a href="<?php echo $site_url; ?>/latest-news/" rel="ddsubmenu4" target="_self" title="News & Press">News & Press</a></li>
         <li><a href="<?php echo $site_url; ?>/types-of-ceremony/" rel="ddsubmenu3" target="_self" title="Types of Ceremony">Types of Ceremony</a></li> 
          <li><a href="<?php echo $site_url; ?>/destinations/" rel="ddsubmenu2" target="_self" title="Destinations">Destinations</a></li>
         <li><a href="<?php echo $site_url; ?>/inspiration-ideas/" rel="ddsubmenu1" target="_self" title="Inspiration &amp; Ideas">Inspiration &amp; Ideas</a></li>
   	</ul>
</div>
<script type="text/javascript">ddlevelsmenu.setup("ddtopmenubar", "topbar") //ddlevelsmenu.setup("mainmenuid", "topbar|sidebar")</script>

<?


$level1_result = $sql_command->select($database_navigation,"id,page_name,page_link,external_link,external_url","WHERE parent_id='0' and hide_page='No'");
$level1_row = $sql_command->results($level1_result);
	
foreach($level1_row as $level1_record) {
	
if($level1_record[1] == "Inspiration &amp; Ideas" or $level1_record[1] == "Destinations" or $level1_record[1] == "Types of Ceremony" or $level1_record[1] == "Packages") {

if($level1_record[1] == "Inspiration &amp; Ideas" ) {
?><ul id="ddsubmenu1" class="ddsubmenustyle"><?
} elseif($level1_record[1] == "Destinations" ) {
?><ul id="ddsubmenu2" class="ddsubmenustyle"><?
} elseif($level1_record[1] == "Types of Ceremony" ) {
?><ul id="ddsubmenu3" class="ddsubmenustyle"><?
} elseif($level1_record[1] == "Packages" ) {
?><ul id="ddsubmenu5" class="ddsubmenustyle"><?
}

$level2_result = $sql_command->select($database_navigation,"id,page_name,page_link,external_link,external_url","WHERE parent_id='".addslashes($level1_record[0])."' and hide_page='No' ORDER BY displayorder");
$level2_row = $sql_command->results($level2_result);

foreach($level2_row as $level2_record) {	

$level3_result = $sql_command->select($database_navigation,"id,page_name,page_link,external_link,external_url","WHERE parent_id='".addslashes($level2_record[0])."' and hide_page='No' ORDER BY displayorder");
$level3_row = $sql_command->results($level3_result);

if($level3_row[0][0]) {
echo "<li><a href=\"$site_url/".stripslashes($level1_record[2])."/".stripslashes($level2_record[2])."/\" target=\"_self\" title=\"".stripslashes($level2_record[1])."\">".stripslashes($level2_record[1])."</a><ul>\n";	
foreach($level3_row as $level3_record) {

$level4_result = $sql_command->select($database_navigation,"id,page_name,page_link,external_link,external_url","WHERE parent_id='".addslashes($level3_record[0])."' and hide_page='No' ORDER BY displayorder");
$level4_row = $sql_command->results($level4_result);

if($level4_row[0][0]) {
echo "<li><a href=\"$site_url/".stripslashes($level1_record[2])."/".stripslashes($level2_record[2])."/".stripslashes($level3_record[2])."/\" target=\"_self\" title=\"".stripslashes($level3_record[1])."\">".stripslashes($level3_record[1])."</a><ul>\n";	
foreach($level4_row as $level4_record) {

// check internal link  level 4
if($level4_record[3] == "Yes") {
echo "<li><a href=\"".stripslashes($level4_record[4])."\" target=\"_self\" title=\"".stripslashes($level4_record[1])."\">".stripslashes($level4_record[1])."</a></li>\n";
} else {
echo "<li><a href=\"$site_url/".stripslashes($level1_record[2])."/".stripslashes($level2_record[2])."/".stripslashes($level3_record[2])."/".stripslashes($level4_record[2])."/\" target=\"_self\" title=\"".stripslashes($level4_record[1])."\">".stripslashes($level4_record[1])."</a></li>\n";	
}
}
// end internal link  level 4

echo "</ul></il>\n";
} else {
	
	
// check internal link  level 3
if($level3_record[3] == "Yes") {
echo "<li><a href=\"".stripslashes($level3_record[4])."\" target=\"_self\" title=\"".stripslashes($level3_record[1])."\">".stripslashes($level3_record[1])."</a></li>\n";
} else {
echo "<li><a href=\"$site_url/".stripslashes($level1_record[2])."/".stripslashes($level2_record[2])."/".stripslashes($level3_record[2])."/\" target=\"_self\" title=\"".stripslashes($level3_record[1])."\">".stripslashes($level3_record[1])."</a></li>\n";	
}
}
// end internal link level 4


}
echo "</ul></il>\n";
} else {
	
// check internal link  level 2
if($level2_record[3] == "Yes") {
echo "<li><a href=\"".stripslashes($level2_record[4])."\" target=\"_self\" title=\"".stripslashes($level2_record[1])."\">".stripslashes($level2_record[1])."</a></li>\n";
} else {
echo "<li><a href=\"$site_url/".stripslashes($level1_record[2])."/".stripslashes($level2_record[2])."/\" target=\"_self\" title=\"".stripslashes($level2_record[1])."\">".stripslashes($level2_record[1])."</a></li>\n";	
}
}
// end internal link level 2


}
?></ul><?
}
}
?>




<ul id="ddsubmenu4" class="ddsubmenustyle">
	<li><a href="<?php echo $site_url; ?>/latest-news/" target="_self" title="Latest News">Latest News</a></li>
    <li><a href="<?php echo $site_url; ?>/news-archive/" target="_self" title="News Archive">News Archive</a></li>
	<li><a href="<?php echo $site_url; ?>/in-the-press/" target="_self" title="Ionian Weddings in the Press">Ionian Weddings in the Press</a></li>
</ul>	

<div class="maincontent">
	
<?
	}


	function bottomHTML() {
	global $site_url, $current_page, $sql_command, $database_navigation,$database_gray_feature, $database_home_feature;


$showcase_result = $sql_command->select($database_navigation,"page_name,page_link","WHERE parent_id='21' ORDER BY displayorder LIMIT 4");
$showcase_row = $sql_command->results($showcase_result);

foreach($showcase_row as $showcase_record) {
list($weddingname,$weddinglocation) = explode(",",$showcase_record[0]);

$showcase_html .= "<li class=\"homefeaturenavigationlink\"><a href=\"$site_url/wedding-showcase/".stripslashes($showcase_record[1])."\" target=\"_self\" title=\"".stripslashes($showcase_record[0])."\">".stripslashes($weddingname)."</a></li>\n";
}

 if($current_page == "index") { 
 
$result = $sql_command->select($database_home_feature,"description","ORDER BY id");
$record = $sql_command->results($result);

?></div>
<table border="0" cellspacing="0" cellpadding="0" class="homefeatures">
	<tr>
		<td class="homefeature">
				<div class="homefeaturecontent">
				<?php echo stripslashes($record[0][0]); ?>
			</div>
		</td>
		<td class="homefeaturepad"></td>
		<td class="homefeature">

			<div class="homefeaturecontent">
					<?php echo stripslashes($record[1][0]); ?>
			</div>
		</td>
		<td class="homefeaturepad"></td>
		<td class="homefeature">
			<div class="homefeaturecontent">
<?php echo stripslashes($record[2][0]); ?>
			</div>
		</td>
		<td class="homefeaturepad"></td>
		<td class="homefeature"><div class="homefeaturecontent">
<?php echo stripslashes($record[3][0]); ?>
</div>
<script src="http://widgets.twimg.com/j/2/widget.js"></script>
			<script>
				new TWTR.Widget({
				  version: 2,
				  type: 'profile',
				  rpp: 4,
				  interval: 30000,
				  width: '225',
				  height: '102',
				  theme: {
					shell: {
					  background: '#d9d9d9',
					  color: '#000000'
					},
					tweets: {
					  background: '#ffffff',
					  color: '#000000',
					  links: '#c08827'
					}
				  },
				  features: {
					scrollbar: true,
					loop: false,
					live: false,
					hashtags: true,
					timestamp: true,
					avatars: false,
					behavior: 'all'
				  }
				}).render().setUser('ionianweddings').start();
			</script>
		</td>
	</tr>
</table>	
<?php } else { 

$gray_result = $sql_command->select($database_gray_feature,"title,description,link_name,link_url","ORDER BY id DESC");
$gray_record = $sql_command->results($gray_result);

	?>
    
<div class="sitefeatures">
	<ul>
		<li class="sitefeaturelink sitefeaturecolor01">
			<h1><a href="<?php echo stripslashes($gray_record[0][3]); ?>" target="_self" title="<?php echo stripslashes($gray_record[0][2]); ?>"><?php echo stripslashes($gray_record[0][0]); ?></a></h1>
			<p><?php echo stripslashes($gray_record[0][1]); ?></p>
			<h2><a href="<?php echo stripslashes($gray_record[0][3]); ?>" target="_self" title="<?php echo stripslashes($gray_record[0][2]); ?>"><?php echo stripslashes($gray_record[0][2]); ?></a></h2>
		</li>
		<li class="sitefeaturelink sitefeaturecolor02">
			<h1><a href="<?php echo stripslashes($gray_record[1][3]); ?>" target="_self" title="<?php echo stripslashes($gray_record[1][2]); ?>"><?php echo stripslashes($gray_record[1][0]); ?></a></h1>
			<p><?php echo stripslashes($gray_record[1][1]); ?></p>
			<h2><a href="<?php echo stripslashes($gray_record[1][3]); ?>" target="_self" title="<?php echo stripslashes($gray_record[1][2]); ?>"><?php echo stripslashes($gray_record[1][2]); ?></a></h2>
            </li>

		<li class="sitefeaturelink sitefeaturecolor03">
			<h1><a href="<?php echo stripslashes($gray_record[2][3]); ?>" target="_self" title="<?php echo stripslashes($gray_record[2][2]); ?>"><?php echo stripslashes($gray_record[2][0]); ?></a></h1>
			<p><?php echo stripslashes($gray_record[2][1]); ?></p>
			<h2><a href="<?php echo stripslashes($gray_record[2][3]); ?>" target="_self" title="<?php echo stripslashes($gray_record[2][2]); ?>"><?php echo stripslashes($gray_record[2][2]); ?></a></h2>
		</li>
		<li class="sitefeaturelink sitefeaturecolor04">
			<h1><a href="<?php echo stripslashes($gray_record[3][3]); ?>" target="_self" title="<?php echo stripslashes($gray_record[3][2]); ?>"><?php echo stripslashes($gray_record[3][0]); ?></a></h1>
			<p><?php echo stripslashes($gray_record[3][1]); ?></p>
			<h2><a href="<?php echo stripslashes($gray_record[3][3]); ?>" target="_self" title="<?php echo stripslashes($gray_record[3][2]); ?>"><?php echo stripslashes($gray_record[3][2]); ?></a></h2>
		</li>
		<li class="clear"></li>
	</ul>
</div></div>
<?php } ?>
   </div>
<div class="footer">
	<div class="footericons">
		<ul>
			<li class="footericonslink"><a href="http://www.abta.com/home" target="_blank" title="ABTA"><img src="<?php echo $site_url; ?>/images/b_abta.png" alt="ABTA" border="0" title="ABTA" /></a></li>
			<li class="footericonslink"><a href="http://www.visitgreece.gr/" target="_blank" title="Greek National Tourist Information"><img src="<?php echo $site_url; ?>/images/b_greek_national_tourist_information.png" alt="Greek National Tourist Information" border="0" title="Greek National Tourist Information" /></a></li>
			<!--<li class="footericonslink"><a href="http://www.facebook.com/pages/Ionian-Weddings/179394783501" target="_blank" title="Facebook"><img src="<?php echo $site_url; ?>/images/b_facebook.png" alt="Facebook" border="0" title="Facebook" /></a></li>-->
			<li class="clear"></li>
		</ul>
	</div>
	<div class="footercontent">
		<h1>This site is brought to you by Ionian Weddings Limited, the only site you need to make your wedding dreams come true</h1>
	</div>
	<div class="footernavigation">
		<ul>
			<li class="footernavigationlink">Copyright &copy; 2012. All 2 rights reserved.</li>
			<li class="clear"></li>
		</ul>
        
<?php
$main_result = $sql_command->select($database_navigation,"hide_page","WHERE id='8' or id='11' or id='104' or id='10' or id='12' or id='20' or id='16'");
$main_record = $sql_command->results($main_result);

?>
		<ul>
        	<?php if($main_record[0][0] != "Yes") { ?>
			<li class="footernavigationlink"><a href="<?php echo $site_url; ?>/our-team/" target="_self" title="About us">About us</a></li>
			<?php } ?>
            <?php if($main_record[2][0] != "Yes") { ?>
			<li class="footernavigationlink"><a href="<?php echo $site_url; ?>/help/" target="_self" title="Help">Help</a></li>			
			<?php } ?>
			<li class="footernavigationlink"><a href="<?php echo $site_url; ?>/awards/" target="_self" title="Awards">Awards</a></li>
            <?php if($main_record[6][0] != "Yes") { ?>
            <li class="footernavigationlink"><a href="<?php echo $site_url; ?>/charity-work/" target="_self" title="Help">Charity Work</a></li>			
			<?php } ?>
            <?php if($main_record[1][0] != "Yes") { ?>
			<li class="footernavigationlink"><a href="<?php echo $site_url; ?>/site-map/" target="_self" title="Site Map">Site Map</a></li>			
			<?php } ?>
            <?php if($main_record[3][0] != "Yes") { ?>
			<li class="footernavigationlink"><a href="<?php echo $site_url; ?>/privacy-policy/" target="_self" title="Privacy Policy">Privacy Policy</a></li>			
			<?php } ?>
            <?php if($main_record[5][0] != "Yes") { ?>
            <li class="footernavigationlink"><a href="<?php echo $site_url; ?>/terms-and-conditions/" target="_self" title="Terms and Conditions">Terms and Conditions</a></li>			
			<?php } ?>
            <?php if($main_record[4][0] != "Yes") { ?>
			<li class="footernavigationlink"><a href="<?php echo $site_url; ?>/contact-us/" target="_self" title="Contact Us">Contact Us</a></li>
            <?php } ?>

			<li class="clear"></li>
		</ul>
	</div>
	<div class="clear"></div>
</div>

</div>
</body>
</html>

<?
	}


		function errorHTML($e_title, $e_header, $errors, $backlink, $url) {
		global $laterooms, $site_url;

		if($backlink == "Yes") {
		$backhtml = "<p>[ <a href=\"$site_url/$url\" class=\"red\">Back</a> ]";
		} elseif($backlink == "Link") {
		$backhtml = "<p>[ <a href=\"$site_url/$url\" class=\"red\">Back</a> ]";
		} else {
		$backhtml = "";
		}
		
		echo "<h1>$e_title</h1>
		<h2>$e_header</h2>
		<p>$errors</p>
		<p>$backhtml</p>";

	}
	

}


class admin_template {

	function topHTML() {
	global $site_url, $meta_title, $meta_keywords, $meta_description,  $sql_command, $database_navigation, $current_page, $add_header, $login_record;
	
	
	if(!$meta_title) { $meta_title = "Ionian Weddings"; }
	if(!$meta_keywords) { $meta_keywords = ""; }
	if(!$meta_description) { $meta_description = ""; }
	


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $meta_title; ?></title>
<meta name="keywords" content="<?php echo $meta_keywords; ?>" />
<meta name="description" content="<?php echo $meta_description; ?>" />
<?php if($current_page == "notfound.php") { ?>
<meta name="robots" content="noindex, nofollow" />	
<?php } else { ?>
<meta name="robots" content="index, follow" />
<?php } ?>



<link href="<?php echo $site_url; ?>/css/iw.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $site_url; ?>/css/ddlevelsmenu-base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $site_url; ?>/css/ddlevelsmenu-topbar.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $site_url; ?>/skins/tn3/tn3.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $site_url; ?>/js/jquery.tn3.min.js"></script>
<script src="<?php echo $site_url; ?>/js/ddlevelsmenu.js" type="text/javascript">

/***********************************************
* All Levels Navigational Menu- (c) Dynamic Drive DHTML code library (http://www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>
<script type="text/javascript" src="<?php echo $site_url; ?>/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo $site_url;?>/ckeditor/ckfinder/ckfinder.js"></script>


<script language="JavaScript" src="<?php echo $site_url;?>/js/calendar_eu.js"></script>
<link rel="stylesheet" href="<?php echo $site_url;?>/css/calendar.css">
<?php echo $add_header; ?>
</head>

<body>
<div class="site">

	<div class="header">
	<div class="logo">
   <h1><a href="<?php echo $site_url; ?>/" target="_self" title=""><img src="<?php echo $site_url; ?>/images/interface/i_logo_ionian_weddings.gif" alt="Ionian Weddings" border="0" title="Ionian Weddings" /></a> </h1>
				<h2><img src="<?php echo $site_url; ?>/images/interface/i_exclusively_mediterranean_weddings.gif" alt="Exclusively Mediterranean Weddings" border="0" title="Exclusively Mediterranean Weddings" /></h2>

        
       </div>
	<div class="headernavigation">
		<h1>Call us today on 020 8894 1991</h1>
        <?
		
$main_result = $sql_command->select($database_navigation,"hide_page","WHERE id='6' or id='7' or id='8' or id='9' or id='10' or id='16'");
$main_record = $sql_command->results($main_result);


		?>
        <ul>
       		<?php if($main_record[0][0] != "Yes") { ?>
            <li class="headernavigationlink"><a href="<?php echo $site_url; ?>/planning-advice/" target="_self" title="Planning advice">Planning advice</a></li>
            <?php } ?>
            <?php if($main_record[1][0] != "Yes") { ?>
			<li class="headernavigationlink"><a href="<?php echo $site_url; ?>/our-story/" target="_self" title="Our Story">Our Story</a></li>
			<?php } ?>
            <?php if($main_record[2][0] != "Yes") { ?>
			<li class="headernavigationlink"><a href="<?php echo $site_url; ?>/our-team/" target="_self" title="Our Team">Our Team</a></li>
			<?php } ?>
            <?php if($main_record[3][0] != "Yes") { ?>
			<li class="headernavigationlink"><a href="<?php echo $site_url; ?>/faqs/" target="_self" title="FAQs">FAQs</a></li>
			<?php } ?>
            <?php if($main_record[4][0] != "Yes") { ?>
			<li class="headernavigationlink"><a href="<?php echo $site_url; ?>/site-map/" target="_self" title="Site map">Site map</a></li>
			<?php } ?>
            <?php if($main_record[5][0] != "Yes") { ?>
			<li class="headernavigationlink"><a href="<?php echo $site_url; ?>/contact-us/" target="_self" title="Contact us">Contact us</a></li>
			<?php } ?>
			<li class="headernavigationlink"><a href="<?php echo $site_url; ?>/search/" target="_self" title="Planning advice">Search</a></li>
			<li class="clear"></li>
		</ul>
	</div>

	<div class="clear"></div>
</div>	


<div class="main">
<div id="ddtopmenubar" class="mattblackmenu">
	<ul>
	<li><a href="<?php echo $site_url; ?>/packages/" rel="ddsubmenu5" target="_self" title="Packages">Packages</a></li>  
     <li><a href="<?php echo $site_url; ?>/testimonials/" target="_self" title="Testimonials">Testimonials</a></li>
       <li><a href="<?php echo $site_url; ?>/latest-news/" rel="ddsubmenu4" target="_self" title="News & Press">News & Press</a></li>
         <li><a href="<?php echo $site_url; ?>/types-of-ceremony/" rel="ddsubmenu3" target="_self" title="Types of Ceremony">Types of Ceremony</a></li> 
          <li><a href="<?php echo $site_url; ?>/destinations/" rel="ddsubmenu2" target="_self" title="Destinations">Destinations</a></li>
         <li><a href="<?php echo $site_url; ?>/inspiration-ideas/" rel="ddsubmenu1" target="_self" title="Inspiration &amp; Ideas">Inspiration &amp; Ideas</a></li>
   	</ul>
</div>
<script type="text/javascript">ddlevelsmenu.setup("ddtopmenubar", "topbar") //ddlevelsmenu.setup("mainmenuid", "topbar|sidebar")</script>



	
<?


$level1_result = $sql_command->select($database_navigation,"id,page_name,page_link,external_link,external_url","WHERE parent_id='0'  and hide_page='No'");
$level1_row = $sql_command->results($level1_result);
	
foreach($level1_row as $level1_record) {
	
if($level1_record[1] == "Inspiration &amp; Ideas" or $level1_record[1] == "Destinations" or $level1_record[1] == "Types of Ceremony" or $level1_record[1] == "Packages") {

if($level1_record[1] == "Inspiration &amp; Ideas" ) {
?><ul id="ddsubmenu1" class="ddsubmenustyle"><?
} elseif($level1_record[1] == "Destinations" ) {
?><ul id="ddsubmenu2" class="ddsubmenustyle"><?
} elseif($level1_record[1] == "Types of Ceremony" ) {
?><ul id="ddsubmenu3" class="ddsubmenustyle"><?
} elseif($level1_record[1] == "Packages" ) {
?><ul id="ddsubmenu5" class="ddsubmenustyle"><?
}

$level2_result = $sql_command->select($database_navigation,"id,page_name,page_link,external_link,external_url","WHERE parent_id='".addslashes($level1_record[0])."'  and hide_page='No' ORDER BY displayorder");
$level2_row = $sql_command->results($level2_result);

foreach($level2_row as $level2_record) {	

$level3_result = $sql_command->select($database_navigation,"id,page_name,page_link,external_link,external_url","WHERE parent_id='".addslashes($level2_record[0])."'  and hide_page='No' ORDER BY displayorder");
$level3_row = $sql_command->results($level3_result);

if($level3_row[0][0]) {
echo "<li><a href=\"$site_url/".stripslashes($level1_record[2])."/".stripslashes($level2_record[2])."/\" target=\"_self\" title=\"".stripslashes($level2_record[1])."\">".stripslashes($level2_record[1])."</a><ul>\n";	
foreach($level3_row as $level3_record) {

$level4_result = $sql_command->select($database_navigation,"id,page_name,page_link,external_link,external_url","WHERE parent_id='".addslashes($level3_record[0])."'  and hide_page='No' ORDER BY displayorder");
$level4_row = $sql_command->results($level4_result);

if($level4_row[0][0]) {
echo "<li><a href=\"$site_url/".stripslashes($level1_record[2])."/".stripslashes($level2_record[2])."/".stripslashes($level3_record[2])."/\" target=\"_self\" title=\"".stripslashes($level3_record[1])."\">".stripslashes($level3_record[1])."</a><ul>\n";	
foreach($level4_row as $level4_record) {

// check internal link  level 4
if($level4_record[3] == "Yes") {
echo "<li><a href=\"".stripslashes($level4_record[4])."\" target=\"_self\" title=\"".stripslashes($level4_record[1])."\">".stripslashes($level4_record[1])."</a></li>\n";
} else {
echo "<li><a href=\"$site_url/".stripslashes($level1_record[2])."/".stripslashes($level2_record[2])."/".stripslashes($level3_record[2])."/".stripslashes($level4_record[2])."/\" target=\"_self\" title=\"".stripslashes($level4_record[1])."\">".stripslashes($level4_record[1])."</a></li>\n";	
}
}
// end internal link  level 4

echo "</ul></il>\n";
} else {
	
	
// check internal link  level 3
if($level3_record[3] == "Yes") {
echo "<li><a href=\"".stripslashes($level3_record[4])."\" target=\"_self\" title=\"".stripslashes($level3_record[1])."\">".stripslashes($level3_record[1])."</a></li>\n";
} else {
echo "<li><a href=\"$site_url/".stripslashes($level1_record[2])."/".stripslashes($level2_record[2])."/".stripslashes($level3_record[2])."/\" target=\"_self\" title=\"".stripslashes($level3_record[1])."\">".stripslashes($level3_record[1])."</a></li>\n";	
}
}
// end internal link level 4


}
echo "</ul></il>\n";
} else {
	
// check internal link  level 2
if($level2_record[3] == "Yes") {
echo "<li><a href=\"".stripslashes($level2_record[4])."\" target=\"_self\" title=\"".stripslashes($level2_record[1])."\">".stripslashes($level2_record[1])."</a></li>\n";
} else {
echo "<li><a href=\"$site_url/".stripslashes($level1_record[2])."/".stripslashes($level2_record[2])."/\" target=\"_self\" title=\"".stripslashes($level2_record[1])."\">".stripslashes($level2_record[1])."</a></li>\n";	
}
}
// end internal link level 2


}
?></ul><?
}
}
?>


<ul id="ddsubmenu4" class="ddsubmenustyle">
<li><a href="<?php echo $site_url; ?>/latest-news/" target="_self" title="Latest News">Latest News</a></li>
	<li><a href="<?php echo $site_url; ?>/news-archive/" target="_self" title="News Archive">News Archive</a></li>
	<li><a href="<?php echo $site_url; ?>/in-the-press/" target="_self" title="Ionian Weddings in the Press">Ionian Weddings in the Press</a></li>
</ul>	

<div class="maincontent">
<div class="maincopy">
<div id="adminnav" style="float:left; width:160px; padding:10px; font-size:12px; margin-bottom:20px; color:#ccc;">
<?php if($login_record[0] == "Admin") { ?>
<b>News / Offers</b>
<p>
- <a href="<?php echo $site_url; ?>/admin/add-news.php">Add News</a><br />
- <a href="<?php echo $site_url; ?>/admin/update-news.php">Update News</a></p>

<b>Testimonials</b>
<p>
- <a href="<?php echo $site_url; ?>/admin/add-testimonial.php">Add Testimonial</a><br />
- <a href="<?php echo $site_url; ?>/admin/update-testimonial.php">Update Testimonial</a></p>

<b>Features</b>
<p>
- <a href="<?php echo $site_url; ?>/admin/update-features.php">Update Features</a><br />
- <a href="<?php echo $site_url; ?>/admin/update-home-features.php">Update Home Features</a></p>


<b>Form Results</b>
<p>
- <a href="<?php echo $site_url; ?>/admin/wedding-questionnaire.php">Wedding Questionnaire</a><br />
- <a href="<?php echo $site_url; ?>/admin/personal-consultations.php">Personal Consultations</a><br />
- <a href="<?php echo $site_url; ?>/admin/book-a-callback.php">Book a Callback</a><br />
- <a href="<?php echo $site_url; ?>/admin/feedback.php">Feedback</a><br />
- <a href="<?php echo $site_url; ?>/admin/contact-us.php">Contact Us</a></p>
<?php } ?>


<?php if($login_record[0] == "Admin" or $login_record[0] == "User") { ?>
<b>Navigation</b>
<p>
- <a href="<?php echo $site_url; ?>/admin/add-page.php">Add Page</a><br  />
- <a href="<?php echo $site_url; ?>/admin/update-page.php">Update Page</a><br  />
- <a href="<?php echo $site_url; ?>/admin/display-order.php">Update Display Order</a><br  />
- <a href="<?php echo $site_url; ?>/admin/other-meta-tags.php">Other Meta Tags</a></p>

<b>Gallery</b>
<p>
- <a href="<?php echo $site_url; ?>/admin/add-gallery.php">Add Gallery</a><br />
- <a href="<?php echo $site_url; ?>/admin/update-gallery.php">Update Gallery</a><br />
- <a href="<?php echo $site_url; ?>/admin/update-gallery-display.php">Gallery Display Order</a></p>
<?php } ?>

<?php if($login_record[0] == "Admin") { ?>
<b>Feature Packages</b>
<p>
- <a href="<?php echo $site_url; ?>/admin/add-feature-package.php">Add Feature Package</a><br />
- <a href="<?php echo $site_url; ?>/admin/update-feature-package.php">Update Feature Package</a></p>

<b>Form Dropdown Lists</b>
<p>
- <a href="<?php echo $site_url; ?>/admin/update-country.php">Update Country</a><br />
- <a href="<?php echo $site_url; ?>/admin/update-preffered-time.php">Update Preffered time</a><br />
- <a href="<?php echo $site_url; ?>/admin/update-type-of-ceremony.php">Update Type of ceremony</a><br />
- <a href="<?php echo $site_url; ?>/admin/update-hear-about-us.php">Update Hear about us</a><br />
- <a href="<?php echo $site_url; ?>/admin/update-plan-to-book.php">Update Plan to book</a></p>

<b>Users</b>
<p>
- <a href="<?php echo $site_url; ?>/admin/add-user.php">Add Users</a><br />
- <a href="<?php echo $site_url; ?>/admin/update-user.php">Update Users</a></p>
<?php } ?>

<p><a href="<?php echo $site_url; ?>/admin/logout.php">Logout</a></p>
</div>
    
    <div style="float:left; width:710px; padding:10px 0px 10px 20px; margin-bottom:20px; font-size:12px;">	
<?
	}


	function bottomHTML() {
	global $site_url, $current_page, $database_navigation, $sql_command;
	

	?>
    
	</div>
    <div style="clear:left;"></div>
    </div>
    </div>
    
   </div>
<div class="footer">
	<div class="footericons">
		<ul>
			<li class="footericonslink"><a href="http://www.abta.com/home" target="_blank" title="ABTA"><img src="<?php echo $site_url; ?>/images/b_abta.png" alt="ABTA" border="0" title="ABTA" /></a></li>
			<li class="footericonslink"><a href="http://www.visitgreece.gr/" target="_blank" title="Greek National Tourist Information"><img src="<?php echo $site_url; ?>/images/b_greek_national_tourist_information.png" alt="Greek National Tourist Information" border="0" title="Greek National Tourist Information" /></a></li>
			<!--<li class="footericonslink"><a href="http://www.facebook.com/pages/Ionian-Weddings/179394783501" target="_blank" title="Facebook"><img src="<?php echo $site_url; ?>/images/b_facebook.png" alt="Facebook" border="0" title="Facebook" /></a></li>-->
			<li class="clear"></li>
		</ul>
	</div>
	<div class="footercontent">
		<h1>This site is brought to you by Ionian Weddings Limited, the only site you need to make your wedding dreams come true</h1>
	</div>
	<div class="footernavigation">
		<ul>
			<li class="footernavigationlink">Copyright &copy; 2012. All rights reserved.</li>
			<li class="clear"></li>
		</ul>
<?php
$main_result = $sql_command->select($database_navigation,"hide_page","WHERE id='8' or id='10' or id='104' or id='11' or id='12' or id='20' or id='16'");
$main_record = $sql_command->results($main_result);

?>
		<ul>
        	<?php if($main_record[0][0] != "Yes") { ?>
			<li class="footernavigationlink"><a href="<?php echo $site_url; ?>/our-team/" target="_self" title="About us">About us</a></li>
			<?php } ?>
            <?php if($main_record[2][0] != "Yes") { ?>
			<li class="footernavigationlink"><a href="<?php echo $site_url; ?>/help/" target="_self" title="Help">Help</a></li>			
			<?php } ?>
			<li class="footernavigationlink"><a href="<?php echo $site_url; ?>/awards/" target="_self" title="Awards">Awards</a></li>
            <?php if($main_record[6][0] != "Yes") { ?>
            <li class="footernavigationlink"><a href="<?php echo $site_url; ?>/charity-work/" target="_self" title="Help">Charity Work</a></li>			
			<?php } ?>
            <?php if($main_record[1][0] != "Yes") { ?>
			<li class="footernavigationlink"><a href="<?php echo $site_url; ?>/site-map/" target="_self" title="Site Map">Site Map</a></li>			
			<?php } ?>
            <?php if($main_record[3][0] != "Yes") { ?>
			<li class="footernavigationlink"><a href="<?php echo $site_url; ?>/privacy-policy/" target="_self" title="Privacy Policy">Privacy Policy</a></li>			
			<?php } ?>
            <?php if($main_record[5][0] != "Yes") { ?>
            <li class="footernavigationlink"><a href="<?php echo $site_url; ?>/terms-and-conditions/" target="_self" title="Terms and Conditions">Terms and Conditions</a></li>			
			<?php } ?>
            <?php if($main_record[4][0] != "Yes") { ?>
			<li class="footernavigationlink"><a href="<?php echo $site_url; ?>/contact-us/" target="_self" title="Contact Us">Contact Us</a></li>
            <?php } ?>
			<li class="clear"></li>
		</ul>
	</div>
	<div class="clear"></div>
</div>

</div>
</body>
</html>

<?
	}


		function errorHTML($e_title, $e_header, $errors, $backlink, $url) {
		global $laterooms, $site_url;

		if($backlink == "Yes") {
		$backhtml = "<p>[ <a href=\"$site_url/$url\" class=\"red\">Back</a> ]";
		} elseif($backlink == "Link") {
		$backhtml = "<p>[ <a href=\"$site_url/$url\" class=\"red\">Back</a> ]";
		} else {
		$backhtml = "";
		}
		
		echo "<h1>$e_title</h1>
		<h2>$e_header</h2>
		<p>$errors</p>
		<p>$backhtml</p>";

	}
	

}




class oos_template {

	function topHTML() {
	global $site_url, $meta_title, $meta_keywords, $meta_description,  $sql_command, $database_navigation, $current_page, $add_header, $login_record, $hide_sidebar;
	
	
	if(!$meta_title) { $meta_title = "Ionian Weddings"; }
	if(!$meta_keywords) { $meta_keywords = ""; }
	if(!$meta_description) { $meta_description = ""; }
	


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $meta_title; ?></title>
<meta name="keywords" content="<?php echo $meta_keywords; ?>" />
<meta name="description" content="<?php echo $meta_description; ?>" />
<?php if($current_page == "notfound.php") { ?>
<meta name="robots" content="noindex, nofollow" />	
<?php } else { ?>
<meta name="robots" content="index, follow" />
<?php } ?>



<link href="<?php echo $site_url; ?>/css/iw_oos.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $site_url; ?>/skins/tn3/tn3.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $site_url; ?>/js/jquery.tn3.min.js"></script>
<script type="text/javascript" src="<?php echo $site_url; ?>/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo $site_url;?>/ckeditor/ckfinder/ckfinder.js"></script>
<script language="JavaScript" src="<?php echo $site_url;?>/js/calendar_eu.js"></script>
<link rel="stylesheet" href="<?php echo $site_url;?>/css/calendar.css">
<?php echo $add_header; ?>
<style type="text/css">
.maincontent h2{
	font-size:18px;
}

.maincontent h3 {
	font-size:14px;
}

a.buttonlink, a.buttonlink:link, a.buttonlink:visited, a.buttonlink:active {
text-decoration:none;
}

a.buttonlink:hover {
text-decoration:none;
}
</style>
</head>

<body>
<div class="site">

	<div class="header">
	<div class="logo">
     <h1><a href="<?php echo $site_url; ?>/" target="_self" title=""><img src="<?php echo $site_url; ?>/images/interface/i_logo_ionian_weddings.gif" alt="Ionian Weddings" border="0" title="Ionian Weddings" /></a> </h1>
				<h2><img src="<?php echo $site_url; ?>/images/interface/i_exclusively_mediterranean_weddings.gif" alt="Exclusively Mediterranean Weddings" border="0" title="Exclusively Mediterranean Weddings" /></h2>
        
       </div>
	<div class="headernavigation">
		<h1>Online Ordering System</h1>
	</div>

	<div class="clear"></div>
</div>	


<div class="main">
<div class="maincontent">
<div class="maincopy" style="margin-top:20px;">
<?php if($hide_sidebar != "Yes") { ?>
<div id="adminnav" style="float:left; width:160px; padding:10px; font-size:12px; margin-bottom:20px; color:#ccc;">

<b>Web Form Submissions</b>
<p>
- <a href="<?php echo $site_url; ?>/oos/wedding-questionnaire.php">Wedding Questionnaire</a><br />
- <a href="<?php echo $site_url; ?>/oos/personal-consultations.php">Personal Consultations</a><br />
- <a href="<?php echo $site_url; ?>/oos/book-a-callback.php">Book a Call Back</a><br />
- <a href="<?php echo $site_url; ?>/oos/contact-us.php">Contact Us</a></p>
 <?
          //          if ($_SESSION['admin_area_username']=="u1") { 
					?>
                    <br /><br />
					- <a href="<?php echo $site_url; ?>/oos/search-submissions.php">Search All</a>
                    <?php 
		//			}
					?>

<b>Customers & Orders</b>
<p>
- <a href="<?php echo $site_url; ?>/oos/search.php">Search</a><br />
- <a href="<?php echo $site_url; ?>/oos/add-client.php">Add Client</a><br />
- <a href="<?php echo $site_url; ?>/oos/manage-client.php">Manage Customer/Orders</a><br />
- <a href="<?php echo $site_url; ?>/oos/manage-supplier-po.php">Manage Supplier P/O's</a></p>

<b>Outstanding</b>
<p>- <a href="<?php echo $site_url; ?>/oos/os-client-invoices.php">Client Invoices</a><br />
- <a href="<?php echo $site_url; ?>/oos/os-supplier-purchase-orders.php">Supplier Purchase Orders</a></p>

<b>Archive</b>
<p>- <a href="<?php echo $site_url; ?>/oos/archived-client-invoices.php">Client Invoices</a><br />
- <a href="<?php echo $site_url; ?>/oos/archived-supplier-purchase-orders.php">Supplier Purchase Orders</a></p>


<?php if($login_record[0] == "Admin") { ?>
<b>Reports</b>
<p>- <a href="<?php echo $site_url; ?>/oos/hmrc-report-1.php">HMRC Report by Month</a><br />
- <a href="<?php echo $site_url; ?>/oos/hmrc-report-2.php">HMRC Report by Date</a><br />
- <a href="<?php echo $site_url; ?>/oos/destination-report.php">Revenue by Destination</a><br />
- <a href="<?php echo $site_url; ?>/oos/destination-report-2.php">Destination / Wedding Date</a><br />
- <a href="<?php echo $site_url; ?>/oos/destination-report-3.php">Average Booking Value</a></p>
<?php } ?>


<b>Packages</b>
<p>
- <a href="<?php echo $site_url; ?>/oos/add-package.php">Add Package</a><br />
- <a href="<?php echo $site_url; ?>/oos/update-package.php">Update Packages</a><br />
- <a href="<?php echo $site_url; ?>/oos/included-in-package.php">Included in Packages</a></p>

<b>Menus</b>
<p>
- <a href="<?php echo $site_url; ?>/oos/add-menu.php">Add Menu</a><br />
- <a href="<?php echo $site_url; ?>/oos/update-menu.php">Update Menu</a></p>

<b>Menu Venues</b>
<p>
- <a href="<?php echo $site_url; ?>/oos/add-venue.php">Add Venue</a><br />
- <a href="<?php echo $site_url; ?>/oos/update-venue.php">Update Venue</a></p>

<b>Extras</b>
<p>
- <a href="<?php echo $site_url; ?>/oos/add-extra.php">Add Extra</a><br />
- <a href="<?php echo $site_url; ?>/oos/update-extra.php">Update Extra</a></p>

<b>Extra Categories</b>
<p>
- <a href="<?php echo $site_url; ?>/oos/add-category.php">Add Category</a><br />
- <a href="<?php echo $site_url; ?>/oos/update-category.php">Update Category</a></p>

<b>Ceremonies/Receptions</b>
<p>
- <a href="<?php echo $site_url; ?>/oos/add-ceremony-reception.php">Add </a><br />
- <a href="<?php echo $site_url; ?>/oos/update-ceremony-reception.php">Update </a></p>

<b>Suppliers</b>
<p>
- <a href="<?php echo $site_url; ?>/oos/add-supplier.php">Add Supplier</a><br />
- <a href="<?php echo $site_url; ?>/oos/update-supplier.php">Update Supplier</a></p>


<?php if($login_record[0] == "Admin") { ?>
<b>Users</b>
<p>
- <a href="<?php echo $site_url; ?>/oos/add-user.php">Add Users</a><br />
- <a href="<?php echo $site_url; ?>/oos/update-user.php">Update Users</a></p>
<?php } ?>

<?php 
//<b>Actions</b>
//<p>
//- <a href="<?php echo $site_url; ?/>/oos/update-menu-prices.php">Update Menu Prices</a><br />
//- <a href="</? echo $site_url; ?/>/oos/update-extra-prices.php">Update Extra Prices</a></p>?>

<p><a href="<?php echo $site_url; ?>/oos/logout.php">Logout</a></p>
</div>
    
    <div style="float:left; width:710px; padding:10px 0px 10px 20px; margin-bottom:20px; font-size:12px;">	
<?php } else { ?>
  <div style="float:left; width:900px; padding:10px 0px 10px 20px; margin-bottom:20px; font-size:12px;">	
<?php } ?><?
	}


	function bottomHTML() {
	global $site_url, $current_page;
	

	?>
    
	</div>
    <div style="clear:left;"></div>
    </div>
    </div>
    
   </div>
</div>
</body>
</html>

<?
	}


		function errorHTML($e_title, $e_header, $errors, $backlink, $url) {
		global $laterooms, $site_url;

		if($backlink == "Yes") {
		$backhtml = "<p>[ <a href=\"$site_url/$url\" class=\"red\">Back</a> ]";
		} elseif($backlink == "Link") {
		$backhtml = "<p>[ <a href=\"$site_url/$url\" class=\"red\">Back</a> ]";
		} else {
		$backhtml = "";
		}
		
		echo "<h1>$e_title</h1>
		<h2>$e_header</h2>
		<p>$errors</p>
		<p>$backhtml</p>";

	}
	

}
?>