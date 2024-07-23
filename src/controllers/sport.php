<?php

require_once('src/Sport/entities/Brand.php');
require_once('src/Sport/entities/City.php');
require_once('src/Sport/entities/Country.php');
require_once('src/Sport/entities/DisplayDatas.php');
require_once('src/Sport/entities/Equipment.php');
require_once('src/Sport/entities/Event.php');
require_once('src/Sport/entities/Mount.php');
require_once('src/Sport/entities/Partner.php');
require_once('src/Sport/entities/Pool.php');
require_once('src/Sport/entities/Road.php');
require_once('src/Sport/entities/Workout.php');
require_once('src/Sport/repositories/BrandRepository.php');
require_once('src/Sport/repositories/CityRepository.php');
require_once('src/Sport/repositories/CompetTrainRepository.php');
require_once('src/Sport/repositories/CountryRepository.php');
require_once('src/Sport/repositories/EnvironmentRepository.php');
require_once('src/Sport/repositories/EquipmentRepository.php');
require_once('src/Sport/repositories/EquipmentSubTypeRepository.php');
require_once('src/Sport/repositories/EquipmentTypeRepository.php');
require_once('src/Sport/repositories/EventRepository.php');
require_once('src/Sport/repositories/IntensityRepository.php');
require_once('src/Sport/repositories/MomentRepository.php');
require_once('src/Sport/repositories/MonthRepository.php');
require_once('src/Sport/repositories/MountRepository.php');
require_once('src/Sport/repositories/PartnerRepository.php');
require_once('src/Sport/repositories/PoolRepository.php');
require_once('src/Sport/repositories/RoadRepository.php');
require_once('src/Sport/repositories/SeasonRepository.php');
require_once('src/Sport/repositories/SportRepository.php');
require_once('src/Sport/repositories/WorkoutRepository.php');

use Sport\Entity\Brand;
use Sport\Entity\City;
use Sport\Entity\Country;
use Sport\Entity\DisplayDatas;
use Sport\Entity\Equipment;
use Sport\Entity\Event;
use Sport\Entity\Mount;
use Sport\Entity\Partner;
use Sport\Entity\Pool;
use Sport\Entity\Road;
use Sport\Entity\Workout;
use Sport\Repository\BrandRepository;
use Sport\Repository\CityRepository;
use Sport\Repository\CompetTrainRepository;
use Sport\Repository\CountryRepository;
use Sport\Repository\EnvironmentRepository;
use Sport\Repository\EquipmentRepository;
use Sport\Repository\EquipmentSubTypeRepository;
use Sport\Repository\EquipmentTypeRepository;
use Sport\Repository\EventRepository;
use Sport\Repository\IntensityRepository;
use Sport\Repository\MomentRepository;
use Sport\Repository\MonthRepository;
use Sport\Repository\MountRepository;
use Sport\Repository\PartnerRepository;
use Sport\Repository\PoolRepository;
use Sport\Repository\RoadRepository;
use Sport\Repository\SeasonRepository;
use Sport\Repository\SportRepository;
use Sport\Repository\WorkoutRepository;

function listMounts()
{
    $countryRepository = new CountryRepository();
	$countries = $countryRepository->findAll();

	require('templates/sport/list_mounts.php');
}

function formCountry(int $idCountry, string $origin)
{
    $countryRepository = new CountryRepository();
    if($idCountry == 0) {
    	$country = new Country();
    } else {
		$country = $countryRepository->findOneById($idCountry);
	}

	require('templates/sport/form_country.php');
}

function saveCountry($origin)
{
    $countryRepository = new CountryRepository();
    $countryRepository->save();

	header("Location: index.php?domain=sport&action=list&type=".$origin);
}

function formMount(int $idMount, int $idCountry)
{
    $mountRepository = new MountRepository();
    if($idMount == 0) {
    	$mount = new Mount();
        $countryRepository = new CountryRepository();
        $mount->setCountry($countryRepository->findOneById($idCountry));
    } else {
		$mount = $mountRepository->findOneById($idMount);
	}

	require('templates/sport/form_mount.php');
}

