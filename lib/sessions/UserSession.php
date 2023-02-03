<?php
    //Class for managing sessions
    namespace lib\sessions;
    
    /** @SuppressWarnings(PHPMD.StaticAccess) */
    class UserSession extends Session{
        public static function setUser(object $obj = null):void{
            self::set('user',$obj);
        }

        public static function getUser():?object{
            return self::get('user');
        }

        public static function isUserLogged():bool{
            return self::getUser() != null;
        }

        public static function open(object $obj = null):void{
            self::setUser($obj);
        }

        public static function close():void{
            self::setUser(null);
            self::destroy();
        }
    }