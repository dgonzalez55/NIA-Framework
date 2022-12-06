<?php
    namespace app\datasources;
    use \PDO;
    use lib\core\datasources\DataSource;
    use lib\core\datasources\DataBaseManager;

    class MySQLDB extends DataBaseManager implements DataSource{
        private $dbConnection;

        //La classe base DataSource ja implementa el patró de disseny Singleton i cridarà a aquest constructor (no pot ser privat)
        protected function __construct(){
            $this->open();
        }

        protected function __destroy(){
            $this->close();
        }

        public function open():void{
            try{
                $this->dbConnection = new PDO(DB_DSN, DB_USER, DB_PASS, [PDO::ATTR_PERSISTENT => true]);
            }catch(\PDOException $e){
                echo 'Error: '.$e->getMessage();
            }
        }

        public function close():void{
            $this->dbConnection = null;
        }

        public function find(string $table, array $filter = [], int $pageResults = 100, int $pageNumber = 1):array{
            $result = [];
            try{
                if($this->dbConnection){
                    //Security checks
                    if(empty($table)) {
                        throw new Exception('Table name cannot be empty');
                    }
                    if(!$this->dbConnection->query("SELECT 1 FROM $table")) {
                        throw new Exception('Table name invalid');
                    }
                    if($pageResults<1){
                        throw new Exception('Page Results must be greater than 0');
                    }
                    if($pageNumber<1){
                        throw new Exception('Page Number must be greater than 0');
                    }
                    //Calculate offset
                    $offset = ($pageNumber-1)*$pageResults;
                    $where = '';
                    foreach(array_keys($filter) as $key){
                        $where .= empty($where) ? "WHERE " : " AND ";
                        $where .= "$key = :$key";
                    }
                    $sql = "SELECT * FROM $table $where LIMIT $pageResults OFFSET $offset";
                    $stmt = $this->dbConnection->prepare($sql);
                    $stmt->execute($filter);
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            }catch(\PDOException $e){
                echo 'Error: '.$e->getMessage();
            }
            return $result;
        }

        public function findOne(string $table, array $filter = []):array{
            $dataset = $this->find($table, $filter, 1);
            return $dataset[0] ?? [];
        }

        public function insert(string $table, array $data):bool{
            $result = false;
            try{
                if($this->dbConnection){
                    //Security checks
                    if(empty($table)) {
                        throw new Exception('Table name cannot be empty');
                    }
                    if(!$this->dbConnection->query("SELECT 1 FROM $table")) {
                        throw new Exception('Table name invalid');
                    }
                    $fields = implode(',', array_keys($data));
                    $values = implode(',', array_map(function($key){return ":$key";}, array_keys($data)));
                    $sql = "INSERT INTO $table($fields) VALUES ($values)";
                    $stmt = $this->dbConnection->prepare($sql);
                    $result = $stmt->execute($data);
                }
            }catch(\PDOException $e){
                echo 'Error: '.$e->getMessage();
            }
            return $result;
        }

        public function update(string $table, array $data, array $filter = []):bool{
            $result = false;
            try{
                if($this->dbConnection){
                    //Security checks
                    if(empty($table)) {
                        throw new Exception('Table name cannot be empty');
                    }
                    if(!$this->dbConnection->query("SELECT 1 FROM $table")) {
                        throw new Exception('Table name invalid');
                    }
                    $set = '';
                    foreach(array_keys($data) as $key){
                        $set .= empty($set) ? "SET " : ", ";
                        $set .= "$key = :$key";
                    }
                    $where = '';
                    foreach(array_keys($filter) as $key){
                        $where .= empty($where) ? "WHERE " : " AND ";
                        $where .= "$key = :$key";
                    }
                    $sql = "UPDATE $table $set $where";
                    $stmt = $this->dbConnection->prepare($sql);
                    $result = $stmt->execute(array_merge($data, $filter));
                }
            }catch(\PDOException $e){
                echo 'Error: '.$e->getMessage();
            }
            return $result;
        }

        public function delete(string $table, array $filter = []):bool{
            $result = false;
            try{
                if($this->dbConnection){
                    //Security checks
                    if(empty($table)) {
                        throw new Exception('Table name cannot be empty');
                    }
                    if(!$this->dbConnection->query("SELECT 1 FROM $table")) {
                        throw new Exception('Table name invalid');
                    }
                    $where = '';
                    foreach(array_keys($filter) as $key){
                        $where .= empty($where) ? "WHERE " : " AND ";
                        $where .= "$key = :$key";
                    }
                    $sql = "DELETE FROM $table $where";
                    $stmt = $this->dbConnection->prepare($sql);
                    $result = $stmt->execute($filter);
                }
            }catch(\PDOException $e){
                echo 'Error: '.$e->getMessage();
            }
            return $result;
        }
        
        public function query(string $sql, array $params):array{
            $result = [];
            try{
                if($this->dbConnection){
                    $stmt = $this->dbConnection->prepare($sql);
                    $stmt->execute($params);
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            }catch(\PDOException $e){
                echo 'Error: '.$e->getMessage();
            }
            return $result;
        }
    }