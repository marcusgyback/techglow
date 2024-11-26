<?php
namespace App\Models\Product;

use Outl1ne\NovaMediaHub\Models\Media;

class Brand extends \App\Models\Product\AbstractModels\AbstractBrand
{
    public function getImages(){
        if(is_null($this->image)) {
            return null;
        }
        return Media::whereIn('id', $this->image)->get();
    }
}
