<div class="header basic-bg spaced">
	<div class="row">	
		<div class="col-md-2 text-left">
			<a href="<?=$this->url('') ?>" alt="<?=$this->t('Home') ?>">
				<?php
					$this->renderImage('logo.jpg', 'Logo', 'img-circle img-responsive logo' );			
				?>
			</a>
		</div>
		
		<div class="col-md-4">
			<span class="main-title"><?=$this->data['site_title'] ?></span>
		</div>	
		
		<div class="col-md-6 text-right">		
			<?php
				$this->renderPartialView('menu');
			?>
			
			<div class="cart-small">
		
				<div>
					<span class="glyphicon glyphicon-shopping-cart"></span>
					<?=$this->t('Shopping Cart')?>:
				</div>
					
				<a class="price" href="<?=$this->url('cart') ?>">
					<span class="ajax-loader ajax-loader-blue"></span>	
					<span class="cart-total-price">
						<?php
							$totals = $this->data['cart_totals'];
							if ($totals['total_cart_price'] > 0) {
								echo $totals['total_cart_price_formatted'];
							} else {
								echo $this->t('Empty');
							}				
						?>
					</span>			
				</a>
				
			</div>
			
		</div>
	</div>
</div>
