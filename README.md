## Configurações:
- Após baixar o projeto do GitHub, localize o arquivo ".env.example".
- Faça uma cópia e renomeie uma das cópias de ".env.example" para ".env".
- Obs.: É importante manter um arquivo ".env.example", pois o ".env" não é commitado.

### Baixar as dependencias do back-end:
- Se for via Docker:
```bash
docker run --rm -v $(pwd):/app composer install
```
- Se não for via Docker:
```bash
composer install
```

---

### Configurações do ".env":
- Para a rota, localize e altere se nececssário:
```env
APP_URL=http://localhost
APP_PORT=8080
```

---

- Para o banco de dados, localize e altere se nececssário:
```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

---

### Rodar o Laravel:
- Se for via Docker:
```bash
./vendor/bin/sail up
```
- Se não for via Docker:
```bash
php artisan serve
```

---

### Gerar a key:
- No ".env" localize a variável:
```env
APP_KEY=
```
- Vai está vazia.
- Se for via Docker rode:
```bash
./vendor/bin/sail artisan key:generate
```
- Se não for via Docker rode:
```bash
php artisan key:generate
```
- Após rodar esse comando, veja que a variável vai está preenchida.
  
---

### Rodar as migrations:
- Se for via Docker:
```bash
./vendor/bin/sail artisan migrate
```
- Se não for via Docker:
```bash
php artisan migrate
```

---

### Preenche o banco de dados com dados fake (opicional):
- Se for via Docker:
```bash
./vendor/bin/sail artisan db:seed
```
- Se não for via Docker:
```bash
php artisan db:seed
```

---

### Baixar dependencias do front-end:
- Se for via Docker:
```bash
./vendor/bin/sail npm install
```
- Se não for via Docker:
```bash
npm install
```

---

### Rodar o Tailwind CSS:
- Se for via Docker:
```bash
./vendor/bin/sail npm run dev
```
- Se não for via Docker:
```bash
npm run build dev
```

---

### Buildar o Tailwind CSS:
- Se for via Docker:
```bash
./vendor/bin/sail npm run build
```
- Se não for via Docker:
```bash
npm run build
```
