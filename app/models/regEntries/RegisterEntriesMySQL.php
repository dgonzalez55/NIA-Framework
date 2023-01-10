<?php 
    namespace app\models\regEntries;
    use app\datasources\MySQLDB;

    // ? No podem tenir una propietat de tipus MySQL ja que utilitza la llibreria PDO que no és serialitzable
    // ? Ens interessa serialitzar la classe per poder-la guardar a la sessió (el dataset és una propietat del model)
    // ? MySQL implementa el patró de disseny Singleton i per tant no podem tenir més d'una instància de la classe
    // * Aquesta classe juga un paper de tipus ORM (Object Relational Mapping), mappeja les dades de la base de dades a objectes

    /** @SuppressWarnings(PHPMD.StaticAccess) */
    class RegisterEntriesMySQL extends RegisterEntries{
        public static function load(int $idUser):?self{
            $result = null;
            if($idUser>0){                
                $mysql = MySQLDB::getInstance();
                $dataset  = $mysql->find('marcatges', ['idUser'=>$idUser]);
                $result = new self();
                foreach($dataset as $regEntry){
                    $regId      = isset($regEntry['idMarcatge']) ? $regEntry['idMarcatge']: null;
                    $timestamp  = isset($regEntry['timestamp']) ? $regEntry['timestamp'] : null;
                    $regType    = $regEntry['tipus']=="Entrada" ? RegisterType::CHECKIN : ($regEntry['tipus'] == "Sortida" ? RegisterType::CHECKOUT : RegisterType::NONE);
                    if(!is_null($regId) && !is_null($timestamp)){
                        $regEntry = new RegisterEntry($regId,$regType,$timestamp);
                        $result->add($regEntry);
                    }
                }
                $result;
            }
            return $result;
        }

        public function save(int $idUser):void{
            $lastEntry = $this->getLast();
            $mysql = MySQLDB::getInstance();
            $data = [   'tipus' => $lastEntry->registerType,
                        'timestamp' => $lastEntry->registerTimestamp,
                        'idUser' => $idUser];
            $mysql->insert('marcatges',$data);
            $lastEntry->setId($mysql->lastInsertedId());
        }
    }