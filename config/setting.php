<?php 

$settingJson = storage_path('app/settings.json');
$settingFgc = json_decode(file_get_contents($settingJson), true);

return $settingFgc;