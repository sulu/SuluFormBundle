<?php

class JMSSerializerAdapter_a5dd94b extends \FOS\RestBundle\Serializer\JMSSerializerAdapter implements \ProxyManager\Proxy\VirtualProxyInterface
{

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $valueHolder7e055 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer1ad21 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties0ebb0 = [
        
    ];

    public function serialize($data, $format, \FOS\RestBundle\Context\Context $context)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'serialize', array('data' => $data, 'format' => $format, 'context' => $context), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->serialize($data, $format, $context);
    }

    public function deserialize($data, $type, $format, \FOS\RestBundle\Context\Context $context)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'deserialize', array('data' => $data, 'type' => $type, 'format' => $format, 'context' => $context), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->deserialize($data, $type, $format, $context);
    }

    /**
     * Constructor for lazy initialization
     *
     * @param \Closure|null $initializer
     */
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;

        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance = $reflection->newInstanceWithoutConstructor();

        \Closure::bind(function (\FOS\RestBundle\Serializer\JMSSerializerAdapter $instance) {
            unset($instance->serializer, $instance->serializationContextFactory, $instance->deserializationContextFactory);
        }, $instance, 'FOS\\RestBundle\\Serializer\\JMSSerializerAdapter')->__invoke($instance);

        $instance->initializer1ad21 = $initializer;

        return $instance;
    }

    public function __construct(\JMS\Serializer\SerializerInterface $serializer, ?\JMS\Serializer\ContextFactory\SerializationContextFactoryInterface $serializationContextFactory = null, ?\JMS\Serializer\ContextFactory\DeserializationContextFactoryInterface $deserializationContextFactory = null)
    {
        static $reflection;

        if (! $this->valueHolder7e055) {
            $reflection = $reflection ?? new \ReflectionClass('FOS\\RestBundle\\Serializer\\JMSSerializerAdapter');
            $this->valueHolder7e055 = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\FOS\RestBundle\Serializer\JMSSerializerAdapter $instance) {
            unset($instance->serializer, $instance->serializationContextFactory, $instance->deserializationContextFactory);
        }, $this, 'FOS\\RestBundle\\Serializer\\JMSSerializerAdapter')->__invoke($this);

        }

        $this->valueHolder7e055->__construct($serializer, $serializationContextFactory, $deserializationContextFactory);
    }

    public function & __get($name)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, '__get', ['name' => $name], $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        if (isset(self::$publicProperties0ebb0[$name])) {
            return $this->valueHolder7e055->$name;
        }

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder7e055;

            $backtrace = debug_backtrace(false);
            trigger_error(
                sprintf(
                    'Undefined property: %s::$%s in %s on line %s',
                    get_parent_class($this),
                    $name,
                    $backtrace[0]['file'],
                    $backtrace[0]['line']
                ),
                \E_USER_NOTICE
            );
            return $targetObject->$name;
            return;
        }

        $targetObject = $this->valueHolder7e055;
        $accessor = function & () use ($targetObject, $name) {
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __set($name, $value)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder7e055;

            return $targetObject->$name = $value;
            return;
        }

        $targetObject = $this->valueHolder7e055;
        $accessor = function & () use ($targetObject, $name, $value) {
            return $targetObject->$name = $value;
        };
        $backtrace = debug_backtrace(true);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __isset($name)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, '__isset', array('name' => $name), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder7e055;

            return isset($targetObject->$name);
            return;
        }

        $targetObject = $this->valueHolder7e055;
        $accessor = function () use ($targetObject, $name) {
            return isset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __unset($name)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, '__unset', array('name' => $name), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder7e055;

            unset($targetObject->$name);
            return;
        }

        $targetObject = $this->valueHolder7e055;
        $accessor = function () use ($targetObject, $name) {
            unset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __clone()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, '__clone', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        $this->valueHolder7e055 = clone $this->valueHolder7e055;
    }

    public function __sleep()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, '__sleep', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return array('valueHolder7e055');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\FOS\RestBundle\Serializer\JMSSerializerAdapter $instance) {
            unset($instance->serializer, $instance->serializationContextFactory, $instance->deserializationContextFactory);
        }, $this, 'FOS\\RestBundle\\Serializer\\JMSSerializerAdapter')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null)
    {
        $this->initializer1ad21 = $initializer;
    }

    public function getProxyInitializer()
    {
        return $this->initializer1ad21;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'initializeProxy', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder7e055;
    }

    public function getWrappedValueHolderValue() : ?object
    {
        return $this->valueHolder7e055;
    }


}
