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
</form>
<?php
