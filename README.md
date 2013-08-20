ep-admin-messages
=================

Show messages in WP Admin

Plugin från EarthPeople för att informera kunder om saker i admin.

## Todo

- [x] Get the plugin the kinda work
- [ ] Add option so messages can be put in metabox on dashboard and post type
- [ ] Write this file in english
- [ ] Make this file a proper wp readme
- [ ] Add files for translation
- [ ] Make a build script that automagically pushes a new svn version based on this git version

## Tankar och idéer:

- All konfigurering sköts via en .json-fil som läggs i temats katalog.
- Ligger i tema-mappen = anpassas för just temat och för de post types etc. som ligger just där
- Ska vara enkelt och tydligt att konfigurera. Inte för många alternativ.

## Funktionalitet

- Platser:
  - dashboard
  - vid redigering av  posts/pages
  - överssiktssida/posts overview screen - för att skriva beskrivning om vad en post type används för
- Vilken text som visas var beror på:
- Vilken capability en användare har, t.ex. en text för admins och en annan för editors.
- Vilken post type som visas
- Vilken slug den har. Konfig ska stödja wildcards så en infotext kan visas på alla sidor som har en slug som börjar med `text-header-*` och då visas den alltså på både `text-header-intro` och `text-header-banner`
- Flera infotexter kan visas på en sida, så infopaketet skräddarsyns för just den användaren


## Användningsexempel:

- Skriva dokumentation för admins eller användare.
- Ange info om en specifik sida vilka tags som finns tillgänglig, t.ex. `%s` för förnamn eller `{{user.fornamn}}` beroende på vilket sätt man skapar mallarna. Gäller främst på post-nivå.
- Visa text på dashboard där det står att Earth People skapat sajten och att dom ska hörav sig till peder@earthpeople.se om dom har frågor eller pengar dom vill bli av med. Gäller för alla/allt/hela rubbet.
- Informera om vilka shortcodes som finns tillgängliga. Gäller på sajt-nivå, eller kanske post-type-nivå.


## Så här kommer det se ut. Typ.

**På dashboard.**
![På dashboard](https://dl.dropboxusercontent.com/u/171101/earthpeople/infobox-example-1.png)

**På en sida.**
Texten ovanför strecket/hr visas bara för admins medan texten under visas för både admins och vanliga användare.
![På en sida](https://dl.dropboxusercontent.com/u/171101/earthpeople/infobox-example-2.png)
