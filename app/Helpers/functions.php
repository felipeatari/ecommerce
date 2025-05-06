<?php

use App\Models\Category;

if (!function_exists('httpStatusCodeError')) {
    function httpStatusCodeError(int $statusCode = 0)
    {
        $statusCodeErrors = [400, 401, 403, 404, 405, 406, 407, 408, 409, 500, 501, 502, 503, 504];

        if (! in_array($statusCode, $statusCodeErrors)) $statusCode = 500;

        return $statusCode;
    }
}

if (!function_exists('slug')) {
    function slug(string $title = '')
    {
        return Illuminate\Support\Str::slug($title);
    }
}

if (!function_exists('buildCategoryTree')) {
    function buildCategoryTree(?int $id = null, int $loop = 1, int $limit = 3, array $tree = [], bool $reverse = true)
    {
        if ($loop === 0) $tree = [];

        $category = Category::query()
                    ->select('id','name','parent','slug')
                    ->where('id', $id)
                    ->where('active', true)
                    ->first();

        if (is_null($category)) return [];

        $category = $category->toArray();

        if (! $category) $tree = [];

        if ($reverse) {
            array_unshift($tree, $category);
        } else {
            $tree[] = $category;
        }

        if (! is_null($category['parent']) and $loop <= $limit) {
            return buildCategoryTree($category['parent'], $loop++, $limit, $tree, $reverse);
        }

        return $tree;
    }
}

if (!function_exists('formatCategoryTree')) {
    function formatCategoryTree(array $categoryTree = [])
    {
        if (! $categoryTree) return [];

        $formatCategoryTree = '';
        $amount = count($categoryTree);
        $i = 1;

        foreach ($categoryTree as $item):
            $categoryName = $item['name'];

            if ($i === 1) {
                $formatCategoryTree .= "$categoryName";
            }
            elseif ($amount !== 1 and $i < $amount) {
                $formatCategoryTree .= " > $categoryName";
            }
            elseif ($amount !== 1 and $i === $amount) {
                $formatCategoryTree .= " > $categoryName";
            }

            $i++;
        endforeach;

        return $formatCategoryTree;
    }
}
