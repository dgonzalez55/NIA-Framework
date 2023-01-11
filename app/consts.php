<?php
    //Definim tipus de datasets que tenim
    define('DB_DATASET_MARIADB','MariaDB');
    define('DB_DATASET_HARDCODED','Hardcoded');
    define('DB_HARDCODED',[
        'users'=>[
            'id'  =>['1',
                     '2',
                     '3'],
            'user'=>['anonim@educem.com',
                    'trump@educem.com',
                    'biden@educem.com'],
            'pass'=>['$2y$10$lIs8q5weNERTcLvnf2liDe/kv30eKZNXcEV26g21E5NlxGPrZZ6pG',
                    '$2y$10$g4im92dXDQLNexxfmHs0UO2Yn5/Y5/oyG9UTHz/pLF39ds5pq4HSS',
                    '$2y$10$WRSC9uVoMKwgWYVOp6v/muOp8/tWyIxAXWk/qZgihbU6iGhRr1TiO'],
            'rol' =>['Usuari sense privilegis',
                    'Supervisor',
                    'Administrador']
                ]
    ]);