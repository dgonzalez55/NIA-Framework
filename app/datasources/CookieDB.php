<?php
    namespace app\datasources;
    use lib\core\datasources\DataManager;
    use lib\core\datasources\DataSource;
    
    /** @SuppressWarnings(PHPMD) */
    class CookieDB extends DataManager implements DataSource{
        private array $marcatges = [];

        protected function __construct(){
            $this->open();
         }
 
         protected function __destroy(){
             $this->close();
          }
 
         public function open():void{
            foreach($_COOKIE as $key => $value){
                if(strpos($key,"marcatges")===0){
                    $this->marcatges[$key] = json_decode($value,true);
                }
            }
         }
 
         public function close():void{
            unset($this->marcatges);
         }
        
        //TODO: Implementar els mètodes de la interfície DataSource
        public function find(string $username, array $filter = [], int $pageResults = 100, int $pageNumber = 1):array{
            $cookieName = "marcatges".hash("sha512",$username);
            return $this->marcatges[$cookieName] ?? [];

        }
        public function findOne(string $table, array $filter = []):array{
            return [];
        }
        public function insert(string $table, array $data):bool{
            return false;
        }
        public function delete(string $table, array $filter = []):bool{
            return false;
        }
        public function update(string $table, array $data, array $filter = []):bool{
            return false;
        }
        public function query(string $query, array $params):array{
            return [];
        }

    }