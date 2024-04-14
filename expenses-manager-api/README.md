### Processo de desenvolvimento API
- [x] Desenhar o diagrama do banco
- [x] Configurar o projeto
    - [x] Docker sail
    - [ ] Pest PHP (Não instalado pois só está disponivel para versão 8.1)
    - [x] Laravel Pint
    - [x] Larastan
- [ ] Documentar endpoints no postman

- [ ] Autenticacão
- [ ] Despesas
- [ ] Permissões
- [ ] Notificacões

### Diagrama do banco
Validacões 

1. Pint
```shell
./vendor/bin/pint
```
2. Larastan
```shell
./vendor/bin/phpstan analyse
```
3. Testes
```shell
php artisan test
```

OU

```shell
composer run test
```

### Diagrama do banco
![Diagrama do banco](../images/database.png)