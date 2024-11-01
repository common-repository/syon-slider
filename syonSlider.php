<?php
/**
 * @package syonSlider
 * @version 1.1.1
 */
/*
Plugin Name: Syon Slider
Plugin URI: http://www.syonplugins.com/
Description: A JCarousellite plugin allows you to quickly & simply put one or more sliders on a page/post/template by using its shortcode or php codes.
Author: syonplugins
Version: 1.1.1
Author URI: http://www.syonplugins.com
*/
function my_admin_scripts() {
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_register_script('my-upload', WP_PLUGIN_URL.'/'.get_slider_dir_name().'/slider_files/js/my-upload.js', array('jquery','media-upload','thickbox'));
wp_enqueue_script('my-upload');

}
function my_admin_styles() {
wp_enqueue_style('thickbox');
}
if (isset($_GET['page']) && $_GET['page'] == 'manage-slider-images') {
	add_action('admin_print_scripts', 'my_admin_scripts');
	add_action('admin_print_styles', 'my_admin_styles');
	}
register_activation_hook(__FILE__,'slider_install');
register_deactivation_hook(__FILE__,'slider_uninstall');
function slider_install()			// Function for installation
{
   global $wpdb;
      $table_name = $wpdb->prefix . "syonslider"; 
		 $table_settings=$wpdb->prefix."syonslidersettings";
$sql = "CREATE TABLE $table_name (
  imgId int(11) NOT NULL auto_increment,
  image varchar(255) default NULL,
  postedtime datetime default NULL,
  savein enum('0','1','2') default '0',
  imgtitle varchar(255) default NULL,
  imgdesc text,
  PRIMARY KEY  (imgId)
)";
	$sql1 = "CREATE TABLE $table_settings (
  id int(11) NOT NULL auto_increment,
  autoplay tinyint(1) default NULL,
  shadow tinyint(1) default NULL,
  controls tinyint(1) default NULL,
  width int(5) default NULL,
  height int(4) default NULL,
  bgcolor varchar(6) default NULL,
  speed int(4) default NULL,
  position enum('0','1','2') default '0',
  sliderno enum('0','1','2') default '0',
  border varchar(255) default NULL,
  PRIMARY KEY  (id)
) ";
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);
dbDelta($sql1);

}
function del_image($delId)
{
	global $wpdb;
  $table_name = $wpdb->prefix . "syonslider";
	$delquery="delete from $table_name where imgId=$delId";
	$delsql=$wpdb->get_results($delquery);
	
}
function del_settings($delId)
{
	global $wpdb;
  $table_name = $wpdb->prefix . "syonslidersettings";
	$delquery="delete from $table_name where id=$delId";
	$delsql=$wpdb->get_results($delquery);
	
}
// Function for uninstallation
function slider_uninstall()
{
	global $wpdb;
  $table_name = $wpdb->prefix . "syonslider";
  $table_settings=$wpdb->prefix."syonslidersettings";
	$sql="DROP TABLE IF EXISTS $table_name;";
	$sql1="DROP TABLE IF EXISTS $table_settings;";
	$wpdb->query($sql);
	$wpdb->query($sql1);
}

function get_slider_dir_name()
{
$dirnamestr=plugin_basename(__FILE__);
$dirnamearray=explode("/",$dirnamestr);
$dirname=trim($dirnamearray[0]);
return $dirname;
}
// Now Adding menus to admin menu
add_action('admin_menu', 'mt_add_pages');

// action function for above hook
function mt_add_pages() {
    add_menu_page(__('Syon Slider','menu-test'), __('Syon Slider','menu-test'), 'manage_options', 'manage-slider-images', 'manage_images' );

    add_submenu_page('manage-slider-images', __('Slider Settings','menu-test'), __('Slider Settings','slider-settings'), 'manage_options', 'slider-settings', 'slider_settings');
	?>


<?

}

