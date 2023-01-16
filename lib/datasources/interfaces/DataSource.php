<?php
    namespace lib\datasources\interfaces;

    interface DataSource{
        public function open():void;
        public function close():void;
        public function find(string $table, array $filter = [], int $pageResults = 100, int $pageNumber = 1):array;
        public function findOne(string $table, array $filter = []):array;
        public function insert(string $table, array $data):int;
        public function delete(string $table, array $filter = []):int;
        public function update(string $table, array $data, array $filter = []):int;
        public function query(string $query, array $params):array;
    }