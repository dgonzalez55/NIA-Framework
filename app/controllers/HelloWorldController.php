<?php  
    namespace app\controllers;

    use lib\mvc\Controller;
    use app\models\HelloWorldModel;

    /** @SuppressWarnings(PHPMD.StaticAccess) */
    class HelloWorldController extends Controller{

        private ?HelloWorldModel $hello;

        final public function __construct(){
            $this->hello = &$this->model;
        }

        public function sayHello($params){
            $fname = isset($params['firstname']) ? filter_var(urldecode($params['firstname']),FILTER_SANITIZE_STRING) : "";
            $lname = isset($params['lastname']) ? filter_var(urldecode($params['lastname']),FILTER_SANITIZE_STRING) : "";
            $this->hello = new HelloWorldModel(trim("$fname $lname"));
            $this->render('helloWorld');
        }
    }
