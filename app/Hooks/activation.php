<?php 

use App\Migrations\FileMigration;

register_activation_hook(LOGISTICS_PLUGIN_FILE, function(){
    (new FileMigration())->up();
});