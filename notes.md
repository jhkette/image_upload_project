FMA plans

- tidy up index page - check GET value - the if else needs to be clearer
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
        ];
- put all images in one folder -> then subfolders




big things
- Json web serivce
- try catch throughout
- Add some css - look at flickr?  









