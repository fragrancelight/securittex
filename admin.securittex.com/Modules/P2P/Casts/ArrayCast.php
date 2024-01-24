<?php
 
namespace Modules\P2P\Casts;
 
use App\Model\CountryList;
use Illuminate\Database\Eloquent\Model;
use Modules\P2P\Entities\PUserPaymentMethod;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
 
class ArrayCast
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     * @return array<string, mixed>
     */
    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        // dd($attributes);
        if(!empty($value) && $key == "payment_method"){
            $p = explode(',',$value);
            return PUserPaymentMethod::whereIn('uid', $p)->with('adminPamyntMethod')->get();
        }
        if(!empty($value) && $key == "country"){
            $p = explode(',',$value);
            return CountryList::whereIn('key', $p)->get();
        }
        return $value;
    }
 
    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        return json_encode($value);
    }
}