# Laravel QueryFilter
A simple & dynamic package for your eloquent query in laravel. It will help 
you to write query logic individual for each parameter.

## Installation
You can start it from composer. Go to your terminal and run this command from your project root directory.

```php
composer require hashemi/queryfilter
```
## Configurations
After complete installation then you have to configure it. First copy these line paste it in ``config/app.php`` where providers array are exists.
```php
Hashemi\QueryFilter\QueryFilterServiceProvider::class
```
Suppose you want use query-filters on `User` model for query. Laravel QueryFilter provide
`Filterable` trait . You need to use it on your model. It will add a scope `filter` on your model. Like,

```php
class User extends Model
{
    // Use Filterable Trait
    // ....
    use \Hashemi\QueryFilter\Filterable;
    // ....
}
```
Now, you need to create your query filter file where you will write sql logic to generate sql by passing parameter. 
You can create your filter file by using command,
```php
php artisan make:filter UserFilter
``` 
This command will create ``Filters`` directory on your ``app/`` directory. So, you can find the file on ``app/Filters/UserFilter.php
``. Every method of filter class, represent your passing parameter key. You need to pass your parameter `snake` case and your method name will be like `apply<ParamterName>Property` format. Property name must be write in `Pascal` case.
```php
class UserFilter extends \Hashemi\QueryFilter\QueryFilter
{
    public function applyIdProperty($id)
    {
        return $this->builder->where('id', '=', $id);
    }

    public function applyNameProperty($name)
    {
        return $this->builder->where('name', 'LIKE', "%$name%");
    }
}
```
After create that file, when you use your model on you controller to query something, you need to use your scope and pass `UserFilter` class as a parameter. You controller will be look like,
```php
class UserController extends Controller
{
    public function index(Request $request, UserFilter $filter)
    {
        $user = User::query()->filter($filter)->get();
        // do whatever
    }
}
``` 
If you want to pass your custom queries on filter, you can also do that in your filter, 
```php
class UserController extends Controller
{
    public function index(Request $request, UserFilter $filter)
    {
        $user = User::query()->filter($filter, [
            'username' => 'ssi-anik'
        ])->get();
        // do whatever
    }
}

```
And on your ``app\Filters\UserFilter.php`` file, you can do something like it,
```php
class UserFilter extends \Hashemi\QueryFilter\QueryFilter
{
    public function applyIdProperty($id)
    {
        return $this->builder->where('id', '=', $id);
    }

    public function applyNameProperty($name)
    {
        return $this->builder->where('name', 'LIKE', "%$name%");
    }
    
    public function applyUsernameProperty($username)
    {
        return $this->builder->where('username', 'LIKE', "%$username%");    
    }

}
```


That's it.

## Contributing
Pull requests are welcome. For any changes, please open an issue first to discuss what you would like to change.