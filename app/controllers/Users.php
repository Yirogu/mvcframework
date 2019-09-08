<?php
class Users extends Controller {
    public function __construct()
    {
    $this->userModel = $this->model('User');

    }
    public function register(){
        //Check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Process form
            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

            $data = [
                'name'=>trim($_POST['name']),
                'email'=> trim($_POST['email']),
                'password'=> trim($_POST['password']),
                'confirm_password'=> trim($_POST['confirm_password']),
                'name_err'=> '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            //Validate Email
            if (empty($data['email'])){
                    $data['email_err'] = 'Please enter email';
            }else{
                // Check email
                if ($this->userModel->findUserByEmail($data['email'])){
                    $data['email_err'] = 'email is alleready taken';
                }
            }
            //Validate Name
            if (empty($data['name'])){
                $data['name_err'] = 'Please enter name';
            }
            //Validate password
            if (empty($data['password'])){
                $data['password_err'] = 'Please enter password';
            }elseif (strlen($data['password']) < 6){
                $data['password_err'] = 'password must be at least 6 charcters';
            }
            //Validate confirm password
            if (empty($data['confirm_password'])){
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']){
                    $data['confirm_password_err'] = 'Password do not match';
                }
            }
            //Make sure are empty
            if (empty($data['email_err'])&& empty($data['name_err'])&&empty($data['confirm_password_err'])&& empty($data['password_err'])){
                // Validated
              // Hash pasword
                $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT) ;

                // Register user
                if ($this->userModel->register($data)){
                    flash('register_success','You are registerd and can log in');
                    redirect('users/login');



                }else{
                    die("Something well wrong");
                }
            }
            else{
                //Load view with errors
                $this->view('users/register',$data);
            }
        }

        //Load form
        else {
            //Init data
    $data = [
        'name'=>'',
        'email'=> '',
        'password'=> '',
        'confirm_password'=> '',
        'name_err'=> '',
        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => ''
    ];
   // load view
            $this->view('users/register',$data);
        }
    }
    public function login(){
        //Check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Process form
            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

            $data = [
                'email'=> trim($_POST['email']),
                'password'=> trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];
//Validate Email
            if (empty($data['password'])){
                $data['password_err'] = 'Please enter password';
            }
            //Validate Email
            if (empty($data['email'])){
                $data['email_err'] = 'Please enter email';
            }
            //Make sure errors are empty
            if (empty($data['email_err'])&& empty($data['password_err'])){
                // Validated
                die('Success');
            }
            else{
                //load view with errors
                $this->view('users/login',$data);
            }

        }
        //Load form
        else {
            //Init data
            $data = [
                'email'=> '',
                'password'=> '',
                'email_err' => '',
                'password_err' => ''
            ];
            // load view
            $this->view('users/login',$data);
        }
    }
}
