# NIA Framework Release Notes

## Release 0.3.2 (Still in development)

### Enhancements
- Add `rowCount()` method to `DSMySQL` class.
- Add special param `__conjunction` in `find()` method of `DSMySQL` allowing election between AND or OR conjuction.
- Add operator option in `find()` method of `DSMySQL`. Now is possible to use LIKE, <,>,<=,>=,...
- Add support for body parameters in `Router` class for best API Rest support.
- Add support for url query parameters in `Router` for best API Rest support
- Add `httpStatusCode` to `render()` method of `View` and `Controller` for best API Rest support
- Add `UserSession` class for easy user session management
- Add prefix `app\controllers\` for controller namespaces in `Router` (become optional in `routes.php`)
- Add `json.php` to `layouts`
- Add new config settings to `config.php`
### Fixes
- Add `Options -Indexes` in `.htaccess` to prevent directory listing
- Add `multipart/form-data` support on `Router` class to allow files upload.
- Add field enclosing to `find()`,`insert()`,`update()`,`delete()` methods in `DSMySQL` to avoid problems with field names.

### Documentation
- Update `README.MD` 

## Release 0.2.0

### Enhancements
- Add string return type to `render()` on `View` and `Controller`
- Add support vendor libraries on `autoload`
- Add `Mailer` interface to `PHPMailer` external library
- Add `PHPMailer` composer dependencies
- Add new config settings to `config.php`

### Fixes
- Change return types of `insert()`,`update()`,`delete()` on `DataSource` interface
- Change `insert()` returns last inserted id on `DSMySQL`
- Change `update()` returns number of rows updated on `DSMySQL`
- Chamge `delete()` returns number of rows deleted on `DSMySQL`
- Change path `EnumExtType` to `/lib/util`

### Documentation
- Add `LICENSE`
- Add `README.MD`
- Add `RELEASE_NOTES`

