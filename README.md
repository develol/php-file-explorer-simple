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
