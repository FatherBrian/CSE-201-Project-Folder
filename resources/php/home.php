<?php
class home {

	function generateHomePage($message) {
		$text = '<div class="container-fluid">
					<div class="row">
						<div class="col-xs-6">' . $message .
						'</div>
					</div>
				</div>';
		echo $text;
	}


}	
?>