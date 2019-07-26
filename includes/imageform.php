 <?php

 ?>

	
<form enctype="multipart/form-data" class="upload-form" action="<?php echo htmlentities($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8'); ?>" method="post">
    <div class="fieldinput">
        <label for="fileinput">Upload a file:</label>
        <!-- "name" of input (userfile) will be the "key" in $_FILES -->
        <input name="userfile" type="file" value="<?php if (isset($data['file'])) {echo htmlentities($data['file']);}  ?>" id="fileinput" />
        <?php if (isset($data['image_err'])) {echo $data['image_err'];}  ?>     
    </div>
   
    <div class="field">
        <div class="fieldinput">
            <label for="title">Title</label>
            <input type="text" value="<?php if (isset($data['title'])) {echo htmlentities($data['title']);} ?>" name="title" id="title" />
        </div>
           <!--echo error message if firstname error is set  -->
        <?php if (isset($data['title_err'])) {echo '<p> Please enter a title for the image</p>';} ?>
    </div>
    <div class="field">
       <div class="fieldinput">
            <label for="description">Description</label>
            <input type="textarea" value="<?php if (isset($data['description'])) {echo htmlentities($data['description']);} ?>" name="description" id="description" />
       </div>
           <!--echo error message if firstname error is set  -->
        <?php if (isset($data['description_err'])) {echo '<p> Please enter a description for the image</p>';} ?>
</div>

    <div class="fieldinput">
        <input type="submit" value="Upload File" name="singlefileupload" />
</div>
      
 
</form>
<?php
