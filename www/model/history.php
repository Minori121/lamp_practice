<?php
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

function insert_history($db, $user_id){

    $sql = "
      INSERT INTO
        history(
          user_id
        )
      VALUES(?);
    ";

    return execute_query($db, $sql, array($user_id));

}

function insert_history_detail($db, $history_id, $carts){
  foreach($carts as $cart){
    $sql = "
      INSERT INTO
        history_details(
          history_id,
          item_id,
          amount,
          price
        )
      VALUES(?, ?, ?, ?);
      ";
    execute_query($db, $sql, array($history_id, $cart['item_id'], $cart['amount'], $cart['price']));
  }
}

function get_all_histories($db){
  $sql = "
    SELECT
      history.history_id,
      history.create_datetime,
      SUM(history_details.amount * history_details.price) AS total_price
    FROM
      history
    JOIN
      history_details
    ON
      history.history_id = history_details.history_id
    GROUP BY
      history_id
  ";
  return fetch_all_query($db, $sql);
}

function get_user_histories($db, $user_id){
  $sql = "
    SELECT
      history.history_id,
      history.create_datetime,
      SUM(history_details.amount * history_details.price) AS total_price
    FROM
      history
    JOIN
      history_details
    ON
      history.history_id = history_details.history_id
    WHERE
      history.user_id = ?
    GROUP BY
      history_id
  ";
  return fetch_all_query($db, $sql, array($user_id));
}

function get_user_history_details($db, $history_id){
  $sql = "
    SELECT
      history_details.amount,
      history_details.price,
      items.name
    FROM
      history_details
    INNER JOIN
      items
    ON
      history_details.item_id = items.item_id
    WHERE
      history_details.history_id = ?
  ";
  return fetch_all_query($db, $sql, array($history_id));
}
