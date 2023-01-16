# NIA Framework Release Notes

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

