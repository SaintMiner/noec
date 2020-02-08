# d42-DmitrijsTkacuks-EnterpriseControl

## Projekta apraksts

Sistēma, kas palīdz kontrolēt un pārvaldīt uzņēmumu tīklu. Šajā sistēmā ietilpst katra uzņēmuma noliktavu vadība un uzraudzība. Darbinieku un nodaļu vadība. Piedāvā kopējos ieņēmumus un katra uzņēmuma peļņas statistiku.

## Izmantotās tehnoloģijas

* Laravel
* Vue
* Axios
* PHP
* JavaScript
* Bootstrap
* CSS
* MySQL
* Composer
* NodeJS
* NPM


## Izmantotie avoti

[Bootstrap Docs](https://getbootstrap.com/docs/4.0/getting-started/introduction/) - Tika izmantota dokumentācijā, lai noformēt lapu ar Bootstrap CSS framework.

[js Docs](https://developer.mozilla.org/en-US/docs/Web/JavaScript) - Tika izmantots, lai iepazīsties ar JacaScript strukturu un funkcijām.

[Vue Docs](https://vuejs.org/v2/guide/) - Tika izmantota dokumentācijā, lai iepazīsties un izstrādāt lapas Frontend daļu uz Vue.js.

[Laravel Docs](https://laravel.com)- Tika izmantota dokumentācijā, lai iepazīsties un izstrādāt lapas BackEnd daļu uz Laravel.

[Laravel Tutorial](https://www.youtube.com/watch?v=eD4yMI-IR8g&list=PLpzy7FIRqpGC8Jk6gyWdSVdxCVXZAsenQ) - Tika izmantoti video materiāli lai ātrāk iemācīties stradat ar Laravel Framework.

[Vue Tutorial](https://www.youtube.com/watch?v=5LYrN_cAJoA&list=PL4cUxeGkcC9gQcYgjhBoeQH7wiAyZNrYa) - Tika izmantoti video materiāli lai ātrāk iemācīties stradat ar Vue Framework.

[SPA Tutorial](https://www.youtube.com/watch?v=AFyzK8qohdE&list=PLpzy7FIRqpGBBKr4FVpEs1fA7uCibdCZ9) - Tika izmantoti video materiāli lai iepazīsties ar SPA tehnoloģiju kura tiek veidota no Vue & Laravel.

[w3School](https://www.w3schools.com) - Tika izmantos, lai atrast vajadzīgas komponentes, elementus un atribūtus.

## Uzstādīšanas instrukcijas

1. Lai izmantot šo sistēmu vajadzēs uzinstalēt sekojošu programmatūru:
    1. Lai lietotu git lejupielādējam [Git for windows](https://git-scm.com/download/win) un instalējam git.
    2. Lai lietotu XAMPP lejupielādējam [XAMPP](https://www.apachefriends.org/index.html) for windows un instalējam to.
    3. Lai lietotu [Composer](https://getcomposer.org/download/) lejupielādējam to un  instalējam.
    4. Lai lietotu NPM vajadzēs uzinstalēt [NodeJS](https://nodejs.org/en/), (labāk  LTS).

2. Dodamies uz XAMPP atrašanās vietu parasti “C:\xampp\htdocs” un izdzēšam tā saturu.

3. Veicam labo klikšķi un izvēlamies opciju "git bash here" un izpildam zemāk raksīto komandu.

```
git clone https://github.com/rvtprog-kvalifikacija-20/d42-DmitrijsTkacuks-EnterpriseControl.git
```

4. Tagad vajag nokonfigurēt XAMPP, dodamies uz “\xampp\apache\conf\extra” un meklējam failu ar nosaukumu “httpd-vhosts.conf” un atveram to.

5. Faila pievienojam sekojošas rindas:

   1. DocumentRoot ceļš var būt aizvietots uz to direktorijas ceļu kura tika noklonētā repozitorijā, bet obligāti uz repozitorijās public direktoriju, piemēram D:/xampp/htdocs/**myDirectory**/public

```
<VirtualHost *:80>
    ServerName localhost
    
    DocumentRoot "C:/xampp/htdocs/d42-DmitrijsTkačuks-EnterpriseControl/public"
</VirtualHost>
```


6. Palaidiet  XAMPP un ieslēdziet Apache un MySQL

7. Dodamies uz [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/) un izveidojam datubāzi ar nosaukumu “enterprisecontrol”

8. Izsaucam konsoli tajā direktorija kura tika noklonētā repozitorijā no Git un izpildām sekojošas komandas:
```
composer install

npm i

php artisan cache:clear

php artisan migrate
```

9. Dodamies uz [http://localhost](http://localhost), lai pārbaudīt sistēmu