# Collection

The `Base\Support\Collection` class provides a convenient way to work with a **collection of arrays**.

[Learn More](README.md) about using the Base Support within your project.


## Creating Collections

Creating a collection is very simple and easy. First you define the new collection class, and then you inject the array into the class construct (as shown below).

```php
// simple collection
$collection = new Collection([1,2,3,4,5,6]);

// collection with all your products
$collection = new Collection([
    ['category' => 'furniture', 'product' => 'Chair'],
    ['category' => 'software', 'product' => 'Atom'],
    ['category' => 'furniture', 'product' => 'Desk']
]);
```
