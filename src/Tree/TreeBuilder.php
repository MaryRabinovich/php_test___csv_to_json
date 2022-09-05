<?php

declare (strict_types = 1);

namespace App\Tree;

use App\Readers\ReaderContract;

class TreeBuilder
{
    private static $reader;

    public static function setReader(ReaderContract $reader)
    {
        self::$reader = $reader;
    }

    public static function buildTree(): void
    {
        self::buildHashesAndBasicTreeFromReader();
        self::updateTreeWithRelationalHash();
    }

    private static function buildHashesAndBasicTreeFromReader(): void
    {
        while ($next = self::$reader->next()) {
            extract($next);

            $node = [
                'itemName' => $itemName,
                'parent' => $parent,
                'children' => [],
            ];

            /**
            * добавляем новый узел в дерево
            * напрямую или сквозь хэш itemNameKeyedRefsHash
            */
            if (array_key_exists($parent, Tree::$itemNameKeyedRefsHash)) {
                $arrRef = &Tree::$itemNameKeyedRefsHash[$parent]['children'];
            } else {
                $arrRef = &Tree::$tree;
                $node['parent'] = null;
            }
            $count = count($arrRef);
            $arrRef[] = $node;
            $ref = &$arrRef[$count];

            /**
            * запоминаем добавленный новый узел
            * в хеш itemNameKeyedRefsHash
            */
            Tree::$itemNameKeyedRefsHash[$itemName] = &$ref;

            /**
            * возможно, запоминаем добавленный новый узел
            * как кандидата на расширение через relation
            */
            if (!$relation) {
                continue;
            }

            if (!array_key_exists($relation, Tree::$relationKeyedRefHash)) {
                Tree::$relationKeyedRefHash[$relation] = [];
            }
            Tree::$relationKeyedRefHash[$relation][] = &$ref;
        }
    }

    private static function updateTreeWithRelationalHash(): void
    {
        /**
         * Проходим по всем ключам, указанным как relation где-либо
         * и по всем элементам, в которых указаны такие relation
         * (верхние два цикла - O(n))
         */
        foreach (Tree::$relationKeyedRefHash as $itemName => $arrRelationsRefs) {
            foreach ($arrRelationsRefs as &$ref) {
                /**
                 * Пользуемся обычным копированием без ссылок,
                 * меняем значение поля parent у верхнего элемента,
                 * добавляем в целевые места через основную таблицу itemNameKeyedRefsHash
                 * (здесь тоже O(n), итоговое общее по трём вложенным циклам O(n^2))
                 */
                foreach (Tree::$itemNameKeyedRefsHash[$itemName]['children'] as $child) {
                    $child['parent'] = $ref['itemName'];
                    $ref['children'][] = $child;
                }
            }
        }
    }
}
