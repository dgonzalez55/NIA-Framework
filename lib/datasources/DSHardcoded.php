<?php
    namespace lib\datasources;
    use lib\datasources\interfaces\DataSource;
    use lib\datasources\datamanagers\DataManager;

    /** @SuppressWarnings(PHPMD) */
    class DSHardcoded extends DataManager implements DataSource{
        private ?array $database = null;
        
        protected function __construct(){
           $this->open();
        }

        protected function __destroy(){
            $this->close();
         }

        public function open():void{
            $this->database = DB_HARDCODED;
        }

        public function close():void{
            $this->database = null;
        }

        public function find(string $table, array $filter = [], int $pageResults = 100, int $pageNumber = 1):array{
            $result = [];
            if($this->database){
                //Security checks
                if(empty($table) || !isset($this->database[$table])){
                    throw new Exception('Table name invalid');
                }
                if($pageResults<1){
                    throw new Exception('Page Results must be greater than 0');
                }
                if($pageNumber<1){
                    throw new Exception('Page Number must be greater than 0');
                }
                $result = $this->database[$table];
                if(count($filter)>0){
                    $result = [];
                    $filtered = [];
                    foreach($filter as $field=>$value){
                        if(isset($this->database[$table][$field])){
                            $filteredIndexes = array_keys($this->database[$table][$field], $value);
                            if(!empty($filteredIndexes)){
                                $filtered[$field] = $filteredIndexes;
                            }
                        }
                    }
                    if(count($filtered)>0){
                        $indexArray = count($filtered)==1 ? $filtered[array_key_first($filtered)] : array_intersect(...array_values($filtered));
                        foreach($indexArray as $index){
                            foreach($this->database[$table] as $field=>$rows){
                                $result[$index][$field] = $rows[$index];
                            }
                        }
                    }
                }
            }
            if(count($result)>$pageResults){
                $result = array_slice($result,($pageNumber-1)*$pageResults,$pageResults);
            }
            return $result;
        }

        public function findOne(string $table, array $filter = []):array{
            $dataset = $this->find($table, $filter, 1);
            return $dataset[array_key_first($dataset)] ?? [];
        }

        //TODO: Implementar aquest mètode
        public function insert(string $table, array $data):int{
            return false;
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