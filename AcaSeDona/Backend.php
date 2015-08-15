<?php namespace AcaSeDona;

use Flight;
use AcaSeDona\Models\Place;

class Backend {

    public static function places()
    {
        $user = getenv('BACKEND_USER');
        $pass = getenv('BACKEND_PASS');

        if (http_login($user, $pass))
        {
            $places = Place::where('confirmed', 1)->orderBy('id', 'desc')->get();
            Flight::view()->set("places", $places->toArray());
            Flight::view()->set("total_places", $places->count());

            Flight::view()->set("base_path", getBasePath());

            Flight::render('backend/places', array(), 'yield');
            Flight::render('backend/layout', array());
        }
    }

    public static function hide_place($id)
    {
        $user = getenv('BACKEND_USER');
        $pass = getenv('BACKEND_PASS');

        if (http_login($user, $pass))
        {
            $place = Place::find($id);
            $place->confirmed = 0;
            $place->save();
        }

        Flight::redirect('/backend/places', 302);
    }

}
