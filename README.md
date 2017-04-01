# WRTestAPI

Introduction
============
This API packages consists of a set of entry points to retrieve data from the WR database about books and categories. The results are returned in JSON format. The first version of the api can be accessed at http://mcharcos.heliohost.org/api/v1/. This document contains information about the API for users and the code for developers. 

API definition
==============

The API allow to retrieve data about books and categories of books. Accessing to the api will require an API key. Although, the implementation is not develop yet and there is no key management the apiKy is required in the call. Thus, a call will look as:

* http://mcharcos.heliohost.org/api/v1/books/list?apiKey=1
or 
* http://mcharcos.heliohost.org/api/v1/books/detailsbyuuid/fab69c13-c538-472c-bc64-5090189d3dc2?apiKey=1

The following entrypoints are available:

* /api/v1/category/list - returns the list of categories that exist in the database
* /api/v1/category/details/[#] - returns the details of a category of id corresponding to the input #
* /api/v1/books/list - returns the list of books that exist in the database
* /api/v1/books/details/[#] - returns the details of the book of id corresponding to the input #
* /api/v1/books/detailsbyuuid/[uuid] - returns the details of the book of uuid corresponding to the input #
* /api/v1/books/categorybyid/[#] - returns the list of books that have the category of id corresponding to the input #
* /api/v1/books/category/[name] - returns the list of books that have the category of name corresponding to the input name

All results are return as a json encoded string. Additionally, specific fields can be requested by adding fields to the URI. For example, 

* http://mcharcos.heliohost.org/api/v1/books/list?apiKey=1&fields=uuid,title

returns the list of uuids and titles of all books in the database. If requested fields are not correct, an error message will be issued and the result won't show for any of the fields. Valid fields are as follow
* category:
  * id
  * iconcolor
  * iconurl
  * name
  * description
  * parent_id
  * listorder
* books
  * id
  * uuid
  * title
  * author
  * language
  * createtime

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
    
    
