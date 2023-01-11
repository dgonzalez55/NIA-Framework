<?php
    namespace lib\mvc;

    interface Model{
        public function getViewData(string $viewName):array;
    }