<?php

require "./config/Router.php";

require "./controllers/PageController.php";
require "./controllers/PlayerController.php";
require "./controllers/TeamController.php";
require "./controllers/MatchController.php";

require "./models/Player.php";
require "./models/Team.php";
require "./models/Performance.php";
require "./models/Media.php";
require "./models/Game.php";

require "./managers/AbstractManager.php";
require "./managers/PlayerManager.php";
require "./managers/MatchManager.php";
require "./managers/TeamManager.php";
