<?php if (isset($cart)) { ?>
<p>
  This is step 3 (final) of your Checkout Process. Please, review your order and when you're ready click "Place Order" to order the contents of your Shopping Cart.
</p>

  <table class="shopping-cart">
    <tr>
      <th class="image">Image</th>
      <th class="name">Product Name</th>
      <th class="quantity">Quantity</th>
      <th class="price">Unit Price</th>
      <th class="total">Total</th>
    </tr>
    <?php foreach ($cart['cart_items'] as $row) { ?>
      <tr>
        <td class="image"><a href="<?php echo $this->url('/products/'.$row['cname'].'/'.$row['id']); ?>"><img title="product" alt="product" src="<?php echo $this->uploads_thumb($row['image']); ?>" height="50" width="50"></a></td>
        <td class="name"><a href="<?php echo $this->url('/products/'.$row['cname'].'/'.$row['id']); ?>"><?php echo $row['name']; ?></a></td>
        <td class="quantity"><?php echo $row['quantity']; ?></td>
        <td class="price">$<?php echo \Helpers\Util::get_just_price($row['price'], $row['sale_price']); ?></td>
        <td class="total">$<?php echo number_format($row['quantity'] * \Helpers\Util::get_just_price($row['price'], $row['sale_price']), 2); ?></td>
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
    </div>
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
      <a href="<?php echo $this->url('/'); ?>"><input type="button" value="Continue Shopping"></a>
      <input type="submit" value="Place Order"><br />
      <small>By clicking the 'Place Order' button, your order will be completed and your credit card will be charged.</small>
    </div>
<?php } else { ?>
  <h2>Shopping Cart &nbsp;<small>Your shopping cart is empty.</small></h2>
  <p>There is nothing to buy. Please, add products to your shopping cart and come back here later to by them all.</p>
<?php } ?>
