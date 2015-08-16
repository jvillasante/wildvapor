<div class="container-2">
<?php if (isset($wish_list)) { ?>
  <div style="clear:both; display:block; height:40px"></div>
  <form method="post" action="<?php echo $this->url('/shop/wishlist'); ?>">
  <h2>Wish List&nbsp;<small>Your Wish List. Please use this form to update your wish list. You may change the quantities, move items to your cart for purchasing, or remove items entirely.</small></h2>
    <table class="shopping-cart">
      <tr>
        <th class="image">Image</th>
        <th class="name">Product Name</th>
        <th class="quantity">Quantity</th>
        <th class="price">Unit Price</th>
        <th class="total">Total</th>
        <th class="action">Action</th>
      </tr>
      <?php foreach ($wish_list['wish_list_items'] as $row) { ?>
        <tr>
          <td class="image"><a href="<?php echo $this->url('/products/'.$row['cname'].'/'.$row['id']); ?>"><img title="product" alt="product" src="<?php echo $this->uploads_thumb($row['image']); ?>" height="50" width="50"></a></td>
          <td  class="name"><a href="<?php echo $this->url('/products/'.$row['cname'].'/'.$row['id']); ?>"><?php echo $row['name']; ?></a></td>
          <td class="quantity">
            <input type="text" size="1" value="<?php echo $row['quantity']; ?>" name="quantity[<?php echo md5($row['id'] . $row['attributes']); ?>]" class="span1">
            <input type="hidden" value="<?php echo $row['id'] . '|' . $row['attributes']; ?>" name="attributes[<?php echo md5($row['id'] . $row['attributes']); ?>]">
          </td>
          <td class="price">$<?php echo \Helpers\Util::get_just_price($row['price'], $row['sale_price']); ?></td>
          <td class="total">$<?php echo number_format($row['quantity'] * \Helpers\Util::get_just_price($row['price'], $row['sale_price']), 2); ?></td>
          <td class="remove-update">
            <a href="<?php echo $this->url('/shop/wishlist?action=remove&id=' . $row['id'] .
              '&attributes=' . $row['attributes']); ?>" class="tip remove" title="Remove from Wish List"><img src="<?php echo $this->path('images/remove.png'); ?>" alt=""></a>
            <a href="<?php echo $this->url('/shop/wishlist?action=move&id=' . $row['id'] .
              '&qty=' . $row['quantity'] . '&attributes=' . $row['attributes']); ?>" class="tip update" original-title="Move to Cart"><img src="<?php echo $this->path('images/update.png'); ?>" alt=""></a>
          </td>
        </tr>
      <?php } ?>
    </table>
    <div class="contentbox">
    <div class="cartoptionbox one-half first">
  </div><!--cartoptionbox-->
    <div class="alltotal one-half">
    <table class="alltotal">
      <tr>
        <td><span class="extra">Sub-Total :</span></td>
        <td><span>$<?php echo number_format($wish_list['subtotal'], 2); ?></span></td>
      </tr>
      <tr>
        <td><span class="extra">Tax:</span></td>
        <td><span>+$<?php echo number_format($wish_list['tax'], 2); ?></span></td>
      </tr>
      <tr>
        <td><span class="extra grandtotal">Total :</span></td>
        <td><span class="grandtotal">$<?php echo number_format($wish_list['total'], 2); ?></span></td>
      </tr>
    </table>
    <input type="submit" value="Update Quantities">
    <a href="<?php echo $this->url('/'); ?>"><input type="button" value="Continue Shopping"></a>
    <a href="<?php echo $this->url('/shop/wishlist?action=clear'); ?>"><input type="button" value="Clear"></a>
  </div><!--end:alltotal-->
  </div><!--end:contentbox-->
  </form>

  <?php $recommended_products = \Data\ProductsRepository::get_recommended_products($db, $wish_list['ids']); ?>
  <?php if (isset($recommended_products) && count($recommended_products)) { ?>
    <div class="relatedprod">
      <h4>Customers who bought this also bought:</h4>
      <?php foreach ($recommended_products as $rp) { ?>
        <div class="entry">
          <div class="da-thumbs">
            <div class="div-related">
              <img src="<?php echo $this->uploads_small($rp['image']); ?>" alt="">
              <article class="da-animate da-slideFromRight" style="display: block;">
                <p>
                  <a href="<?php echo $this->url('/products/' . $rp['cname'] . '/'. $rp['id']); ?>" class="link tip" title="View Detail"></a>&nbsp;
                </p>
              </article>
            </div>
          </div>
          <h3><a href="<?php echo $this->url('/products/accessories/'.$rp['id']); ?>"><?php echo $rp['name']; ?></a></h3>
          <span>$<?php echo \Helpers\Util::get_just_price($rp['price'], $rp['sale_price']); ?></span>
        </div>
      <?php } ?>
    </div>
  <?php } ?>

  <div style="clear:both; display:block; height:40px"></div>
<?php } else { ?>
  <div style="clear:both; display:block; height:40px"></div>
  <h2>Wish List &nbsp;<small>Your wish list is empty</small></h2>
  <div style="clear:both; display:block; height:40px"></div>
<?php } ?>
</div><!--end:container-2-->
