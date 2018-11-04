<?php 
  include 'inc/header.php';
  include 'inc/db.php';

  if(empty($_SESSION['hotel_id'])){
    header('location:login.php');
  }
?>

<!------ Include the above in your HEAD tag ---------->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">


<style type="text/css">
img {
    height: 80px;
    width: 100px;
    border: 1px solid;
    margin: 10px;
}

div#error_register {
    text-align: center;
}
.row.filed {
    margin-top: 20px;
    margin-bottom: 70px;
}
</style>
<style type="text/css">
/*body {
    padding: 30px 0px;
}*/

#lightbox .modal-content {
    display: inline-block;
    text-align: center;   
}

#lightbox .close {
    opacity: 1;
    color: rgb(255, 255, 255);
    background-color: rgb(25, 25, 25);
    padding: 5px 8px;
    border-radius: 30px;
    border: 2px solid rgb(255, 255, 255);
    position: absolute;
    top: -15px;
    right: -55px;
    
    z-index:1032;
}

img.show_img {
  height: 100%;
  width: 100%;
  border: 1px solid;
  margin: 10px;
}

.row.image_list {
    margin-left: 0px;
    margin-right: 0px;
}

img.show_img {
    height: 75%;
    width: 89%;
    border: 1px solid;
    margin: 10px;
}

.thumbnail {
    height: 100%;
    width: 100%;
    border: 1px solid #e6e6e6;
    margin: 10px;
}


.thumbnail1 {
    height: 100%;
    width: 100%;
    border: 1px solid #e6e6e6;
    margin: 10px;
}


.col-xs-6.col-sm-2.img_view {
    margin-top: 20px;
}

.col-xs-6.col-sm-3.img_view1 {
    margin-top: 20px;
}

/*i.fa.fa-times.close1 {
    float: right;
}*/

