
<?php
$actionsettings=trim($_POST['actionsettings']);
if($actionsettings)
{
	$editid=$_POST['editid'];
$autoplay=$_POST['autoplay'][0];
$shadow=$_POST['shadow'][0];
$controls=$_POST['controls'][0];
$width=$_POST['width'];
$height=$_POST['height'];
$bgcolor=$_POST['bgcolor'];
$speed=$_POST['speed'];
$position=$_POST['position'];
$sliderno=$_POST['sliderno'];
$border=$_POST['border'];
if(!$border)
{
	$border="fff";
}
$thickness=$_POST['thickness'];
if(!$thickness)
{
	$thickness="3";
}
$border=str_replace("#","",$border);
$nborder="solid ".$thickness."px #$border";
if(!$editid)
{
save_settings($autoplay,$shadow,$controls,$width,$height,$bgcolor,$speed,$position,$sliderno,$nborder);
}
else
{
	update_settings($autoplay,$shadow,$controls,$width,$height,$bgcolor,$speed,$position,$sliderno,$nborder,$editid);
}
?>
<script type="text/javascript">
window.location="<?=$_SERVER['HTTP_REFERER'];?>";
</script>
<?
}
if(isset($_POST['delid']))
{
	$delid=round(trim($_POST['delid']));
	del_settings($delid);
	?>
	<script type="text/javascript">
	window.location="<?=$_SERVER['HTTP_REFERER'];?>";
	</script>
	<?
}

?>
<div id="syon-wrap">
	<h1>Syon Slider <br /><span>Ver 1.0.0</span></h1>
<h2>Slider Setting</h2>



<div id="box">
	<ul class="tab-menu">
					  <li><a href="#slide1">Slider I</a></li>
					  <li><a href="#slide2">Slider II</a></li>
                      <li><a href="#slide3">Slider III</a></li>
					</ul>
    <div style="clear:both"></div>
    <div class="tab_container">
    <?php
	$IstSlider=get_slider_settings("0");
	
	?>
    	<div id="slide1" class="tab_content"><form action="" method="post" >
