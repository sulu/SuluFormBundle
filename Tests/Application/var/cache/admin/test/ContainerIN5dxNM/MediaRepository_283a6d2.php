<?php

class MediaRepository_283a6d2 extends \Sulu\Bundle\MediaBundle\Entity\MediaRepository implements \ProxyManager\Proxy\VirtualProxyInterface
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

    public function findMediaById($id, $asArray = false)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'findMediaById', array('id' => $id, 'asArray' => $asArray), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->findMediaById($id, $asArray);
    }

    public function findMediaByIdForRendering($id, $formatKey)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'findMediaByIdForRendering', array('id' => $id, 'formatKey' => $formatKey), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->findMediaByIdForRendering($id, $formatKey);
    }

    public function findMedia($filter = [], $limit = null, $offset = null, ?\Sulu\Component\Security\Authentication\UserInterface $user = null, $permission = null)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'findMedia', array('filter' => $filter, 'limit' => $limit, 'offset' => $offset, 'user' => $user, 'permission' => $permission), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->findMedia($filter, $limit, $offset, $user, $permission);
    }

    public function findMediaDisplayInfo($ids, $locale)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'findMediaDisplayInfo', array('ids' => $ids, 'locale' => $locale), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->findMediaDisplayInfo($ids, $locale);
    }

    public function count(array $filter)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'count', array('filter' => $filter), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->count($filter);
    }

    public function findMediaWithFilenameInCollectionWithId($filename, $collectionId)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'findMediaWithFilenameInCollectionWithId', array('filename' => $filename, 'collectionId' => $collectionId), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->findMediaWithFilenameInCollectionWithId($filename, $collectionId);
    }

    public function findMediaByCollectionId($collectionId, $limit, $offset)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'findMediaByCollectionId', array('collectionId' => $collectionId, 'limit' => $limit, 'offset' => $offset), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->findMediaByCollectionId($collectionId, $limit, $offset);
    }

    public function createNew()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'createNew', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->createNew();
    }

    public function createQueryBuilder($alias, $indexBy = null)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'createQueryBuilder', array('alias' => $alias, 'indexBy' => $indexBy), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->createQueryBuilder($alias, $indexBy);
    }

    public function createResultSetMappingBuilder($alias)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'createResultSetMappingBuilder', array('alias' => $alias), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->createResultSetMappingBuilder($alias);
    }

    public function createNamedQuery($queryName)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'createNamedQuery', array('queryName' => $queryName), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->createNamedQuery($queryName);
    }

    public function createNativeNamedQuery($queryName)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'createNativeNamedQuery', array('queryName' => $queryName), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->createNativeNamedQuery($queryName);
    }

    public function clear()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'clear', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->clear();
    }

    public function find($id, $lockMode = null, $lockVersion = null)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'find', array('id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->find($id, $lockMode, $lockVersion);
    }

    public function findAll()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'findAll', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->findAll();
    }

    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'findBy', array('criteria' => $criteria, 'orderBy' => $orderBy, 'limit' => $limit, 'offset' => $offset), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->findBy($criteria, $orderBy, $limit, $offset);
    }

    public function findOneBy(array $criteria, ?array $orderBy = null)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'findOneBy', array('criteria' => $criteria, 'orderBy' => $orderBy), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->findOneBy($criteria, $orderBy);
    }

    public function __call($method, $arguments)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, '__call', array('method' => $method, 'arguments' => $arguments), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->__call($method, $arguments);
    }

    public function getClassName()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getClassName', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getClassName();
    }

    public function matching(\Doctrine\Common\Collections\Criteria $criteria)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'matching', array('criteria' => $criteria), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->matching($criteria);
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

        unset($instance->_entityName, $instance->_em, $instance->_class);

        $instance->initializer1ad21 = $initializer;

        return $instance;
    }

    public function __construct(\Doctrine\ORM\EntityManagerInterface $em, \Doctrine\ORM\Mapping\ClassMetadata $class)
    {
        static $reflection;

        if (! $this->valueHolder7e055) {
            $reflection = $reflection ?? new \ReflectionClass('Sulu\\Bundle\\MediaBundle\\Entity\\MediaRepository');
            $this->valueHolder7e055 = $reflection->newInstanceWithoutConstructor();
        unset($this->_entityName, $this->_em, $this->_class);

        }

        $this->valueHolder7e055->__construct($em, $class);
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
        unset($this->_entityName, $this->_em, $this->_class);
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
