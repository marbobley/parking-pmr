# parking-pmr
Projet Symfony visant à afficher sur une carte Google les places de parkings récupérées depuis une API REST.

Architecture mise en place: Hexagonale (Ports & Adapters)

- Domain (coeur métier)
  - App/Domain/Parking/Parking: entité/VO représentant une place de parking
  - App/Domain/Parking/ParkingRepositoryInterface: port primaire pour accéder aux parkings
- Application (use cases)
  - App/Application/Parking/GetAllParkings: cas d’usage pour lister les parkings
- Infrastructure (adapters)
  - App/Infrastructure/Parking/ApiParkingRepository: adaptateur utilisant HttpClient pour interroger l’API REST externe
- Interface utilisateur (Symfony Controller + Twig)
  - App/Controller/HomeController: injecte le cas d’usage et transmet les données au template
  - templates/home/index.html.twig: prépare l’affichage de la carte (div #map) et liste les parkings

Configuration

1) Définir l’URL de l’API REST en variable d’environnement (par exemple dans .env.local):

   PARKING_API_URL="https://exemple.tld/api/parkings"

2) La valeur est injectée via config/services.yaml dans le service ApiParkingRepository.

Lancer l’application

- Démarrer le serveur Symfony et accéder à la page d’accueil (/). Si l’URL d’API est renseignée et renvoie des éléments avec au minimum latitude/longitude, la liste des parkings sera affichée.

Prochaines étapes (non incluses dans ce commit)

- Brancher le SDK Google Maps et placer des marqueurs en fonction des coordonnées
- Affiner le mapping JSON -> domaine selon le format réel de l’API
- Ajouter des tests unitaires pour le cas d’usage et l’adaptateur