function manage_images() {
	?>
	
	<?php
   include('slider_files/updateimages.php');
}
function get_all_records()
{
	global $wpdb;
  $table_name = $wpdb->prefix . "syonslider";
	$sql="select * from $table_name order by postedtime";

	$result1=$wpdb->query($sql);
	
	if($result1 == 0)
	{
		return "null";
	}
	else
	{
			$result=$wpdb->get_results($sql);
			
			return $result;
	}
	
}
function save_settings($autoplay,$shadows,$controls,$width,$height,$bgcolor,$speed,$position,$sliderno,$nborder)
{

	global $wpdb;
	$shadows='0';
	$table_settings=$wpdb->prefix."syonslidersettings";	
	$checkquery="select * from $table_settings";
	$checksql=round($wpdb->query($checkquery));
if(!$position)
{
	$position=0;
}
	if($checksql<=3)
	{
	$insertquery="insert into $table_settings";
	$insertquery.="(autoplay,shadow,controls,width,height,bgcolor,speed,position,sliderno,border)";
	$insertquery.="values('$autoplay','$shadows','$controls',$width,$height,'$bgcolor',$speed,'$position','$sliderno','$nborder')";
	
	$wpdb->get_results($insertquery);
	}
	else
	{
		return "full";
	}
}
function update_settings($autoplay,$shadows,$controls,$width,$height,$bgcolor,$speed,$position,$sliderno,$nborder,$editid)
{

	global $wpdb;
	$shadows='0';
	$table_settings=$wpdb->prefix."syonslidersettings";	
	$checkquery="select * from $table_settings";
	$checksql=round($wpdb->query($checkquery));
if(!$position)
{
	$position=0;
}
	if($checksql<=3)
	{
	$insertquery="update $table_settings";
	$insertquery.=" set autoplay='$autoplay',shadow='$shadows',controls='$controls',width=$width,height=$height,bgcolor='$bgcolor',speed=$speed,position='$position',sliderno='$sliderno',border='$nborder' where id=$editid";

	
	$wpdb->get_results($insertquery);
	}
	else
	{
		return "full";
	}
}
function get_thumbnail_size()
{
	global $wpdb;
	$table_name=$wpdb->prefix."options";
	$thumbnailquery="select * from $table_name where option_name='thumbnail_size_w' or option_name='thumbnail_size_h'";
	$thumbsobject=$wpdb->get_results($thumbnailquery);
	$width=$thumbsobject[0]->option_value;
	$height=$thumbsobject[1]->option_value;
	$array[0]=$width;
	$array[1]=$height;
	return $array;
}
function count_slider()
{
	global $wpdb;

	$table_settings=$wpdb->prefix."syonslidersettings";	
	$checkquery="select * from $table_settings";
	$checksql=round($wpdb->query($checkquery));
return $checksql;
}
function all_settings()
{
	global $wpdb;

		$table_settings=$wpdb->prefix."syonslidersettings";	
		$checkquery="select * from $table_settings";
		$checksql=$wpdb->get_results($checkquery);
		return $checksql;
}
function calculate_new_size($imagepath,$staticsize)
{
$imagesize=getimagesize($imagepath);
	$imagewidth=$imagesize[0];
	$imageheight=$imagesize[1];
		if($imagewidth>$imageheight)
						{
							$newwidth=$staticsize;
							$ratio=$imageheight/$imagewidth;
							$newheight=$newwidth*$ratio;
							
						}
						else
						{
							$newheight=$staticsize;
							$ratio=$imagewidth/$imageheight;
							$newwidth=$newheight*$ratio;
						}
						$return[0]=round($newwidth);
						$return[1]=round($newheight);
						
						return $return;
}

