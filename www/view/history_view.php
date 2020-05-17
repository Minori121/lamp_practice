<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>購入履歴</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'admin.css'); ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  <h1>購入履歴</h1>

  <div class="container">
    <?php include VIEW_PATH . 'templates/messages.php'; ?>

    <?php if(count($histories) > 0){ ?>
      <table class="table table-bordered">
        <thead class="thead-light">
          <tr>
            <th>注文番号</th>
            <th>購入日時</th>
            <th>合計金額</th>
            <th>購入明細</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($histories as $history){ ?>
          <tr>
            <td><?php print(h($history['history_id'])); ?></td>
            <td><?php print(h($history['create_datetime'])); ?></td>
            <td><?php print(number_format($history['total_price'])); ?>円</td>
            <td>
            <form method="post" action="history_details.php">
                <input type="submit" value="明細をみる">
                <input type="hidden" name="history_id" value="<?php print(h($history['history_id'])); ?>">
                <input type="hidden" name="create_datetime" value="<?php print(h($history['create_datetime'])); ?>">
                <input type="hidden" name="total_price" value="<?php print(number_format($history['total_price'])); ?>">
            </form>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } ?>
  </div>
</body>
</html>
