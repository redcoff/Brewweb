<?php

/**
 * Class Error404Page
 */
class Error404Page {
    /**
     * Error404Page constructor.
     */
    function __construct() {

		}

    /**
     *
     */
    function render() {
		?>
			<div class="cover-container d-flex w-100 h-100 m-5 p-5 mx-auto flex-column flex-wrap align-content-center">
                <main>
			        <div class="row">
			            <div role="main" class="inner col-12" >
			                <h1>Four, oh: four.</h1>
                            <h3>Page not Found</h3>
                            <h4>There was a PAGE here.</h4>
                            <h4>It's gone now.</h4>
                            <p>(Is this what happens to pages that wander into the forest?)</p>
			            </div>
			        </div>
			    </div>
            </main>
		<?php
		}
	}
?>