<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hrv extends Model
{
  protected $table = 'hrv';
  protected $primaryKey ='id';
  protected $fillable = ['id','user_id','before','hrv','after'];
  public $timestamps = false;

  public function users(){
    return $this->belongsTo('App\User');
  }
}
