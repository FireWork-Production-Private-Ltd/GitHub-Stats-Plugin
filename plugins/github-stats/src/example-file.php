<?php
/**
 * Simple Namespace Example
 * 
 * @package GithubStats
 */

namespace GithubStats;

class ExampleFile {
    public function __construct() {
        add_action( 'init', [ $this, 'init' ] );
    }

    public function init() {
        echo "Hello World!";
    }
}