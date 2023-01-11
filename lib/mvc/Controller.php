<?php
    namespace lib\mvc;

    abstract class Controller{
        protected ?Model $model;

        public function __construct(){
            $this->model = null;
        }

        public function render(string $name,array $viewExtraParams = [],string $type = 'html'){
            //Obtenim dades del model
            $modelData = isset($this->model) ? $this->model->getViewData($name) : [];
            //Fusionem dades del model amb dades extra injectades pel controlador
            $modelData += $viewExtraParams;
            //Carreguem la vista
            $view = new View($name, $modelData, $type);
            $view->render();
            //Alliberem memòria una vegada carregada la vista
            unset($view);
        }
    }