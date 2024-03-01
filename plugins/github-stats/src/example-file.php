<?php

/**
 * Simple Namespace Example
 *
 * @package GithubStats
 */

namespace GithubStats;

/**
 * Example File
 */
class ExampleFile
{
    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('init', array( $this, 'init' ));
    }

    /**
     * Init
     */
    public function init()
    {
        echo 'Hello World!';
    }
}
