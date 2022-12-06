<?php 
    namespace app\datasets;
    use lib\core\DataSet;
    use app\datasources\CookieDB;

    /** @SuppressWarnings(PHPMD.StaticAccess) */
    class RegisterEntriesDataSetCookie implements DataSet{
        public function loadData(array $params = []):array{
            $result = [];
            if(isset($params['username'])){                
                $connect    = CookieDB::getInstance();
                $dataset = $connect->query($params['username'],[]);
                if($dataset && count($dataset)>0){
                    $result = $dataset;
                }
            }
            return $result;
        }
    }