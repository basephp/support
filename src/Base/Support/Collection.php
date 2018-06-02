<?php

namespace Base\Support;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;

use Base\Support\Arr;

/**
* The collection repository.
* A re-usable class to hold a collection of items.
*
*/
class Collection implements ArrayAccess, IteratorAggregate
{

    /**
    * All of the items in collection
    *
    * @var array
    */
    protected $items = [];


    /**
    * Create a new collection repository.
    *
    * @param  array  $items
    * @return void
    */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }


    /**
    * Get all items in collection
    *
    * @return array
    */
    public function all()
    {
        return $this->items;
    }


    /**
    * Returns true if the parameter is defined.
    *
    * @param string $key The key
    *
    * @return bool true if the parameter exists, false otherwise
    */
    public function has($key)
    {
        $keys = is_array($key) ? $key : func_get_args();

        foreach ($keys as $value) {
            if (! $this->offsetExists($value)) {
                return false;
            }
        }

        return true;
    }


    /**
    * Get the specified configuration value.
    *
    * @param  array|string  $key
    * @param  mixed   $default
    * @return mixed
    */
    public function get($key, $default = null)
    {
        if (is_array($key)) {
            return $this->getMany($key);
        }

        return Arr::get($this->items, $key, $default);
    }


    /**
    * Get many configuration values.
    *
    * @param  array  $keys
    * @return array
    */
    public function getMany($keys)
    {
        $config = [];

        foreach ($keys as $key => $default)
        {
            if (is_numeric($key)) {
                list($key, $default) = [$default, null];
            }

            $config[$key] = Arr::get($this->items, $key, $default);
        }

        return $config;
    }


    /**
    * Set a given value into the collection
    *
    * @param  array|string  $key
    * @param  mixed   $value
    * @return void
    */
    public function set($key, $value = null)
    {
        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $key => $value)
        {
            $this->items[$key] = $value;
        }
    }


    /**
     * Get the first item from the collection.
     *
     * @param  callable|null  $callback
     * @param  mixed  $default
     * @return mixed
     */
    public function first(callable $callback = null, $default = null)
    {
        return Arr::first($this->items, $callback, $default);
    }


    /**
     * Get the last item from the collection.
     *
     * @param  callable|null  $callback
     * @param  mixed  $default
     * @return mixed
     */
    public function last(callable $callback = null, $default = null)
    {
        return Arr::last($this->items, $callback, $default);
    }


    /**
     * Shuffle the items in the collection.
     *
     * @param  int  $seed
     * @return static
     */
    public function shuffle($seed = null)
    {
        $items = $this->items;

        if (is_null($seed))
        {
            shuffle($items);
        }
        else
        {
            srand($seed);

            usort($items, function () {
                return rand(-1, 1);
            });
        }

        return new static($items);
    }


    /**
     * Slice the underlying collection array.
     *
     * @param  int  $offset
     * @param  int  $length
     * @return static
     */
    public function slice($offset, $length = null)
    {
        return new static(array_slice($this->items, $offset, $length, true));
    }


    /**
     * Get and remove the first item from the collection.
     *
     * @return mixed
     */
    public function shift()
    {
        return array_shift($this->items);
    }


    /**
     * Reverse items order.
     *
     * @return static
     */
    public function reverse()
    {
        return new static(array_reverse($this->items, true));
    }


    /**
    * Removes a item.
    *
    * @param string $key The key
    */
    public function remove($key)
    {
        unset($this->items[$key]);
    }


    /**
    * Returns the number of items.
    *
    * @return int The number of items
    */
    public function count()
    {
        return count($this->items);
    }


    /**
     * Take the first or last {$limit} items.
     *
     * @param  int  $limit
     * @return static
     */
    public function take($limit)
    {
        if ($limit < 0) {
            return $this->slice($limit, abs($limit));
        }

        return $this->slice(0, $limit);
    }


    /**
     * Search the collection for a given value and return the corresponding key if successful.
     *
     * @param  mixed  $value
     * @param  bool  $strict
     * @return mixed
     */
    public function search($value, $strict = false)
    {
        return array_search($value, $this->items, $strict);
    }


    /**
     * Concatenate values of a given key as a string.
     *
     * @param  string  $value
     * @param  string  $glue
     * @return string
     */
    public function implode($value, $glue = null)
    {
        $first = $this->first();

        if (is_array($first) || is_object($first)) {
            return implode($glue, $this->pluck($value)->all());
        }

        return implode($value, $this->items);
    }


    /**
     * Get the keys of the collection items.
     *
     * @return static
     */
    public function keys()
    {
        return new static(array_keys($this->items));
    }


    /**
     * Run a map over each of the items.
     *
     * @param  callable  $callback
     * @return static
     */
    public function map(callable $callback)
    {
        $keys = array_keys($this->items);

        $items = array_map($callback, $this->items, $keys);

        return new static(array_combine($keys, $items));
    }


    /**
     * Get the values of a given key.
     *
     * @param  string|array  $value
     * @param  string|null  $key
     * @return static
     */
    public function pluck($value, $key = null)
    {
        return new static(Arr::pluck($this->items, $value, $key));
    }


    /**
     * Get an iterator for the items.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }


    /**
     * Determine if an item exists at an offset.
     *
     * @param  mixed  $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->items);
    }


    /**
     * Get an item at a given offset.
     *
     * @param  mixed  $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->items[$key];
    }

    /**
     * Set the item at a given offset.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        if (is_null($key)) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }
    }

    /**
     * Unset the item at a given offset.
     *
     * @param  string  $key
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }


    /**
     * Get the collection of items as a plain array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_map(function ($value) {
            return $value;
        }, $this->items);
    }


    /**
     * Get the collection of items as JSON.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->items, $options);
    }


    /**
    * If the collection is seen as a string, send it as json
    *
    * @return string JSON formatted
    */
    public function __toString()
    {
        return $this->toJson();
    }


}
