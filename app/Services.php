<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{

	protected $table		 = 'services';
	protected $primaryKey	 = 'id';

	public function orders()
    {
        return $this->hasMany('App\Orders', 'services_id', 'id');
    }

	public function create(\Illuminate\Http\Request $request)
	{
		$this->name			 = $request->name;
		$this->description	 = $request->description;
		$this->priceLoaded	 = $request->priceLoaded;
		$this->priceUnLoaded = $request->priceUnLoaded;
		$this->minWeight	 = $request->minWeight;
		$this->maxWeight	 = $request->maxWeight;
		$this->save();
	}

}
