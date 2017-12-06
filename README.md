# FITTYPET API

Introduction
============
This API packages consists of a set of entry points to retrieve data from the Fittypet database about books, users,... The results are returned in JSON format. 

API definition
==============


Developers
==========

The code tree is as follow:

* **/** - main entry point
  * /.htaccess - handles the requests to resources in the directory. It will call api.php to handle the api.
* **/api** - directory containing all the code and entry points for the api
  * /api/index.php - default welcome page (uses valid_api_msg.php)
  * /api/valid_api_msg.php - page showing basic message on available api
  * **/api/config** - contains configuration files
    * /api/config/.htaccess - restrict access to this directory
    * /api/config/db.conf - contains information about configuration (plain text but ideally should be encrypted)
  * **/api/lib** - Common classes to be used in API
    * /api/lib/.htacces - restricts access to this directory
    * /api/lib/API.class.php - abstract class wrapping the custom endpoints
    * /api/lib/APIKey.class.php - class managing the user keys since there is no client info store in server. A dummy class in this context to be honest since it will always return true as long as the apiKey is used
    * /api/lib/Books.class.php - Class managing the calls for the API related to the book search
    * /api/lib/Category.class.php - Class managing the calls for the API related to the category search
    * /api/lib/DB.class.php - Class managing the access to the database
  * **/api/v1** - Directory containing the class for the version v1 of the API
    * /api/v1/api.php - Script managing the requests from the user
    * /api/v1/index.php - Page handling the access to the top directory by the user. It refers to the available API-v1
    * /api/WRAPI.php - The meat of the whole package, it contains all the reference to the function in the various classes and interface between the user calls and the searches.
    
    
