# Sport

## Que fait cette application?
Cette application a pour but de pouvoir suivre de manière plus poussée les activités de sport

## D'où viennent les données?
Elles sont entrés à la main, en copiant des caractéristiques de Strava ou Décathlon coach.


# Évolutions à prévoir

## Technique
* Revoir la classe "Workout". En effet, je n'ai pas trouvé comment bien initier "WorkoutSwimming" ou "WorkoutCycle" en fonction du sport autrement qu'en entrant en dur des conditions. Dès qu'une donnée change côté BDD, il faudra faire gaffe à modifier le code.
* Faire l'hydratation automatique.

## Autres
* Connecter l'API Décathlon Coach pour recevoir automatiquement les séances
