<?php

namespace Bernhardh\NovaDynamicViews;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class NovaDynamicViews extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('nova-dynamic-views', __DIR__.'/../dist/js/tool.js');
    }
}
