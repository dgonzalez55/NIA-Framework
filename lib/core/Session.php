<?php
    //Class for managing sessions
    namespace lib\core;
    
    /** @SuppressWarnings(PHPMD.StaticAccess) */
    class Session{
        public static function isStarted():bool{
            if(isset($_COOKIE[APP_SESSION_NAME])){
                Session::start();
                if(!empty($_SESSION)){
                    return true;
                }
                //Tenim cookie però no hi ha sessió
                Session::destroy();
            }
            return false;
        }

        public static function start():void{
            if(session_status() == PHP_SESSION_NONE){
                session_name(APP_SESSION_NAME);
                session_start();
            }
        }
  
        public static function set(string $key, $value){
            $_SESSION[$key] = $value;
        }
    
        public static function get(string $key){
            return Session::isStarted() ? (isset($_SESSION[$key]) ? $_SESSION[$key] : null) : null;
        }

        public static function destroy():void{
            Session::start();
            unset($_SESSION);
            setcookie(session_name(),"",time()-3600);
            session_destroy();
        }
    }