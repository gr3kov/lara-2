<?php


namespace App\Extensions;

use Illuminate\View\View as BaseView;

class ExtendedView extends BaseView
{
    public function render(?callable $callback = null)
    {
        return parent::render($callback);
    }
}
