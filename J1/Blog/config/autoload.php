<?php

require "./controllers/AuthController.php";
require "./controllers/PageController.php";
require "./controllers/AdminController.php";

require "./config/Router.php";

require "./models/User.php";
require "./models/Post.php";
require "./models/Category.php";


require "./managers/AbstractManager.php";
require "./managers/UserManager.php";
require "./managers/PostManager.php";
require "./managers/CategoryManager.php";
