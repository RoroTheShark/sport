# Sport

## Que fait cette application?
Cette application a pour but de pouvoir suivre de manière plus poussée les activités de sport.
Elle date de plusieurs années, et je n'ai pas eu le temps de tout mettre à jour, il peut y avoir quelques coquilles.

## D'où viennent les données?
Elles sont entrés à la main, en copiant des caractéristiques de Strava ou Décathlon coach.

## Versions
 * PHP : 8.2.0
 * MySQL : 8.0.31

# Évolutions à prévoir

## Technique
* Revoir la classe "Workout". En effet, je n'ai pas trouvé comment bien initier "WorkoutSwimming" ou "WorkoutCycle" en fonction du sport autrement qu'en entrant en dur des conditions. Dès qu'une donnée change côté BDD, il faudra faire gaffe à modifier le code.
* Faire l'hydratation automatique.
* Revoir la classe de connexion à la BDD (singleton)
* Ajouter un autoload

## Autres
* Connecter l'API Décathlon Coach pour recevoir automatiquement les séances
