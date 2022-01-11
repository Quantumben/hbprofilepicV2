<?php

//  designed by Thrilldigitals Technologies
//  contact us via 
// services@thrilldigitals.com

namespace Verot\Upload;

error_reporting(E_ALL);

// we first include the upload class, as we will need it here to deal with the uploaded file
include('verot/class.upload.php/src/class.upload.php');

// set variables
$dir_dest = (isset($_GET['dir']) ? $_GET['dir'] : 'tmp');
$dir_pics = (isset($_GET['pics']) ? $_GET['pics'] : $dir_dest);

$log = '';

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv=content-type content="text/html; charset=UTF-8">
<head>
    <title>Download Image</title>
    <link rel="stylesheet" href="ben.css">
    <style>
  img {
    width:100%;
    height:auto;
  }
  .img{
    vertical-align: middle !important ;
    display: inline-block !important ;
    height: auto;
    max-width: 100% !important ;
    border: none;
    -webkit-border-radius: 0;
    border-radius: 0;
    -webkit-box-shadow: none;
    box-shadow: none;
    width: 406 !important;
    /* width= 406!important;  */
    /* height="37" */
    width:30% !important;
    padding-top: 79.141px !important;
}
  .customrole{
    color: #FFFFFF;
    font-family: "Roboto", Sans-serif;
    font-size: 20px;
    font-weight: 300;
    /* padding-top: 20px; */
    padding: 20px;
  }
  .white {
    padding-top: 79.141px !important;
  }
  </style>
</head>

<body>
<img src="banner1.jpg" >
<img  class="img" width="406" height="37" src="http://hbprofilepic.com/wp-content/uploads/2022/01/logo.png">
    <h2 class="customrole">Custom role profile pic</h2>
   <h2 class="h2">DOWNLOAD YOUR PIC</h2>

<?php


// we have several forms on the test page, so we redirect accordingly
$action = (isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : ''));

