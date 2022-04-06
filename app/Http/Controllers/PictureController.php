<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use Illuminate\Support\Facades\Http;

/**
 *
 */
class PictureController extends Controller
{
    /**
     *
     */
    public function __construct()
    {
        $this->getPicture();
    }

    /**
     * Retrieves the NASA Space Picture of the Day and decode the response
     *
     * @return void
     */
    public function getPicture()
    {
        $nasa_key = config('services.nasa.key');
        $response = Http::get('https://api.nasa.gov/planetary/apod?api_key=' . $nasa_key);
        $apiPicture = json_decode($response->body());

        $this->storePicture($apiPicture);
    }

    /**
     * Stores the API response in the pictures table
     *
     * @param $apiPicture
     *
     * @return void
     */
    public function storePicture($apiPicture)
    {
        if (!Picture::where('title', $apiPicture->title)->first()) {
            $picture = new Picture;
            $new_title = $this->modifyApiPictureTitle($apiPicture->title);

            $picture->title = $apiPicture->title;
            $picture->new_title = $new_title;
            $picture->date = $apiPicture->date;
            $picture->url = $apiPicture->url;
            $picture->hdurl = $apiPicture->hdurl;

            // Check to see if the copyright field has been returned.
            if (isset($apiPicture->copyright)) {
                $picture->copyright = $apiPicture->copyright;
            } else {
                $picture->copyright = '';
            }

            $picture->save();
        }
    }

    /**
     * Modifies the picture title.
     *
     * @param $title
     *
     * @return string
     */
    public function modifyApiPictureTitle($title)
    {
        $new_title = $title . '... with aliens. You can see them if you squint.';

        return $new_title;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $pictures = Picture::all();
        return view('picture.list', ['pictures' => $pictures]);
    }
}
