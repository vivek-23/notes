* Composer is a dependency management tool for PHP. 
* Structure is as follows:

`
	
    {	
    	 "name":"Name of the author/project name",
         "version":"4.5.2",
	     "require":{
		    "monolog/monolog" : "1.0.*"
		  },
          "require-dev":{
            "phpunit/phpunit" : "2.3.*"
          }
      }
`

* Package names are always(or should at least be) author name / project name. 
* To install all these dependencies, we just do **composer install**.
* This automatically generates a **composer.lock** file which is very useful as we can keep all team members working on the project to use the same version across all git branches. In other words, consistency of versions which are to be used.
* **require-dev** are packages only for development and testing. **composer install** will install all of them though. These aren't meant for production and so can be avoided using **composer install --no-dev** command. 
* When doing a composer install, it creates a **vendor** folder with autoloading files and all dependency packages' code resides in them.
