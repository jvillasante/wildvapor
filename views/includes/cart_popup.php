<?php if (isset($cart)) { ?>
<a id="cart-link" href="#cart" title="Cart"><?php echo $this->tr('cart-box.title', array('count' => $cart['count'], 'total' => number_format($cart['total'], 2))); ?></a>
<div id="cart-panel">
  <div class="item-cart">
    <table>
      <tbody>
        <?php foreach ($cart['cart_items'] as $_row) { ?>
          <tr>
            <td class="image"><a href="<?php echo $this->url('/products/'.$_row['cname'].'/'.$_row['id']); ?>"><img width="60" height="60" src="<?php echo $this->uploads_thumb($_row['image']); ?>" alt="product" title="product"></a></td>
            <td class="name"><a title="<?php echo $_row['name']; ?>" href="<?php echo $this->url('/products/'.$_row['cname'].'/'.$_row['id']); ?>"><?php echo \Helpers\Util::safe_truncate($this->out($_row['name']), 25); ?></a></td>
            <td class="quantity">x&nbsp;<?php echo $_row['quantity']; ?></td>
            <td class="total">$<?php echo number_format($_row['quantity'] * \Helpers\Util::get_just_price($_row['price'], $_row['sale_price']), 2); ?></td>
            <td class="remove"><i class="icon-remove"></i></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <table>
      <tbody>
        <tr>
          <td class="textright"><b>Sub-Total:</b></td>
          <td class="textright">$<?php echo number_format($cart['subtotal'], 2); ?></td>
        </tr>
        <tr>
          <td class="textright"><b>Tax:</b></td>
          <td class="textright">+$<?php echo number_format($cart['tax'], 2); ?></td>
        </tr>
        <tr>
          <td class="textright"><b>Total:</b></td>
          <td class="textright">$<?php echo number_format($cart['total'], 2); ?></td>
        </tr>
      </tbody>
    </table>
    <div class="buttoncart">
      <a href="<?php echo $this->url('/shop/cart'); ?>">View Cart</a>
      <a href="<?php echo $this->url_secure('/shop/checkout'); ?>">Checkout</a>
    </div>
  </div>
<?php } else { ?>
  <a id="cart-link" href="#cart" title="Cart"><?php echo $this->tr('cart-box.title', array('count' => 0, 'total' => 0)); ?></a>
  <div id="cart-panel">
    <div class="item-cart">
      <table>
        <tbody>
        </tbody>
      </table>
      <table>
        <tbody>
          <tr>
            <td class="textright"><b>Sub-Total:</b></td>
            <td class="textright">$0.00</td>
          </tr>
          <tr>
            <td class="textright"><b>Tax:</b></td>
            <td class="textright">+$0.00</td>
          </tr>
          <tr>
            <td class="textright"><b>Total:</b></td>
            <td class="textright">$0.00</td>
          </tr>
        </tbody>
      </table>
      <div class="buttoncart">
        <em>Empty Cart</em>
      </div>
    </div>
<?php } ?>
