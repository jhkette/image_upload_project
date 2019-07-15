FMA plans

- tidy up index page - check GET value - the if else needs to be clearer DONE ?
- tidy up main imagage functions in controller and possibly in model
- tidy up index page functions in controller and possibly in model
- further checking of form validation, and form submission in controller (poss also model)
-  trim data - do this -> 
    $data =[
          'name' => trim($_POST['name']),
          'email' => trim($_POST['email']),
          'password' => trim($_POST['password']),
          'confirm_password' => trim($_POST['confirm_password']),
          'name_err' => '',
          'email_err' => '',
          'password_err' => '',
          'confirm_password_err' => ''
        ]; DONE
- put all images in one folder -> then subfolders DONE
- add congig to DB DONE
- people can't add same filename




big things
- Json web serivce DONE
- try catch throughout DONE...(double check)
- Add some css - look at flickr?  
- add language variables









