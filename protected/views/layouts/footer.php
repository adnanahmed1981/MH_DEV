		<footer class="footer">
		<div class="container" style="background-color: transparent;">
			<div class="row">
				<div class="col-xs-4 col-sm-2 col-md-2 col-lg-2"><a href="termsOfUse" class="default-white">Terms of use</a></div>
				<div class="col-xs-4 col-sm-2 col-md-2 col-lg-2"><a href="faq" class="default-white">Help & FAQ</a></div>
			</div>
			<div class="row">
				<div class="col-xs-4 col-sm-2 col-md-2 col-lg-2"><a href="privacy" class="default-white">Privacy policy</a></div>
				<div class="col-xs-4 col-sm-2 col-md-2 col-lg-2"><a href="contactUs" class="default-white">Contact us</a></div>
				<div class="col-xs-4 col-sm-8 text-right" style="color:rgb(150,150,200);">
<?php 		
		if (LIVE) {
			echo "w:";
			if (RLS_ENV){ 
				echo "p";	
			}else{
				echo "d";
			}
		}else{
			echo "localhost";
		}
?>	
				</div>
			</div>
			
		</div>
		</footer>
		
		
		