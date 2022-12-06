<?php
    namespace app\models\regEntries;

    use \JsonSerializable;

    class RegisterEntry implements JsonSerializable{
        protected int $registerId;
        protected int $registerType;
        protected string $registerTimestamp;

        public function __construct(int $regId, int $type, string $timestamp){
            $this->registerId = $regId;
            $this->registerType = $type;
            $this->registerTimestamp = $timestamp;
        }

        public function __get(string $key){
            return $this->$key;
        }

        public function jsonSerialize(){
            return [
                'id' => $this->registerId,
                'type' => $this->registerType,
                'timestamp' => $this->registerTimestamp,
            ];
        }
    }
