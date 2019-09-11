<?php
class Pages extends Controller{
    public function __construct()
    {


    }
    public function index(){
        if (isLoggedIn()){
            redirect('posts');
        }
        $data = ['title' => 'Welcome',
        'description' => 'simple social betwor build on MVC'];
        $this->view('pages/index',$data);

    }

    public function about() {
        $data = ['title' => 'About us',
            'description' => 'app to share post with other users'];
        $this->view('pages/about',$data);
    }

}