if ($action == 'simple') {

    // ---------- SIMPLE UPLOAD ----------

    // we create an instance of the class, giving as argument the PHP object
    // corresponding to the file field from the form
    // All the uploads are accessible from the PHP object $_FILES
    $handle = new Upload($_FILES['my_field']);

    // then we check if the file has been uploaded properly
    // in its *temporary* location in the server (often, it is /tmp)
    if ($handle->uploaded) {

        // yes, the file is on the server
        // now, we start the upload 'process'. That is, to copy the uploaded file
        // from its temporary location to the wanted location
        // It could be something like $handle->process('/home/www/my_uploads/');
        $handle->process($dir_dest);

        // we check if everything went OK
        if ($handle->processed) {
            // everything was fine !
            echo '<p class="result">';
            echo '  <b>File uploaded with success</b><br />';
            echo '  File: <a href="'.$dir_pics.'/' . $handle->file_dst_name . '">' . $handle->file_dst_name . '</a>';
            echo '   (' . round(filesize($handle->file_dst_pathname)/256)/4 . 'KB)';
            echo '</p>';
        } else {
            // one error occured
            echo '<p class="result">';
            echo '  <b>File not uploaded to the wanted location</b><br />';
            echo '  Error: ' . $handle->error . '';
            echo '</p>';
        }

        // we delete the temporary files
        $handle-> clean();

    } else {
        // if we're here, the upload file failed for some reasons
        // i.e. the server didn't receive the file
        echo '<p class="result">';
        echo '  <b>File not uploaded on the server</b><br />';
        echo '  Error: ' . $handle->error . '';
        echo '</p>';
    }

    $log .= $handle->log . '<br />';


} else if ($action == 'base64') {

    // ---------- BASE64 FILE ----------

    // we create an instance of the class, giving as argument the data string
    $handle = new Upload((isset($_POST['my_field']) ? $_POST['my_field'] : (isset($_GET['file']) ? $_GET['file'] : '')));

    // check if a temporary file has been created with the file data
    if ($handle->uploaded) {

        // yes, the file is on the server
        $handle->process($dir_dest);

        // we check if everything went OK
        if ($handle->processed) {
            // everything was fine !
            echo '<p class="result">';
            echo '  <b>File uploaded with success</b><br />';
            echo '  File: <a href="'.$dir_pics.'/' . $handle->file_dst_name . '">' . $handle->file_dst_name . '</a>';
            echo '   (' . round(filesize($handle->file_dst_pathname)/256)/4 . 'KB)';
            echo '</p>';
        } else {
            // one error occured
            echo '<p class="result">';
            echo '  <b>File not uploaded to the wanted location</b><br />';
            echo '  Error: ' . $handle->error . '';
            echo '</p>';
        }

        // we delete the temporary files
        $handle-> clean();

    } else {
        // if we're here, the file failed for some reasons
        echo '<p class="result">';
        echo '  <b>File not uploaded on the server</b><br />';
        echo '  Error: ' . $handle->error . '';
        echo '</p>';
    }

    $log .= $handle->log . '<br />';

} else if ($action == 'image') {

    // ---------- IMAGE UPLOAD ----------

    // we create an instance of the class, giving as argument the PHP object
    // corresponding to the file field from the form
    // All the uploads are accessible from the PHP object $_FILES
    $handle = new Upload($_FILES['my_field']);

    // then we check if the file has been uploaded properly
    // in its *temporary* location in the server (often, it is /tmp)
    if ($handle->uploaded) {

        // yes, the file is on the server
        // below are some example settings which can be used if the uploaded file is an image.
        $handle->image_resize            = true;
        $handle->image_ratio_y           = true;
        $handle->image_x                 = 500;
        $handle->image_x                 = 500;
        
        // $handle->image_border          = 5;
        // $handle->image_border_color    = '#00FF00';
        // $handle->image_border_opacity  = 50;


        // $handle->image_unsharp         = true;
        // $handle->image_unsharp_amount  = 200;
        // $handle->image_unsharp_radius  = 1;
        // $handle->image_unsharp_threshold = 5;

        // $handle->image_frame           = 1;
        // $handle->image_frame_colors    = '#FF0000 #FFFFFF
        //                                   #FFFFFF #0000FF';
        // $handle->image_resize          = true;
        // $handle->image_ratio_y         = true;
        // $handle->image_x               = 150;
        // $handle->image_precrop         = 15;

        // $handle->image_resize          = true;
        // $handle->image_ratio_y         = true;
        // $handle->image_x               = 50;

        $handle->image_watermark       = 'TEMPLATE_OG.png';
       // $handle->image_watermark_no_zoom_out = true;

        // now, we start the upload 'process'. That is, to copy the uploaded file
        // from its temporary location to the wanted location
        // It could be something like $handle->process('/home/www/my_uploads/');
        $handle->process($dir_dest);

        // we check if everything went OK
        if ($handle->processed) {
            // everything was fine !
            echo '<p class="result">';
            echo '  <b>File uploaded with success</b><br />';
           // echo '  <img src="'.$dir_pics.'/' . $handle->file_dst_name . '" />';
            $info = getimagesize($handle->file_dst_pathname);
            
            echo '<center> File: <a class="myButton2" download=""  href="'.$dir_pics.'/' . $handle->file_dst_name . ' " > DOWNLOAD NOW</a> </center>';
     
            echo '   (' . $info['mime'] . ' - ' . $info[0] . ' x ' . $info[1] .' -  ' . round(filesize($handle->file_dst_pathname)/256)/4 . 'KB)';
            echo '</p>';
        } 
        

    } else {
        // if we're here, the upload file failed for some reasons
        // i.e. the server didn't receive the file
        echo '<p class="result">';
        echo '  <b>File not uploaded on the server</b><br />';
        echo '  Error: ' . $handle->error . '';
        echo '</p>';
    }

    $log .= $handle->log . '<br />';

} else if ($action == 'xhr') {

    // ---------- XMLHttpRequest UPLOAD ----------

    // we first check if it is a XMLHttpRequest call
    if (isset($_SERVER['HTTP_X_FILE_NAME']) && isset($_SERVER['CONTENT_LENGTH'])) {

        // we create an instance of the class, feeding in the name of the file
        // sent via a XMLHttpRequest request, prefixed with 'php:'
        $handle = new Upload('php:'.$_SERVER['HTTP_X_FILE_NAME']);

    } else {
        // we create an instance of the class, giving as argument the PHP object
        // corresponding to the file field from the form
        // This is the fallback, using the standard way
        $handle = new Upload($_FILES['my_field']);
    }

    // then we check if the file has been uploaded properly
    // in its *temporary* location in the server (often, it is /tmp)
    if ($handle->uploaded) {

        // yes, the file is on the server
        // now, we start the upload 'process'. That is, to copy the uploaded file
        // from its temporary location to the wanted location
        // It could be something like $handle->process('/home/www/my_uploads/');
        $handle->process($dir_dest);

        // we check if everything went OK
        if ($handle->processed) {
            // everything was fine !
            echo '<p class="result">';
            echo '  <b>File uploaded with success</b><br />';
            echo '  File: <a href="'.$dir_pics.'/' . $handle->file_dst_name . '">' . $handle->file_dst_name . '</a>';
            echo '   (' . round(filesize($handle->file_dst_pathname)/256)/4 . 'KB)';
            echo '</p>';
        } else {
            // one error occured
            echo '<p class="result">';
            echo '  <b>File not uploaded to the wanted location</b><br />';
            echo '  Error: ' . $handle->error . '';
            echo '</p>';
        }

        // we delete the temporary files
        $handle-> clean();

    } else {
        // if we're here, the upload file failed for some reasons
        // i.e. the server didn't receive the file
        echo '<p class="result">';
        echo '  <b>File not uploaded on the server</b><br />';
        echo '  Error: ' . $handle->error . '';
        echo '</p>';
    }

    $log .= $handle->log . '<br />';

} else if ($action == 'multiple') {

    // ---------- MULTIPLE UPLOADS ----------

    // as it is multiple uploads, we will parse the $_FILES array to reorganize it into $files
    $files = array();
    foreach ($_FILES['my_field'] as $k => $l) {
        foreach ($l as $i => $v) {
            if (!array_key_exists($i, $files))
                $files[$i] = array();
            $files[$i][$k] = $v;
        }
    }

    // now we can loop through $files, and feed each element to the class
    foreach ($files as $file) {

        // we instanciate the class for each element of $file
        $handle = new Upload($file);

        // then we check if the file has been uploaded properly
        // in its *temporary* location in the server (often, it is /tmp)
        if ($handle->uploaded) {

            // now, we start the upload 'process'. That is, to copy the uploaded file
            // from its temporary location to the wanted location
            // It could be something like $handle->process('/home/www/my_uploads/');
            $handle->process($dir_dest);

            // we check if everything went OK
            if ($handle->processed) {
                // everything was fine !
                echo '<p class="result">';
                echo '  <b>File uploaded with success</b><br />';
                echo '  File: <a href="'.$dir_pics.'/' . $handle->file_dst_name . '">' . $handle->file_dst_name . '</a>';
                echo '   (' . round(filesize($handle->file_dst_pathname)/256)/4 . 'KB)';
                echo '</p>';
            } else {
                // one error occured
                echo '<p class="result">';
                echo '  <b>File not uploaded to the wanted location</b><br />';
                echo '  Error: ' . $handle->error . '';
                echo '</p>';
            }

        } else {
            // if we're here, the upload file failed for some reasons
            // i.e. the server didn't receive the file
            echo '<p class="result">';
            echo '  <b>File not uploaded on the server</b><br />';
            echo '  Error: ' . $handle->error . '';
            echo '</p>';
        }

        $log .= $handle->log . '<br />';
    }

} else if ($action == 'local' || isset($_GET['file'])) {

    // ---------- LOCAL PROCESSING ----------


    //error_reporting(E_ALL ^ (E_NOTICE | E_USER_NOTICE | E_WARNING | E_USER_WARNING));
    ini_set("max_execution_time",0);

    // we don't upload, we just send a local filename (image)
    $handle = new Upload((isset($_POST['my_field']) ? $_POST['my_field'] : (isset($_GET['file']) ? $_GET['file'] : '')));

    // then we check if the file has been "uploaded" properly
    // in our case, it means if the file is present on the local file system
    if ($handle->uploaded) {

        // now, we start a serie of processes, with different parameters
        // we use a little function TestProcess() to avoid repeting the same code too many times
        function TestProcess(&$handle, $title = 'test', $details='') {
            global $dir_pics, $dir_dest;

            $handle->process($dir_dest);

            if ($handle->processed) {
                echo '<fieldset class="classuploadphp">';
                echo '  <legend>' . $title . '</legend>';
                echo '  <div class="classuploadphppic"><img src="'.$dir_pics.'/' . $handle->file_dst_name . '" />';
                $info = getimagesize($handle->file_dst_pathname);
                echo '  <p>' . $info['mime'] . ' &nbsp;-&nbsp; ' . $info[0] . ' x ' . $info[1] .' &nbsp;-&nbsp; ' . round(filesize($handle->file_dst_pathname)/256)/4 . 'KB</p></div>';
                if ($details) echo '  <pre class="code php">' . htmlentities($details) . '</pre>';
                echo '</fieldset>';
            } else {
                echo '<fieldset class="classuploadphp">';
                echo '  <legend>' . $title . '</legend>';
                echo '  Error: ' . $handle->error . '';
                if ($details) echo '  <pre class="code php">' . htmlentities($details) . '</pre>';
                echo '</fieldset>';
            }
        }
        if (!file_exists($dir_dest)) mkdir($dir_dest);

        // -----------
        TestProcess($handle, 'original file', '');

        // -----------
        $handle->image_resize          = true;
        $handle->image_ratio_y         = true;
        $handle->image_x               = 50;
        TestProcess($handle, 'width 50, height auto', "\$foo->image_resize          = true;\n\$foo->image_ratio_y         = true;\n\$foo->image_x               = 50;");

     

    } else {
        // if we are here, the local file failed for some reasons
        echo '<b>local file error</b><br />';
        echo 'Error: ' . $handle->error . '';
    }

    $log .= $handle->log . '<br />';
}

echo '<center> <p class="white">I’m not affiliated in any way with HapeBeast. Made with love for the community by @Pspace | HAPEBEAST</p> </center>';

if ($log) echo '<pre>' . $log . '</pre>';

?>
<script type="text/javascript" src="download.js"></script>
</body>

</html>