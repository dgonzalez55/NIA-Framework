<?php
    namespace lib\datasources;
    use lib\datasources\interfaces\DataSource;
    use lib\datasources\datamanagers\DataBaseManager;
    use \PDO;

    class DSMySQL extends DataBaseManager implements DataSource{
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
                    $conjunction = "AND";
                    if (isset($filter['__conjunction'])) {
                        $conjunction = $filter['__conjunction'];
                        unset($filter['__conjunction']);
                    }
                    foreach($filter as $key => $value){
                        $condition = "`$key` = :$key";
                        if(is_array($value)){
                            $condition = "`$key` ".key($value)." :$key";
                            $filter[$key] = current($value);
                        } 
                        $where .= empty($where) ? "WHERE " : " $conjunction ";
                        $where .=  $condition;
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

        public function insert(string $table, array $data):int{
            $result = 0;
            try{
                if($this->dbConnection){
                    //Security checks
                    if(empty($table)) {
                        throw new Exception('Table name cannot be empty');
                    }
                    if(!$this->dbConnection->query("SELECT 1 FROM $table")) {
                        throw new Exception('Table name invalid');
                    }
                    $fields = '`'.implode('`,`', array_keys($data)).'`';
                    $values = implode(',', array_map(function($key){return ":$key";}, array_keys($data)));
                    $sql = "INSERT INTO $table($fields) VALUES ($values)";
                    $stmt = $this->dbConnection->prepare($sql);
                    $stmt->execute($data);
                    $result = $this->dbConnection->lastInsertId();
                }
            }catch(\PDOException $e){
                echo 'Error: '.$e->getMessage();
            }
            return $result;
        }

        public function update(string $table, array $data, array $filter = []):int{
            $result = 0;
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
                        $set .= "`$key` = :$key";
                    }
                    $where = '';
                    foreach(array_keys($filter) as $key){
                        $where .= empty($where) ? "WHERE " : " AND ";
                        $where .= "`$key` = :$key";
                    }
                    $sql = "UPDATE $table $set $where";
                    $stmt = $this->dbConnection->prepare($sql);
                    $stmt->execute(array_merge($data, $filter));
                    $result = $stmt->rowCount();
                }
            }catch(\PDOException $e){
                echo 'Error: '.$e->getMessage();
            }
            return $result;
        }

        public function delete(string $table, array $filter = []):int{
            $result = 0;
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
                        $where .= "`$key` = :$key";
                    }
                    $sql = "DELETE FROM $table $where";
                    $stmt = $this->dbConnection->prepare($sql);
                    $stmt->execute($filter);
                    $result = $stmt->rowCount();
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

        //Aquest mètode no pertany a la interfície DataSource, però s'hi podria afegir si convingués
        public function lastInsertId():int{
            $result = -1;
            try{
                if($this->dbConnection){
                    $result = $this->dbConnection->lastInsertId();
                }
            }catch(\PDOException $e){
                echo 'Error: '.$e->getMessage();
            }
            return $result;
        }
        
        //Aquest mètode no pertany a la interfície DataSource, però s'hi podria afegir si convingués
        public function rowCount(string $table, array $filter = []):int{
            $result = -1;
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
                    $conjunction = "AND";
                    if (isset($filter['__conjunction'])) {
                        $conjunction = $filter['__conjunction'];
                        unset($filter['__conjunction']);
                    }
                    foreach($filter as $key => $value){
                        $condition = "`$key` = :$key";
                        if(is_array($value)){
                            $condition = "`$key` ".key($value)." :$key";
                            $filter[$key] = current($value);
                        } 
                        $where .= empty($where) ? "WHERE " : " $conjunction ";
                        $where .=  $condition;
                    }
                    $sql = "SELECT COUNT(*) FROM $table $where";
                    $stmt = $this->dbConnection->prepare($sql);
                    $stmt->execute($filter);
                    $result = $stmt->fetchColumn();
                }
            }catch(\PDOException $e){
                echo 'Error: '.$e->getMessage();
            }
            return $result;
        }
    }