function saveMount()
{
    $mountRepository = new MountRepository();
    $mountRepository->save();

	header("Location: index.php?domain=sport&action=list&type=mounts");
}

function formRoad(int $idRoad, int $idMount)
{
    $roadRepository = new RoadRepository();
    if($idRoad == 0) {
    	$road = new Road();
        $mountRepository = new MountRepository();
        $road->setMount($mountRepository->findOneById($idMount));
    } else {
		$road = $roadRepository->findOneById($idRoad);
	}

	require('templates/sport/form_road.php');
}

function saveRoad()
{
    $roadRepository = new RoadRepository();
    $roadRepository->save();

	header("Location: index.php?domain=sport&action=list&type=mounts");
}

function listPools()
{
    $countryRepository = new CountryRepository();
	$countries = $countryRepository->findAll();

	require('templates/sport/list_pools.php');
}

function formCity(int $idCity, int $idCountry)
{
    $cityRepository = new CityRepository();
    if($idCity == 0) {
    	$city = new City();
        $countryRepository = new CountryRepository();
        $city->setCountry($countryRepository->findOneById($idCountry));
    } else {
		$city = $cityRepository->findOneById($idCity);
	}

	require('templates/sport/form_city.php');
}

function saveCity()
{
    $cityRepository = new CityRepository();
    $cityRepository->save();

	header("Location: index.php?domain=sport&action=list&type=pools");
}

function formPool(int $idPool, int $idCity)
{
    $poolRepository = new PoolRepository();
    if($idPool == 0) {
    	$pool = new Pool();
        $cityRepository = new CityRepository();
        $pool->setCity($cityRepository->findOneById($idCity));
    } else {
		$pool = $poolRepository->findOneById($idPool);
	}

	require('templates/sport/form_pool.php');
}

function savePool()
{
    $poolRepository = new PoolRepository();
    $poolRepository->save();

	header("Location: index.php?domain=sport&action=list&type=pools");
}

function listEvents()
{
    $eventRepository = new EventRepository();
    $events = $eventRepository->findAll();

    require('templates/sport/list_events.php');
}

function formEvent(int $idEvent)
{
    $eventRepository = new EventRepository();
    if($idEvent == 0) {
        $event = new Event();
    } else {
        $event = $eventRepository->findOneById($idEvent);
    }

    require('templates/sport/form_event.php');
}

function saveEvent()
{
    $eventRepository = new EventRepository();
    $eventRepository->save();

    header("Location: index.php?domain=sport&action=list&type=events");
}

function listPartners()
{
    $partnerRepository = new PartnerRepository();
    $partners = $partnerRepository->findAll();

    require('templates/sport/list_partners.php');
}

function formPartner(int $idPartner)
{
    $partnerRepository = new PartnerRepository();
    if($idPartner == 0) {
        $partner = new Partner();
    } else {
        $partner = $partnerRepository->findOneById($idPartner);
    }

    require('templates/sport/form_partner.php');
}

function savePartner()
{
    $partnerRepository = new PartnerRepository();
    $partnerRepository->save();

    header("Location: index.php?domain=sport&action=list&type=partners");
}

function listEquipments($all)
{
    $equipmentRepository = new EquipmentRepository();
    $equipments = $equipmentRepository->findAll($all == 1);

    require('templates/sport/list_equipments.php');
}

function formBrand(int $idEquipment)
{
    $brand = new Brand();

    require('templates/sport/form_brand.php');
}

function saveBrand()
{
    $brandRepository = new BrandRepository();
    $brandRepository->save();

    header("Location: index.php?domain=sport&action=form&type=equipment&idEquipment=".$_POST['idEquipment']);
}

function formEquipment(int $idEquipment)
{
    $equipmentRepository = new EquipmentRepository();
    if($idEquipment == 0) {
        $equipment = new Equipment();
    } else {
        $equipment = $equipmentRepository->findOneById($idEquipment);
    }

    $equipmentSubTypeRepository = new EquipmentSubTypeRepository();
    $equipmentSubTypes = $equipmentSubTypeRepository->findAll();

    $brandRepository = new BrandRepository();
    $brands = $brandRepository->findAll();

    $sportRepository = new SportRepository();
    $sports = $sportRepository->findAll();

    require('templates/sport/form_equipment.php');
}