function save_image($filename,$savein,$desc,$title)
{
	global $wpdb;
	$desc=htmlentities($desc);
	$tablename=$wpdb->prefix."syonslider";
	if($tablename)
	{
		if(!$savein)
		{
			$savein=0;
		}
		$insertquery="insert into $tablename(image,postedtime,savein,imgtitle,imgdesc)values('$filename',now(),'$savein','$title','$desc')";
	
		$insertsql=$wpdb->get_results($insertquery);
		?>
<script type="text/javascript">
		window.location="<?=$_SERVER['HTTP_REFERER'];?>";
		</script>
<?
	}
}
function get_slider_settings($sliderno)
{
	global $wpdb;
	if(!$sliderno)
	{
		$sliderno=0;
	}
	$table_name=$wpdb->prefix."syonslidersettings";
	$query="select * from $table_name where sliderno='$sliderno'";
	$sql=$wpdb->get_results($query);
	$mobject=$sql[0];
	$marray['id']=$mobject->id;
		$marray['autoplay']=$mobject->autoplay;
			$marray['shadow']=$mobject->shadow;
				$marray['controls']=$mobject->controls;
					$marray['width']=$mobject->width;
						$marray['height']=$mobject->height;
							$marray['bgcolor']=$mobject->bgcolor;
								$marray['speed']=$mobject->speed;
									$marray['position']=$mobject->position;
										$marray['sliderno']=$mobject->sliderno;
										$marray['border']=$mobject->border;
	return $marray;
}
function slider_settings() {
  include('slider_files/slidersettings.php');
}
// Adding menus ends

// Adding admin head configurations

function admin_head_settings()
{
	?>
    <style type="text/css">
#syon-wrap{
	}
#syon-wrap label{
	width:110px;
	display:block;
	float:left
	}
#syon-wrap input[type=radio]{
	margin:0 4px 0 0;
	}
#syon-wrap h1{
	font-size:28px;
	margin:10px 0;
	padding:10px 8px;
	border-bottom:1px solid #e3e3e3;
	background-color:#fafafa;
	}
#syon-wrap h2{
	font-size:22px;
	margin:10px 0;
	padding:10px 0;
	border-bottom:1px solid #e3e3e3;
	}
#syon-wrap h1 span{
	font-size:12px;
	padding:8px 0 0 0;
	display:block;
	font-weight:normal;
	}

.datatable th {
	background-color:#686868;
	color:white;
	height:35px;
}
.mtext {
	background-color:#f5f5f5;
	height:30px;
	padding-left:5px;
	border-radius:5px;
}
.mselect {
	background-color:#f5f5f5;
	height:30px;
	padding-left:5px;
	border-radius:5px;
}
.tfoot {
	background-color:#686868;
	height:25px;
}
.quote {
	font-size:12px;
	font-style:italic;
}
#viewcode{
	font-style: italic;
	background-color:#444;
	padding:10px;
	float:left;
	color:#fff;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
	margin:0 10px 0 0;
	}
#box{
	margin: 0;
	text-align: left;
	border-left: 1px solid #999;	
	}
ul.tab-menu{
	margin:0;
	padding:0;
	list-style:none;
	}
.tab-menu li{
	float: left;
	}
.tab-menu li a{
	display:block;
	padding:8px 18px 7px 18px;
	border-right: 1px solid #999;	
	border-top: 1px solid #999;
	}
.tab-menu li.active a{
	display:block;
	background-color:#444;
	color:#fff;
	text-decoration:none;
	font-weight:bold
	}
.tab_content{
	padding:15px;
	border: 1px solid #999;
	border-left:none;
	margin:-7px 20px 0 0;
	}
</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>

