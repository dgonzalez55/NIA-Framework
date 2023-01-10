<?php
    namespace app\models\regEntries;

    use lib\core\EnumExtType;

    //Definim els nostres enumerats extesos derivant la classe abstracte EnumExtType que ens hem creat
    final class RegisterType extends EnumExtType{
        const NONE = 0;
        const CHECKIN = 1;
        const CHECKOUT = 2;

        const ENUM_MSG = [
            self::NONE => "Cap",
            self::CHECKIN => "Entrada",
            self::CHECKOUT => "Sortida",
        ];
    }