# Pokémon Cards (PRG5 Herkansing)

Een Laravel webapplicatie waarin je Pokémon kaarten kunt bekijken, zoeken en filteren.  
Als je ingelogd bent kun je kaarten uploaden (met afbeelding). De eigenaar kan zijn eigen kaart bewerken/verwijderen.

## Features

- Overzichtspagina met tabel:
    - afbeelding (thumbnail)
    - naam
    - rarity
    - omschrijving
    - owner
    - details knop
- Zoeken op naam/omschrijving
- Filter op rarity (Common / Rare / Legendary)
- Details pagina per kaart
- Authenticatie (Laravel Breeze)
    - register / login / logout
- Upload kaart (alleen ingelogd)
    - optioneel afbeelding uploaden
- Authorization / beveiliging:
    - alleen eigenaar kan edit/delete (Policy)
- Demo data:
    - Seeder + Factory om snel testdata te vullen

## Tech stack

- Laravel (met Blade)
- Laravel Breeze (auth)
- SQLite database (local)
- Tailwind (via Breeze scaffolding)
- File uploads via `storage/app/public` + `public/storage` symlink

---

Owner Inlog voor Adminrechten:
- email:trev@gmail.com
- wachtwoord: 123123123
