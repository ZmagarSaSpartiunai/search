## Deployment of the project
The project was deployed using the standard laravel solution on Linux with Docker Compose: [Laravel Sail](https://laravel.com/docs/10.x/installation#getting-started-on-linux)
## Installing Composer Dependencies
```
docker run --rm \
-u "$(id -u):$(id -g)" \
-v "$(pwd):/var/www/html" \
-w /var/www/html \
laravelsail/php82-composer:latest \
composer install --ignore-platform-reqs
```
[Installing Composer Dependencies For Existing Applications](https://laravel.com/docs/10.x/sail#installing-composer-dependencies-for-existing-projects)
## Example request

curl --location --request GET 'http://localhost/api/tasks?filters%5Bstatus%5D%5Boperator%5D=is&filters%5Bstatus%5D%5Bvalue%5D=in_progress&filters%5Bstatus%5D%5Bboolean%5D=or&filters%5Bestimate%5D%5Boperator%5D=in&filters%5Bestimate%5D%5Bvalue%5D=1,2&filters%5Bestimate%5D%5Bboolean%5D=and&filters%5Bcontent%5D%5Boperator%5D=contains&filters%5Bcontent%5D%5Bvalue%5D=libero'

# Filters Structure

The filters structure is represented as an associative array with the key 'filters', containing an array of conditions.

```php
$filters = [    
    'status' => [
        'operator' => 'is',
        'value' => 'in_progress',
        'boolean' => 'or',
    ],
    'content' => [
        'operator' => 'contains',
        'value' => 'fox',
        'boolean' => 'and',
    ],
    'estimate' => [
        'operator' => 'in',
        'value' => '1,2',
        'boolean' => 'or',
    ],
    // Add more conditions as needed    
];
```


## Logic of params in request
All params are optional. 
Each field support the following search conditions(operator):
* is (equals) - default if the parameter 'operator' is missing
* not (not equals)
* in (is any of)
* contains
* does_not_contain

If the parameter 'boolean' is missing - 'and' is default.
If the parameter 'value' is missing - the filter does not participate in the formation of query.

## Examples of queries that can be generated
1. select * from `tasks` where `status` != 'in_progress' **and** `content` LIKE '%aut libero%' **and** `estimate` in ('1', '2')
2. select * from `tasks` where `status` = 'in_progress' **and** (`content` LIKE '%aut libero%' **or** `estimate` in ('1', '2'))
3. select * from `tasks` where `status` != 'in_progress' **or** `content` NOT LIKE '%aut libero%' **or** `estimate` in ('1', '2')
4. select * from `tasks` where `status` = 'in_progress' **and** `content` LIKE '%aut libero%' **or** (`estimate` in ('1', '2'))
