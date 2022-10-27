<?php
	session_start();
	include('./lib/initialization.php');
	Initialization::_main();
	
	include('./lib/handlerDirectory.php');
	include('./lib/userInterface.php');
	include('./lib/handlerFile.php');

	$handlerDirectory = new HandlerDirectory();
	$userInterface = new UserInterface();
	$handlerFile = new HandlerFile();	
	
	if(isset($_SESSION["user"])){	
		if(isset($_GET['dwld']))
			$handlerFile->downloadFile(".".$_GET['dwld']);

		if(isset($_GET['cDir']))
			$handlerDirectory->createDirectory($_GET['link'], $_GET['cDir']);

		if(isset($_GET['cFile']))
			$handlerFile->createFile($_GET['link'], $_GET['cFile']);

		if(isset($_GET['dFileName']))
			$handlerFile->deleteFile($_GET['link'], $_GET['dFileName']);

		if(isset($_GET['dDirName']))
			$handlerDirectory->deleteDirectory($_GET['link'], $_GET['dDirName']);

		if(isset($_GET['dwldDirName']))
			$handlerFile->directoryToZip($_GET['link'], $_GET['dwldDirName']);

		if(isset($_FILES['uploadFile']))
			$handlerFile->uploadFile($_FILES, $_GET["uploadFile"]);
        
        if(isset($_POST['sFile']))
			$handlerFile->saveFile($_POST['link'], $_POST['sFile'], $_POST['text']);

		if(!isset($_GET["link"]))
			$_GET["link"]="";
	}
	
	include('./configuration.php');
	
	if(isset($_POST["userName"]))
		if($_POST["userName"]==$configuration["login"])
			if($_POST["password"]==$configuration["pwd"])
				$_SESSION["user"]=true;
?>
<head>
	<title id="title"><?php $configuration["title"];?></title>
	<link rel="stylesheet" href="./css/index.css" type="text/css"/>
	<script src="./js/index.js"></script>
</head>
<body>
<?php


		

    if(isset($_SESSION["user"])){
		echo $userInterface->editor();
		echo $userInterface->explorer($_GET["link"]);
		echo $userInterface->uploadFile($_GET["link"]);
	}else{
		echo $userInterface->login();
	}

?>
</body>