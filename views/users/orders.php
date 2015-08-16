<div class="container-2">
  <div style="clear:both; display:block; height:40px"></div>
    <?php if ($orders) { ?>
      <table class="shopping-cart">
        <tr>
          <th class="image">Order Id</th>
          <th class="name">Total</th>
          <th class="quantity">Tax</th>
          <th class="total">Date</th>
          <th class="action">Action</th>
        </tr>
        <?php foreach ($orders as $order) { ?>
          <tr>
            <td class="name"><?php echo $order['id']; ?></td>
            <td class="total">$<?php echo number_format($order['total'], 2); ?></td>
            <td class="price">$<?php echo $order['tax']; ?></td>
            <td class="name"><?php echo $order['date']; ?></td>
            <td class="remove-update"><a href="<?php echo $this->url('/users/'.$_SESSION['user_id'].'/orders/'.$order['id']); ?>" class="tip update" original-title="View Order"><img src="<?php echo $this->path('images/update.png'); ?>" alt=""></a>
            </td>
          </tr>
        <?php } ?>
      </table>
    <?php } else { ?>
     <h3>No Orders to show!</h3>
    <?php } ?>
  <div style="clear:both; display:block; height:40px"></div>
</div><!--end:container-2-->
