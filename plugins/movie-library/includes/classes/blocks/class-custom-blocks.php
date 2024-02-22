<?php
/**
 * Rt_Movies_Block
 *
 * @package rt-movies
 */

namespace Movie_Library\Includes\Blocks;

use Movie_Library\Includes\Traits\Singleton;

define( 'RT_MOVIE_DIR', __DIR__ );

/**
 * Rt_Movies_Block
 */
class Custom_Blocks {

	use Singleton;

	/**
	 * Method __construct
	 *
	 * @return void
	 */
	protected function __construct() {
		add_action( 'init', array( $this, 'rt_movies_block_rt_movies_block_block_init' ) );
	}

	/**
	 * Method rt_movies_block_rt_movies_block_block_init
	 *
	 * @return mixed
	 */
	public function rt_movies_block_rt_movies_block_block_init() {
		register_block_type( RT_MOVIE_DIR . '/build/rt-movies-block' );
		register_block_type( RT_MOVIE_DIR . '/build/rt-movie-block' );
		register_block_type( RT_MOVIE_DIR . '/build/rt-persons-block' );
		register_block_type( RT_MOVIE_DIR . '/build/rt-person-block' );
	}
}
