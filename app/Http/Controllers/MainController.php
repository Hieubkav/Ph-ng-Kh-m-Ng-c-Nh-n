<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function storeFront()
    {
        return view('shop.storeFront');
    }

    public function page($id)
    {
        return view('shop.page', ['id' => $id]);
    }

    public function post($id)
    {
        return view('shop.post', ['id' => $id]);
    }

    public function catPost($id)
    {
        return view('shop.catPost', ['id' => $id]);
    }

    public function hiring()
    {
        return view('shop.hiring');
    }

    public function services($id)
    {
        return view('shop.services', ['id' => $id]);
    }

    public function servicePost($serviceId, $postId)
    {
        return view('shop.servicePost', [
            'serviceId' => $serviceId,
            'postId' => $postId
        ]);
    }
}
