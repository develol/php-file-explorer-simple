# php-file-explorer-simple
[PHP] Simple explorer with simple authorization

***PHP v7.2+***

## Getting started
1. Cloning this repository
2. Launch **index.php** file for initialization
3. Update **configuration.php** file
```php
<?php
  $configuration=[
    "login" => "<value>", // User name for authorization
    "pwd"   => "<value>", // Password for authorization
    "title" => "<value>"  // Text in the <title> of the page
  ];
?>              
```

## Overview of functions
- Authorization
  - Creating a file and Upload file
    - Open in file editor
    - Open in browser
    - Deleting a file
    - Downloading files
  - Creating a directory
    - Open in explorer
    - Open in browser
    - Deleting a directory
    - Downloading directory
    
## File structure
```
/ ............................ Root
├─ index.php ................. Main PHP file
├─ configuration.php ......... File with configuration
├─ css ....................... Folder with CSS files
│  └─ index.css .............. Main CSS file
├─ js ........................ Folder with JavaScript files
│  └─ index.css .............. Main JS file
├─ lib ....................... Folder with PHP classes
│  ├─ handlerDirectory.php ... File with a class for working with directories
│  ├─ handlerFile.php ........ File with a class for working with files
│  ├─ initialization.php ..... File with class for first initialization
│  └─ userInterface.php ...... File with a class for working with users components
├─ temp ...................... Folder with temporary files
│  └─ .
└─ dir ....................... Folder with explorer files and folders
   └─ . 
```
