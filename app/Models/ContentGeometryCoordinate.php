<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Auth;

class ContentGeometryCoordinate extends Model
{
    //
    protected $table = 'content_geometry_coordinates';
    protected $fillable = ['id', 'geometry_id', 'longitude', 'latitude'];
    protected $hidden = ['user_id', 'created_at', 'updated_at'];

    public function contentGeometry(){
        return $this->belongsTo('App\Models\ContentGeometry','geometry_id','id');
    }

    public function getGeometryCoordinateByGeometryId($geometryId){
        return $this->where('geometry_id', $geometryId)->get();
    }

    public function deleteGeometryCoordinateByGeometryId($geometryId){
        $geometryCoordinate = $this->getGeometryCoordinateByGeometryId($geometryId);
        if(count($geometryCoordinate)>0){
            $geometryCoordinate->delete();
        }
    }

    public function addGeometryCoordinate($data){
        try{
            $this->geometry_id = $data['geometry_id'];
            $this->longitude = $data[0];
            $this->latitude = $data[1];
            $this->user_id = Auth::id();
        }catch(QueryException $e){
            report($e);
            return false;
        }

    }
}