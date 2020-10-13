## Book API: Laravel 7.24 based Book API with the front end created with Vue.js

## How to install
* Clone the repository with git clone 
* Copy .env.example file to .env and edit database credentials there (Rename .env.example to .env) 
* Configure the new .env file like this 
    + DB_DATABASE=books_api
    + DB_USERNAME=root
    + DB_PASSWORD= 
* Run "composer install" 
* Run "php artisan key:generate" 
* Run "php artisan migrate --seed" or "php artisan db:seed" (it has some seeded data for testing) 
* For the front end install npm by running npm install, after that run "npm run dev" or "npm run wacth" to compile the components to Javascript 

+ Front end Url http://test-book-api.herokuapp.com/ - (Not Https://)

# Book API Endpoints
## The application is hosted on heroku, the endpoints are below
* External Book endpoint http://127.0.0.1:8000/api/v1/external-books?name={nameOfBook} or <br>
   + http://test-book-api.herokuapp.com/api/v1/external-books?name={nameOfBook} - GET Request <br>
    Note: NameOfBook is not case sensitive and does not respective spaces as well
* Create Book endpoint http://127.0.0.1:8000/api/v1/books/ or <br>
   + http://test-book-api.herokuapp.com/api/v1/books/ - POST Mthod<br>
* Get List of books http://127.0.0.1:8000/api/v1/books  or <br>
   + http://test-book-api.herokuapp.com/api/v1/books - GET Method<br>
* Update Book http://127.0.0.1:8000/api/v1/books/{id} or <br>
   + http://test-book-api.herokuapp.com/api/v1/books/{id} - PUT Method <br>
* Delete Book http://127.0.0.1:8000/api/v1/books/{id} - or <br>
    + http://test-book-api.herokuapp.com/api/v1/books/{id} - DELETE Method <br>
* Show a Book http://127.0.0.1:8000/api/v1/books/{id} - GET Method <br>
   + http://test-book-api.herokuapp.com/api/v1/books/{id} - GET Method <br>
* Search List of books http://127.0.0.1:8000/api/v1/search?query={query} -GET Method <br>
   + http://test-book-api.herokuapp.com/api/v1/search?query={query} - Get Method <br>

# Testing The Application
## Testing of the application is done with Laravel PHPunit
* General testing of the application can be done by running this command: <br>
    + vendor\bin\phpunit tests\Feature\BookApiTest.php <br>
* Testing each of the features can be done by running the below command <br>
    + * External book API <br>
        + vendor\bin\phpunit --filter test_external_book <br>
        + Please connect to the internet since is external API for the this test not to fail
    + * Read API <br>
        + vendor\bin\phpunit --filter test_index_book <br>
    + * Create API <br>
        + vendor\bin\phpunit --filter test_create_book <br>
    + * Update API <br>
        + vendor\bin\phpunit --filter test_update_book <br>
    + * Show Book API <br>
        + vendor\bin\phpunit --filter test_show_book <br>
    + * 404 error for book not found <br>
        + vendor\bin\phpunit --filter test_404_if_book_not_found <br>
    + * Delete Book API <br>
        + vendor\bin\phpunit --filter test_delete_book <br>
    + * Edit Book API <br>
        + vendor\bin\phpunit --filter test_edit_book <br>

If the test is ran successfully without an error, it will look below

![alt text](https://i.ibb.co/wW3XY7K/Screenshot-355.png)

