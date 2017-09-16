<?php

	$category = $this->getData('category');
	$paging = $this->getData('paging');
	$products = $this->getData('products');

	echo $category->val('category_description');

	$this->renderPartialView('prod-sort', $paging);

	$paging->renderLinks();

?>

<div id="products-container" class="row spaced products">
	<?php
		foreach ( $products as $product) {
			$this->renderPartialView('prod-prev', $product);
		}

		// render Load more... button

		//renderPartial('lmbutton', $paging);
	?>

</div>

<?php
	$paging->renderLinks();
?>

<?php
	$this->renderPartialView('modal-added');
?>

<script>

	function loadMore(offset, limit) {
		$('#load-more-button').remove();
		$('#load-more-waiting').show();
		$.get(
			'<?=$this->url('partials/loadmore') ?>',
			{
				category_ids: '<?=implode(',', $this->getData('ids')) ?>',
				sorting: '<?=$this->getData('sorting') ?>',
				offset: offset,
				limit: limit
			},
			moreLoaded,
			'html'
		);
	}

	function moreLoaded(data) {
		$('#load-more').remove();
		$('#products-container').html(data);
	}


</script>
