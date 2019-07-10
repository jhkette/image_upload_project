 <?php
 ?>
<h1>Upload a file:</h1>	
<form enctype="multipart/form-data" action="<?php echo htmlentities($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8'); ?>" method="post">
    <div>
        <label for="fileinput">Upload a file:</label>
        <!-- "name" of input (userfile) will be the "key" in $_FILES -->
        <input name="userfile" type="file" id="fileinput" />
    </div>
    <div>
        <input type="submit" value="Upload File" name="singlefileupload" />
    </div>
    <div class="field">
        <div class="adduserforminput">
            <label for="title">Title</label>
            <input type="text" value="<?php if (isset($cleanData['title'])) {echo htmlentities($cleanData['title']);} ?>" name="title" id="title" />
       </div>
           <!--echo error message if firstname error is set  -->
        <?php if (isset($errors['title'])) {echo '<p> Please enter your first name </p>';} ?>
     </div>
    <div class="field">
        <div class="adduserforminput">
            <label for="description">description</label>
            <input type="textarea" value="<?php if (isset($cleanData['description'])) {echo htmlentities($cleanData['description']);} ?>" name="description" id="description" />
       </div>
           <!--echo error message if firstname error is set  -->
        <?php if (isset($errors['description'])) {echo '<p> Please enter your first name </p>';} ?>
     </div>
</form>
<?php