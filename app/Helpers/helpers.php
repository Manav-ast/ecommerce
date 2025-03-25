<?php

use App\Models\StaticBlock;

if (!function_exists('getFooterBlock')) {
    function getFooterBlock($slug = 'footer-test')
    {
        return StaticBlock::where('slug', $slug)->where('status', 'active')->first();
    }

    function getFooterLinks($slug = 'footer-link'){
        return StaticBlock::where('slug', $slug)->where('status', 'active')->first();
    }

    function getHomeBanner($slug = 'home-banner'){
        return StaticBlock::where('slug', $slug)->where('status', 'active')->first();
    }
}
