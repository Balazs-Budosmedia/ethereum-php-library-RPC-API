<?php
/**
 * Created by Balazs
 * Date: 01/03/17
 * Time: 15:14
 */
ini_set('display_errors',1);
require_once('functions.php');


/*
Accounts:
[0]=>
  string(42) "0x72e1c4b0c31bb6295e186b5759febbd9c62a22bf"
  [1]=>
  string(42) "0xff1678e74dec4c91d77f69a3e42cb32e64727eff"
  [2]=>
  string(42) "0xabf2f368a46b8905d415ad3117029975e0a4316c"
  [3]=>
  string(42) "0xf6e6c009890268bc9f82c124e9c9884de890e59c"

new acc: 0x367b85a06294ff8cfde236f42743761468368fe8
*/

$url =  "http://127.0.0.1";
$port = 8000;

// Block #3
$block = 3;
$hash = "0x2503ead8a49c2ccc3405e7517d46938d0078f05f6bf98ac86ba415a0c7ef1b5d";
$trx_hash = "0xde6fc979cfa22e489c94ed2b9fc133a0fcf70e97787571533d0c8beb419bb3fc";

$eth = new ethereum($url, $port);
$acc = $eth->eth_accounts();
echo '<pre>';

//Not Working with RPC yet
//$modules = $eth->check_modules();
//var_dump($modules);

//$block = $eth->eth_blockNumber(3);
//echo "Latest Block: ".$block;

//$balance = $eth->eth_getBalance($acc[0]);
//echo "Balance: ".$balance." for account ".$acc[0];

//$peers = $eth->admin_peers();
//echo "Connected Peers: <pre>";
//var_dump($peers);

//$node_info = $eth->admin_nodeInfo();
//echo "Node Info: <pre>";
//var_dump($node_info);

//$enode = "enode://a6848bc2a47b91b4ad2b58b788d1bbd3f66bf3e24734f9b8ae2c675b6d8a3c860cc50eb48871d6767446d795cb38e1a10244f7ac6a9ddcde8f66e1755e8994bf@[::]:30303?discport=0";
//$ip = "192.168.0.14";
//$new_peer = $eth->admin_addPeer($enode, $ip);
//echo "Peer added: <pre>";
//var_dump($new_peer);

//same as eth_accounts()
//$accounts = $eth->personal_listAccounts();
//var_dump($accounts);

//$key = "1234";
//$new_acc = $eth->personal_newAccount($key);
//echo "New address: ".$new_acc;

//$unlock_acc = $eth->personal_unlockAccount($acc[4],"1234");
//var_dump($unlock_acc);

//$lock_acc = $eth->personal_lockAccount($acc[4]);
//var_dump($lock_acc);

//$coinbase = $eth->eth_coinbase();
//echo "Coinbase address: ".$coinbase;


//$mining = $eth->eth_mining();
//var_dump($mining);

//$gas_price = $eth->eth_gasPrice();
//var_dump($gas_price);

//$hash_rate = $eth->eth_hashrate();
//echo "Hash rate (H/s): ".$hash_rate;

//$peer_count = $eth->net_peerCount();
//echo "Connected peers: ".$peer_count;

//$syncing = $eth->eth_syncing();
//var_dump($syncing);

//$miner_start = $eth->miner_start();
//echo "Miner Started: ".$miner_start;

//$miner_stop = $eth->miner_stop();
//echo "Miner Stopped: ".$miner_stop;

//$tx_content =  $eth->txpool_content();
//var_dump($tx_content);

//$tx_inspect = $eth->txpool_inspect();
//var_dump($tx_content);

//$tx_staus = $eth->txpool_status();
//var_dump($tx_staus);

//$net_version = $eth->net_version();
//var_dump($net_version);

//$net_listen = $eth->net_listening();
//var_dump($net_listen);

//$eth_prot = $eth->eth_protocolVersion();
//var_dump($eth_prot);

//$web3_ver = $eth->web3_clientVersion();
//var_dump($web3_ver);

//$trx_count = $eth->eth_getTransactionCount($acc[1]);
//var_dump($trx_count);

//$trx_blockCbyhash = $eth->eth_getBlockTransactionCountByHash($hash);
//var_dump($trx_blockCbyhash);

//$trx_blockCbynum = $eth->eth_getBlockTransactionCountByNumber(4);
//var_dump($trx_blockCbynum);

//$UncleCbyhash = $eth->eth_getUncleCountByBlockHash($hash);
//var_dump($UncleCbyhash);

//$UncleCbynum = $eth->eth_getUncleCountByBlockNumber(4);
//var_dump($UncleCbynum);

// TODO SOMETHING STRANGE COMING BACK  -  {"jsonrpc":"2.0","id":4,"result":"0x"}
//$code = $eth->eth_getCode($acc[2]);
//var_dump($code);

//$blockbyhash = $eth->eth_getBlockByHash($hash);
//var_dump($blockbyhash);

//$blockbynum = $eth->eth_getBlockByNumber($block);
//var_dump($blockbynum);

//$trx_byhash = $eth->eth_getTransactionByHash($trx_hash);
//var_dump($trx_byhash);

//$trx_byrec = $eth->eth_getTransactionReceipt($trx_hash);
//var_dump($trx_byrec);

//$compliers = $eth->eth_getCompilers();
//var_dump($compliers);


//$nonce="0x0000000000000001";
//$pow_hash = "0x1234567890abcdef1234567890abcdef1234567890abcdef1234567890abcdef";
//$digest = "0xD1FE5700000000000000000000000000D1FE5700000000000000000000000000";

//$submit_work = $eth->eth_submitWork($nonce,$pow_hash, $digest);
//var_dump($submit_work);


//$hash_rate = "0x500000";
//$ID = "0x59daa26581d0acd1fce254fb7e85952f4c09d0915afd33d3886cd914bc7d283c";
//$submit_hash_rate = $eth->eth_submitHashrate($hash_rate, $ID);
//var_dump($submit_hash_rate);


// TODO Following items [db_] & [shh_] not tesetd yet
/*
$DB_name = "TEST_DB";
$DB_Key = "Key";
$data = "random_data";
$put_str = $eth->db_putString($DB_name, $DB_Key, $data);
var_dump($put_str);

$get_str = $eth->db_getString($DB_name, $DB_Key);
var_dump($get_str);


$DB_Key2 = "Key";
$hex = "0x68656c6c6f20776f726c64";
$put_hex = $eth->db_putHex($DB_name, $DB_Key2, $hex);
var_dump($put_hex);

$get_hex = $eth->db_getHex($DB_name, $DB_Key2);
var_dump($get_hex);

$shh_ver = $eth->shh_version();
var_dump($shh_ver);
*/

//TODO 2: Write test for these as well
//shh_newIdentity(){
//shh_hasIdentity($new_ID_address){


// ------------- SENDING TRANSACTION ---------------- //

//check balance
$balance = $eth->eth_getBalance($acc[0]);
echo "Balance: ".$eth->wei_to_eth($balance)." for account ".$acc[4];

//unlock account
$unlock_acc = $eth->personal_unlockAccount($acc[0],"asdasd");

//calculate gas
$gas_est = $eth->eth_estimateGas($acc[0],$acc[1], $eth->eth_to_wei(0.01));
var_dump($gas_est);

//send transaction
$trx = $eth->eth_sendTransaction($acc[0],$acc[1], $eth->eth_to_wei(0.01),$gas_est);
var_dump($trx);

//check the TX Pool, is it in there....
$tx_content =  $eth->txpool_content();
var_dump($tx_content);
