<?php
namespace App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Outl1ne\NovaMediaHub\Models\Media;

class Partner extends \App\Models\Partner\AbstractModels\AbstractPartner
{
    use HasFactory;

    public function getImages(){
        if(is_null($this->image)) {
            return null;
        }
        return Media::whereIn('id', $this->image)->get();
    }
}
