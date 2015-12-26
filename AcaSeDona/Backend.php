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

    public static function edit_place($id)
    {
        $user = getenv('BACKEND_USER');
        $pass = getenv('BACKEND_PASS');

        if (http_login($user, $pass))
        {
            $place = Place::find($id);

            Flight::view()->set("place_name", $place->name);
            Flight::view()->set("place_address", $place->address);
            Flight::view()->set("place_start_hour", $place->start_hour);
            Flight::view()->set("place_end_hour", $place->end_hour);
            Flight::view()->set("place_days", $place->days);
            Flight::view()->set("place_comments", $place->comments);

            Flight::view()->set("basepath", getBasePath());

            Flight::render('backend/places-edit', array(), 'yield');
            Flight::render('backend/layout', array());
        }
    }

    public static function update_place($id)
    {
        $user = getenv('BACKEND_USER');
        $pass = getenv('BACKEND_PASS');

        if (http_login($user, $pass))
        {
            $post_data = Flight::request()->data;

            $place = Place::find($id);
            $place->name = $post_data['name'];
            $place->address = $post_data['address'];
            $place->start_hour = $post_data['start_hour'];
            $place->end_hour = $post_data['end_hour'];
            $place->days = $post_data['days'];
            $place->comments = $post_data['comments'];
            $place->save();
        }

        Flight::redirect('/backend/places', 302);
    }

}
