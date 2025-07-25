<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Pager extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Default Pager Template
     * --------------------------------------------------------------------------
     *
     * This is the default template that the Pager class will use when displaying
     * pagination links.
     *
     * @var string
     */
    public $template = 'CodeIgniter\Pager\Views\default_full';

    /**
     * --------------------------------------------------------------------------
     * Items Per Page
     * --------------------------------------------------------------------------
     *
     * The default number of results shown in a single page.
     *
     * @var int
     */
    public $perPage = 12;

    /**
     * --------------------------------------------------------------------------
     * Custom Pager Templates
     * --------------------------------------------------------------------------
     *
     * Templates that can be used with the Pager class.
     *
     * @var array
     */
    public $templates = [
        'default_full'   => 'CodeIgniter\Pager\Views\default_full',
        'default_simple' => 'CodeIgniter\Pager\Views\default_simple',
        'default_head'   => 'CodeIgniter\Pager\Views\default_head',
        'frontend'       => 'App\Views\pager\frontend',
    ];
}
