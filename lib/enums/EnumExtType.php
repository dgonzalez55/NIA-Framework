<?php
    namespace lib\enums;
    use \ReflectionClass;

    //Ens muntem una classe pels enumerats (no existeixen en PHP anteriors al 8)
    abstract class EnumExtType{
        //Aquest array servirà per desar els missatges de text relacionats amb l'enumerat
        const ENUM_MSG = [];
        //El constructor privat per evitar instanciar la classe (ús estàtic dels enumerats)
        private function __construct(){}
        //Aquest mètode permet obtenir un array amb les constants de la classe, que seran els nostres valors enumerats
        public static function getConstants():array{
            $oClass = new ReflectionClass(get_called_class());
            return $oClass->getConstants();
        }
        //Per saber si un valor és vàlid, comprovem si existeix el valor dins l'array de constants de la classe
        public static function isValid(int $value):bool{
            return in_array($value, static::getConstants());
        }
        //Obtenim el missatge de text associat a un valor de l'enumerat 
        public static function getCodeMsg(int $value):string{
            return self::isValid($value) && array_key_exists($value, static::ENUM_MSG) ? static::ENUM_MSG[$value] : 'Uknown Value';
        }
    }