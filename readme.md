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
    - Woher kam der Fehler?
2. Der Admin soll bei Posts festlegen können wer der Autor ist.
3. Jeden 1. des Monats soll das System einen Post mit Titel "Zusammenfassung (Monat im Format mm.yyyy)" im Hintergrund anlegen. Autor ist der Admin.
4. Nach dem erstellen eines Posts soll der Admin eine Notification bekommen. Titel: "Neuer Post". Inhalt: Link zum Post.


