<?php
    namespace app\models;

    use lib\mvc\Model;
    use app\models\regEntries\RegisterEntries;

    //Domain Model Class
    /** @SuppressWarnings(PHPMD.StaticAccess) */
    final class HelloWorldModel implements Model{
        protected string $msg;

        public function __construct(string $username){
            $this->msg = "Hello " . (empty($username) ? "World" : $username) . "!";
        }

        public function __get(string $key){
            return $this->$key;
        }
        
        //Controlem els atributs que es passen a la vista (passem només els necessaris en cada cas)
        public function getViewData(string $viewName):array{
            switch($viewName){
                case 'helloWorld':
                    return ['message' => $this->msg];
                default:
                    return [];
            }
        }
    }