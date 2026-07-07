# new_website

## Localisation des demandes

- La création de demande client inclut désormais une carte Leaflet (tuiles OpenStreetMap) avec géocodage d'adresse via Nominatim.
- Le formulaire enregistre l'adresse texte, la latitude et la longitude (ainsi que le champ GPS texte).
- Si votre base existe déjà, exécutez la migration SQL :
  - `sql/migrations/20260707_add_mission_request_coordinates.sql`