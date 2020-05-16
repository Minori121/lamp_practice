<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';
require_once MODEL_PATH . 'history.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);


/*カートに入っているものをトル*/
$carts = get_user_carts($db, $user['user_id']);

if(validate_cart_purchase($carts) !== false) {
  $db->beginTransaction();
  try {
    purchase_carts($db, $carts);

    insert_history($db, $carts[0]['user_id']);
    $history_id = $db->lastInsertId();
    insert_history_detail($db, $history_id, $carts);
    delete_user_carts($db, $carts[0]['user_id']);
    $db->commit();
  } catch (PDOException $e) {
    $db->rollback();
    throw $e;
  }

}


$total_price = sum_carts($carts);

include_once '../view/finish_view.php';
