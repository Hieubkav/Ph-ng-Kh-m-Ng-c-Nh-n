<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\CatPost;
use App\Models\Doctor;
use App\Models\Post;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\ServicePost;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function storeFront()
    {
        $carousels = Carousel::query()->orderByDesc('created_at')->get();
        $services = Service::query()->orderBy('order_service')->get();
        $doctors = Doctor::all();
        $activeSchedule = Schedule::query()->where('status', 'show')->latest()->first();
        $hotPosts = Post::query()
            ->where('is_hot', 'hot')
            ->orderByDesc('created_at')
            ->get();
        $catPosts = CatPost::query()
            ->where('status', 'show')
            ->with([
                'posts' => function ($query) {
                    $query->orderByDesc('created_at')
                        ->limit(3);
                },
            ])
            ->get();

        return view('shop.storeFront', compact(
            'carousels',
            'services',
            'doctors',
            'activeSchedule',
            'hotPosts',
            'catPosts'
        ));
    }

    public function page($id)
    {
        return view('shop.page', ['id' => $id]);
    }

    public function post(string $slug)
    {
        $post = Post::query()
            ->with('cat_post')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('shop.post', [
            'post' => $post,
        ]);
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

    public function servicePost($serviceId, string $slug)
    {
        $service = Service::query()->findOrFail($serviceId);
        $servicePost = ServicePost::query()
            ->where('service_id', $serviceId)
            ->where('slug', $slug)
            ->firstOrFail();

        return view('shop.servicePost', [
            'service' => $service,
            'servicePost' => $servicePost,
        ]);
    }
}
