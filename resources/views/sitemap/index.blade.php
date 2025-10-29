<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    {{-- Trang chủ --}}
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    
    {{-- Các trang --}}
    @foreach($pages as $page)
    <url>
        <loc>{{ route('page', $page->id) }}</loc>
        <lastmod>{{ $page->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach
    
    {{-- Các bài viết --}}
    @foreach($posts as $post)
    <url>
        <loc>{{ route('post', $post->slug) }}</loc>
        <lastmod>{{ $post->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach
    
    {{-- Danh mục bài viết --}}
    @foreach($categories as $category)
    <url>
        <loc>{{ route('catPost', $category->id) }}</loc>
        <lastmod>{{ $category->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.6</priority>
    </url>
    @endforeach
    
    {{-- Các dịch vụ --}}
    @foreach($services as $service)
    <url>
        <loc>{{ route('services', $service->id) }}</loc>
        <lastmod>{{ $service->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach
    
    {{-- Bài viết dịch vụ --}}
    @foreach($servicePosts as $servicePost)
    <url>
        <loc>{{ route('servicePost', ['serviceId' => $servicePost->service_id, 'slug' => $servicePost->slug]) }}</loc>
        <lastmod>{{ $servicePost->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach
    
    {{-- Trang tuyển dụng --}}
    <url>
        <loc>{{ route('hiring') }}</loc>
        <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
</urlset>
