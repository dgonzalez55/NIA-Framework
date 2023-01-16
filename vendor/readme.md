//PER DESCARREGAR DEPENDÈNCIES EXACTES
php composer.phar install
//PER DESCARREGAR ÚLTIMA VERSIÓ
php composer.phar update

/* TODO: ADAPTAR NIA FRAMEWORK PER UTILITZAR COMPOSER AUTOLOAD
IMPLICA CANVIAR TOTS ELS NAMESPACES DE NOM SI ES VOL PUJAR A PACKAGIST, CAS CONTRARI SOLS MODIFICAR composer.json / composer.lock 
CAL AFEGIR
{
    "autoload": {
        "psr-4": {"lib\\": "lib/"}
    }
}
DESPRÉS FER: php composer.phar dump-autoload

VEURE: https://getcomposer.org/doc/01-basic-usage.md#autoloading
*/