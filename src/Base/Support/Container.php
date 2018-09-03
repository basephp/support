<?php

namespace Base\Support;

use Closure;

class Container
{

    /**
     * The current globally available container (if any).
     *
     * @var static
     */
    protected static $instance;

    /**
     * The container's shared instances.
     *
     * @var array
     */
    protected $instances = [];

    /**
     * The registered type aliases.
     *
     * @var array
     */
    protected $aliases = [];

    /**
     * The resolved instances
     *
     * @var array
     */
    protected $resolved = [];


    /**
     * Get the resolved instances
     *
     * @return array
     */
    public function getResolved()
    {
        return $this->resolved;
    }

    /**
     * Get all active instances
     *
     * @return array
     */
    public function getInstances()
    {
        return $this->instances;
    }

    /**
     * Determine if a given string is an alias.
     *
     * @param  string  $name
     * @return bool
     */
    public function isAlias($handle)
    {
        return isset($this->aliases[$handle]);
    }

    /**
     * Get an alias
     *
     * @param  string  $name
     * @return string
     *
     */
    public function getAlias($alias)
    {
        if ($this->isAlias($alias)) {
            return $this->aliases[$alias];
        }

        return $alias;
    }

    /**
     * Set alias
     *
     * @param  mixed  $alias
     *
     */
    public function setAlias($alias)
    {
        $alias = (array) $alias;

        $this->aliases = array_merge($this->aliases, $alias);

        return $this;
    }

    /**
     * Check if the instance exist
     *
     * @param  string  $id
     *
     */
    public function has($handle)
    {
        $namespace = $this->getAlias($handle);

        return isset($this->instances[$namespace]);
    }

    /**
     * Get the instance if exist
     *
     * @param  string  $id
     *
     */
    public function get($handle)
    {
        if ($this->has($handle)) {
            return $this->resolve($handle);
        }

        return null;
    }

    /**
     * Resolve the given type from the container.
     *
     * @param  string  $abstract
     * @param  array  $parameters
     * @return mixed
     */
    public function make($handle, array $parameters = [])
    {
        return $this->resolve($handle, $parameters);
    }

    /**
     * Resolve the given type from the container.
     *
     * @param  string  $abstract
     * @param  array  $parameters
     * @return mixed
     */
    protected function resolve($handle, $parameters = [])
    {
        // holding off on the closure at this time.
        // I dont think its worth the memory consumption
        // if ($handle instanceof Closure) {
            // return $handle($this);
        // }

        $namespace = $this->getAlias($handle);

        // If an instance of the type is currently being managed as a singleton we'll
        // just return an existing instance instead of instantiating new instances
        // so the developer can keep using the same objects instance every time.
        if (isset($this->instances[$namespace])) {
            return $this->instances[$namespace];
        }

        if (!empty($parameters)) {
            $obj = new $namespace(...$parameters);
        } else {
            $obj = new $namespace;
        }

        $this->resolved[] = $namespace;

        return $this->instances[$namespace] = $obj;
    }

    /**
     * Remove a resolved instance from the instance cache.
     *
     * @param  string  $abstract
     * @return void
     */
    public function forgetInstance($handle)
    {
        $namespace = $this->getAlias($handle);

        unset($this->instances[$namespace]);

        $resolvedKey = array_search($namespace, $this->resolved);

        unset($this->resolved[$resolvedKey]);
    }

    /**
     * Clear all of the instances from the container.
     *
     * @return void
     */
    public function forgetInstances()
    {
        $this->instances = [];
        $this->resolved = [];
    }

    /**
     * Set the globally available instance of the container.
     *
     * @return static
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

}
