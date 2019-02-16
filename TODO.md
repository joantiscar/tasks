# Petites explicacions pendents

- Feu una ullada a document PDF Component Gallery

# Recordatori de Tasques

## Drop area
- TODO -> millorar la interfície de pujada de fitxers

## File Uploads

## Empty states
- [x] No Mostrar datatables quan no hi ha cap tasca al sistema
  - [x] Mostrar més aviat quelcom més similar a una welcome Page
  - [x] Tres items:
    - [x] Imatge SVG 
    - [x] Text gran (simpàtic i expliqui que cal fer)
    - [x] Botó CTA 
    - [x] Opcional: background opcions: color paleta de grisos, patro, algun pattern de fons parcial 
- [x] El mateix per a tags
## Refactoritzacions

- Moure als seus propis components parts del layout principal:
  - [x] component pel menú de navegació de l'esquerra

## Menu seleccionat Actiu

- [x] Utilitzar tècnica "discreta" de colorejar un border (el dret) amb un color accent
- [x] Cal abans refactoritzar la vista app.blade.php per crear un nou component
- [x] Opcional: canviar el color de les icones per que no siguin negres. FET per Vuetify
- [x] Color de les lletres un gris molt fos en comptes de negre

## Profile usuari

- Settings: permetre canviar el color primary com a mínim (pràctica simple utilitzar LocalStorage)
  - [x] "Selector de tema" / Theme Selector
  
# Manifest.json i PWA
- [x] Colors i icones al manifest de la system bar i de la barra de navegació 
- [x] Add to Home Screen: Service Worker simple i comprovar la instal·lació a mòbils 
- [x] FAVICON:   https://realfavicongenerator.net/

# Background colors
  
- [x] Utilitzar l'escala de grisos que hem definit per substituir algun fons blanc

##US/UI i estils

- [x] No utilitzar color roig als botons acció eliminar que tenen una opció de confirmació de l'acció. Si tenen confirmació no són tant perillosos
  - [x] Aplicar jerarquia per NO destacar el botó acció d'esborrar (secondari o terciari com a mínim)
- [x] Sí utilitzar botó roig al menú de confirmació on realment s'elimina el recurs
- [x] Botons cancel: terciaris arreu

CARDS:
- [x] Vista mòbil les tasques han de ser una card cada tasca:
 - [x]Utilitzar font-weigth en comptes de mides de lletra o semantiques h1, h2, p per fer jerarquia:
  • [x] A normal font weight (400 or 500 depending on the font) for most text
  • [x] A heavier font weight (600 or 700) for text you want to emphasize
- [x]Elevation: provar la elevation
- [x] Intentar no utilitzar labels
  
TIPOGRAFIA:  
- [x]Colors de lletres en escala de grisos
  - [x]A dark color for primary content (like the headline of an article)
  - [x]A grey for secondary content (like the date an article was published)
  - [x]A lighter grey for tertiary content (maybe the copyright notice in a footer)
  
FAVICON i altres icones 2:
- [x] MASTER:140x140pixels Exemple: https://realfavicongenerator.net/files/aa721752ab56d736bb190769232caefe50591992/master_favicon_thumbnail.png

# WHAT WEB CAN DO TODAY

## SOCIAL SHARING

Llegiu SOCIAL_SHARING.md

## API CREDENTIALS JAVASCRIPT

- [ ] Permet guardar la paraula de pas i password al gestor de credencials de Android
- Seguretat? 
- Comoditat: a tots els dispositius mateix compte Google es recordara l'accés
- Canviar el component de Login per utilitzar aquesta api

## LOCAL NOTIFICATIONS | NOTIFICATIONS API

- Permet a una aplicació web enviar notificacions de Sistema (són mostrades fora de la pàgina web utilitzant sistema notificacions de la plataforma/Sistema operatiu en ús)
- És possible fins i tot combinant amb web workers/service workers fer-ho sense aplicació estar en execució

Recursos:
- https://developer.mozilla.org/en-US/docs/Web/API/Notifications_API
- https://whatwebcando.today/local-notifications.html

## PUSH NOTIFICATIONS

- [x] CAL SERVICE WORKERS I SUPORT BROADCAST O INFRAESTRUCTURA DE SERVIDOR

# PWA

# MILLORES APLICACIó PER FACILITAT PRÀCTIQUES EXPLOTACIó

## Widgets Toolbar

### Notifications

-[x] Exemple Event:
	- Tasca Completada
	  - Ara:
		- Enviem Email
		- Changelog
	  - Suposem també volem:
		- Enviar SMS
		- Enviar petició de broadcast en temps real: altres
		- Guardar a una base de dades la notificació per poder mostrar a l'usuari les notificacions
		- Enviar missatge Chat/Slack/Telegram
		- Push notificacion
		- Tot això són notificacions   

### Widget de Notificacions

[x] Boto Icona amb Menú Dropdown: https://codepen.io/pen/?&editable=true&editors=101 | https://vuetifyjs.com/en/components/menus

STORING NOTIFICACIONS:

```
php artisan notifications:table
2019_01_29_140800_create_notifications_table
php artisan migrate
```
```
Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
```        
   
- API: 
  - $user->notifications
  - $user->unreadNotifications
  - $notification->markAsRead();
  - $user->unreadNotifications->markAsRead();


CANALS:
- EMAIL -> Els usuaris tenen email
- SMS -> Cal incorporar un mòbil al usuari
- Slack-> ???
- Telegram-> ?

Sistema integral de notificacions per a una app:
- [ ] Les notificacions poden ser emails/SMS/Missatges de Chat o múltiples opcions mateix temps

- [ ] Task Scheduling de Laravel: utilitzar per fer neteja de notificacions antigues
  - [ ] Comanda Laravel que netegi notificacions velles (poder indicar quin és el criteri per esboorar)
  - [ ] Programar l'execució automàtica de la comanda

### Widget Missatges Chat
TODO

### WIDGET TASQUES PENDENTS:
- [ ] Icona tasques o similar
- [ ] Badge amb el contador de tasques pendents
- [ ] Un cop es fa click mostrar un menu amb la llista de tasques pendents
- [ ] Cal incorporar camp al model Task -> progress: Enter entre 1 i 100 (tant per cent). MIgration DEFAULT: 0'
- [ ] Al fet click a la tasca s'ha de mostrar la tasca:
  - [ ] Cal fer show tasca
  - [ ] Després del show tornar a la llista de tasques
- REAL TIME SUPPORT: s'actualitzi en temps reals   
Exemple: adminLTE: bandereta amb badget mostra llista de tasques pendents amb tant per cent execució
https://adminlte.io/themes/AdminLTE/index2.html#

# PERFORMANCE/RENDIMENT

## EAGER LOADING

- [x] Fer un estudi de com impacte les relacions i el Lazy Loading en el rendiment de l'aplicació
- [x] Laravel Telescope/ Laravel Debugbar per fer l'analisi

## CACHE

- [x] Explicar com funciona el cache
- [x] TODO -> Buscar un exemple de com aplicar. Podriem fer amb les etiquetes
  - [x] Russian Dolls: utilitzar Event per controlar el cache i el cache refresh 
## TASK SCHEDULING

- [x] Explicar com funciona
  - [x] Buscar exemple aplicació

## APLICACIÓ EN EXPLOTACIÓ

- [ ] npm run prod
- [ ] cache config i altres
- [x] Cuas a explotació
