<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
    use HasFactory;
    public static $sortParameters = ['name', 'number', 'color', 'vin', 'model', 'brand', 'year'];
    protected $fillable = ['name', 'number', 'color', 'vin', 'model', 'brand', 'year'];


    public static function search($params)
    {
        $query = Cars::query();

        $query->where('model',$params->model)->where('brand', $params->brand)->where('year', $params->year);
        if(isset($params['model'])) $query->where('model',$params['model']);
        if(isset($params['brand'])) $query->where('brand', $params['brand']);
        if(isset($params['year'])) $query->where('year', $params['year']);

        if(in_array($params['sort'], Cars::$sortParameters)){
            $query->orderBy($params['sort']);
        }

        return $query;
    }
}
