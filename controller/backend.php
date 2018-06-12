<?php

// Chargement des classes du model
require_once('model/PostsManager.php');
require_once('model/CommentsManager.php');
require_once('model/UsersManager.php');


function adminHome()
	{
		require('view/backend/homeAdminView.php');
	}
?>