<table cellpadding="4" cellspacing="0" width="100%" >
	    	<input type="hidden" name="sliderno" id="sliderno" value="0" />
    <tr>
    	<td width="150">
        	<label>Code</label>
        </td>
        <td >
        	<div id="viewcode"><em >Copy <strong>[mslider]</strong> or <strong>&lt;?php echo wp_Slider() ?&gt;</strong> and paste where you want to display this slider</em></div> 
        </td>
       
	</tr>
    <tr>
    	<td width="150">
        	<label>Autoplay</label>
        </td>
        <td>
  <label><input type="radio" name="autoplay[]" id="autoplay[]" value="1" <?php if($IstSlider['autoplay']=="1"){ echo "checked='checked'"; } ?> <?php if(!$IstSlider['autoplay']){ echo "checked='checked'"; } ?> />True</label>&nbsp;<label><input type="radio" name="autoplay[]" id="autoplay[]" value="0" <?php if($IstSlider['autoplay']=="0"){ echo "checked='checked'"; } ?>  />False</label>
            
        </td>
	</tr>
    
    <tr>
    	<td width="150">
        	<label>Controls</label>
        </td>
        <td>
        	<label><input type="radio" name="controls[]" id="controls[]" value="1" <?php if($IstSlider['controls']=="1"){ echo "checked='checked'"; } ?> <?php if(!$IstSlider['controls']){ echo "checked='checked'"; } ?>/>True</label>&nbsp;<label><input type="radio" name="controls[]" id="controls[]" value="0" <?php if($IstSlider['controls']=="0"){ echo "checked='checked'"; } ?>/>False</label>
            
        </td>
	</tr>
     <tr>
    	<td width="150">
        	<label>Slider Width</label>
        </td>
        <td>
        	<input type="text" name="width" id="width" class="mtext"  style="width:50px;" maxlength="4" onKeyPress="return onlyNumbers(event)" value="<?php if($IstSlider['width']>0) { echo $IstSlider['width'];} else { echo "600";}?> "/> px
        </td>
	</tr>
    <tr>
    	<td width="150">
        	<label>Slider Height</label>
        </td>
        <td>
        	<input type="text" name="height" id="height" class="mtext"  style="width:50px;" maxlength="4" onKeyPress="return onlyNumbers(event)" value="<?php if($IstSlider['height']>0) { echo $IstSlider['height'];} else { echo "200";}?>"/> px
        </td>
	</tr>
     <tr>
    	<td width="150">
        	<label>Background Color</label>
        </td>
        <td>
        	<input type="text" name="bgcolor" id="bgcolor" class="mtext"  style="width:50px;" maxlength="6" value="<?php if($IstSlider['bgcolor']) { echo str_replace("#","",$IstSlider['bgcolor']);} else { echo "ffffff";}?>"/> (HexCode eg ccccc) 
        </td>
	</tr>
    <tr>
    	<td width="150">
        	<label>Slider Speed</label>
        </td>
        <td>
        	<input type="text" name="speed" id="speed" class="mtext"  style="width:50px;" maxlength="4" onKeyPress="return onlyNumbers(event)" value="<?php if($IstSlider['speed']>0) { echo $IstSlider['speed'];} else { echo "2000";}?>"/>
        </td>
	</tr>
    <tr>
    	<?php
		$bcolor=$IstSlider['border'];
		?>
        <td width="150">
        	<label>Border Color</label>
           <?php
		   $bcolor=str_replace("solid","",$bcolor);
			$explode=explode("px",$bcolor);
			 $bwidth=trim(round($explode[0]));
			if(!$bwidth)
			{
				$bwidth=3;
			}
			$bcolor=trim($explode[1]);
			$bcolor=str_replace("#","",$bcolor);
			if(!$bcolor)
			{
				$bcolor="efefef";
			}
		   ?>
        </td>
        <td>
        	<input type="text" name="border" id="border" class="mtext"  style="width:50px;" maxlength="6" value="<?=$bcolor;?>"/>
        </td>
	</tr>
     <tr>
    	<td width="150">
        	<label>Border Thickness</label>
        </td>
        <td>
        	<input type="text" name="thickness" id="thickness" class="mtext"  style="width:50px;" maxlength="4" onKeyPress="return onlyNumbers(event)" value="<?=$bwidth;?>"/>
        </td>
	</tr>
      <tr>
    	<td width="150">&nbsp;
        	
        </td>
        <td>
        <input type="hidden" name="actionsettings" value="post" />
        <?php
		if($IstSlider['id'])
		{
			?>
			<input type="hidden" name="editid" id="editid" value="<?=trim(round($IstSlider['id']));?>" />
			<?
		}
		?>
        	<input type="submit" value="Save Slider">&nbsp;<input type="reset" value="Reset" />
        </td>
	</tr>
</table>
</form>
</div>
        <div id="slide2" class="tab_content">
         <?php
	$IstSlider="";
	$IstSlider=get_slider_settings("1");

	?>
        <form action="" method="post" >
