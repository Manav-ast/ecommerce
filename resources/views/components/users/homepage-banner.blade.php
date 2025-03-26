@props(['banner', 'title1', 'subtitle'])

{{-- @dd($title1) --}}
@php
    // Check if content exists
    $base64Image = null;
    if (!empty($banner->content)) {
        preg_match('/<img[^>]+src=["\'](data:image\/[^"\']+)["\']/', $banner->content, $matches);
        $base64Image = $matches[1] ?? null;
    }
@endphp

<div class="relative w-full h-[500px] flex items-center justify-start overflow-hidden"
    style="background-image: url('{{ $base64Image ?? asset('assets/images/banner-home2.jpg') }}');
           background-size: cover; background-position: center;">

    <!-- Content Overlay -->
    <div class="container">
        <h1 class="text-6xl text-gray-800 font-medium mb-4 capitalize">
            {!! $title1->content !!}
            {{-- Deals & Collections --}}
        </h1>
        {{-- <p>Shop top-quality products across fashion.</p> --}}
        {!! $subtitle->content !!}
        <div class="mt-12">
            <a href="/shop"
                class="bg-blue-500 border border-blue-700 text-white px-8 py-3 font-medium 
                rounded-md hover:bg-transparent hover:text-white">Shop
                Now</a>
        </div>
    </div>
</div>
