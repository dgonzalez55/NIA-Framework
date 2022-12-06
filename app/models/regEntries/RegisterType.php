<?php
    namespace app\models\regEntries;

    use lib\core\EnumExtType;

    //Definim els nostres enumerats extesos derivant la classe abstracte EnumExtType que ens hem creat
    final class RegisterType extends EnumExtType{
        const CHECKIN = 0;
        const CHECKOUT = 1;

        const ENUM_MSG = [
            self::CHECKIN => "Entrada",
            self::CHECKOUT => "Sortida",
        ];
    }