# Laravel QueryFilter
A simple & dynamic package for your eloquent query in laravel. It will help 
you to write query logic individual for each parameter.

## Installation
You can start it from composer. Go to your terminal and run this command from your project root directory.

```php
composer require hashemi/queryfilter
```

- If you're using Laravel, then Laravel will automatically discover the package. In case it doesn't discover the package then add the following provider in your `config/app.php`'s **providers** array.
```php
Hashemi\QueryFilter\QueryFilterServiceProvider::class
```

- If you're using Lumen, then you'll have to add the following snippet in your `bootstrap/app.php` file.
```php
$app->register(Hashemi\QueryFilter\QueryFilterServiceProvider::class)
```

## Usage
Suppose you want use query-filters on `User` model for query. Laravel QueryFilter provide `Filterable` trait . You need to use it on your model. It will add a scope `filter` on your model. Like,

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

This command will create `Filters` directory on your `app/` directory. So, you can find the file on `app/Filters/UserFilter.php`. Every method of filter class, represent your passing parameter key. You need to pass your parameter `snake` case and your method name will be like `apply<ParamterName>Property` format. Property name must be write in `Pascal` case.

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
And on your `app\Filters\UserFilter.php` file, you can do something like it,

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

## Convention
- Your `*Filter` class should have methods in `apply*Property` format. Where the `*` will be replaced by the StudlyCase Property names. So, if your field name is `first_name`, then the method name should be `applyFirstNameProperty()`.
- If you're passing an extra data to the Model's filter scope like `Model::filter($filter, ['id' => 4])`, then the provided array will take precedence over the request's data.

## Caveat
If your **request** & **provided array** to the `filter` scope cannot find any suitable method, then it'll return the whole table data as `select * from your_table`. Be aware of this issue.

## Contributing
Pull requests are welcome. For any changes, please open an issue first to discuss what you would like to change.