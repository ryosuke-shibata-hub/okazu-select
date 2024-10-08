<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FloorModel extends Model
{
    use HasFactory;

    protected $table = "floor";

    protected $fillable = [
        'site_name',
        'site_code',
        'service_name',
        'service_code',
        'floor_id',
        'floor_name',
        'floor_code',
    ];

    public static function checkUniqueFloor($floorData) {

        $data = FloorModel::where('floor_id', $floorData)
        ->first();

        return $data;
    }

    public static function createNewFloor($floorRecordData)
    {
        FloorModel::create([
            'site_name' => $floorRecordData['site_name'],
            'site_code' => $floorRecordData['site_code'],
            'service_name' => $floorRecordData['service_name'],
            'service_code' => $floorRecordData['service_code'],
            'floor_id' => $floorRecordData['floor_id'],
            'floor_name' => $floorRecordData['floor_name'],
            'floor_code' => $floorRecordData['floor_code'],
            'delete_flg' => config('const.FLOOR.FLG.DELETE_FLG.ACTIVE'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