<script type="text/javascript">
	var $tjx = jQuery.noConflict()
	$tjx(document).ready(function() {
	//Default Action
	$tjx(".tab_content").hide(); //Hide all content
	$tjx("ul.tab-menu li:first").addClass("active").show(); //Activate first tab
	$tjx(".tab_content:first").show(); //Show first tab content
	
	//On Click Event
	$tjx("ul.tab-menu li").click(function() {
		$tjx("ul.tab-menu li").removeClass("active"); //Remove any "active" class
		$tjx(this).addClass("active"); //Add "active" class to selected tab
		$tjx(".tab_content").hide(); //Hide all tab content
		var activeTab = $tjx(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
		$tjx(activeTab).fadeIn(); //Fade in the active content
		return false;
	});

});</script>
    <script type="text/javascript">
function onlyNumbers(evt)
{
	var evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57))
	{
		return false;
		
	}
	else
	{
		return true;
	}
} 
function addmyshortcode()
{
	var savein=document.getElementById("sliderno").value;
	if(savein=="0")
	{
	document.getElementById("viewcode").innerHTML="<strong>[mslider]</strong> or <strong>&lt;?php wp_Slider1(); ?&gt;</strong> ";
	}
	else if(savein=="1")
	{
	document.getElementById("viewcode").innerHTML="<strong>[mslider1]</strong> or <strong>&lt;?php wp_Slider2(); ?&gt;</strong> ";
	}
	else
	{
	document.getElementById("viewcode").innerHTML="<strong>[mslider]</strong> or <strong>&lt;?php wp_Slider3(); ?&gt;</strong> ";
	}
	
}
</script>
    <?

}
add_action("admin_head","admin_head_settings");
add_action('wp_head', 'embedd_files');

// Adding admin head configuration ends
function embedd_files()
{

$unvpath="wp-content/plugins/".get_slider_dir_name()."/slider_files/";

?>

    <link rel="stylesheet" type="text/css" href="<?=$unvpath;?>style_syon.css" />
    <script type="text/javascript" src="<?=$unvpath;?>js/jquery.js"></script>
    <script type="text/javascript" src="<?=$unvpath;?>js/jcarousellite_1.0.1.js"></script>
    <? 
}
add_action('get_header', 'wp_Slider');
function wp_Slider()
{


	global $wpdb;
	$settings_table=$wpdb->prefix."syonslidersettings";
	$main_table=$wpdb->prefix."syonslider";
	$settingsquery="select * from $settings_table where sliderno='0'";
	$settingssql=$wpdb->get_results($settingsquery); 
	
	if(sizeof($settingssql)>0)
	{

		$settingsobj=$settingssql[0];
		$slidername=$settingsobj->sliderno;
		$slidername=round($slidername);
		?>
    <?
			 $recordsquery="select * from $main_table where savein='$slidername'";
		$recordssql=$wpdb->get_results($recordsquery);

		if(sizeof($recordssql))
		{
		
			$Width=$settingsobj->width;
			$Height=$settingsobj->height;
			$auto=$settingsobj->autoplay;
			$speed=$settingsobj->speed;			
			$controls=$settingsobj->controls;
			$unvpath="wp-content/plugins/".get_slider_dir_name()."/slider_files/";
			$rand=rand();
			$border=$settingsobj->border;
			$str='<div id="csGallery'.$rand.'">';
			$str.='<div class="jCarouselLite" style="width:'.$Width.'px;height:'.$Height.'px;"><ul>';
			foreach($recordssql as $mobject)
			{
			$img=$mobject->image;
					$imgtitle=ltrim(rtrim(strip_tags($mobject->imgtitle)));
					$imgdesc=ltrim(rtrim(strip_tags($mobject->imgdesc)));
			$newsize=calculate_new_size($img,$Width);
			$str.='<li style="width:'.($Width-25).'px;height:'.($Height-25).'px; border:'.$border.'"><img src="'.$img.'" width="'.$newsize[0].'" height="'.$newsize[1].'" alt="" />';
			if((strlen(trim($imgtitle))) || (strlen(trim($imgdesc))))
			{
			$str.='<div class="slide-des"><h2>'.$imgtitle.'</h2><p>'.$imgdesc.'</p></div>';				
			}
			$str.='</li>';
			}
			$str.='</ul></div><div style="clear:both"></div>';
			if($controls=="1")
			{
			$str.='<div class="pagination">';
			for($i=1;$i<=sizeof($recordssql);$i++)
			{
				$str.='<a href="#" class="'.$i.'">'.$i.'</a>';
			}
			$str.='</div><div style="clear:both"></div>';
			}
			$str.='</div>';
						
			if($auto=="1")
			{
				$auto="800";
			}
			else
			{
				$auto="false";
			}
			if($speed>0)
			{
	
			}
			else
			{
				$speed="2000";
			}
			$pname="#csGallery".$rand;
			if($controls=="1")
			{
				$mstr=',btnGo:[';
				$nstr="";
				$mcntr=0;
				for($i=1;$i<sizeof($recordssql);$i++)
				{
					$nstr[$mcntr]='"'.$pname.' .'.$i.'"';
					$mcntr++;
				}
				
					$nstr[$mcntr]='"'.$pname.' .'.$i.'"]';
				
				$mstr.=implode(",",$nstr);				

			}
			else
			{
				$mstr="";
			}
            $str.='<script type="text/javascript">$(function() { $("#csGallery'.$rand.'").jCarouselLite({auto: '.$auto.',speed:'.$speed.',visible:true'.$mstr.'});});</script>';
			
			

		}
		
	}
	return $str;
}

