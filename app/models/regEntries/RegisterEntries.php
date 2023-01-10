<?php
    namespace app\models\regEntries;

    use \ArrayIterator;
    use \lib\core\mvc\Model;

    //Domain Model Class
    /** @SuppressWarnings(PHPMD.StaticAccess) */
    abstract class RegisterEntries extends ArrayIterator implements Model{
        public function __construct(RegisterEntry ...$entry){
            parent::__construct($entry);
        }
        public function add(RegisterEntry $entry):void{
            $this->append($entry);
        }
        public function set(int $index, RegisterEntry $entry):void{
            $this->offsetSet($index, $entry);
        }
        public function all():array{
            return $this->getArrayCopy();
        }        
        public function current():RegisterEntry{
            return parent::current();
        }
        public function offsetGet($index):RegisterEntry{
            return parent::offsetGet($index);
        }

        public function isCheckinRequired():bool{
            return $this->getNextRegisterEntryType() == RegisterType::CHECKIN;
        }

        public function getLast():RegisterEntry{
            return $this->offsetGet($this->count()-1);
        }

        public function getNextRegisterEntryType():int{
            $next = RegisterType::CHECKIN;
            if($this->count()>0 && $this->getLast()->registerType === RegisterType::CHECKIN){
                $next = RegisterType::CHECKOUT;
            }
            return $next;
        }

        private function getNextRegisterEntryId():int{
            return $this->count()==0 ? 1 : $this->getLast()->registerId+1;
        }

        public function addNext(int $idUser):void{
            $idReg  = $this->getNextRegisterEntryId();
            $type   = $this->getNextRegisterEntryType();
            $time   = date('Y-m-d H:i:s');
            $this->add(new RegisterEntry($idReg,$type,$time));
            $this->save($idUser);
        }

        public static function load(int $idUser):?self{
            return DB_DATASET_TYPE==DB_DATASET_MARIADB ? RegisterEntriesMySQL::load($idUser) : RegisterEntriesCookie::load($idUser);
        }

        public abstract function save(int $idUser):void;

        public function lastRecordInfoToHTML(){
            $html = "";
            if($this->count()>0){
                $lastRecord = $this->getLast();
                $time = $lastRecord->registerTimestamp;
                $type = $lastRecord->registerType == RegisterType::CHECKIN ? "Entrada" : "Sortida";
                if($time){
                    $html .= "<p>Últim marcatge realitzat</p>";
                    $html .= "<span class=\"$type\">$time</span>";
                }
            }
            return $html;
        }

        public function toHTML(){
            $table = "";
            if($this->count()>0){
                $table = "<table class=\"fitxatges\"><tbody><tr><th>REGISTRE DE FITXATGE</th></tr>";
                foreach($this as $record){
                    $time = $record->registerTimestamp;
                    $type = $record->registerType == RegisterType::CHECKIN ? "entrada" : "sortida";
                    $table .= "<tr><td class=\"$type\">$time</td></tr>";
                }
                $table .= "</tbody></table>";
            }
            return $table;
        }

        public function getViewData(string $viewName):array{
            switch($viewName){
                case 'mainPage': return [
                    'checkinRequired'   => $this->isCheckinRequired(),
                    'lastRecordInfo'    => $this->lastRecordInfoToHTML(),
                    'recordTable'       => $this->toHTML() 
                ];
                default: return [];
            }
        }
    }