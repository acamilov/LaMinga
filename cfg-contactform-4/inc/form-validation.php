<?php

session_start();

require_once('../inc/contactform.config.php');

require_once('../class/class.contactform.php');

$contactform_obj = new contactForm($cfg);

$json_error = '';



$post_required_email = array('cfg-element-4-34');

?>
<?php

/**
 * required files and elements are written in saveform.php
 * $post_required_element = array...
 * $post_required_email = array...
 * $json_error = '';
 * json error message for invalid captcha (captcha_img_string)
 */


// delete the files the user uploaded and then deleted

if(isset($_POST['deleteuploadedfile']) && $_POST['deleteuploadedfile'])
{
	foreach($_POST['deleteuploadedfile'] as $value)
	{
		
		if(in_array($value, $_SESSION['uploaded_files']))
		{
			@unlink('../upload/'.$contactform_obj->quote_smart($value));
		}
	}
}



if(isset($_POST['form_value_array']) && $_POST['form_value_array'])
{
	foreach($_POST['form_value_array'] as $value)
	{
		$contactform_obj->mergePost($value);

	}
}

// print_r($post_element_ids);print_r($contactform_obj->merge_post);

if(isset($post_required_element) && $post_required_element && isset($contactform_obj->merge_post) && $contactform_obj->merge_post)
{
	
	foreach($post_required_element as $value)
	{
		foreach($contactform_obj->merge_post as $vvalue)
		{
			if($vvalue['element_id'] == $value)
			{
				if(!$vvalue['element_value'])
				{	//echo $value;
					$json_error .= '{"element_id"