function wp_Slider1()
{


	global $wpdb;
	$settings_table=$wpdb->prefix."syonslidersettings";
	$main_table=$wpdb->prefix."syonslider";
	$settingsquery="select * from $settings_table where sliderno='1'";
	$settingssql=$wpdb->get_results($settingsquery); 
	
	if(sizeof($settingssql)>0)
	{

		$settingsobj=$settingssql[0];
		$slidername=$settingsobj->sliderno;
		$slidername=round($slidername);
		?>
    <?
			 $recordsquery="select * from $main_table where savein='$slidername'";
		$recordssql=$wpdb->get_results($recordsquery);

		if(sizeof($recordssql))
		{
		
			$Width=$settingsobj->width;
			$Height=$settingsobj->height;
			$auto=$settingsobj->autoplay;
			$speed=$settingsobj->speed;			
			$controls=$settingsobj->controls;
			$unvpath="wp-content/plugins/slider_files/";
			$rand=rand();
			$border=$settingsobj->border;
			$str='<div id="csGallery'.$rand.'">';
			$str.='<div class="jCarouselLite" style="width:'.$Width.'px;height:'.$Height.'px;"><ul>';
			foreach($recordssql as $mobject)
			{
			$img=$mobject->image;
					$imgtitle=ltrim(rtrim(strip_tags($mobject->imgtitle)));
					$imgdesc=ltrim(rtrim(strip_tags($mobject->imgdesc)));
			$newsize=calculate_new_size($img,$Width);
			$str.='<li style="width:'.($Width-25).'px;height:'.($Height-25).'px; border:'.$border.'"><img src="'.$img.'" width="'.$newsize[0].'" height="'.$newsize[1].'" alt="" />';
			if((strlen(trim($imgtitle))) || (strlen(trim($imgdesc))))
			{
			$str.='<div class="slide-des"><h2>'.$imgtitle.'</h2><p>'.$imgdesc.'</p></div>';				
			}
			$str.='</li>';
			}
			$str.='</ul></div><div style="clear:both"></div>';
			if($controls=="1")
			{
			$str.='<div class="pagination">';
			for($i=1;$i<=sizeof($recordssql);$i++)
			{
				$str.='<a href="#" class="'.$i.'">'.$i.'</a>';
			}
			$str.='</div><div style="clear:both"></div>';
			}
			$str.='</div>';
						
			if($auto=="1")
			{
				$auto="800";
			}
			else
			{
				$auto="false";
			}
			if($speed>0)
			{
	
			}
			else
			{
				$speed="2000";
			}
			$pname="#csGallery".$rand;
			if($controls=="1")
			{
				$mstr=',btnGo:[';
				$nstr="";
				$mcntr=0;
				for($i=1;$i<sizeof($recordssql);$i++)
				{
					$nstr[$mcntr]='"'.$pname.' .'.$i.'"';
					$mcntr++;
				}
				
					$nstr[$mcntr]='"'.$pname.' .'.$i.'"]';
				
				$mstr.=implode(",",$nstr);				

			}
			else
			{
				$mstr="";
			}
            $str.='<script type="text/javascript">$(function() { $("#csGallery'.$rand.'").jCarouselLite({auto: '.$auto.',speed:'.$speed.',visible:true'.$mstr.'});});</script>';
			
			

		}
		
	}
	return $str;
}

