<?php 

	$path =  plugin_dir_url(__FILE__); // define path to link and scripts
	$pageURL = get_permalink();
	$sign = strpos($pageURL,'?')?'&':'?';
	global $wpdb;
	$upb_fields =$wpdb->prefix."upb_fields";
	extract($_REQUEST);


	if($login1)
	{
		include 'UPB_register_file.php';
	}
	else if($login2)
	{
		include 'UPB_login_file.php';
	}
	else if($login3)
	{
		include 'UPB_recover_password_file.php';
	}
	else if($login4)
	{
		include 'UPB_view_profile_file.php';
	}
	else
	{



		?>


		<?php include 'UPB_theme.php'; ?>


		<?php



		if ( is_user_logged_in() )



		{



			$current_user = wp_get_current_user();



			$current_ID = $current_user->ID;



			$user_info = get_userdata($current_ID);



			$user_login = $user_info->user_login;



			$user_firstname = $user_info->user_firstname;



			$user_lastname = $user_info->user_lastname;



			$nickname = $user_info->nickname;



			$display_name = $user_info->display_name;



			$user_e_mail = $user_info->user_email;



			$user_url = $user_info->user_url;



			$user_description = $user_info->user_description;







			$key = 'avtar_image';



			$single = true;



			$avtar_image = get_user_meta( $current_ID, $key, $single );







			$EPSubmit = $_REQUEST['EPSubmit'];







			if($EPSubmit)



			{



				$current_user = wp_get_current_user();



				$current_ID = $current_user->ID;



				$current_ID = $_POST['current_ID'];



				$first_name = $_POST['first_name'];



				$first_name = ucfirst(strtolower($first_name));



				$last_name = $_POST['last_name'];



				$last_name = ucfirst(strtolower($last_name));



				$nickname = $_POST['nickname'];



				$display_name = $_POST['display_name'];



				$display_name = ucfirst(strtolower($display_name));



				$user_email = $_POST['email'];



				$user_url = $_POST['user_url'];



				$aim = $_POST['aim'];



				$yim = $_POST['yim'];



				$jabber = $_POST['jabber'];



				$description = $_POST['description'];



				$pass1 = $_POST['inputPassword'];



				$pass2 = $_POST['pass2'];



				$avtar_image = $_FILES['avtar_image'];



				require_once( ABSPATH . WPINC . '/registration.php');



				$args = array(



					'ID'         => $current_ID,



					'user_email' => $user_email



					);



				if (!empty($user_email))



				{



					wp_update_user( $args );



				}



				



				wp_update_user( array ('ID' => $current_ID, 'first_name' => $first_name) ) ;

				

				wp_update_user( array ('ID' => $current_ID, 'last_name' => $last_name) ) ;



				wp_update_user( array ('ID' => $current_ID, 'nickname' => $nickname) ) ;



				wp_update_user( array ('ID' => $current_ID, 'display_name' => $display_name) ) ;				



				wp_update_user( array ('ID' => $current_ID, 'user_url' => $user_url) ) ;

				add_user_meta( $current_ID, 'aim', $aim, true );

				update_user_meta( $current_ID, 'aim', $aim, $prev_value );



				add_user_meta( $current_ID, 'yim', $yim, true );



				update_user_meta( $current_ID, 'yim', $yim, $prev_value );



				add_user_meta( $current_ID, 'jabber', $jabber, true );



				update_user_meta( $current_ID, 'jabber', $jabber, $prev_value );



				wp_update_user( array ('ID' => $current_ID, 'description' => $description) ) ;







				if (!empty($pass1))



				{



					wp_set_password( $pass1, $current_ID );



				}



				$qry1 = "select * from $upb_fields where user_group like '%".$current_user_role."%' order by ordering asc";

				$reg1=$wpdb->get_results($qry1);

							 //$reg1=mysql_query($qry1);


				if(!empty($reg1))
				{
					foreach($reg1 as $row1)
					{



								 //$Customfield = "CustomField".$row1['Id'];

						$Customfield = str_replace(" ","_",$row1->Name);

								 //echo $Customfield;die;

						add_user_meta( $current_ID, $Customfield, $_POST[$Customfield], true );	



						update_user_meta( $current_ID, $Customfield, $_POST[$Customfield], $prev_value );



					}

				}









				if ($_FILES['avtar_image']['error'] === 0)



				{



					if ( ! function_exists( 'wp_handle_upload' ) )



					{



						require_once( ABSPATH . 'wp-admin/includes/file.php' );



					}



					$upload_overrides = array( 'test_form' => false );



					$movefile = wp_handle_upload( $avtar_image, $upload_overrides );



					$image1 = $movefile['file'];







					$image = wp_get_image_editor( $image1 );



					if ( ! is_wp_error( $image ) )



					{



						$image->resize( 200, 200, true );



						$image->save( $movefile['file'] );



					}







					if ( $movefile )



					{



						$user_id = $current_ID;



						$meta_value = $movefile['url'];



						$meta_key = 'avtar_image';



						$single = true;



						$user_last = get_user_meta( $user_id, $meta_key, $single ); 



						if($user_last)



						{



							update_user_meta( $current_ID, $meta_key, $meta_value );



						}



						else



						{



							update_user_meta( $current_ID, $meta_key, $meta_value );



						}



					}



				}



				?>
				
				<h4 class="text-center">
					Tu perfil ha sido actualizado exitosamente.
				</h4>
				<div class="col-sm-6 col-sm-offset-3">
					<div class="row">
						<div class="col-sm-6">
							<a class="btn btn-primary btn-block" href="javascript:void(0);" onclick="javascript:history.back();">
							Volver al editor
							</a>
						</div>
						<div class="col-sm-6">
							<a class="btn btn-primary btn-block" href="<?php echo $pageURL.$sign; ?>login4=1" title="Home-Page">
								Volver al inicio
							</a>
						</div>
					</div>
				</div>

				<?php



			}



			else



			{



				?>



				<div class="wrap edit-profile-top-area-device">
						<!-- <div class="edit-info">
							<div class="upb-button">



								<a href="javascript:void(0);" onclick="javascript:history.back();">
									Cancel and go back
								</a>



							</div>



						</div> -->
						

						<script type="text/javascript">

							function ValidateFileUpload() {

								var fuData = document.getElementById('avtar_image');

								var FileUploadPath = fuData.value;



//To check if user upload any file

if (FileUploadPath == '') {

           // alert("Please upload an image");



       } else {

       	var Extension = FileUploadPath.substring(

       		FileUploadPath.lastIndexOf('.') + 1).toLowerCase();



//The file uploaded is an image



if (Extension == "gif" || Extension == "png" || Extension == "bmp"

	|| Extension == "jpeg" || Extension == "jpg") {



// To Display

if (fuData.files && fuData.files[0]) {

	var reader = new FileReader();



	reader.onload = function(e) {

		$('#blah').attr('src', e.target.result);

	}



	reader.readAsDataURL(fuData.files[0]);

}



} 



//The file upload is NOT an image

else {

	alert("Photo only allows file types of GIF, PNG, JPG, JPEG and BMP. ");

	return false;



}

}

}

</script>

<script language="javascript" type="text/javascript">



	function validateyour_profile()



	{



		var fuData = document.getElementById('avtar_image');

		var FileUploadPath = fuData.value;



//To check if user upload any file

if (FileUploadPath == '') {

            //alert("Please upload an image");



        } else {

        	var Extension = FileUploadPath.substring(

        		FileUploadPath.lastIndexOf('.') + 1).toLowerCase();



//The file uploaded is an image



if (Extension == "gif" || Extension == "png" || Extension == "bmp"

	|| Extension == "jpeg" || Extension == "jpg") {



// To Display

if (fuData.files && fuData.files[0]) {

	var reader = new FileReader();



	reader.onload = function(e) {

		$('#blah').attr('src', e.target.result);

	}



	reader.readAsDataURL(fuData.files[0]);

}



} 



//The file upload is NOT an image

else {

	alert("Photo only allows file types of GIF, PNG, JPG, JPEG and BMP. ");

	return false;



}

}



var inputPassword = document.getElementById('inputPassword').value;



var user_confirm_password = document.getElementById('user_confirm_password').value;



if(inputPassword != user_confirm_password)



{



	with(document.getElementById('divuser_confirm_password').style)



	{



		width = '300px';



		display = 'block';



	}



	document.getElementById("user_confirm_password").focus();



	return false;



}



return true;



}



</script>



<div>



	<form method="post" action="" id="your-profile" enctype="multipart/form-data" onsubmit="javascript: return validateyour_profile();">

		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-4">
					<label for="user_login">Usuario</label>
					<span class="edit-info pull-right">
						<small>
							Este campo no puede ser editado
						</small>
					</span>
					<input type="text" class="form-control" disabled="disabled" value="<?php echo $user_login; ?>" id="user_login" name="user_login">
					<label for="email">Correo electrónico</label>
					<span class="edit-info pull-right">
						<small>
							Este campo no puede ser editado
						</small>
					</span>
					<input type="text" class="form-control" disabled="disabled" value="<?php echo $user_e_mail; ?>" id="email" name="email">
					<label for="user_password">Contraseña</label>
					<input class="form-control" name="inputPassword" type="password" onfocus="javascript:document.getElementById('user_confirm_password').value = '';" />
					<div id="complexity" class="default" style="display:none;"></div>
					<div id="password_info" class="password-pro" s >Mínimo 7 caracteres</div>
					<label for="user_confirm_password">Confirmar contraseña</label>
					<input id="user_confirm_password" class="form-control" name="pass2" type="password"/>
					<label for="first_name">Nombre</label>
					<input type="text" class="form-control" value="<?php echo $user_firstname; ?>" id="first_name" name="first_name">
					<label for="last_name">Apellido</label>
					<input type="text" class="form-control" value="<?php echo $user_lastname; ?>" id="last_name" name="last_name">
					<label for="nickname">Usuario</label>
					<input type="text" class="form-control" value="<?php echo $nickname; ?>" id="nickname" name="nickname">
					<label for="url">Página web</label>
					<input type="text" class="form-control" value="<?php echo $user_url; ?>" id="user_url" name="user_url">
					<label for="aim">AIM</label>
					<input type="text" class="form-control" value="<?php echo get_user_meta($current_ID, 'aim', true); ?>" id="aim" name="aim">
					<label for="yim">Yahoo IM</label>
					<input type="text" class="form-control" value="<?php echo get_user_meta($current_ID, 'yim', true); ?>" id="yim" name="yim">
					<label for="jabber">Jabber / Google Talk</label>
					<input type="text" class="form-control" value="<?php echo get_user_meta($current_ID,'jabber', true); ?>" id="jabber" name="jabber">
					<label for="avtar_image">Foto de perfil</label>
					<input type="file" onChange="return ValidateFileUpload()" class="regular-text" value="" id="avtar_image" name="avtar_image">
					<label for="description">Acerca de mi</label>
					<textarea class="form-control" cols="30" rows="5" id="description" name="description"><?php echo $user_description; ?></textarea>
				</div>
			</div>
		</div>

		<!-- <div class="formtable">
			<div  class="lable-text">
				<label for="user_login">Username <br/><span class="edit-info">This field cannot be edited</span></label></div>
				<div class="input-box">
					<input type="text" class="regular-text" disabled="disabled" value="<?php echo $user_login; ?>" id="user_login" name="user_login">
				</div>
			</div>
			<div class="formtable">
				<div  class="lable-text">
					<label for="email">E-mail<br/><span class="edit-info">This field cannot be edited</span></label></div><div class="input-box">
					<input type="text" class="regular-text" disabled="disabled" value="<?php echo $user_e_mail; ?>" id="email" name="email"></div>
				</div>
				<div class="formtable">
					<div class="lable-text">
						<label for="user_password">Password<br>
						</label>
					</div>
					<div class="input-box">
						<input id="inputPassword" name="inputPassword" type="password" onfocus="javascript:document.getElementById('user_confirm_password').value = '';" />
						<div id="complexity" class="default" style="display:none;"></div>
						<div id="password_info" class="password-pro" s >At least 7 characters please!</div>
					</div>
				</div>
				<div class="formtable">
					<div class="lable-text">
						<label for="user_confirm_password">Confirm Password<br>
						</label>
					</div>
					<div class="input-box">
						<input id="user_confirm_password" name="pass2" type="password"/>
					</div>
				</div>
				<div class="reg_frontErr" id="divuser_confirm_password" style="display:none;margin: -26px 0 23px !important; margin-left: 223px !important;">Password and confirm password do not match.</div>
				<div class="formtable">
					<div  class="lable-text">
						<label for="first_name">First Name</label></div>
						<div class="input-box">
							<input type="text" class="regular-text" value="<?php echo $user_firstname; ?>" id="first_name" name="first_name"></div>
						</div>
						<div class="formtable">
							<div  class="lable-text">
								<label for="last_name">Last Name</label></div>
								<div class="input-box">
									<input type="text" class="regular-text" value="<?php echo $user_lastname; ?>" id="last_name" name="last_name"></div>
								</div>
								<div class="formtable">
									<div  class="lable-text">
										<label for="nickname">Nickname</label></div>
										<div class="input-box">
											<input type="text" class="regular-text" value="<?php echo $nickname; ?>" id="nickname" name="nickname"></div>
										</div>
										<div class="formtable">
											<div  class="lable-text">
												<label for="url">Website</label></div><div class="input-box">
												<input type="text" class="regular-text code" value="<?php echo $user_url; ?>" id="user_url" name="user_url"></div>
											</div>
											<div class="formtable">
												<div  class="lable-text">
													<label for="aim">AIM</label></div><div class="input-box">
													<input type="text" class="regular-text" value="<?php echo get_user_meta($current_ID, 'aim', true); ?>" id="aim" name="aim"></div>
												</div>
												<div class="formtable">
													<div  class="lable-text">
														<label for="yim">Yahoo IM</label></div><div class="input-box">
														<input type="text" class="regular-text" value="<?php echo get_user_meta($current_ID, 'yim', true); ?>" id="yim" name="yim"></div>
													</div>
													<div class="formtable">
														<div  class="lable-text">
															<label for="jabber">Jabber / Google Talk</label></div><div class="input-box">
															<input type="text" class="regular-text" value="<?php echo get_user_meta($current_ID,'jabber', true); ?>" id="jabber" name="jabber"></div>
														</div>
														<div class="formtable">
															<div  class="lable-text">
																<label for="avtar_image">Display picture publicly as</label></div><div class="input-box">
																<input type="file" onChange="return ValidateFileUpload()" class="regular-text" value="" id="avtar_image" name="avtar_image"></div>
															</div>
															<div class="formtable">
																<div  class="lable-text">
																	<label for="description">About Me</label></div><div class="input-box">
																	<textarea cols="30" rows="5" id="description" name="description"><?php echo $user_description; ?></textarea>
																</div>
															</div> -->

															<?php 

															/* start custom field */	

															$current_user_role = $current_user->roles[0];

															$qry1 = "select * from $upb_fields  where user_group like '%".$current_user_role."%' order by ordering asc";
															$reg1 = $wpdb->get_results($qry1);

						//$reg1=mysql_query($qry1);

						//$totalcustomfield = mysql_num_rows($reg1);


															if(!empty($reg1)):

																?>

															<div class="upb-name UPB-Additional-Information">



																Información adicional



															</div>



															<div class="main-edit-profile edit-profile-device">



																<?php 
																foreach($reg1 as $row1)
																{
								// $key = "CustomField".$row1['Id'];

																	$key = str_replace(" ","_",$row1->Name);

																	$value = get_user_meta($current_ID, $key, true);



																	if($row1->Type=='text')

								//print_r($row1);die;

																		{?>



																	<div class="formtable">

																		<div  class="lable-text">



																			<label for="<?php echo $key; ?>"><?php echo $row1->Name;?></label></div>

																			<div class="input-box">



																				<input type="text" class="regular-text <?php echo $row1->Class;?>" maxlength="<?php echo $row1->Max_Lenght;?>"  value="<?php echo $value;?>" id="<?php echo $key;  ?>" name="<?php echo $key;  ?>" <?php if($row1->Readonly==1)echo 'readonly';?> <?php if($row1->Require==1)echo 'required';?>>



																			</div></div>



																			<?php }







																			if($row1->Type=='textarea')



																				{?>



																			<div class="formtable">

																				<div  class="lable-text">



																					<label for="<?php echo $key;  ?>"><?php echo $row1->Name;?></label></div>

																					<div class="input-box">



																						<textarea  class="regular-text <?php echo $row1->Class;?>" maxlength="<?php echo $row1->Max_Lenght;?>" cols="<?php echo $row1->Cols;  ?>" rows="<?php echo $row1->Rows;  ?>" id="<?php echo $key;  ?>" name="<?php echo $key;  ?>" <?php if($row1->Readonly==1)echo 'readonly';?> <?php if($row1->Require==1)echo 'required';?>><?php echo $value; ?></textarea>



																					</div></div>



																					<?php }







																					if($row1->Type=='radio')



																						{?>



																					<div class="formtable">

																						<div  class="lable-text">



																							<label for="<?php echo $key;  ?>"><?php echo $row1->Name;?></label></div>

																							<div class="input-box">



																								<?php 



																								$arr_radio = explode(',',$row1->Option_Value);







																								foreach($arr_radio as $radio)



																									{?>



																								<div class="radio_option"><?php echo $radio; ?></div> <input type="radio" class="regular-text <?php echo $row1->Class;?>" value="<?php echo $radio;?>" id="<?php echo $key;  ?>" style="width:50px;" name="<?php echo $key;  ?>" <?php if($value == $radio)echo 'checked' ?> <?php if($row1->Readonly==1)echo 'readonly';?> >

																								<?php }?>
																							</div></div>
																							<?php }

																							if($row1->Type=='checkbox')
																								{?>



																							<div class="formtable">

																								<div  class="lable-text">



																									<label for="<?php echo $key;  ?>"><?php echo $row1->Name;?></label></div>

																									<div class="input-box">



																										<?php 



																										$arr_radio = explode(',',$row1->Option_Value);



									//print_r($value);die;

																										$radio_count = 1;

																										foreach($arr_radio as $radio)



																											{?>



																										<div style="float:left;"><?php echo $radio; ?> </div>

																										<input type="checkbox" class="regular-text <?php echo $row1->Class;?>" 

																										value="<?php echo $radio;?>" id="<?php echo $key;  ?>" 

																										style="width:50px;" name="<?php echo $row1->Name.'[]';?>" 

																										<?php if($value!=""){if(in_array($radio,$value))echo 'checked';} ?> 

																										<?php if($row1->Readonly==1)echo 'readonly';?>>







																										<?php $radio_count++; }?>







																									</div></div>



																									<?php }







																									if($row1->Type=='file')



																										{?>



																									<div class="formtable">

																										<div  class="lable-text">



																											<label for="<?php echo $key;  ?>"><?php echo $row1->Name;?></label></div>

																											<div class="input-box">



																												<input type="file" class="regular-text <?php echo $row1->Class;?>" value="" id="<?php echo $key;  ?>" name="<?php echo $key;  ?>">



																											</div></div>



																											<?php }







																											if($row1->Type=='select')



																												{?>



																											<div class="formtable">

																												<div  class="lable-text">



																													<label for="<?php echo $key;  ?>"><?php echo $row1->Name;?></label></div>

																													<div class="input-box">



																														<select class="regular-text <?php echo $row1->Class;?>" id="<?php echo $key;  ?>" name="<?php echo $key;  ?>" <?php if($row1->Readonly==1)echo 'readonly';?> <?php if($row1->Require==1)echo 'required';?>>



																															<?php



																															$arr = explode(',',$row1->Option_Value);



																															foreach($arr as $ar)



																															{



																																?>



																																<option value="<?php echo $ar;?>" <?php if($ar==$value)echo 'selected';?>><?php echo $ar;?></option>



																																<?php	



																															}



																															?>



																														</select>



																													</div></div>



																													<?php }







																												}











																												?>







																											</div>



																											<?php 



																											endif; 

																											/*custom field end */

																											?>




																											<input type="hidden" name="current_ID" id="current_ID" value="<?php echo $current_ID; ?>" />


																											<br>
																											<div class="container">
																												<div class="row">
																													<div class="col-sm-2 col-sm-offset-4">
																														<input type="submit" value="Guardar" class="btn btn-primary btn-block" id="EPSubmit" name="EPSubmit">
																													</div>
																													<div class="col-sm-2">
																														<a class="btn btn-primary btn-block" href="javascript:void(0);" onclick="javascript:history.back();">
																															Volver
																														</a>
																													</div>
																												</div>
																											</div>







																										</div>



																									</form>



																								</div>



																								<?php



																							}



																						}



																						else



																						{



																							?>



																							<div class="main-edit-profile" align="center">



																								You need to login to view this page.



																								<br />



																								<br />



																								<div align="center" style="width:430px;">



																									<div class="UltimatePB-Button">



																										<a href="<?php echo site_url(); ?>">



																											Go back to Home-Page



																										</a>



																									</div>



																									&nbsp;



																									<div class="UltimatePB-Button">



																										<a href="<?php echo $pageURL; ?><?php echo $sign; ?>login2=1" title="Login">



																											Go back to Login



																										</a>



																									</div>



																								</div>



																							</div>



																							<?php



																						}



																					}



																					?>

																					<script>

																						$("#EPSubmit").click(function () {

																							if (!$('#avtar_image').hasExtension(['.jpg', '.png', '.gif'])) {

    // ... block upload

    alert("Invalid Image Extensions");

    return false;

}

else

{

	return true;	

}

});

																					</script>