<table cellpadding="4" cellspacing="0" width="100%" >
	    	<input type="hidden" name="sliderno" id="sliderno" value="1" />
    <tr>
    	<td width="150">
        	<label>Code</label>
        </td>
        <td >
        	<div id="viewcode"><em >Copy <strong>[mslider1]</strong> or <strong>&lt;?php echo wp_Slider1() ?&gt;</strong> and paste where you want to display this slider</em></div> 
        </td>
       
	</tr>
    <tr>
    	<td width="150">
        	<label>Autoplay</label>
        </td>
        <td>
  <label><input type="radio" name="autoplay[]" id="autoplay[]" value="1" <?php if($IstSlider['autoplay']=="1"){ echo "checked='checked'"; } ?> <?php if(!$IstSlider['autoplay']){ echo "checked='checked'"; } ?>/>True</label>&nbsp;<label><input type="radio" name="autoplay[]" id="autoplay[]" value="0" <?php if($IstSlider['autoplay']=="0"){ echo "checked='checked'"; } ?>  />False</label>
            
        </td>
	</tr>
    
    <tr>
    	<td width="150">
        	<label>Controls</label>
        </td>
        <td>
        	<label><input type="radio" name="controls[]" id="controls[]" value="1" <?php if($IstSlider['controls']=="1"){ echo "checked='checked'"; } ?> <?php if(!$IstSlider['controls']){ echo "checked='checked'"; } ?>/>True</label>&nbsp;<label><input type="radio" name="controls[]" id="controls[]" value="0" <?php if($IstSlider['controls']=="0"){ echo "checked='checked'"; } ?>/>False</label>
            
        </td>
	</tr>
     <tr>
    	<td width="150">
        	<label>Slider Width</label>
        </td>
        <td>
        	<input type="text" name="width" id="width" class="mtext"  style="width:50px;" maxlength="4" onKeyPress="return onlyNumbers(event)" value="<?php if($IstSlider['width']>0) { echo $IstSlider['width'];} else { echo "600";}?> "/> px
        </td>
	</tr>
    <tr>
    	<td width="150">
        	<label>Slider Height</label>
        </td>
        <td>
        	<input type="text" name="height" id="height" class="mtext"  style="width:50px;" maxlength="4" onKeyPress="return onlyNumbers(event)" value="<?php if($IstSlider['height']>0) { echo $IstSlider['height'];} else { echo "200";}?>"/> px
        </td>
	</tr>
     <tr>
    	<td width="150">
        	<label>Background Color</label>
        </td>
        <td>
        	<input type="text" name="bgcolor" id="bgcolor" class="mtext"  style="width:50px;" maxlength="6" value="<?php if($IstSlider['bgcolor']) { echo str_replace("#","",$IstSlider['bgcolor']);} else { echo "ffffff";}?>"/> (HexCode eg ccccc) 
        </td>
	</tr>
    <tr>
    	<td width="150">
        	<label>Slider Speed</label>
        </td>
        <td>
        	<input type="text" name="speed" id="speed" class="mtext"  style="width:50px;" maxlength="4" onKeyPress="return onlyNumbers(event)" value="<?php if($IstSlider['speed']>0) { echo $IstSlider['speed'];} else { echo "2000";}?>"/>
        </td>
	</tr>
    <tr>
    	<?php
		$bcolor=$IstSlider['border'];
		?>
        <td width="150">
        	<label>Border Color</label>
           <?php
		   $bcolor=str_replace("solid","",$bcolor);
			$explode=explode("px",$bcolor);
			 $bwidth=trim(round($explode[0]));
			if(!$bwidth)
			{
				$bwidth=3;
			}
			$bcolor=trim($explode[1]);
			$bcolor=str_replace("#","",$bcolor);
			if(!$bcolor)
			{
				$bcolor="efefef";
			}
		   ?>
        </td>
        <td>
        	<input type="text" name="border" id="border" class="mtext"  style="width:50px;" maxlength="6" value="<?=$bcolor;?>"/>
        </td>
	</tr>
     <tr>
    	<td width="150">
        	<label>Border Thickness</label>
        </td>
        <td>
        	<input type="text" name="thickness" id="thickness" class="mtext"  style="width:50px;" maxlength="4" onKeyPress="return onlyNumbers(event)" value="<?=$bwidth;?>"/>
        </td>
	</tr>
      <tr>
    	<td width="150">&nbsp;
        	
        </td>
        <td>
        <input type="hidden" name="actionsettings" value="post" />
        <?php
		if($IstSlider['id'])
		{
			?>
			<input type="hidden" name="editid" id="editid" value="<?=trim(round($IstSlider['id']));?>" />
			<?
		}
		?>
        	<input type="submit" value="Save Slider">&nbsp;<input type="reset" value="Reset" />
        </td>
	</tr>
</table>
</form>
</div>
        <div id="slide3" class="tab_content"><?php
		$IstSlider="";
	$IstSlider=get_slider_settings("2");
	
	?>
        <form action="" method="post" >
