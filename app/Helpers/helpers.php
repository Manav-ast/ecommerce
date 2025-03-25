<?php

use App\Models\StaticBlock;

if (!function_exists('getFooterBlock')) {
    function getStaticBlock($slug = 'footer-test')
    {
        return StaticBlock::where('slug', $slug)->where('status', 'active')->first();
    }
}
