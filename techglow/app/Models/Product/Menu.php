<?php
namespace App\Models\Product;

use Illuminate\Support\Facades\DB;

class Menu extends \App\Models\Product\AbstractModels\AbstractMenu
{

    public function children()
    {
        return parent::children()->orderBy('weight');
    }

    public function parent()
    {
        return parent::parent()->orderBy('weight');
    }

    public static function treeByParentId(int $parent = null)
    {
        if(is_null($parent)) {
            return static::tree();
        }
        return static::with(implode('.', array_fill(0, 5, 'children')))->where('parent_id', '=', $parent)->orderBy('weight')->get();
    }

    public static function tree()
    {
        return static::with(implode('.', array_fill(0, 5, 'children')))->whereNotNull('published')->whereNull('parent_id')->orderBy('weight')->get();
    }
}