<table cellpadding="4" cellspacing="0" width="100%" >
	    	<input type="hidden" name="sliderno" id="sliderno" value="2" />
    <tr>
    	<td width="150">
        	<label>Code</label>
        </td>
        <td >
        	<div id="viewcode"><em >Copy <strong>[mslider2]</strong> or <strong>&lt;?php echo wp_Slider2() ?&gt;</strong> and paste where you want to display this slider</em></div> 
        </td>
       
	</tr>
    <tr>
    	<td width="150">
        	<label>Autoplay</label>
        </td>
        <td>
  <label><input type="radio" name="autoplay[]" id="autoplay[]" value="1" <?php if($IstSlider['autoplay']=="1"){ echo "checked='checked'"; } ?> <?php if(!$IstSlider['autoplay']){ echo "checked='checked'"; } ?>/>True</label>&nbsp;<label><input type="radio" name="autoplay[]" id="autoplay[]" value="0" <?php if($IstSlider['autoplay']=="0"){ echo "checked='checked'"; } ?>  />False</label>
            
        </td>
	</tr>
    
    <tr>
    	<td width="150">
        	<label>Controls</label>
        </td>
        <td>
        	<label><input type="radio" name="controls[]" id="controls[]" value="1" <?php if($IstSlider['controls']=="1"){ echo "checked='checked'"; } ?> <?php if(!$IstSlider['controls']){ echo "checked='checked'"; } ?>/>True</label>&nbsp;<label><input type="radio" name="controls[]" id="controls[]" value="0" <?php if($IstSlider['controls']=="0"){ echo "checked='checked'"; } ?>/>False</label>
            
        </td>
	</tr>
     <tr>
    	<td width="150">
        	<label>Slider Width</label>
        </td>
        <td>
        	<input type="text" name="width" id="width" class="mtext"  style="width:50px;" maxlength="4" onKeyPress="return onlyNumbers(event)" value="<?php if($IstSlider['width']>0) { echo $IstSlider['width'];} else { echo "600";}?> "/> px
        </td>
	</tr>
    <tr>
    	<td width="150">
        	<label>Slider Height</label>
        </td>
        <td>
        	<input type="text" name="height" id="height" class="mtext"  style="width:50px;" maxlength="4" onKeyPress="return onlyNumbers(event)" value="<?php if($IstSlider['height']>0) { echo $IstSlider['height'];} else { echo "200";}?>"/> px
        </td>
	</tr>
     <tr>
    	<td width="150">
        	<label>Background Color</label>
        </td>
        <td>
        	<input type="text" name="bgcolor" id="bgcolor" class="mtext"  style="width:50px;" maxlength="6" value="<?php if($IstSlider['bgcolor']) { echo str_replace("#","",$IstSlider['bgcolor']);} else { echo "ffffff";}?>"/> (HexCode eg ccccc) 
        </td>
	</tr>
    <tr>
    	<td width="150">
        	<label>Slider Speed</label>
        </td>
        <td>
        	<input type="text" name="speed" id="speed" class="mtext"  style="width:50px;" maxlength="4" onKeyPress="return onlyNumbers(event)" value="<?php if($IstSlider['speed']>0) { echo $IstSlider['speed'];} else { echo "2000";}?>"/>
        </td>
	</tr>
    <tr>
    	<?php
		$bcolor=$IstSlider['border'];
		?>
        <td width="150">
        	<label>Border Color</label>
           <?php
		   $bcolor=str_replace("solid","",$bcolor);
			$explode=explode("px",$bcolor);
			 $bwidth=trim(round($explode[0]));
			if(!$bwidth)
			{
				$bwidth=3;
			}
			$bcolor=trim($explode[1]);
			$bcolor=str_replace("#","",$bcolor);
			if(!$bcolor)
			{
				$bcolor="efefef";
			}
		   ?>
        </td>
        <td>
        	<input type="text" name="border" id="border" class="mtext"  style="width:50px;" maxlength="6" value="<?=$bcolor;?>"/>
        </td>
	</tr>
     <tr>
    	<td width="150">
        	<label>Border Thickness</label>
        </td>
        <td>
        	<input type="text" name="thickness" id="thickness" class="mtext"  style="width:50px;" maxlength="4" onKeyPress="return onlyNumbers(event)" value="<?=$bwidth;?>"/>
        </td>
	</tr>
      <tr>
    	<td width="150">&nbsp;
        	
        </td>
        <td>
        <input type="hidden" name="actionsettings" value="post" />
        <?php
		if($IstSlider['id'])
		{
			?>
			<input type="hidden" name="editid" id="editid" value="<?=trim(round($IstSlider['id']));?>" />
			<?
		}
		?>
        	<input type="submit" value="Save Slider">&nbsp;<input type="reset" value="Reset" />
        </td>
	</tr>
</table>
</form>
</div>
    </div>
</div>

