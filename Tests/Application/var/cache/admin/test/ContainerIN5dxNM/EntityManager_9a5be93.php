<?php

class EntityManager_9a5be93 extends \Doctrine\ORM\EntityManager implements \ProxyManager\Proxy\VirtualProxyInterface
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

    public function getConnection()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getConnection', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getConnection();
    }

    public function getMetadataFactory()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getMetadataFactory', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getMetadataFactory();
    }

    public function getExpressionBuilder()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getExpressionBuilder', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getExpressionBuilder();
    }

    public function beginTransaction()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'beginTransaction', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->beginTransaction();
    }

    public function getCache()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getCache', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getCache();
    }

    public function transactional($func)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'transactional', array('func' => $func), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->transactional($func);
    }

    public function commit()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'commit', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->commit();
    }

    public function rollback()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'rollback', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->rollback();
    }

    public function getClassMetadata($className)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getClassMetadata', array('className' => $className), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getClassMetadata($className);
    }

    public function createQuery($dql = '')
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'createQuery', array('dql' => $dql), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->createQuery($dql);
    }

    public function createNamedQuery($name)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'createNamedQuery', array('name' => $name), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->createNamedQuery($name);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'createNativeQuery', array('sql' => $sql, 'rsm' => $rsm), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->createNativeQuery($sql, $rsm);
    }

    public function createNamedNativeQuery($name)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'createNamedNativeQuery', array('name' => $name), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->createNamedNativeQuery($name);
    }

    public function createQueryBuilder()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'createQueryBuilder', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->createQueryBuilder();
    }

    public function flush($entity = null)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'flush', array('entity' => $entity), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->flush($entity);
    }

    public function find($entityName, $id, $lockMode = null, $lockVersion = null)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'find', array('entityName' => $entityName, 'id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->find($entityName, $id, $lockMode, $lockVersion);
    }

    public function getReference($entityName, $id)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getReference', array('entityName' => $entityName, 'id' => $id), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getReference($entityName, $id);
    }

    public function getPartialReference($entityName, $identifier)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getPartialReference', array('entityName' => $entityName, 'identifier' => $identifier), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getPartialReference($entityName, $identifier);
    }

    public function clear($entityName = null)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'clear', array('entityName' => $entityName), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->clear($entityName);
    }

    public function close()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'close', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->close();
    }

    public function persist($entity)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'persist', array('entity' => $entity), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->persist($entity);
    }

    public function remove($entity)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'remove', array('entity' => $entity), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->remove($entity);
    }

    public function refresh($entity)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'refresh', array('entity' => $entity), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->refresh($entity);
    }

    public function detach($entity)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'detach', array('entity' => $entity), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->detach($entity);
    }

    public function merge($entity)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'merge', array('entity' => $entity), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->merge($entity);
    }

    public function copy($entity, $deep = false)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'copy', array('entity' => $entity, 'deep' => $deep), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->copy($entity, $deep);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'lock', array('entity' => $entity, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->lock($entity, $lockMode, $lockVersion);
    }

    public function getRepository($entityName)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getRepository', array('entityName' => $entityName), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getRepository($entityName);
    }

    public function contains($entity)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'contains', array('entity' => $entity), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->contains($entity);
    }

    public function getEventManager()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getEventManager', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getEventManager();
    }

    public function getConfiguration()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getConfiguration', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getConfiguration();
    }

    public function isOpen()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'isOpen', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->isOpen();
    }

    public function getUnitOfWork()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getUnitOfWork', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getUnitOfWork();
    }

    public function getHydrator($hydrationMode)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getHydrator', array('hydrationMode' => $hydrationMode), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getHydrator($hydrationMode);
    }

    public function newHydrator($hydrationMode)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'newHydrator', array('hydrationMode' => $hydrationMode), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->newHydrator($hydrationMode);
    }

    public function getProxyFactory()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getProxyFactory', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getProxyFactory();
    }

    public function initializeObject($obj)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'initializeObject', array('obj' => $obj), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->initializeObject($obj);
    }

    public function getFilters()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getFilters', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getFilters();
    }

    public function isFiltersStateClean()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'isFiltersStateClean', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->isFiltersStateClean();
    }

    public function hasFilters()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'hasFilters', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->hasFilters();
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

        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $instance, 'Doctrine\\ORM\\EntityManager')->__invoke($instance);

        $instance->initializer1ad21 = $initializer;

        return $instance;
    }

    protected function __construct(\Doctrine\DBAL\Connection $conn, \Doctrine\ORM\Configuration $config, \Doctrine\Common\EventManager $eventManager)
    {
        static $reflection;

        if (! $this->valueHolder7e055) {
            $reflection = $reflection ?? new \ReflectionClass('Doctrine\\ORM\\EntityManager');
            $this->valueHolder7e055 = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);

        }

        $this->valueHolder7e055->__construct($conn, $config, $eventManager);
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
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);
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