function saveEquipment()
{
    $equipmentRepository = new EquipmentRepository();
    $equipmentRepository->save();

    header("Location: index.php?domain=sport&action=list&type=equipments");
}

function listWorkouts()
{
    $fDateStart = isset($_GET['fDateStart']) ? $_GET['fDateStart'] : "";
    $fDateEnd = isset($_GET['fDateEnd']) ? $_GET['fDateEnd'] : "";
    $fSport = isset($_GET['fSport']) && $_GET['fSport'] != "" ? $_GET['fSport'] : 0;
    $sportRepository = new SportRepository();
    $sports = $sportRepository->findAll();
    $fEnvironment = isset($_GET['fEnvironment']) && $_GET['fEnvironment'] != "" ? $_GET['fEnvironment'] : 0;
    $environmentRepository = new EnvironmentRepository();
    $environments = $environmentRepository->findAll();
    $fDistanceStart = isset($_GET['fDistanceStart']) && $_GET['fDistanceStart'] != "" ? $_GET['fDistanceStart'] : 0;
    $fDistanceEnd = isset($_GET['fDistanceEnd']) && $_GET['fDistanceEnd'] != "" ? $_GET['fDistanceEnd'] : 0;
    $fTimeStart = isset($_GET['fTimeStart']) && $_GET['fTimeStart'] != "" ? $_GET['fTimeStart'] : 0;
    $fTimeEnd = isset($_GET['fTimeEnd']) && $_GET['fTimeEnd'] != "" ? $_GET['fTimeEnd'] : 0;
    $fPartner = isset($_GET['fPartner']) && $_GET['fPartner'] != "" ? $_GET['fPartner'] : 0;
    $partnerRepository = new PartnerRepository();
    $partners = $partnerRepository->findAll();


    $workoutRepository = new WorkoutRepository();
    $workouts = $workoutRepository->findSeveralBy($fDateStart, $fDateEnd, $fSport, $fEnvironment, $fDistanceStart, $fDistanceEnd, $fTimeStart, $fTimeEnd, $fPartner);

    $sumTime = array_sum(array_map(fn($s): int => $s->getTime(), $workouts));
    $sumDistance = round(array_sum(array_map(fn($s): int => $s->getDistance(), $workouts))/1000);
    $sumElevation = array_sum(array_map(fn($s): int => $s->getElevation(), $workouts));
    $sumDatas = new DisplayDatas($sumDistance, 0, $sumTime, 0, 0, $sumElevation);

    require('templates/sport/list_workouts.php');
}

function formWorkout(int $idWorkout)
{
    $workoutRepository = new WorkoutRepository();

    if($idWorkout == 0) {
        $workout = new Workout();
    } else {
        $workout = $workoutRepository->findOneById($idWorkout);
    }

    $sportRepository = new SportRepository();
    $sports = $sportRepository->findAll();

    $environmentRepository = new EnvironmentRepository();
    $environments = $environmentRepository->findAll();

    $countryRepository = new CountryRepository();
    $countries = $countryRepository->findAll();

    $cityRepository = new CityRepository();
    $cities = $cityRepository->findAll();

    $poolRepository = new PoolRepository();
    $pools = $poolRepository->findAll();

    $competTrainRepository = new CompetTrainRepository();
    $competTrains = $competTrainRepository->findAll();

    $momentRepository = new MomentRepository();
    $moments = $momentRepository->findAll();

    $intensityRepository = new IntensityRepository();
    $intensities = $intensityRepository->findAll();

    $partnerRepository = new PartnerRepository();
    $partners = $partnerRepository->findAll();

    $equipmentTypeRepository = new EquipmentTypeRepository();
    $equipmentTypes = $equipmentTypeRepository->findAll();

    $countryRepository = new CountryRepository();
    $countriesMounts = $countryRepository->findSeveralWithMounts();

    require('templates/sport/form_workout.php');
}

