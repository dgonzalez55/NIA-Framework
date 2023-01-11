<?php
    namespace lib\datasources\datamanagers;

    abstract class DataManager{

        public static function getInstance():self{
            $class = get_called_class();
            return new $class();
        }
    }