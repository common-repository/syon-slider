<?php
$furl=$_POST['furl'];
$fdesc=$_POST['fdesc'];
$filepath=$_POST['upload_image'];
$savein=$_POST['savein'];
$filepath=trim($filepath);

if($filepath)
{
	$title=ltrim(rtrim(strip_tags($_POST['imgtitle'])));
	$desc=ltrim(rtrim(strip_tags($_POST['imgdesc'])));
	
save_image($filepath,$savein,$desc,$title);
}
if(isset($_POST['delid']))
{
	$delid=round(trim($_POST['delid']));
	del_image($delid);
	?>
	<script type="text/javascript">
	window.location="<?=$_SERVER['HTTP_REFERER'];?>";
	</script>
	<?
}
?>
<div id="syon-wrap">
	<h1>Syon Slider <br /><span>Ver 1.0.0</span></h1>
<table width="100%" border="0" cellpadding="1" cellspacing="1" class="maintable">
    <tr>
    	<td >
        	<form action="" method="post" id="myform" name="myform">
            <table cellpadding="2" cellspacing="2" width="100%">
             <tr>
            <td  width="146">
            <label>Image Title</label>
            :</td>
            <td width="1007">
			<input type="text" class="mtext" name="imgtitle" id="imgtitle" style="width:300px;"  />
            </td>
            </tr>
            <tr>
            <td id="savintd" width="146">
            <label>Save In </label>
            :</td>
            <td>
			<select class="mtext" name="savein" id="savein"  style="width:300px;">
            		<option value="null" selected="selected">Choose your Slider............</option>
            		<option value="0">Slider I</option>
            		<option value="1">Slider II</option>
	            	<option value="2">Slider III</option>                                
            </select>
            </td>
            </tr>
            
            <tr>
            <td colspan="2">
            <img id="uploadedimage" />
            </td>
            </tr>
            <tr>
            <td id="imagetd">
           <label>Image url</label>
           :</td>
         	  <td>
            <input type="text" name="upload_image" id="upload_image" class="mtext" style="width:300px;"/> <strong>or</strong>  <input class="button-secondary" id="upload_image_button" type="button" value="Upload Image" />
       		<input type="hidden" name="imagedesc" id="imagedesc" />
            </td>
            </tr>
             <tr>
            <td id="imagetd" valign="top">
           <label>Image description</label>
           :
          	 </td>
         	  <td>
            <textarea name="imgdesc" cols="50" class="mtextarea" id="imgdesc" ></textarea>
            </td>
            </tr>
            <tr>
            <td width="146">
            </td>
            <td>
			
			<input type="submit" class="button-primary" name="submit" value="Save Changes" style="" />
            </td>
            </tr>
            </Table>
            </form>
            <br/>
			<?php
			$records=get_all_records();
			if($records =="null")
			{
				?>
				<table cellpadding="0" cellspacing="0" width="100%" border="0" class="datatable">
                	<tr>
                    	<td style="text-align:center" class="mandatory">&nbsp;
                        
                        </td>
                    </tr>
                	<tr>
                    	<td style="text-align:center" class="mandatory">
                        Sorry, No Image Uploaded Yet.
                        </td>
                    </tr>
                	<tr>
                    	<td style="text-align:center" class="mandatory">&nbsp;
                        
                        </td>
                    </tr>                    
                </table>
				<?
			}
			else
			{
				$sno=1;
				
				?>
				<table cellpadding="0" cellspacing="0" width="100%" border="0" class="datatable">
            		<th width="75" style="border-radius:10px 0px 0px 0px;">Sr.No.</th>
                    <th style="text-align:left;">Image</th>
                    <th width="80" style="text-align:left;">Slider</th>
                    <th width="50" style="border-radius:0px 10px 0px 0px;">&nbsp;</th>
                  	<?php
					$count=0;
					foreach($records as $myobject)
					{
						if($count%2==0)
						{
							$st='style="background-color:#e9e9e9;"';
						}
						else
						{
							$st='style="background-color:#d0d0d0;"';
						}
						?>
						<tr <?=$st;?>>
                        	<td align="center">
                            <?=$sno++;?>
                            </td>
	                        <td align="left" style="padding:4px;">
                            <?php
							$mimg=$myobject->image;
											
							$newsize=calculate_new_size($mimg,200);
							?>
                            <img src="<?=$mimg;?>" width="<?=$newsize[0];?>" height="<?=$newsize[1];?>" />
                            
                            </td>
                            <td align="left"><? $savein=$myobject->savein;
							if($savein==0)
							{
								echo "Slider I";
							}
							elseif($savein==1)
							{
								echo "Slider II";
							}
							else
							{
								echo "Slider III";
							}
							?></td>
                            <td>
                            <form action="" method="post">
                            <input type="hidden" name="delid" value="<?=$myobject->imgId;?>" />
							<input type="image" src="../wp-content/plugins/<?php echo get_slider_dir_name();?>/slider_files/delete.png" />
                            </form>
                            </td>
                        </tr>
						<?
						$count++;
					}
					?>
					<tr>
                    <td class="tfoot">&nbsp;</td>
                    <td class="tfoot">&nbsp;</td>
                    <td class="tfoot">&nbsp;</td>
                    <td class="tfoot">&nbsp;</td>
                    </tr>
                </table>
				<?
			}
			?>
    	</td>
    </tr>

</table>
</div>