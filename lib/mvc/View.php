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

        final public function render(int $statusCode = 200):string{
            $headersSent = true;
            switch ($this->type){
                case 'xml':
                    header("HTTP/1.1 $statusCode");
                    header('Content-type: text/xml; charset=UTF-8');
                    break;
                case 'json':
                    header("HTTP/1.1 $statusCode");
                    header("Content-Type: application/json; charset=UTF-8");
                    break;
                case 'html':
                    header("HTTP/1.1 $statusCode");
                    header("Content-Type: text/html; charset=UTF-8");
                    break;
                default : $headersSent = false;
            }
            $content = $this->content("app/views/layouts/","{$this->type}");
            if($headersSent) echo $content;
            
            return $content;
        }

        final public function content(string $viewBasePath = "app/views/", string $viewFileName = "", string $ext = ".php"):string{
            ob_start();
            $viewFilePath  = APP_BASE_PATH . $viewBasePath . "/";
            $viewFilePath .= $viewFileName == "" ? "{$this->name}$ext" : $viewFileName.$ext;
            require_once $viewFilePath;
            $out = ob_get_contents();
            ob_end_clean();
            return $out;
        }

        public function __get($key){
            return isset($this->modelView) ? (isset($this->modelView[$key]) ? $this->modelView[$key] : "") : "";
        }

        public function __isset($key){
            return isset($this->modelView) ? isset($this->modelView[$key]) : false;
        }
    }
