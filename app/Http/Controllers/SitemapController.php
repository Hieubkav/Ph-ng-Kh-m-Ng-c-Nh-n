<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\ServicePost;
use App\Models\Service;
use App\Models\CatPost;
use App\Models\Page;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 1)
            ->orderBy('updated_at', 'DESC')
            ->get();
            
        $servicePosts = ServicePost::where('status', 1)
            ->orderBy('updated_at', 'DESC')
            ->get();
            
        $services = Service::where('status', 1)
            ->orderBy('updated_at', 'DESC')
            ->get();
            
        $categories = CatPost::where('status', 1)
            ->orderBy('updated_at', 'DESC')
            ->get();
            
        $pages = Page::where('status', 1)
            ->orderBy('updated_at', 'DESC')
            ->get();

        $content = view('sitemap.index', [
            'posts' => $posts,
            'servicePosts' => $servicePosts,
            'services' => $services,
            'categories' => $categories,
            'pages' => $pages
        ])->render();

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }
}