function wp_Slider2()
{


	global $wpdb;
	$settings_table=$wpdb->prefix."syonslidersettings";
	$main_table=$wpdb->prefix."syonslider";
	$settingsquery="select * from $settings_table where sliderno='2'";
	$settingssql=$wpdb->get_results($settingsquery); 
	
	if(sizeof($settingssql)>0)
	{

		$settingsobj=$settingssql[0];
		$slidername=$settingsobj->sliderno;
		$slidername=round($slidername);
		?>
    <?
			 $recordsquery="select * from $main_table where savein='$slidername'";
		$recordssql=$wpdb->get_results($recordsquery);

		if(sizeof($recordssql))
		{
		
			$Width=$settingsobj->width;
			$Height=$settingsobj->height;
			$auto=$settingsobj->autoplay;
			$speed=$settingsobj->speed;			
			$controls=$settingsobj->controls;
			$unvpath="wp-content/plugins/slider_files/";
			$rand=rand();
			$border=$settingsobj->border;
			$str='<div id="csGallery'.$rand.'">';
			$str.='<div class="jCarouselLite" style="width:'.$Width.'px;height:'.$Height.'px;"><ul>';
			foreach($recordssql as $mobject)
			{
			$img=$mobject->image;
					$imgtitle=ltrim(rtrim(strip_tags($mobject->imgtitle)));
					$imgdesc=ltrim(rtrim(strip_tags($mobject->imgdesc)));
			$newsize=calculate_new_size($img,$Width);
			$str.='<li style="width:'.($Width-25).'px;height:'.($Height-25).'px; border:'.$border.'"><img src="'.$img.'" width="'.$newsize[0].'" height="'.$newsize[1].'" alt="" />';
			if((strlen(trim($imgtitle))) || (strlen(trim($imgdesc))))
			{
			$str.='<div class="slide-des"><h2>'.$imgtitle.'</h2><p>'.$imgdesc.'</p></div>';				
			}
			$str.='</li>';
			}
			$str.='</ul></div><div style="clear:both"></div>';
			if($controls=="1")
			{
			$str.='<div class="pagination">';
			for($i=1;$i<=sizeof($recordssql);$i++)
			{
				$str.='<a href="#" class="'.$i.'">'.$i.'</a>';
			}
			$str.='</div><div style="clear:both"></div>';
			}
			$str.='</div>';
						
			if($auto=="1")
			{
				$auto="800";
			}
			else
			{
				$auto="false";
			}
			if($speed>0)
			{
	
			}
			else
			{
				$speed="2000";
			}
			$pname="#csGallery".$rand;
			if($controls=="1")
			{
				$mstr=',btnGo:[';
				$nstr="";
				$mcntr=0;
				for($i=1;$i<sizeof($recordssql);$i++)
				{
					$nstr[$mcntr]='"'.$pname.' .'.$i.'"';
					$mcntr++;
				}
				
					$nstr[$mcntr]='"'.$pname.' .'.$i.'"]';
				
				$mstr.=implode(",",$nstr);				

			}
			else
			{
				$mstr="";
			}
            $str.='<script type="text/javascript">$(function() { $("#csGallery'.$rand.'").jCarouselLite({auto: '.$auto.',speed:'.$speed.',visible:true'.$mstr.'});});</script>';
			
			

		}
		
	}
	return $str;
}

function foobar_func( $atts ){
 return wp_Slider();
}
function foobar_func1( $atts ){
 return wp_Slider1();
}
function foobar_func2( $atts ){
 return wp_Slider2();
}
add_shortcode( 'mslider', 'foobar_func' );
add_shortcode( 'mslider1', 'foobar_func1' );
add_shortcode( 'mslider2', 'foobar_func2' );


?>