# Laravel Blog

## Installation

```
git clone XXX
cd blog
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
```

# Aufgaben

1. Fehler auf admin/posts lösen?
   -  Woher kam der Fehler?
2. Der Admin soll bei Posts festlegen können wer der Autor ist.
3. Jeden 1. des Monats soll das System einen Post mit Titel "Zusammenfassung (Monat im Format mm.yyyy)" im Hintergrund anlegen. Autor ist der Admin.
4. Nach dem erstellen eines Posts soll der Admin eine Notification bekommen. Titel: "Neuer Post". Inhalt: Link zum Post.

# Lösungen

1. -  Beim Seeden: Der DummyData-Seeder setzt einen Post mit user_id 100, wobei dieser User nicht existiert, da nur 10 User insgesamt in die Datenbank persisitiert werden, aufsteigend von ID 1 bis 10
2. -  In der PostController edit- und create-Methode müssen wir zuerst alle User mit Namen und Id im Formular verfügbar machen
   -  in der \_form.blade muss dann ein neues Select-Feld eingebettet werden, welches als values, die jeweilige Id des Autors hält
   -  beim Abschicken muss diese Id, dann wiederum im Request-Objekt der PostController update- und create-Methode verfügbar sein, um die Änderungen speichern zu können
   -  um die User-ID nur für den Admin sichtbar zu machen, muss ein conditional im Formular her und das automatische zuweisen der ID, falls das Feld fehlt, beim updaten in der Post boot-Methode möglich gemacht werden
3. -  Kommando mit make:command anlegen und handle-Methode definieren
      -  dabei den Admin aus der Users-Tabelle suchen und den neuen Post in dessen Posts-Collection speichern
   -  im Kernel in der schedule-Methode command anlegen, monatlich timen und im commands-Array registrieren
4. -  Notification Klasse "PostCreated" erstellen
   -  im Post Model im created-Hook per Facade eine Notification an den Admin absetzen und den Post in den Konstruktor weitergeben
   -  in der toMail-Methode den Betreff ändern und den Link aus der Post-Instanz erzeugen.

## Anmerkung

-  ich habe den Mail-Client nicht getestet, sondern nur, ob Admin und Link korrekt ankommen
-  die .env.example war nicht im Repo enthalten, daher habe ich sie aus einem Template im Netz genommen
