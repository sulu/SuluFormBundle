<?php

class CategoryRepository_9c346ab extends \Sulu\Bundle\CategoryBundle\Entity\CategoryRepository implements \ProxyManager\Proxy\VirtualProxyInterface
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

    public function createNew()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'createNew', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->createNew();
    }

    public function isCategoryId($id)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'isCategoryId', array('id' => $id), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->isCategoryId($id);
    }

    public function isCategoryKey($key)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'isCategoryKey', array('key' => $key), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->isCategoryKey($key);
    }

    public function findCategoryById($id)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'findCategoryById', array('id' => $id), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->findCategoryById($id);
    }

    public function findCategoryByKey($key)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'findCategoryByKey', array('key' => $key), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->findCategoryByKey($key);
    }

    public function findCategoriesByIds(array $ids)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'findCategoriesByIds', array('ids' => $ids), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->findCategoriesByIds($ids);
    }

    public function findChildrenCategoriesByParentId($parentId = null)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'findChildrenCategoriesByParentId', array('parentId' => $parentId), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->findChildrenCategoriesByParentId($parentId);
    }

    public function findChildrenCategoriesByParentKey($parentKey = null)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'findChildrenCategoriesByParentKey', array('parentKey' => $parentKey), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->findChildrenCategoriesByParentKey($parentKey);
    }

    public function findCategoryIdsBetween($fromIds, $toIds)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'findCategoryIdsBetween', array('fromIds' => $fromIds, 'toIds' => $toIds), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->findCategoryIdsBetween($fromIds, $toIds);
    }

    public function findCategoryByIds(array $ids)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'findCategoryByIds', array('ids' => $ids), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->findCategoryByIds($ids);
    }

    public function findCategories($parent = null, $depth = null, $sortBy = null, $sortOrder = null)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'findCategories', array('parent' => $parent, 'depth' => $depth, 'sortBy' => $sortBy, 'sortOrder' => $sortOrder), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->findCategories($parent, $depth, $sortBy, $sortOrder);
    }

    public function findChildren($key, $sortBy = null, $sortOrder = null)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'findChildren', array('key' => $key, 'sortBy' => $sortBy, 'sortOrder' => $sortOrder), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->findChildren($key, $sortBy, $sortOrder);
    }

    public function getRootNodesQueryBuilder($sortByField = null, $direction = 'asc')
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getRootNodesQueryBuilder', array('sortByField' => $sortByField, 'direction' => $direction), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getRootNodesQueryBuilder($sortByField, $direction);
    }

    public function getRootNodesQuery($sortByField = null, $direction = 'asc')
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getRootNodesQuery', array('sortByField' => $sortByField, 'direction' => $direction), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getRootNodesQuery($sortByField, $direction);
    }

    public function getRootNodes($sortByField = null, $direction = 'asc')
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getRootNodes', array('sortByField' => $sortByField, 'direction' => $direction), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getRootNodes($sortByField, $direction);
    }

    public function __call($method, $args)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, '__call', array('method' => $method, 'args' => $args), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->__call($method, $args);
    }

    public function getPathQueryBuilder($node)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getPathQueryBuilder', array('node' => $node), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getPathQueryBuilder($node);
    }

    public function getPathQuery($node)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getPathQuery', array('node' => $node), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getPathQuery($node);
    }

    public function getPath($node)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getPath', array('node' => $node), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getPath($node);
    }

    public function childrenQueryBuilder($node = null, $direct = false, $sortByField = null, $direction = 'ASC', $includeNode = false)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'childrenQueryBuilder', array('node' => $node, 'direct' => $direct, 'sortByField' => $sortByField, 'direction' => $direction, 'includeNode' => $includeNode), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->childrenQueryBuilder($node, $direct, $sortByField, $direction, $includeNode);
    }

    public function childrenQuery($node = null, $direct = false, $sortByField = null, $direction = 'ASC', $includeNode = false)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'childrenQuery', array('node' => $node, 'direct' => $direct, 'sortByField' => $sortByField, 'direction' => $direction, 'includeNode' => $includeNode), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->childrenQuery($node, $direct, $sortByField, $direction, $includeNode);
    }

    public function children($node = null, $direct = false, $sortByField = null, $direction = 'ASC', $includeNode = false)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'children', array('node' => $node, 'direct' => $direct, 'sortByField' => $sortByField, 'direction' => $direction, 'includeNode' => $includeNode), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->children($node, $direct, $sortByField, $direction, $includeNode);
    }

    public function getChildrenQueryBuilder($node = null, $direct = false, $sortByField = null, $direction = 'ASC', $includeNode = false)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getChildrenQueryBuilder', array('node' => $node, 'direct' => $direct, 'sortByField' => $sortByField, 'direction' => $direction, 'includeNode' => $includeNode), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getChildrenQueryBuilder($node, $direct, $sortByField, $direction, $includeNode);
    }

    public function getChildrenQuery($node = null, $direct = false, $sortByField = null, $direction = 'ASC', $includeNode = false)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getChildrenQuery', array('node' => $node, 'direct' => $direct, 'sortByField' => $sortByField, 'direction' => $direction, 'includeNode' => $includeNode), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getChildrenQuery($node, $direct, $sortByField, $direction, $includeNode);
    }

    public function getChildren($node = null, $direct = false, $sortByField = null, $direction = 'ASC', $includeNode = false)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getChildren', array('node' => $node, 'direct' => $direct, 'sortByField' => $sortByField, 'direction' => $direction, 'includeNode' => $includeNode), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getChildren($node, $direct, $sortByField, $direction, $includeNode);
    }

    public function getLeafsQueryBuilder($root = null, $sortByField = null, $direction = 'ASC')
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getLeafsQueryBuilder', array('root' => $root, 'sortByField' => $sortByField, 'direction' => $direction), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getLeafsQueryBuilder($root, $sortByField, $direction);
    }

    public function getLeafsQuery($root = null, $sortByField = null, $direction = 'ASC')
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getLeafsQuery', array('root' => $root, 'sortByField' => $sortByField, 'direction' => $direction), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getLeafsQuery($root, $sortByField, $direction);
    }

    public function getLeafs($root = null, $sortByField = null, $direction = 'ASC')
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getLeafs', array('root' => $root, 'sortByField' => $sortByField, 'direction' => $direction), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getLeafs($root, $sortByField, $direction);
    }

    public function getNextSiblingsQueryBuilder($node, $includeSelf = false)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getNextSiblingsQueryBuilder', array('node' => $node, 'includeSelf' => $includeSelf), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getNextSiblingsQueryBuilder($node, $includeSelf);
    }

    public function getNextSiblingsQuery($node, $includeSelf = false)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getNextSiblingsQuery', array('node' => $node, 'includeSelf' => $includeSelf), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getNextSiblingsQuery($node, $includeSelf);
    }

    public function getNextSiblings($node, $includeSelf = false)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getNextSiblings', array('node' => $node, 'includeSelf' => $includeSelf), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getNextSiblings($node, $includeSelf);
    }

    public function getPrevSiblingsQueryBuilder($node, $includeSelf = false)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getPrevSiblingsQueryBuilder', array('node' => $node, 'includeSelf' => $includeSelf), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getPrevSiblingsQueryBuilder($node, $includeSelf);
    }

    public function getPrevSiblingsQuery($node, $includeSelf = false)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getPrevSiblingsQuery', array('node' => $node, 'includeSelf' => $includeSelf), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getPrevSiblingsQuery($node, $includeSelf);
    }

    public function getPrevSiblings($node, $includeSelf = false)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getPrevSiblings', array('node' => $node, 'includeSelf' => $includeSelf), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getPrevSiblings($node, $includeSelf);
    }

    public function moveDown($node, $number = 1)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'moveDown', array('node' => $node, 'number' => $number), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->moveDown($node, $number);
    }

    public function moveUp($node, $number = 1)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'moveUp', array('node' => $node, 'number' => $number), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->moveUp($node, $number);
    }

    public function removeFromTree($node)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'removeFromTree', array('node' => $node), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->removeFromTree($node);
    }

    public function reorder($node, $sortByField = null, $direction = 'ASC', $verify = true)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'reorder', array('node' => $node, 'sortByField' => $sortByField, 'direction' => $direction, 'verify' => $verify), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->reorder($node, $sortByField, $direction, $verify);
    }

    public function reorderAll($sortByField = null, $direction = 'ASC', $verify = true)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'reorderAll', array('sortByField' => $sortByField, 'direction' => $direction, 'verify' => $verify), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->reorderAll($sortByField, $direction, $verify);
    }

    public function verify()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'verify', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->verify();
    }

    public function recover()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'recover', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->recover();
    }

    public function getNodesHierarchyQueryBuilder($node = null, $direct = false, array $options = [], $includeNode = false)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getNodesHierarchyQueryBuilder', array('node' => $node, 'direct' => $direct, 'options' => $options, 'includeNode' => $includeNode), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getNodesHierarchyQueryBuilder($node, $direct, $options, $includeNode);
    }

    public function getNodesHierarchyQuery($node = null, $direct = false, array $options = [], $includeNode = false)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getNodesHierarchyQuery', array('node' => $node, 'direct' => $direct, 'options' => $options, 'includeNode' => $includeNode), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getNodesHierarchyQuery($node, $direct, $options, $includeNode);
    }

    public function getNodesHierarchy($node = null, $direct = false, array $options = [], $includeNode = false)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getNodesHierarchy', array('node' => $node, 'direct' => $direct, 'options' => $options, 'includeNode' => $includeNode), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getNodesHierarchy($node, $direct, $options, $includeNode);
    }

    public function setRepoUtils(\Gedmo\Tree\RepositoryUtilsInterface $repoUtils)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'setRepoUtils', array('repoUtils' => $repoUtils), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->setRepoUtils($repoUtils);
    }

    public function getRepoUtils()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getRepoUtils', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getRepoUtils();
    }

    public function childCount($node = null, $direct = false)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'childCount', array('node' => $node, 'direct' => $direct), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->childCount($node, $direct);
    }

    public function childrenHierarchy($node = null, $direct = false, array $options = [], $includeNode = false)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'childrenHierarchy', array('node' => $node, 'direct' => $direct, 'options' => $options, 'includeNode' => $includeNode), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->childrenHierarchy($node, $direct, $options, $includeNode);
    }

    public function buildTree(array $nodes, array $options = [])
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'buildTree', array('nodes' => $nodes, 'options' => $options), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->buildTree($nodes, $options);
    }

    public function buildTreeArray(array $nodes)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'buildTreeArray', array('nodes' => $nodes), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->buildTreeArray($nodes);
    }

    public function setChildrenIndex($childrenIndex)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'setChildrenIndex', array('childrenIndex' => $childrenIndex), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->setChildrenIndex($childrenIndex);
    }

    public function getChildrenIndex()
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'getChildrenIndex', array(), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->getChildrenIndex();
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

    public function count(array $criteria)
    {
        $this->initializer1ad21 && ($this->initializer1ad21->__invoke($valueHolder7e055, $this, 'count', array('criteria' => $criteria), $this->initializer1ad21) || 1) && $this->valueHolder7e055 = $valueHolder7e055;

        return $this->valueHolder7e055->count($criteria);
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

        unset($instance->listener, $instance->repoUtils, $instance->_entityName, $instance->_em, $instance->_class);

        $instance->initializer1ad21 = $initializer;

        return $instance;
    }

    public function __construct(\Doctrine\ORM\EntityManagerInterface $em, \Doctrine\ORM\Mapping\ClassMetadata $class)
    {
        static $reflection;

        if (! $this->valueHolder7e055) {
            $reflection = $reflection ?? new \ReflectionClass('Sulu\\Bundle\\CategoryBundle\\Entity\\CategoryRepository');
            $this->valueHolder7e055 = $reflection->newInstanceWithoutConstructor();
        unset($this->listener, $this->repoUtils, $this->_entityName, $this->_em, $this->_class);

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
        unset($this->listener, $this->repoUtils, $this->_entityName, $this->_em, $this->_class);
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
