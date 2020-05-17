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

$history_id = get_post('history_id');
$create_datetime = get_post('create_datetime');
$total_price = get_post('total_price');

$details = get_user_history_details($db, $history_id);


include_once VIEW_PATH . 'history_details_view.php';
