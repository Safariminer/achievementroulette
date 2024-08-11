<?php

class Achievement{
    public $name;
    public $description;
    public $imageurl;
    public $imageurlclosed;
}

$xmlfile = file_get_contents("https://steamcommunity.com/id/" . $_GET['player'] . "/stats/" . $_GET['game'] . "/?xml=1");
$xml = simplexml_load_string($xmlfile);

$achievements = array();

foreach($xml->achievements->achievement as $achievement){
    if($achievement['closed'] == "0"){
        $ach = new Achievement;
        $ach->name = $achievement->name;
        $ach->description = $achievement->description;
        $ach->imageurl = $achievement->iconOpen;
        $ach->imageurlclosed = $achievement->iconClosed;
        $achievements[] = $achievement;
    }
    else{
        // echo "Achievement " . $achievement->name . " already unlocked<br/>";
    }
    $achrand = rand(0, count($achievements) - 1);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achievement Roulette</title>
    <style>
        .achievementicon{
            background: url("<?php echo $achievements[$achrand]->iconOpen; ?>");
            width: 64px;
            height: 64px;
        }
        .achievementicon:hover{
            background: url("<?php echo $achievements[$achrand]->iconClosed; ?>");
            width: 64px;
            height: 64px;
        }
    </style>
</head>
<body>
    <h1>Achievement Roulette</h1>
    <h2><?php echo $xml->game->gameName; ?></h2>
    <hr/>
    <div class="achievementicon"> </div>
    <h2><?php echo $achievements[$achrand]->name;?></h2>
    <h3><?php echo $achievements[$achrand]->description;?></h3>
</body>
</html>