.container.preview {
    margin-bottom: 60px;
}.close1{position:absolute; z-index: 999;     cursor: pointer;}
.red{color:#e02a6b; font-weight: 600;}
</style>


<?php include 'inc/menu.php';?>

  <div class="content">
    <div class="container">
      <div id="error_register" class="alert alert-dismissible alert-success" style="<?php if(!empty($succesmsg)){ echo "display:block"; }else {echo "display: none"; }?>">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong><?php echo $succesmsg;?></strong>.
      </div> 
      
      <div class="alert alert-dismissible alert-danger" style="<?php if(!empty($message)){ echo "display:block"; }else {echo "display: none"; }?>">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong><?php echo $message;?></strong>.
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-icon card-header-rose">
              <div class="card-icon">
                  <i class="material-icons">image</i>
              </div>
              <h4 class="card-title"> Create Gallary  <small class="category"></small></h4>
            </div>

            <div class="card-body">
              <form action="upload_file.php" method="post" enctype="multipart/form-data">
                <div class="row filed">
                  <div class="col-md-1"></div>
				  	    <?php 
                $hotel_id = $_SESSION['hotel_id'];
                  $select_image =  "SELECT count(id) as totel FROM hotel_image_details WHERE hotel_id = '$hotel_id' AND images !=''";
                $selected = $conn->query($select_image);

                $row = $selected->fetch_assoc(); 
                    $totel = $row['totel'];
				
                  ?>
                    <div class="col-md-5 col-sm-6">
                      <h4 class="title">Upload Hotel Images</h4>
                        <div id="wrapper">
                          <div class="container">
                              <div class="col-md-6">
							  <?php if($totel<200){?>
                                  <input type="file" id="upload_file" name="upload_file[]" class="btn btn-primary btn-round fileinput-exists sizechankimages" onchange="preview_image();" multiple accept="image/*" />
							  <?php }else{  ?>
								       <input type="button" id="upload_file1" name="upload_file" class="btn btn-primary btn-round fileinput-exists" data-toggle="modal" value="choose files" data-target="#images" />
								  <?php } ?>
								  
                              </div>
							  <div>* Maximum Upload File 200 <br/> * Maximum file size 1Mb </div>
                              <div class="row" id="image_preview"></div>
                          </div>
                      </div>
                    </div>

                   <!--  <div class="col-md-1"></div> -->
			
				   
                    <div class="col-md-5 col-sm-6">
                      <h4 class="title">Upload Hotel Videos</h4>
                        <div id="wrapper1">
                          <div class="container">
						   <?php 
                $hotel_id = $_SESSION['hotel_id'];
                  $select_image =  "SELECT count(id) as totel FROM hotel_image_details WHERE hotel_id = '$hotel_id' AND videos !=''";
                $selected = $conn->query($select_image);

                $row = $selected->fetch_assoc(); 
                    $totel = $row['totel'];
				
                  ?>
                              <div class="col-md-6">
							  <?php if($totel<10){ ?>
                                  <input type="file" id="upload_file" class="btn btn-primary btn-round fileinput-exists sizechank" name="upload_file[]" multiple accept="video/*"  />
							  <?php }else{ ?>
							   <input type="button" id="upload_file1" name="upload_file" class="btn btn-primary btn-round fileinput-exists" data-toggle="modal" value="choose files" data-target="#video" />
							  <?php } ?>
                              </div>
							  <div class="max_video">* Maximum Upload video File 10 <br/> * Maximum file size 10Mb <b>File Size </b> <span class="lblSize"></span></div>
                              <div id="image_preview1"></div>
                          </div>
                        </div>
                    </div>
                </div>
                  <button type="submit" class="btn btn-rose" name="uplode_media" value="submit">UPLOAD</button>
                  <div class="clearfix"></div>
              </form>
            </div>
             <hr>

            <!--===== UPLOADED IMAGE-WRAPPER ====-->
            <div class="container preview">
              <h3>Uploaded Image </h3>  
              <div class="row image_list">

              <?php 
                $hotel_id = $_SESSION['hotel_id'];
                $select_image =  "SELECT  * FROM hotel_image_details WHERE hotel_id = '$hotel_id'";
                $selected = $conn->query($select_image);

                while($row = $selected->fetch_assoc()){ 
                  $id = $row['id'];

                  if($row['images'] !=""){?>

                    <div class="col-xs-6 col-sm-2 img_view images<?php echo $id;  ?>">
                      <div href="#" class="thumbnail"> 
                      <i class="fa fa-times close"  data-id="<?php echo $row['id'];?>"></i>
                         <img class="show_img" src="images/<?php echo $row['images'];?>" /> 
                      </div>
                  </div>

                 <?php } } ?>

              </div>
            </div>
            <!-- end innerpage-wrapper -->
    
            <!--===== UPLOADED VIDEO-WRAPPER ====-->
            <hr>
            <div class="container preview">
              <h3>Uploaded Video </h3>
              <div class="row image_list">

              <?php 
                $hotel_id = $_SESSION['hotel_id'];
                $select_videos =  "SELECT * FROM hotel_image_details WHERE hotel_id = '$hotel_id'";
                $selected_videos = $conn->query($select_videos);

                while($row = $selected_videos->fetch_assoc()){ 
                  if($row['videos'] !=""){   ?>

                    <div class="col-xs-6 col-sm-3 img_view1 videoid<?php echo $row['id'] ?>">
                        <div href="#" class="thumbnail1 "> 
                         <i class="fa fa-times close1" data-id='<?php echo $row['id'];?>'></i>
                          <video width="220" height="220" controls>
                            <source src="videos/<?php echo $row['videos'];?>" type="video/mp4">
                            Sorry, your browser doesn't support the video element.
                          </video>
                        </div>
                    </div>
               <?php } } ?>

              </div>
            </div>
            <!-- end innerpage-wrapper -->
          </div>
        </div>
      </div>
    </div>
  </div>
<!---images model--->
<div class="modal fade" id="images" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Images Upload</h4>
        </div>
        <div class="modal-body">
          <p>Maximum Upload File 200</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<!---end model-->
<!---images model--->
<div class="modal fade" id="video" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Video Upload</h4>
        </div>
        <div class="modal-body">
          <p>Maximum Upload video file 20 </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<!---end model-->
<?php include 'inc/footer.php';?>
<script>
 $("document").ready(function(){

    $(".sizechank").change(function(e) {
         
		  var iSize = this.files[0].size / 1024;
		  if(iSize>10250){
			   $('#image_preview1').html("<span class='red'>* Maximum file size this file not upload</span>");
			     alert("Maximum file size");
			      $(".sizechank").val('');
		          }
		  
		  
		  if (((iSize / 1024) / 1024) > 1) 
        { 
            iSize = (Math.round(((iSize / 1024) / 1024) * 100) / 100);
            $(".lblSize").html( iSize + "Gb"); 
        }
        else
        { 
            iSize = (Math.round((iSize / 1024) * 100) / 100)
            $(".lblSize").html( iSize + "Mb"); 
        } 
      
         
    });
});
</script>
<script>
  $(document).ready(function() {
      $('form').ajaxForm(function() {
		  var lenth= $('.sizechank').val();
		  var lenth1= $('.sizechankimages').val();
		      if(lenth1.length>0){
				  var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
                      if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                      alert("Only formats are allowed : "+fileExtension.join(', '));
                           }
				 alert("Your Details Updated Succesfully...!");
				 window.location.reload(true);
				 
				 
			 }else if(lenth.length>0){
				 
				 alert("Your Details Updated Succesfully...!");
				  window.location.reload(true);
				 
			 }else{
				 
				 alert("Please Choose a file to Upload");
			 }
         // 
		  
          //
      });
  });

  function preview_image() {
      var total_file = document.getElementById("upload_file").files.length;
      for (var i = 0; i < total_file; i++) {
          $('#image_preview').append("<div class='col-md-3 img'><img src='" + URL.createObjectURL(event.target.files[i]) + "'></div>");
      }
  }
</script>

<script>


  $('.close').on('click', function() {
    var image_id = $(this).data("id");
    var ref   = "image_box";
	
	 var r = confirm("Are you sure you wants to delete this image  ");
	 if(r == true){
    $.ajax({
      url       :"inc/common.php",
      type      :"POST",
      dataType  :"JSON",
      data :{
          ref      : ref,
          image_id :  image_id
        }
      }).done(function(res){
        if(res.success){
          $(".images"+image_id).hide();
          //window.location.reload(true);
        }
      });
	 }
  });



 $('.close1').on('click', function() {
    var video_id = $(this).data("id");
    var ref      = "video_box";
	var r = confirm("Are you sure you wants to delete this video  ");
	 if(r == true){
    $.ajax({
      url       :"inc/common.php",
      type      :"POST",
      dataType  :"JSON",
      data :{
          ref      : ref,
          video_id :  video_id
        }
      }).done(function(res){
        if(res.success){
          $(".videoid"+video_id).hide();
           //window.location.reload(true);
        }
      });
	 }
  });


</script>


