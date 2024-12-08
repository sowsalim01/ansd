<?php
error_reporting(0);

header("Access-Control-Allow-Origin: *");//this allows coors
# Connection à la base de données
include_once('config.php');

#Requete pour sélectionner les entités cartographiques et les données attributaires
// $region=$_GET['region'];

// if($region=='*')
$sql = "SELECT region,homme,femme,densite,pop2023,urbain, taux1976, taux1988, taux2002, taux2013, taux2023, ST_AsGeoJSON(geom) AS geojson FROM reg";
// else
// 	$sql = "select st_asgeojson(geom) as geojson, gid,nomreg from region_sn where nomreg='$region'";

$rs = $conn->query($sql);
if (!$rs) {
    echo 'Erreur SQL.\n';
    exit;
}

# Préparer une variable pour le formatage des données en Geojson
$geojson = array(
   'type'      => 'FeatureCollection',
   'features'  => array()
);

# Formater les données de la requete en GEOJSON
while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
    $properties = $row;
     
    unset($properties['geojson']);
    unset($properties['geom']);
    $feature = array(
         'type' => 'Feature',
         'geometry' => json_decode($row['geojson'], true),
         'properties' => $properties
    );
    # Ajouter le feature array à la collection
    array_push($geojson['features'], $feature);
}

header('Content-type: application/json');
echo json_encode($geojson, JSON_NUMERIC_CHECK);
$conn = NULL;
?>