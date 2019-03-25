<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Breathing extends Model
{
    protected $table = 'breathing';
    protected $primaryKey ='id';
    protected $fillable = ['id','user_id','before','after'];
    public $timestamps = false;

    public function users(){
      return $this->belongsTo('App\User');
    }

}
