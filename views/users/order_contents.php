<div class="container-2">
  <div style="clear:both; display:block; height:40px"></div>
    <h2><strong>Order #<?php echo $order_id; ?></strong></h2>
    <table class="shopping-cart">
      <tr>
        <th class="image">Image</th>
        <th class="name">Product Name</th>
        <th class="quantity">Quantity</th>
        <th class="price">Unit Price</th>
        <th class="total">Total</th>
        <th class="total">Ship Date</th>
      </tr>
      <?php foreach ($order_contents as $row) { ?>
        <tr>
          <td class="image"><a href="<?php echo $this->url('/products/'.$row['cname'].'/'.$row['id']); ?>"><img title="product" alt="product" src="<?php echo $this->uploads_thumb($row['image']); ?>" height="50" width="50"></a></td>
          <td class="name"><a href="<?php echo $this->url('/products/'.$row['cname'].'/'.$row['id']); ?>"><?php echo $row['name']; ?></a></td>
          <td class="quantity"><?php echo $row['quantity']; ?></td>
          <td class="price">$<?php echo $row['price_per']; ?></td>
          <td class="total">$<?php echo number_format($row['subtotal'], 2); ?></td>
          <td class="total"><?php echo ($row['ship_date']) ? $row['ship_date'] : 'Not Shipped Yet'; ?></td>
        </tr>
      <?php } ?>
    </table>
    <div class="contentbox">
      <div class="cartoptionbox one-half first">
      </div><!--cartoptionbox-->
    </div>
    <div class="alltotal one-half">
      <?php $order = $order_contents[0]; ?>
      <table class="alltotal">
        <tr>
          <td><span class="extra">Sub-Total :</span></td>
          <td><span>$<?php echo number_format($order['total'] - $order['tax'], 2); ?></span></td>
        </tr>
        <tr>
          <td><span class="extra">Tax :</span></td>
          <td><span>+$<?php echo number_format($order['tax'], 2); ?></span></td>
        </tr>
        <tr>
          <td><span class="extra grandtotal">Total :</span></td>
          <td><span class="grandtotal">$<?php echo number_format($order['total'], 2); ?></span></td>
        </tr>
      </table>
    </div>
  <div style="clear:both; display:block; height:40px"></div>
</div><!--end:container-2-->
