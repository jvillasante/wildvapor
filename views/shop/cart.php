<div class="container-2">
<?php if (isset($cart)) { ?>
  <div style="clear:both; display:block; height:40px"></div>
  <form method="post" action="<?php echo $this->url('/shop/cart'); ?>">
  <h2>Shopping Cart &nbsp;<small>Your shopping cart. Please use this form to update your shopping cart. You may change the quantities, move items to your wish list for future purchasing, or remove items entirely. When you are ready to complete your purchase, please click Checkout to be taken to a secure page for processing.</small></h2>
    <table class="shopping-cart">
      <tr>
        <th class="image">Image</th>
        <th class="name">Product Name</th>
        <th class="quantity">Quantity</th>
        <th class="price">Unit Price</th>
        <th class="total">Total</th>
        <th class="action">Action</th>
      </tr>
      <?php foreach ($cart['cart_items'] as $row) { ?>
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
            <a href="<?php echo $this->url('/shop/cart?action=remove&id=' . $row['id'] .
              '&attributes=' . $row['attributes']); ?>" class="tip remove" title="Remove from Cart"><img src="<?php echo $this->path('images/remove.png'); ?>" alt=""></a>
            <a href="<?php echo $this->url('/shop/cart?action=move&id=' . $row['id'] .
              '&qty=' . $row['quantity'] . '&attributes=' . $row['attributes']); ?>" class="tip update" original-title="Move to Wish List"><img src="<?php echo $this->path('images/update.png'); ?>" alt=""></a>
          </td>
        </tr>
      <?php } ?>
    </table>
    <div class="contentbox">
    <div class="cartoptionbox one-half first">
    <?php
      if (isset($cart['messages']) && count($cart['messages'])) {
        echo '<table class="alltotal">';
        foreach ($cart['messages'] as $message) {
          echo '<tr><td><span>' . $message . '</span></td></tr>';
        }
        echo '</table>';
      }
    ?>
  </div><!--cartoptionbox-->
    <div class="alltotal one-half">
    <table class="alltotal">
      <tr>
        <td><span class="extra">Sub-Total :</span></td>
        <td><span>$<?php echo number_format($cart['subtotal'], 2); ?></span></td>
      </tr>
      <tr>
        <td><span class="extra">Tax:</span></td>
        <td><span>+$<?php echo number_format($cart['tax'], 2); ?></span></td>
      </tr>
      <tr>
        <td><span class="extra grandtotal">Total :</span></td>
        <td><span class="grandtotal">$<?php echo number_format($cart['total'], 2); ?></span></td>
      </tr>
    </table>

    <input type="submit" value="Update Quantities">
    <a href="<?php echo $this->url('/shop/cart?action=clear'); ?>"><input type="button" value="Clear"></a>
    <a href="<?php echo $this->url_secure('/shop/checkout'); ?>"><input type="button" value="Checkout"></a>
  </div><!--end:alltotal-->
  </div><!--end:contentbox-->
  </form>

  <?php $recommended_products = \Data\ProductsRepository::get_recommended_products($db, $cart['ids']); ?>
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
  <h2>Shopping Cart &nbsp;<small>Your shopping cart is empty</small></h2>
  <div style="clear:both; display:block; height:40px"></div>
<?php } ?>
</div><!--end:container-2-->
