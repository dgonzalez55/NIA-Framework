<?php
    namespace lib\datasources;
    use lib\datasources\interfaces\DataSource;
    use lib\datasources\datamanagers\DataManager;
    
    /** @SuppressWarnings(PHPMD) */
    class DSCookie extends DataManager implements DataSource{
        private array $db = [];

        protected function __construct(){
            $this->open();
         }
 
         protected function __destroy(){
             $this->close();
          }
 
         public function open():void{
            foreach($_COOKIE as $key => $value){
                if(strpos($key,"db_")===0){
                    $this->db[$key] = json_decode($value,true);
                }
            }
         }
 
         public function close():void{
            unset($this->marcatges);
         }
        
        public function find(string $table, array $filter = [], int $pageResults = 100, int $pageNumber = 1):array{
            $cookieName = "db_".$table;
            return $this->db[$cookieName] ?? [];

        }

        //TODO: Implementar aquest mètode
        public function findOne(string $table, array $filter = []):array{
            return [];
        }

        public function insert(string $table, array $data):int{
            $result = 0;
            if(!empty($table) && !empty($data)){
                $cookieName = "db_".$table;
                $cookieValue = json_encode($data);
                setcookie($cookieName,$cookieValue,0,'/',APP_DOMAIN,true,true);
                $result = 1;
            }
            return $result;
        }
        
        //TODO: Implementar aquest mètode
        public function delete(string $table, array $filter = []):int{
            return false;
        }

        //TODO: Implementar aquest mètode
        public function update(string $table, array $data, array $filter = []):int{
            return false;
        }
        
        //TODO: Implementar aquest mètode
        public function query(string $query, array $params):array{
            return [];
        }
    }