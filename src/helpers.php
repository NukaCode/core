<?php

if (! function_exists('viewBuilder')) {
    /**
     * Return the ViewBuilder instance.
     *
     * @return mixed
     */
    function viewBuilder()
    {
        return app('viewBuilder');
    }
}