function saveWorkout()
{
    $workoutRepository = new WorkoutRepository();
    $workoutRepository->save();

    header("Location: index.php?domain=sport&action=list&type=workouts");
}

function listStats()
{
    $vue = "season";
    if(isset($_GET['vue'])) {
        $vue = $_GET['vue'];
    }
    $selectedPeriod = null;
    if(isset($_GET['selectedPeriod'])) {
        $selectedPeriod = $_GET['selectedPeriod'];
    }

    $workoutRepository = new WorkoutRepository();

    if($vue == "season") {
        $seasonRepository = new SeasonRepository();
        if(!$selectedPeriod) {
            $lastYearSeason = (date("m") < 9) ? date("Y") : date("Y")+1;

            $seasonActual = $seasonRepository->findOneByLastYear($lastYearSeason);
            $seasonPrevious = $seasonRepository->findOneByLastYear($lastYearSeason-1);

            $selectedPeriod = $seasonActual->getId();
        } else {
            $seasonActual = $seasonRepository->findOneById($selectedPeriod);
        }
        $seasonPrevious = $seasonRepository->findOneByLastYear($seasonActual->getYearEnd()-1);

        $dateStartActual = new \DateTime($seasonActual->getYearStart()."-09-01");
        $stringDateStartActual = $dateStartActual->format("Y-m-d");
        $dateEndActual = new \DateTime($seasonActual->getYearEnd()."-08-31");
        $stringDateEndActual = $dateEndActual->format("Y-m-d");

        $dateStartPrevious = new \DateTime($seasonPrevious->getYearStart()."-09-01");
        $stringDateStartPrevious = $dateStartPrevious->format("Y-m-d");
        $dateEndPrevious = new \DateTime($seasonPrevious->getYearEnd()."-08-31");
        $stringDateEndPrevious = $dateEndPrevious->format("Y-m-d");

        // On formate pour avoir la même sortie que la liste des années
        $listChoices = array_map(fn($s):array => ['value' => $s->getId(), 'name' => $s->getYearStart()."/".$s->getYearEnd()], $seasonRepository->findAll());
    } else {
        if(!$selectedPeriod) {
            $selectedPeriod = date("Y");
        }
        $yearActual = $selectedPeriod;
        $yearPrevious = $selectedPeriod-1;

        $dateStartActual = new \DateTime($yearActual."-01-01");
        $stringDateStartActual = $dateStartActual->format("Y-m-d");
        $dateEndActual = new \DateTime($yearActual."-12-31");
        $stringDateEndActual = $dateEndActual->format("Y-m-d");

        $dateStartPrevious = new \DateTime($yearPrevious."-01-01");
        $stringDateStartPrevious = $dateStartPrevious->format("Y-m-d");
        $dateEndPrevious = new \DateTime($yearPrevious."-12-31");
        $stringDateEndPrevious = $dateEndPrevious->format("Y-m-d");

        $listChoices = $workoutRepository->findAllYears();
    }

    $statsPeriodActual = $workoutRepository->findStatsByDates($stringDateStartActual, $stringDateEndActual);
    $statsPeriodPrevious = $workoutRepository->findStatsByDates($stringDateStartPrevious, $stringDateEndPrevious);

    $sportRepository = new SportRepository();
    $sportsPeriod = $sportRepository->findSeveralByDatesActualAndPrevious($stringDateStartActual, $stringDateEndActual, $stringDateStartPrevious, $stringDateEndPrevious);

    $monthRepository = new MonthRepository();
    $months = $monthRepository->findSeveralByDates($stringDateStartActual, $stringDateEndActual);

    $tabType = [
        'sumDistanceActual' => 0,
        'moyDistanceActual' => 0,
        'maxDistanceActual' => 0,
        'sumTimeActual' => 0,
        'moyTimeActual' => 0,
        'maxTimeActual' => 0,
        'numWorkoutsActual' => 0,
        'sumDistancePrevious' => 0,
        'moyDistancePrevious' => 0,
        'maxDistancePrevious' => 0,
        'sumTimePrevious' => 0,
        'moyTimePrevious' => 0,
        'maxTimePrevious' => 0,
        'numWorkoutsPrevious' => 0
    ];
    $arrayTotal = $tabType;
    $arrayEnv = [];

    $arrayResults = ['months' => [], 'environments' => [], 'sports' => [], 'total' => []];
    foreach($months as $month) {
        $arrayMonth = $tabType;
        $arrayResults['months'][$month->getId()] = ['sports' => [], 'environments' => []];
        foreach($sportsPeriod as $sport) {
            $arraySport = $tabType;
            foreach($sport->getEnvironments() as $environment) {
                $sumDistanceActual = 0;
                $moyDistanceActual = 0;
                $maxDistanceActual = 0;
                $sumTimeActual = 0;
                $moyTimeActual = 0;
                $maxTimeActual = 0;
                $numWorkoutsActual = 0;
                $sumDistancePrevious = 0;
                $moyDistancePrevious = 0;
                $maxDistancePrevious = 0;
                $sumTimePrevious = 0;
                $moyTimePrevious = 0;
                $maxTimePrevious = 0;
                $numWorkoutsPrevious = 0;
                if(!isset($arrayEnv[$environment->getId()])) {
                    $arrayEnv[$environment->getId()] = $tabType;
                }

                if(isset($statsPeriodActual[$month->getId()]) && isset($statsPeriodActual[$month->getId()][$environment->getId()])) {
                    $sumDistanceActual = $statsPeriodActual[$month->getId()][$environment->getId()]['sumDistance'];
                    $maxDistanceActual = $statsPeriodActual[$month->getId()][$environment->getId()]['maxDistance'];
                    $sumTimeActual = $statsPeriodActual[$month->getId()][$environment->getId()]['sumTime'];
                    $maxTimeActual = $statsPeriodActual[$month->getId()][$environment->getId()]['maxTime'];
                    $numWorkoutsActual = $statsPeriodActual[$month->getId()][$environment->getId()]['numWorkouts'];

                    // Somme pour les tableaux de sport (dernière colonne)
                    $arraySport['sumDistanceActual'] += $sumDistanceActual;
                    $arraySport['maxDistanceActual'] = $arraySport['maxDistanceActual'] < $maxDistanceActual ? $maxDistanceActual : $arraySport['maxDistanceActual'];
                    $arraySport['sumTimeActual'] += $sumTimeActual;
                    $arraySport['maxTimeActual'] = $arraySport['maxTimeActual'] < $maxTimeActual ? $maxTimeActual : $arraySport['maxTimeActual'];
                    $arraySport['numWorkoutsActual'] += $numWorkoutsActual;

                    // Somme pour les tableaux d'environnement (dernière ligne)
                    $provEnv = $arrayEnv[$environment->getId()];
                    $provEnv['sumDistanceActual'] += $sumDistanceActual;
                    $provEnv['maxDistanceActual'] = $provEnv['maxDistanceActual'] < $maxDistanceActual ? $maxDistanceActual : $provEnv['maxDistanceActual'];
                    $provEnv['sumTimeActual'] += $sumTimeActual;
                    $provEnv['maxTimeActual'] = $provEnv['maxTimeActual'] < $maxTimeActual ? $maxTimeActual : $provEnv['maxTimeActual'];
                    $provEnv['numWorkoutsActual'] += $numWorkoutsActual;
                    $arrayEnv[$environment->getId()] = $provEnv;
                }
                if(isset($statsPeriodPrevious[$month->getId()]) && isset($statsPeriodPrevious[$month->getId()][$environment->getId()])) {
                    $sumDistancePrevious = $statsPeriodPrevious[$month->getId()][$environment->getId()]['sumDistance'];
                    $maxDistancePrevious = $statsPeriodPrevious[$month->getId()][$environment->getId()]['maxDistance'];
                    $sumTimePrevious = $statsPeriodPrevious[$month->getId()][$environment->getId()]['sumTime'];
                    $maxTimePrevious = $statsPeriodPrevious[$month->getId()][$environment->getId()]['maxTime'];
                    $numWorkoutsPrevious = $statsPeriodPrevious[$month->getId()][$environment->getId()]['numWorkouts'];

                    // Somme pour les tableaux de sport (dernière colonne)
                    $arraySport['sumDistancePrevious'] += $sumDistancePrevious;
                    $arraySport['maxDistancePrevious'] = $arraySport['maxDistancePrevious'] < $maxDistancePrevious ? $maxDistancePrevious : $arraySport['maxDistancePrevious'];
                    $arraySport['sumTimePrevious'] += $sumTimePrevious;
                    $arraySport['maxTimePrevious'] = $arraySport['maxTimePrevious'] < $maxTimePrevious ? $maxTimePrevious : $arraySport['maxTimePrevious'];
                    $arraySport['numWorkoutsPrevious'] += $numWorkoutsPrevious;

                    // Somme pour les tableaux d'environnement (dernière ligne)
                    $provEnv = $arrayEnv[$environment->getId()];
                    $provEnv['sumDistancePrevious'] += $sumDistancePrevious;
                    $provEnv['maxDistancePrevious'] = $provEnv['maxDistancePrevious'] < $maxDistancePrevious ? $maxDistancePrevious : $provEnv['maxDistancePrevious'];
                    $provEnv['sumTimePrevious'] += $sumTimePrevious;
                    $provEnv['maxTimePrevious'] = $provEnv['maxTimePrevious'] < $maxTimePrevious ? $maxTimePrevious : $provEnv['maxTimePrevious'];
                    $provEnv['numWorkoutsPrevious'] += $numWorkoutsPrevious;
                    $arrayEnv[$environment->getId()] = $provEnv;
                }
                $arrayResults['months'][$month->getId()]['environments'][$environment->getId()]['actual'] = new DisplayDatas($sumDistanceActual, $maxDistanceActual, $sumTimeActual, $maxTimeActual, $numWorkoutsActual, 0);
                $arrayResults['months'][$month->getId()]['environments'][$environment->getId()]['previous'] = new DisplayDatas($sumDistancePrevious, $maxDistancePrevious, $sumTimePrevious, $maxTimePrevious, $numWorkoutsPrevious);
            }
            $arrayResults['months'][$month->getId()]['sports'][$sport->getId()]['actual'] = new DisplayDatas($arraySport['sumDistanceActual'], $arraySport['maxDistanceActual'], $arraySport['sumTimeActual'], $arraySport['maxTimeActual'], $arraySport['numWorkoutsActual'], 0);
            $arrayResults['months'][$month->getId()]['sports'][$sport->getId()]['previous'] = new DisplayDatas($arraySport['sumDistancePrevious'], $arraySport['maxDistancePrevious'], $arraySport['sumTimePrevious'], $arraySport['maxTimePrevious'], $arraySport['numWorkoutsPrevious'], 0);

            // Somme pour les tableaux de months
            $arrayMonth['sumDistanceActual'] += $arraySport['sumDistanceActual'];
            $arrayMonth['maxDistanceActual'] = $arrayMonth['maxDistanceActual'] < $arraySport['maxDistanceActual'] ? $arraySport['maxDistanceActual'] : $arrayMonth['maxDistanceActual'];
            $arrayMonth['sumTimeActual'] += $arraySport['sumTimeActual'];
            $arrayMonth['maxTimeActual'] = $arrayMonth['maxTimeActual'] < $arraySport['maxTimeActual'] ? $arraySport['maxTimeActual'] : $arrayMonth['maxTimeActual'];
            $arrayMonth['numWorkoutsActual'] += $arraySport['numWorkoutsActual'];
            $arrayMonth['sumDistancePrevious'] += $arraySport['sumDistancePrevious'];
            $arrayMonth['maxDistancePrevious'] = $arrayMonth['maxDistancePrevious'] < $arraySport['maxDistancePrevious'] ? $arraySport['maxDistancePrevious'] : $arrayMonth['maxDistancePrevious'];
            $arrayMonth['sumTimePrevious'] += $arraySport['sumTimePrevious'];
            $arrayMonth['maxTimePrevious'] = $arrayMonth['maxTimePrevious'] < $arraySport['maxTimePrevious'] ? $arraySport['maxTimePrevious'] : $arrayMonth['maxTimePrevious'];
            $arrayMonth['numWorkoutsPrevious'] += $arraySport['numWorkoutsPrevious'];
        }

        $arrayResults['months'][$month->getId()]['total']['actual'] = new DisplayDatas($arrayMonth['sumDistanceActual'], $arrayMonth['maxDistanceActual'], $arrayMonth['sumTimeActual'], $arrayMonth['maxTimeActual'], $arrayMonth['numWorkoutsActual'], 0);
        $arrayResults['months'][$month->getId()]['total']['previous'] = new DisplayDatas($arrayMonth['sumDistancePrevious'], $arrayMonth['maxDistancePrevious'], $arrayMonth['sumTimePrevious'], $arrayMonth['maxTimePrevious'], $arrayMonth['numWorkoutsPrevious'], 0);
    }

    // On repasse sur chaque environnement pour faire la synthèse
    foreach($sportsPeriod as $sport) {
        $arrayTotalSport = $tabType;
        foreach($sport->getEnvironments() as $environment) {
            $arrayResults['environments'][$environment->getId()]['actual'] = new DisplayDatas($arrayEnv[$environment->getId()]['sumDistanceActual'], $arrayEnv[$environment->getId()]['maxDistanceActual'], $arrayEnv[$environment->getId()]['sumTimeActual'], $arrayEnv[$environment->getId()]['maxTimeActual'], $arrayEnv[$environment->getId()]['numWorkoutsActual'], 0);
            $arrayResults['environments'][$environment->getId()]['previous'] = new DisplayDatas($arrayEnv[$environment->getId()]['sumDistancePrevious'], $arrayEnv[$environment->getId()]['maxDistancePrevious'], $arrayEnv[$environment->getId()]['sumTimePrevious'], $arrayEnv[$environment->getId()]['maxTimePrevious'], $arrayEnv[$environment->getId()]['numWorkoutsPrevious'], 0);

            // Somme pour les tableaux de sport
            $arrayTotalSport['sumDistanceActual'] += $arrayEnv[$environment->getId()]['sumDistanceActual'];
            $arrayTotalSport['maxDistanceActual'] = $arrayTotalSport['maxDistanceActual'] < $arrayEnv[$environment->getId()]['maxDistanceActual'] ? $arrayEnv[$environment->getId()]['maxDistanceActual'] : $arrayTotalSport['maxDistanceActual'];
            $arrayTotalSport['sumTimeActual'] += $arrayEnv[$environment->getId()]['sumTimeActual'];
            $arrayTotalSport['maxTimeActual'] = $arrayTotalSport['maxTimeActual'] < $arrayEnv[$environment->getId()]['maxTimeActual'] ? $arrayEnv[$environment->getId()]['maxTimeActual'] : $arrayTotalSport['maxTimeActual'];
            $arrayTotalSport['numWorkoutsActual'] += $arrayEnv[$environment->getId()]['numWorkoutsActual'];

            $arrayTotalSport['sumDistancePrevious'] += $arrayEnv[$environment->getId()]['sumDistancePrevious'];
            $arrayTotalSport['maxDistancePrevious'] = $arrayTotalSport['maxDistancePrevious'] < $arrayEnv[$environment->getId()]['maxDistancePrevious'] ? $arrayEnv[$environment->getId()]['maxDistancePrevious'] : $arrayTotalSport['maxDistancePrevious'];
            $arrayTotalSport['sumTimePrevious'] += $arrayEnv[$environment->getId()]['sumTimePrevious'];
            $arrayTotalSport['maxTimePrevious'] = $arrayTotalSport['maxTimePrevious'] < $arrayEnv[$environment->getId()]['maxTimePrevious'] ? $arrayEnv[$environment->getId()]['maxTimePrevious'] : $arrayTotalSport['maxTimePrevious'];
            $arrayTotalSport['numWorkoutsPrevious'] += $arrayEnv[$environment->getId()]['numWorkoutsPrevious'];
        }
        $arrayResults['sports'][$sport->getId()] = [
            'actual' => new DisplayDatas($arrayTotalSport['sumDistanceActual'], $arrayTotalSport['maxDistanceActual'], $arrayTotalSport['sumTimeActual'], $arrayTotalSport['maxTimeActual'], $arrayTotalSport['numWorkoutsActual'], 0),
            'previous' => new DisplayDatas($arrayTotalSport['sumDistancePrevious'], $arrayTotalSport['maxDistancePrevious'], $arrayTotalSport['sumTimePrevious'], $arrayTotalSport['maxTimePrevious'], $arrayTotalSport['numWorkoutsPrevious'], 0)
        ];

        // Somme pour le tableau total
        $arrayTotal['sumDistanceActual'] += $arrayTotalSport['sumDistanceActual'];
        $arrayTotal['maxDistanceActual'] = $arrayTotal['maxDistanceActual'] < $arrayTotalSport['maxDistanceActual'] ? $arrayTotalSport['maxDistanceActual'] : $arrayTotal['maxDistanceActual'];
        $arrayTotal['sumTimeActual'] += $arrayTotalSport['sumTimeActual'];
        $arrayTotal['maxTimeActual'] = $arrayTotal['maxTimeActual'] < $arrayTotalSport['maxTimeActual'] ? $arrayTotalSport['maxTimeActual'] : $arrayTotal['maxTimeActual'];
        $arrayTotal['numWorkoutsActual'] += $arrayTotalSport['numWorkoutsActual'];

        $arrayTotal['sumDistancePrevious'] += $arrayTotalSport['sumDistancePrevious'];
        $arrayTotal['maxDistancePrevious'] = $arrayTotal['maxDistancePrevious'] < $arrayTotalSport['maxDistancePrevious'] ? $arrayTotalSport['maxDistancePrevious'] : $arrayTotal['maxDistancePrevious'];
        $arrayTotal['sumTimePrevious'] += $arrayTotalSport['sumTimePrevious'];
        $arrayTotal['maxTimePrevious'] = $arrayTotal['maxTimePrevious'] < $arrayTotalSport['maxTimePrevious'] ? $arrayTotalSport['maxTimePrevious'] : $arrayTotal['maxTimePrevious'];
        $arrayTotal['numWorkoutsPrevious'] += $arrayTotalSport['numWorkoutsPrevious'];
    }
    $arrayResults['total']['actual'] = new DisplayDatas($arrayTotal['sumDistanceActual'], $arrayTotal['maxDistanceActual'], $arrayTotal['sumTimeActual'], $arrayTotal['maxTimeActual'], $arrayTotal['numWorkoutsActual'], 0);
    $arrayResults['total']['previous'] = new DisplayDatas($arrayTotal['sumDistancePrevious'], $arrayTotal['maxDistancePrevious'], $arrayTotal['sumTimePrevious'], $arrayTotal['maxTimePrevious'], $arrayTotal['numWorkoutsPrevious'], 0);

    $partnerRepository = new PartnerRepository();
    $statsPartners = $partnerRepository->findStatsByDates($stringDateStartActual, $stringDateEndActual);
    // On trie pour avoir celui qui a le plus de séance en haut
    uasort($statsPartners['partners'], function($a, $b) {
        if($a->getNumWorkouts() == $b->getNumWorkouts())
            return 0;
        return ($a->getNumWorkouts() > $b->getNumWorkouts()) ? -1 : 1;
    });


    $countryRepository = new CountryRepository();
    $countriesMounts = $countryRepository->findSeveralWithMounts();

    $roadRepository = new RoadRepository();
    $statsRoads = $roadRepository->findStatsByDates($stringDateStartActual, $stringDateEndActual);

    $countriesCities = $countryRepository->findSeveralWithCities();

    $poolRepository = new PoolRepository();
    $statsPools = $poolRepository->findStatsByDates($stringDateStartActual, $stringDateEndActual);

    require('templates/sport/list_stats.php');
}
