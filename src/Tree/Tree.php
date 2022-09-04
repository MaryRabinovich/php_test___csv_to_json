<?php

declare (strict_types = 1);

namespace App\Tree;

class Tree
{
    /**
     * @var array
     */
    public static $tree = [];

    /**
     * @var array
     * линейный ассоциативный массив ссылок на элементы дерева self::$tree
     * по ключам itemName
     */
    public static $itemNameKeyedRefsHash = [];

    /**
     * @var array
     * двумерный массив ссылок на элементы дерева self::$tree
     * по ключам relation
     * 
     * на каждом значении relation 
     * свой одномерный массив ссылок 
     * на элементы self::$tree с таким relation
     */
    public static $relationKeyedRefHash = [];
}
