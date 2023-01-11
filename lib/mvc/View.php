<?php
    namespace lib\mvc;

    class View{
        private $name;
        private $modelView;
        private $type;

        public function __construct($name, $modelView, $type = 'html'){
            $this->name = $name;
            $this->modelView = $modelView;
            $this->type = $type;
        }

        final public function render(){
            switch ($this->type){
                case 'xml':
                    header('Content-type: text/xml; charset=UTF-8');
                    break;
                case 'json':
                    header("Content-Type: application/json; charset=UTF-8");
                    break;
                default:
                    header("Content-Type: text/html; charset=UTF-8");
            }
            require_once APP_BASE_PATH . "app/views/layouts/{$this->type}.php";
        }

        final public function content(){
            ob_start();
            require_once APP_BASE_PATH . "app/views/{$this->name}.php";
            $out = ob_get_contents();
            ob_end_clean();
            return $out;
        }

        public function __get($key){
            return isset($this->modelView) ? (isset($this->modelView[$key]) ? $this->modelView[$key] : "") : "";
        }
    }
