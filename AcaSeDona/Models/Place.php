<?php namespace AcaSeDona\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Cocur\Slugify\Slugify;
use Snipe\BanBuilder\CensorWords;

class Place extends Eloquent {

    protected $fillable = array(
        'name', 'address', 'start_hour', 'end_hour', 'days', 'comments'
    );

    protected $hidden = array(
        'confirmed', 'created_at', 'updated_at'
    );

    public function setNameAttribute($value)
    {
        // censor name
        $censor = new CensorWords;
        $badwords = $censor->setDictionary(array('es','en-us', 'en-uk'));
        $cname = $censor->censorString($value);
        $name = $cname['clean'];

        $this->attributes['name'] = $name;

        // generates uri slug
        $slugify = new Slugify();
        $this->attributes['slug'] = $slugify->slugify($name);

        // TODO - generates short url of this place
        // $this->attributes['googl'] = '';
    }

    public function setAddressAttribute($value)
    {
        // censor address
        $censor = new CensorWords;
        $badwords = $censor->setDictionary(array('es','en-us', 'en-uk'));
        $caddress = $censor->censorString($value);
        $address = $caddress['clean'];

        // search coordinates with the provided address
        $Geocoder = new \GoogleMapsGeocoder();
        $Geocoder->setAddress($address);
        $response = $Geocoder->geocode();

        // defaults when the coordinates aren't found
        $this->attributes['address'] = $address;
        $this->attributes['lat'] = '-34.6036844';
        $this->attributes['long'] = '-58.381559100000004';

        // success, we have coordinates!
        if ($response['status'] == 'OK')
        {
            $info = array(
                'address' => $response['results'][0]['formatted_address'],
                'lat'     => $response['results'][0]['geometry']['location']['lat'],
                'long'    => $response['results'][0]['geometry']['location']['lng'],
            );

            $this->attributes['address'] = $info['address'];
            $this->attributes['lat'] = $info['lat'];
            $this->attributes['long'] = $info['long'];
        }
    }

}
