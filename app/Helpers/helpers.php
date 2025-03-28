<?php

use App\Models\StaticBlock;

if (!function_exists('getStaticBlock')) {
    function getStaticBlock($slug = 'footer-test')
    {
        try {
            return StaticBlock::where('slug', $slug)->where('status', StaticBlock::ACTIVE_STATUS)->first();
        } catch (\Exception $e) {
            return null;
        }
    }
}
