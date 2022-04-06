<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use Illuminate\Support\Facades\Http;

/**
 *
 */
class PictureController extends Controller
{
    public function __construct()
    {
        $this->getPicture();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $pictures = Picture::all();
        return view('picture.list', ['pictures' => $pictures]);
    }

    public function getPicture()
    {
        // Retrieve the NASA Space Picture of the Day and decode the response
        $nasa_key = config('services.nasa.key');
        $response = Http::get('https://api.nasa.gov/planetary/apod?api_key=' . $nasa_key);
        $apiPicture = json_decode($response->body());

        $this->storePicture($apiPicture);
    }

    public function storePicture($apiPicture)
    {
        if (!Picture::where('title', $apiPicture->title)->first()) {
            $picture = new Picture;

            $picture->title = $apiPicture->title;
            $picture->date = $apiPicture->date;
            $picture->copyright = $apiPicture->copyright;
            $picture->url = $apiPicture->url;
            $picture->hdurl = $apiPicture->hdurl;

            $picture->save();
        }
    }

    public function modifyApiPictureTitle($title){


    }
}
