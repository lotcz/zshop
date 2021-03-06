<!-- Modal -->
<div class="modal fade" id="modal-added" tabindex="-1" role="dialog" aria-labelledby="addedModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="<?=$this->t('Close') ?>">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="addedModalLabel"><?=$this->t('Product was added to cart.') ?></h5>
      </div>
      <div class="modal-body">
        <div class="table-responsive panel panel-default cart">
          <table class="table">
            <tbody>
                <tr class="item" id="modal-added-item">
                  <!-- Here comes added product -->
                </tr>
              </tbody>
            </table>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary continue-shopping-button" data-dismiss="modal"><?=$this->t('Continue shopping') ?></button>
        <a type="button" class="btn btn-success go-to-cart-button" href="<?=$this->url('cart') ?>"><?=$this->t('Go to cart') ?></a>
      </div>
    </div>
  </div>
</div>

<script>
	<?=$this->z->i18n->jsFormatPrice();?>
</script>
