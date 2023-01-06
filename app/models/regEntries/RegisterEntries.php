<?php
    namespace app\models\regEntries;

    use \ArrayIterator;
    use \lib\core\mvc\Model;
    use \app\datasets\RegisterEntriesDataSetCookie;

    class RegisterEntries extends ArrayIterator implements Model{
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

        public function addNext():void{
            $idReg  = $this->getNextRegisterEntryId();
            $type   = $this->getNextRegisterEntryType();
            $time   = date('Y-m-d H:i:s');
            $this->add(new RegisterEntry($idReg,$type,$time));
        }

        public function save(string $cookieNameSuffix):void{
            $cookieName = "marcatges" . hash("sha512",$cookieNameSuffix);
            $cookieValue = json_encode($this->all());
            setcookie($cookieName,$cookieValue,0,'/',APP_DOMAIN,true,true);
        }

        public function load(string $cookieNameSuffix):void{
            $cookieName = "marcatges" . hash("sha512",$cookieNameSuffix);
            $regEntries = isset($_COOKIE[$cookieName]) ? json_decode($_COOKIE[$cookieName]) : [];
            foreach($regEntries as $regEntry){
                $regId      = isset($regEntry->id) ? $regEntry->id : null;
                $regType    = isset($regEntry->type) ? $regEntry->type : null;
                $timestamp  = isset($regEntry->timestamp) ? $regEntry->timestamp : null;
                if(!is_null($regId) && !is_null($regType) && !is_null($timestamp)){
                    $regEntry = new RegisterEntry($regId,$regType,$timestamp);
                    $this->add($regEntry);
                }
            }
        }

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