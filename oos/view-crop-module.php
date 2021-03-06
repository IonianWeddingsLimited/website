<?
require ("../_includes/settings.php");
require ("../_includes/function.templates.php");
include ("../_includes/function.database.php");
include ("../_includes/function.genpass.php");

// Connect to sql database
$sql_command = new sql_db();
$sql_command->connect($database_host,$database_name,$database_username,$database_password);

$get_template = new main_template();
include("run_login.php");

// Get Templates
$get_template = new oos_template();

echo "<style type=\"text/css\">
body { background-color: #dcddde; }
</style>";

class Resize_Image {
   
   var $image;
   var $image_type;
 
   function load($filename) {
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
         $this->image = imagecreatefrompng($filename);
      }
   }
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=90, $permissions=null) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image,$filename);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image,$filename);
      }   
      if( $permissions != null) {
         chmod($filename,$permissions);
      }
   }

   function getWidth() {
      return imagesx($this->image);
   }
   function getHeight() {
      return imagesy($this->image);
   }
   function resizeToWidth($width) {
   	  $oldwidth = $this->getWidth();
   	  if($oldwidth>$width) {
      $ratio = $width / $oldwidth;
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
	  }
   }
   function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;   
   }  
     
}

if($_GET["a"] == "viewcrop") {

$image_result = $sql_command->select($database_image_module,"*","WHERE id='".addslashes($_GET["id"])."' and require_crop='Yes'");
$image_record = $sql_command->result($image_result);

if($image_record[3] == "2x1") {
$width = "406";	
} elseif($image_record[3] == "3x1") {
$width = "267";	
} elseif($image_record[3] == "4x1") {
$width = "822";	
} else {
$width = "198";	
} 


$subfolders_result = $sql_command->select($database_pdf_subfolders,"id,folder,name","WHERE folder='".$image_record[3]."' ORDER BY name");
$subfolders_rows = $sql_command->results($subfolders_result);

foreach($subfolders_rows as $subfolders_record) {
if($subfolders_record[0] == $image_record[7]) { $add_selected = "selected=\"selected\""; } else { $add_selected = ""; }
$list1 .= "<option value=\"".$subfolders_record[0]."\" $add_selected >- ".stripslashes($subfolders_record[2])."</option>\n";
}

list($max_width, $max_height, $type, $attr) = getimagesize("../images/imageuploads/".$image_record[3]."/".$image_record[4]);


$aspect_ratio = $width / 185;

?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script src="http://www.ionianweddings.co.uk/js/jquery.Jcrop.js"></script>
<script type="text/javascript">

$(document).ready(function() {

    var jcrop_api;

    $('#target').Jcrop({
      onChange:   showCoords,
      onSelect:   showCoords,
      onRelease:  clearCoords,
	  minSize: [ <?php echo $width; ?>, 185],
	  maxSize: [ <?php echo $max_width; ?>, <?php echo $max_height; ?>],
	  setSelect: [ 0, 0, <?php echo $width; ?>, 185 ],
	  aspectRatio: <?php echo $aspect_ratio; ?>,
    },function(){
      jcrop_api = this;
    });

    $('#coords').on('change','input',function(e){
      var x1 = $('#x1').val(),
          x2 = $('#x2').val(),
          y1 = $('#y1').val(),
          y2 = $('#y2').val();
      jcrop_api.setSelect([x1,y1,x2,y2]);
    });

  });

  function showCoords(c) {
    $('#x1').val(c.x);
    $('#y1').val(c.y);
    $('#x2').val(c.x2);
    $('#y2').val(c.y2);
    $('#w').val(c.w);
    $('#h').val(c.h);
  };

  function clearCoords() { $('#coords input').val(''); }

</script>
<style type="text/css">
form {
	padding:0;
	margin:0;
}
</style>
<link rel="stylesheet" href="../css/jquery.Jcrop.css" type="text/css" />
<div style="width:820px; font-family: Arial, Helvetica, sans-serif; font-size:12px;">
<p style="color:#F00; font-size:14px;"><strong>You must click the image below to select the area you wish to crop.</strong></p>
 <!-- This is the image we're attaching Jcrop to -->
  <img src="/images/imageuploads/<?php echo $image_record[3];?>/<?php echo $image_record[4]; ?>?<?php echo $time; ?>" id="target" width="<?php echo $max_width; ?>" height="<?php echo $max_height; ?>"/>
<div style="clear:both;"></div>
  <!-- This is the form that our event handler fills -->
  <form id="coords" class="coords" method="post"  action="view-crop-module.php">
  <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>" />
  
    <div class="inline-labels" style="display:none;">
    <label>X1 <input type="text" size="4" id="x1" name="x1" /></label>
    <label>Y1 <input type="text" size="4" id="y1" name="y1" /></label>
    <label>X2 <input type="text" size="4" id="x2" name="x2" /></label>
    <label>Y2 <input type="text" size="4" id="y2" name="y2" /></label>
    <label>W <input type="text" size="4" id="w" name="w" /></label>
    <label>H <input type="text" size="4" id="h" name="h" /></label>
   
    </div>


<div style="clear:both;"></div>

<p><hr /></p>
<div style="float:left; width:150px; padding:5px; margin-top:10px;"><strong>Folder</strong></div>
<div style="float:left; padding:5px; margin-top:10px;"><select name="dosavefolder" style="width:170px;">
<option value="<?php echo $image_record[3]; ?>"><?php echo $image_record[3]; ?></option>
<?php echo $list1; ?>
</select></div>
<div style="clear:left;"></div>
<div style="float:left; width:150px; padding:5px; "><strong>Title</strong></div>
<div style="float:left; padding:5px;"><input type="text" name="title" style="width:250px; padding:5px;"/></div>
<div style="clear:left;"></div>
<div style="float:left; width:150px; padding:5px;"><strong>Description</strong></div>
<div style="float:left; padding:5px;"><input type="text" name="description" style="width:450px;padding:5px; " /></div>
<div style="clear:left;"></div>

<div style="float:left; margin-top:10px;"> 
    <input type="submit" name="a" value="Crop and Update" /></div>
    </form>
      <form method="post"  action="view-crop-module.php">
  <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>" />
  <input type="hidden" name="foldername" value="<?php echo $image_record[3]; ?>" />
  <input type="hidden" name="imagename" value="<?php echo $image_record[4]; ?>" />
  
    <div style="float:right;margin-top:10px;"> <input type="submit" name="a" value="Delete Image" /></div>
    <div style="clear:left;"></div>

  </form>
  </div>
  <?
} elseif ($_POST["a"] == "Delete Image") {

$sql_command->delete($database_image_module,"id='".addslashes($_POST["id"])."'");
unlink($base_directory."/images/imageuploads/".$_POST["foldername"]."/".$_POST["imagename"]);

?>
<div style="text-align:left; font-family: Arial, Helvetica, sans-serif; font-size:12px;">
<p>The image has been deleted</p>
</div>
<?

} elseif ($_POST["a"] == "Crop and Update") {
	$targ_w = $_POST['w'];
	$targ_h = $_POST['h'];
	$jpeg_quality = 100;

$image_result = $sql_command->select($database_image_module,"*","WHERE id='".addslashes($_POST["id"])."' and require_crop='Yes'");
$image_record = $sql_command->result($image_result);

if(!$image_record[0]) { $error .= "Please select a file<br>"; }
if(!$_POST['w']) { $error .= "Please select a width<br>"; }
if(!$_POST['h']) { $error .= "Please select a height<br>"; }


if($error) {
?>
<div style="text-align:left; font-family: Arial, Helvetica, sans-serif; font-size:12px;">
<p><?php echo $error; ?></p>
</div>
<?
} else {

if($_POST["dosavefolder"] != "1x1" and $_POST["dosavefolder"] != "2x1" and $_POST["dosavefolder"] != "3x1" and $_POST["dosavefolder"] != "4x1") {

$folder_result = $sql_command->select($database_pdf_subfolders,"id,folder","WHERE id='".addslashes($_POST["dosavefolder"])."'");
$folder_record = $sql_command->result($folder_result);

$save_mainfolder = $folder_record[1];
$save_subfolder = $folder_record[0];
} else {
$save_mainfolder = $_POST["dosavefolder"];
$save_subfolder = 0;	
}
	
	
if($save_mainfolder == "2x1") {
$width = "406";	
} elseif($save_mainfolder == "3x1") {
$width = "267";	
} elseif($save_mainfolder == "4x1") {
$width = "822";	
} else {
$width = "198";	
} 


	  $src = $base_directory."/images/imageuploads/".$image_record[3]."/".$image_record[4];
	  $image_info = getimagesize($src);
      
	  if($image_info["mime"] == "image/png") {
      $img_r = imagecreatefrompng($src);
      }elseif( $image_info["mime"] == "image/jpeg" ) {
      $img_r = imagecreatefromjpeg($src);
      } elseif( $image_info["mime"] == "image/gif" ) {
      $img_r = imagecreatefromgif($src);
      } 
	  
	  $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );


	  
	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x1'],$_POST['y1'],$targ_w,$targ_h,$_POST['w'],$_POST['h']);

      if($image_info["mime"] == "image/png") {
      imagepng($dst_r,$src,$jpeg_quality);
      } elseif($image_info["mime"] == "image/jpeg" ) {
      imagejpeg($dst_r,$src,$jpeg_quality);
      } elseif($image_info["mime"] == "image/gif" ) {
      imagegif($dst_r,$src,$jpeg_quality);    
      } 
	  
	  
	$image = new Resize_Image();
	$image->load($src);
	$image->resizeToWidth($width);
	$image->save($src);  
	  
	  
	  
$sql_command->update($database_image_module,"title='".addslashes($_POST["title"])."'","id='".addslashes($_POST["id"])."'");
$sql_command->update($database_image_module,"description='".addslashes($_POST["description"])."'","id='".addslashes($_POST["id"])."'");
$sql_command->update($database_image_module,"require_crop='No'","id='".addslashes($_POST["id"])."'");
if($_POST["dosavefolder"] != "1x1" and $_POST["dosavefolder"] != "2x1" and $_POST["dosavefolder"] != "3x1" and $_POST["dosavefolder"] != "4x1") { 
$sql_command->update($database_image_module,"subfolder='".addslashes($save_subfolder)."'","id='".addslashes($_POST["id"])."'");
} else {
$sql_command->update($database_image_module,"subfolder='0'","id='".addslashes($_POST["id"])."'");	
}

?>
<div style="text-align:left; font-family: Arial, Helvetica, sans-serif; font-size:12px;">
<p>The image has been cropped</p>
</div>
<?
}

} elseif($_GET["id"] != "undefined") {
	
$image_result = $sql_command->select($database_image_module,"*","WHERE id='".addslashes($_GET["id"])."' and require_crop='Yes'");
$image_record = $sql_command->result($image_result);

if(!$image_record[0]) {
?>
<div style="position:absolute; top:0; right:0; width:36px; height:36px; z-index:2000; cursor:pointer;" onclick="close_imagemodule();"><img src="/images/close.png" /></div>
<div style="position:relative; width:890px; height:26px; background-color:#666; text-align:left; padding-left:10px; padding-top:10px; color:#FFF;"><strong>Image Management</strong></div>

<div style=" height:464px;">
<div style="float:left; width:680px; padding:10px; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size:12px;">
<div style="float:left;"><span onclick="open_imagemodule('1x1','1');" style="color:#c08827; cursor:pointer;">1x1</span> | 
<span onclick="open_imagemodule('2x1','1');" style="color:#c08827; cursor:pointer;">2x1</span> | 
<span onclick="open_imagemodule('3x1','1');" style="color:#c08827; cursor:pointer;">3x1</span> | 
<span onclick="open_imagemodule('4x1','1');" style="color:#c08827; cursor:pointer;">4x1</span></div>
<div style="float:right;"><span onclick="open_awaitingcrop();" style="color:#c08827; cursor:pointer;">Awaiting Cropping</span> | <span onclick="open_originals();" style="color:#c08827; cursor:pointer;">Original Images</span> | <span onclick="open_search();" style="color:#c08827; cursor:pointer;">Search Images</span></div>
<div class="clear"></div>
<p><strong>Awaiting Cropping</strong></p>
<div style="overflow:auto; width:680px; height:570px;"><p>Please select an image to crop</p></div>
</div><div style="float:left; width:180px; padding:10px; background-color:#ccc; height:640px; font-size:12px;">
<span onclick="subfolder('add');" style="color:#c08827; cursor:pointer;">Add Folder</span> | 
<span onclick="subfolder('edit');" style="color:#c08827; cursor:pointer;">Update Folder</span>
<iframe src="file-upload-module.php" style="width:180px;height:600px;border:0px; overflow:hidden;" scrolling="no" width="180" height="600"  frameBorder="0" ></iframe>  
</div>
<div class="clear"></div>
</div>
<?
} else {

if($image_record[3] == "2x1") {
$width = "406";	
} elseif($image_record[3] == "3x1") {
$width = "267";	
} elseif($image_record[3] == "4x1") {
$width = "822";	
} else {
$width = "198";	
} 


list($orig_width, $orig_height) = getimagesize("../images/imageuploads/".$image_record[3]."/".$image_record[4]);

?>
<div style="position:absolute; top:0; right:0; width:36px; height:36px; z-index:2000; cursor:pointer;" onclick="close_imagemodule();"><img src="/images/close.png" /></div>
<div style="position:relative; width:890px; height:26px; background-color:#666; text-align:left; padding-left:10px; padding-top:10px; color:#FFF;"><strong>Image Management</strong></div>

<div style=" height:464px;">
<div style="float:left; width:880px; padding:10px; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size:12px;">
<div style="float:left;"><span onclick="open_imagemodule('1x1','1');" style="color:#c08827; cursor:pointer;">1x1</span> | 
<span onclick="open_imagemodule('2x1','1');" style="color:#c08827; cursor:pointer;">2x1</span> | 
<span onclick="open_imagemodule('3x1','1');" style="color:#c08827; cursor:pointer;">3x1</span> | 
<span onclick="open_imagemodule('4x1','1');" style="color:#c08827; cursor:pointer;">4x1</span></div>
<div style="float:right;"><span onclick="open_awaitingcrop();" style="color:#c08827; cursor:pointer;">Awaiting Cropping</span> | <span onclick="open_originals();" style="color:#c08827; cursor:pointer;">Original Images</span> | <span onclick="open_search();" style="color:#c08827; cursor:pointer;">Search Images</span></div>
<div class="clear"></div>
<p><strong>Crop Image</strong></p>
<p><strong>Folder <?php echo $image_record[3]; ?></strong></p>
<div style="overflow:auto; width:880px; height:670px;"><iframe src="view-crop-module.php?a=viewcrop&id=<?php echo $_GET["id"]; ?>" style="width:880px; height:570px; border:0px;" width="680" height="570" border="0"  frameBorder="0" ></iframe>  </div>
</div>


</div>
<?
}

} else {
	
if($_GET["page"] == "undefined") { $_GET["page"] = ""; }

$page = $_GET["page"];
if($page < 1) { $page = 1; }


$limit = 15;
$limitbottom=($page-1)*$limit;
$order_by = "LIMIT $limitbottom,$limit";


$image_result = $sql_command->select($database_image_module,"*","WHERE require_crop='Yes' and original='No' ORDER BY id $order_by");
$image_row = $sql_command->results($image_result);

foreach($image_row as $image_record) {
$html .= "<img src=\"/images/imageuploads/".addslashes($image_record[3])."/".$image_record[4]."?".$time."\" style=\"float:left; margin-right:5px; margin-bottom:5px;cursor:pointer;\" height=\"85\" onclick=\"open_awaitingcrop('".$image_record[0]."');\">";
}

if(!$html) { $html = "<p>No images found</p>"; }

$total_images = 0;
$total_images = $sql_command->count_rows($database_image_module,"id","require_crop='Yes' and original='No'");


if($total_images > $limit) {
$totalpages = $total_images / $limit;
list($part1,$part2) = explode(".",$totalpages);
if ($part2) { $newpage = $part1 + 1; } else { $newpage = $totalpages; }

$newpage2 = $newpage - 5;

if($page <= 11) {
$start_page = 1;
$end_page = 21;
} elseif($page >= $newpage2) {
$start_page = $newpage - 21;
$end_page = $newpage;
} else {
$start_page = $page -10;
$end_page = $page + 10;
}


for($eachpage=1; $eachpage <= $newpage; $eachpage++) {
if($eachpage >= $start_page and $eachpage <= $end_page) {	
if($eachpage == $page) {
$pagehtml .= "( $eachpage ) ";
} else {
$pagehtml .= "[&nbsp;<span onclick=\"open_awaitingcrop('undefined','".$eachpage."');\" style=\"color:#c08827; cursor:pointer;\">$eachpage</span>&nbsp;] ";
}
}
}
}


$newpage_end = $newpage - 5;
if($page > 5) { $add_start = "<span onclick=\"open_awaitingcrop('undefined','1');\" style=\"color:#c08827; cursor:pointer;\">&lt;&lt;</span> "; }
if($page < $newpage_end) { $add_end = " <span onclick=\"open_awaitingcrop('undefined','".$newpage_end."');\" style=\"color:#c08827; cursor:pointer;\">&gt;&gt;</span>"; }

if($totalpages > 0) {
$showpageinfo = "<p>Page: $add_start$pagehtml$add_end</p>";
}

?>
<div style="position:absolute; top:0; right:0; width:36px; height:36px; z-index:2000; cursor:pointer;" onclick="close_imagemodule();"><img src="/images/close.png" /></div>
<div style="position:relative; width:890px; height:26px; background-color:#666; text-align:left; padding-left:10px; padding-top:10px; color:#FFF;"><strong>Image Management</strong></div>

<div style=" height:464px;">
<div style="float:left; width:680px; padding:10px; text-align:left; font-family: Arial, Helvetica, sans-serif; font-size:12px;">
<div style="float:left;"><span onclick="open_imagemodule('1x1','1');" style="color:#c08827; cursor:pointer;">1x1</span> | 
<span onclick="open_imagemodule('2x1','1');" style="color:#c08827; cursor:pointer;">2x1</span> | 
<span onclick="open_imagemodule('3x1','1');" style="color:#c08827; cursor:pointer;">3x1</span> | 
<span onclick="open_imagemodule('4x1','1');" style="color:#c08827; cursor:pointer;">4x1</span></div>
<div style="float:right;"><span onclick="open_awaitingcrop();" style="color:#c08827; cursor:pointer;">Awaiting Cropping</span> | <span onclick="open_originals();" style="color:#c08827; cursor:pointer;">Original Images</span> | <span onclick="open_search();" style="color:#c08827; cursor:pointer;">Search Images</span></div>
<div class="clear"></div>
<p><strong>Awaiting Cropping</strong></p>
<?php echo $showpageinfo; ?>
<div style="overflow:auto; width:680px; height:370px;"><?php echo $html; ?><div class="clear"></div></div>


     </div><div style="float:left; width:180px; padding:10px; background-color:#ccc; height:640px; font-size:12px;">
<span onclick="subfolder('add');" style="color:#c08827; cursor:pointer;">Add Folder</span> | 
<span onclick="subfolder('edit');" style="color:#c08827; cursor:pointer;">Update Folder</span>
<iframe src="file-upload-module.php" style="width:180px;height:600px;border:0px; overflow:hidden;" scrolling="no" width="180" height="600"  frameBorder="0" ></iframe>   
</div>
<div class="clear"></div>
</div>
<?
}
?>