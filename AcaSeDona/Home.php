<?php namespace AcaSeDona;

use Flight;
use AcaSeDona\Models\Place;
use ReCaptcha\ReCaptcha;
use Tamtamchik\SimpleFlash\Flash;

class Home {

    public static function index()
    {
        $flash = (string) flash();
        if ( ! empty($flash))
        {
            Flight::view()->set("flash", 'success');
        }

        Flight::view()->set("base_path", getBasePath());
        Flight::view()->set("url_website", getWebsiteUrl(false) . '/');
        Flight::view()->set("recaptcha_public", getenv('RECAPTCHA_PUBLIC'));
        Flight::view()->set("ga_code", getenv('GOOGLE_ANALYTICS'));
        Flight::view()->set("gm_api_key", getenv('GOOGLE_MAPS_API_KEY'));

        Flight::view()->set("fb_app_id", getenv('FB_APP_ID'));

        // layout assets
        Flight::view()->set("asset_favicon", getAssetUrl("assets/images/favicon.png"));
        Flight::view()->set("asset_css", getAssetUrl("assets/css/app.css"));
        Flight::view()->set("asset_js_vendors", getAssetUrl("assets/js/vendors.js"));
        Flight::view()->set("asset_js", getAssetUrl("assets/js/app.js"));

        Flight::view()->set("asset_share_fb", getAssetUrl("assets/images/acasedona-fb.png"));
        Flight::view()->set("asset_share_tw", getAssetUrl("assets/images/acasedona-tw.png"));
        Flight::view()->set("asset_share_gp", getAssetUrl("assets/images/acasedona-fb.png"));

        Flight::render('flowics', array(), 'flowics');
        Flight::render('analytics', array(), 'analytics');
        Flight::render('header', array(), 'header');
        Flight::render('home', array(), 'yield');
        Flight::render('layout', array());
    }

    public static function save_place()
    {
        $flash = new Flash();
        $post_data = Flight::request()->data;

        // recaptcha
        $secret = getenv('RECAPTCHA_SECRET');
        $gRecaptchaResponse = $post_data['g-recaptcha-response'];
        $recaptcha = new ReCaptcha($secret);
        $resp = $recaptcha->verify($gRecaptchaResponse, $_SERVER['REMOTE_ADDR']);

        if ($resp->isSuccess())
        {
            // verified!
            $address = "{$post_data['calle']} {$post_data['altura']}, {$post_data['ciudad']}, {$post_data['provincia']}, Argentina";

            // save new place
            Place::create(
                array(
                    'name'       => $post_data['name'],
                    'address'    => $address,
                    'start_hour' => $post_data['start_hour'],
                    'end_hour'   => $post_data['end_hour'],
                    'days'       => $post_data['days'],
                    'comments'   => $post_data['comments'],
                )
            );

            $flash->message('success');
        } else
        {
            $errors = $resp->getErrorCodes();

            $flash->message('error');
        }

        Flight::redirect('/', 302);
    }

    public static function display_places()
    {
        // places markers
        $places = Place::where('confirmed', 1)->get();
        $list_places = $places->toArray();
        $final_list = array();

        foreach ($list_places as $place)
        {
            $complete = "<strong>{$place['name']}</strong>";
            $complete .= "<br>{$place['address']}";

            if ( ! empty($place['start_hour']))
            {
                $complete .= "<br><small><u>Horario:</u> ";
                $complete .= "{$place['start_hour']}";
                if ( ! empty($place['end_hour']) && $place['start_hour'] != $place['end_hour'])
                    $complete .= " - {$place['end_hour']}";
                if ( ! empty($place['days']))
                    $complete .= " - {$place['days']}";
                $complete .= "</small>";
            }

            if ( ! empty($place['comments']))
                $complete .= "<br><br>{$place['comments']}";

            $place['complete'] = $complete;

            $place['name'] = "{$place['name']} - {$place['address']}";

            $final_list[] = $place;
        }

        Flight::json($final_list);
    }

}
