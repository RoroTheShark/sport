<?php

require_once('src/controllers/homepage.php');
require_once('src/controllers/sport.php');

try {
	if (isset($_GET['domain']) && $_GET['domain'] !== '') {
		if ($_GET['domain'] === 'sport') {
			if(isset($_POST['action']) && $_POST['action'] == 'save') {
				if($_POST['type'] == 'country') {
					saveCountry($_POST['origin']);
				} else if($_POST['type'] == 'mount') {
					saveMount();
				} else if($_POST['type'] == 'road') {
					saveRoad();
				} else if($_POST['type'] == 'city') {
					saveCity();
				} else if($_POST['type'] == 'pool') {
					savePool();
				} else if($_POST['type'] == 'event') {
					saveEvent();
				} else if($_POST['type'] == 'partner') {
					savePartner();
				} else if($_POST['type'] == 'equipment') {
					saveEquipment();
				} else if($_POST['type'] == 'brand') {
					saveBrand();
				} else if($_POST['type'] == 'workout') {
					saveWorkout();
				}
			} else if(isset($_GET['action'])) {
	    		if($_GET['action'] == 'form' && isset($_GET['type'])) {
    				if($_GET['type'] == 'country' && isset($_GET['idCountry'])) {
						formCountry($_GET['idCountry'], isset($_GET['origin']) ? $_GET['origin'] : 'mounts');
    				} else if($_GET['type'] == 'mount' && isset($_GET['idCountry']) && isset($_GET['idMount'])) {
						formMount($_GET['idMount'], $_GET['idCountry']);
    				} else if($_GET['type'] == 'road' && isset($_GET['idMount']) && isset($_GET['idRoad'])) {
						formRoad($_GET['idRoad'], $_GET['idMount']);
					} else if($_GET['type'] == 'city' && isset($_GET['idCountry']) && isset($_GET['idCity'])) {
						formCity($_GET['idCity'], $_GET['idCountry']);
    				} else if($_GET['type'] == 'pool' && isset($_GET['idCity']) && isset($_GET['idPool'])) {
						formPool($_GET['idPool'], $_GET['idCity']);
					} else if($_GET['type'] == 'event' && isset($_GET['idEvent'])) {
						formEvent($_GET['idEvent']);
					} else if($_GET['type'] == 'partner' && isset($_GET['idPartner'])) {
						formPartner($_GET['idPartner']);
					} else if($_GET['type'] == 'workout' && isset($_GET['idWorkout'])) {
						formWorkout($_GET['idWorkout']);
					} else if($_GET['type'] == 'equipment' && isset($_GET['idEquipment'])) {
						formEquipment($_GET['idEquipment']);
					} else if($_GET['type'] == 'brand' && isset($_GET['idEquipment'])) {
						formBrand($_GET['idEquipment']);
					} else {
						echo "Erreur : Manque paramètres";
					}
	    		} else if($_GET['action'] == 'list' && isset($_GET['type'])) {
	    			if($_GET['type'] == 'mounts') {
	    				listMounts();
	    			} else if($_GET['type'] == 'pools') {
	    				listPools();
	    			} else if($_GET['type'] == 'events') {
	    				listEvents();
	    			} else if($_GET['type'] == 'partners') {
	    				listPartners();
	    			} else if($_GET['type'] == 'equipments') {
	    				listEquipments(isset($_GET['all']) ? $_GET['all'] : 0);
	    			} else if($_GET['type'] == 'workouts') {
	    				listWorkouts();
	    			} else if($_GET['type'] == 'stats') {
	    				listStats();
	    			}
	    		}
	    	} else {
	    		listStats();
	    	}
		} else {
	    	echo "Erreur 404 : la page que vous recherchez n'existe pas.";
		}
	} else {
		homepage();
	}
} catch (Exception $e) { // S'il y a eu une erreur, alors...
	echo 'Erreur : '.$e->getMessage();
}