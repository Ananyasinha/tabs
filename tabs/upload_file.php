<?php 
  include 'inc/db.php';
  if(empty($_SESSION['hotel_id'])){
    header('location:login.php');
  }

    function make_rand($one, $two, $three) {
      $id = substr(uniqid(md5((hash('md5', hash('md5', $one) . $two) . $three))), 0, 10);
      return $id;
  }

 // $user_id  = "123";

  $hotel_id  = $_SESSION['hotel_id']; 
  $name      = $_SESSION['hotel_name'];
  $datetime   = date("Y-m-d H:i:s");
  
  if(isset($_POST['uplode_media'])) {
	   function compress_image($source_url, $destination_url, $quality) {

      $info = getimagesize($source_url);

          if ($info['mime'] == 'image/jpeg')
          $image = imagecreatefromjpeg($source_url);

          elseif ($info['mime'] == 'image/gif')
          $image = imagecreatefromgif($source_url);

          elseif ($info['mime'] == 'image/png')
          $image = imagecreatefrompng($source_url);

          imagejpeg($image, $destination_url, $quality);
          return $destination_url;
        }

    for($i = 0; $i < count($_FILES["upload_file"]["name"]); $i++){
      $uploadfile   = $_FILES["upload_file"]["tmp_name"][$i];
      $extension    = explode(".",$_FILES["upload_file"]["name"][$i])[1];

      if(strtoupper($extension) == "JPG" || strtoupper($extension) == "PNG" || strtoupper($extension) == "JPEG" || strtoupper($extension) == "GIF"){
          $folder    = "images/";
      }else if(strtoupper($extension) == "MP4" || strtoupper($extension) == "3GP"){
         $folder    = "videos/";
      }
     
      $rand_number   = make_rand($hotel_id,$datetime,rand(1000000,9999999));
      $new_name      = $hotel_id."_".$rand_number;
      $hotel_image   = "";
      $hotel_video   = "";
      if(strtoupper($extension) == "JPG" || strtoupper($extension) == "PNG" || strtoupper($extension) == "JPEG" || strtoupper($extension) == "GIF"){
          //$images    = $new_name;
          $hotel_image   = $new_name.'.'.$extension;
      }else{
         // $videos    = $new_name;
          $hotel_video   = $new_name.'.'.$extension;
      }
	  if(strtoupper($extension) == "JPG" || strtoupper($extension) == "PNG" || strtoupper($extension) == "JPEG" || strtoupper($extension) == "GIF"){
          $filename = compress_image($_FILES["upload_file"]["tmp_name"][$i], "$folder".$new_name.".".$extension, 60);
		  
      }else if(strtoupper($extension) == "MP4" || strtoupper($extension) == "3GP"){
         move_uploaded_file($_FILES["upload_file"]["tmp_name"][$i], "$folder".$new_name.".".$extension);
      }
      
      $image_status = 0;
	  
      $insert1   = "INSERT INTO hotel_image_details (hotel_id,images,videos,image_status,created_on) VALUES ('$hotel_id','$hotel_image','$hotel_video','$image_status','$datetime')";
      $inserted1 = $conn->query($insert1);
    }
  
     //exit();
      if($inserted1){
         //header("location:update_profile.php");
          $succesmsg = "Your Details Updated Succesfully...!";
        }else{
        $message = 'opps somthing went wrong...!';
      }
  }

?>

