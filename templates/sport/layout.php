<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Language" content="fr" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=no" />
	<title>Mon sport - <?= isset($title) ? $title : "Accueil" ?></title>
	<link rel="stylesheet" href="public/css/sport_styles.css">
</head>
<body>
	<header>
		<h1><?= isset($title) ? $title : "Accueil" ?></h1>
	    <div>
	    	<a href="index.php?domain=sport&action=list&type=stats">Statistiques globales</a> / <a href="index.php?domain=sport&action=form&type=workout&idWorkout=0">Nouvelle séance</a> / <a href="index.php?domain=sport&action=list&type=workouts">Liste filtrée</a>
	    </div>
	    <div>
	     	<a href="index.php?domain=sport&action=list&type=partners">Liste des partenaires</a> / <a href="index.php?domain=sport&action=list&type=equipments">Liste des matériels</a> / <a href="index.php?domain=sport&action=list&type=events">Liste des évènements</a> / <a href="index.php?domain=sport&action=list&type=mounts">Liste des monts et cols</a> / <a href="index.php?domain=sport&action=list&type=pools">Liste des piscines</a>
	    </div>
	</header>
	<main>
		<?= $content ?>
	</main>
	<?= isset($javascript) ? $javascript : "" ?>
</body>
</html>