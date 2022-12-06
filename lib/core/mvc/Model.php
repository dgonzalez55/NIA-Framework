<?php
    namespace lib\core\mvc;

    interface Model{
        public function getViewData(string $viewName):array;
    }