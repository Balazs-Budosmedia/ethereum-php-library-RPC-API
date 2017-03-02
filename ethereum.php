<?php
/**
 * User: Balazs
 * Date: 01/03/17
 * Time: 15:14
 */
 
 
 //CLASS LIB FILE .. under construction

class ethereum
{
    var $url = null;
    var $port = null;
    var $id = 0;
    var $debug=true;

    function __construct($url, $port){
        //TODO VALIDIATE / CHECK IS IT LIVE
        $this->url = $url;
        $this->port = $port;
    }

    function curl_data($method, $parameters="", $state =null){

        if(!empty($state)) {
            //prepare state
            switch ($state) {
                case 0:
                    $parameters .= '","earliest';
                    break;
                case 1:
                    $parameters .= '","latest';
                    break;
                case 2:
                    $parameters .= '","pending';
                    break;
            }

        }

        $data = '{"jsonrpc":"2.0","method":"'.$method.'","params":["'.$parameters.'"],"id":'.$this->id.'}';
        $ch = curl_init($this->url.":".$this->port);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        if($this->debug) {
            echo "Request: $data \n";
            echo "Result: $result \n";
        }
        $result = json_decode($result);

        $this->id++;
        return $result;
    }

    function check_modules(){
        $method = "modules";
        $resp = $this->curl_data($method);
        return $resp->result;
    }

    function admin_peers(){
        $method = "admin_peers";
        $resp = $this->curl_data($method);
        return $resp->result;
    }

    function admin_nodeInfo(){
        $method = "admin_nodeInfo";
        $resp = $this->curl_data($method);
        return $resp->result;
    }

    function admin_addPeer($enode, $ip){
        $method = "admin_addPeer";

        //STRIP " if left in.
        $enode = str_replace('"',"",$enode);

        //Fill the IP in
        $parameters = str_replace("[::]",$ip,$enode);

        $resp = $this->curl_data($method, $parameters);
        return $resp->result;
    }

    function eth_accounts(){
        $method = "eth_accounts";
        $resp = $this->curl_data($method);
        return $resp->result;
    }

    function eth_blockNumber(){
        $method = "eth_blockNumber";
        $resp = $this->curl_data($method);;
        return hexdec($resp->result);
    }

    function eth_getBalance($account, $state=1){
        $method = "eth_getBalance";
        $resp = $this->curl_data($method, $account, $state);
        return hexdec($resp->result);
    }

    function eth_coinbase(){
        $method = "eth_coinbase";
        $resp = $this->curl_data($method);
        return $resp->result;
    }

    function eth_mining(){
        $method = "eth_mining";
        $resp = $this->curl_data($method);
        return $resp->result;
    }

    function eth_gasPrice(){
        $method = "eth_gasPrice";
        $resp = $this->curl_data($method);
        return hexdec($resp->result);
    }

    function eth_hashrate(){
        if($this->eth_mining()) {
            $method = "eth_hashrate";
            $resp = $this->curl_data($method);
            return hexdec($resp->result);
        } else {
            return "This node is not mining -> Hash rate: 0";
        }
    }

    function net_peerCount(){
        $method = "net_peerCount";
        $resp = $this->curl_data($method);
        return hexdec($resp->result);
    }

    function eth_syncing(){
        $method = "eth_syncing";
        $resp = $this->curl_data($method);
        return $resp->result;
    }

    function admin_datadir(){
        $method = "admin_datadir";
        $resp = $this->curl_data($method);
        return $resp->result;
    }

    function miner_start(){
        $method = "miner_start";
        $resp = $this->curl_data($method);
        return $resp->result;
    }

    function miner_stop(){
        $method = "miner_stop";
        $resp = $this->curl_data($method);
        return $resp->result;
    }

    function miner_startAutoDAG(){
        $method = "miner_startAutoDAG";
        $resp = $this->curl_data($method);
        return $resp->result;
    }

    function miner_stopAutoDAG(){
        $method = "admin_datadir";
        $resp = $this->curl_data($method);
        return $resp->result;
    }

    function personal_listAccounts(){
        $method = "personal_listAccounts";
        $resp = $this->curl_data($method);
        return $resp->result;
    }

    function personal_newAccount($key){
        $method = "personal_newAccount";
        $resp = $this->curl_data($method, $key);
        return $resp->result;

    }

    function personal_unlockAccount($account, $key, $time=""){
        $method = "personal_unlockAccount";
        $parameters = $account.'", "'.$key;
        if(!empty($time)) {
            $parameters .= '", "'.$time;
        }

        $resp = $this->curl_data($method, $parameters);
        return $resp->result;

    }

    function personal_lockAccount($account){
        $method = "personal_lockAccount";
        $resp = $this->curl_data($method, $account);
        return $resp->result;
    }

    function txpool_content(){
        $method = "txpool_content";
        $resp = $this->curl_data($method);
        return $resp->result;
    }

    function txpool_inspect(){
        $method = "txpool_inspect";
        $resp = $this->curl_data($method);
        return $resp->result;
    }

    function txpool_status(){
        $method = "txpool_status";
        $resp = $this->curl_data($method);
        return $resp->result;
    }

    function net_version(){
        $method = "net_version";
        $resp = $this->curl_data($method);
        return $resp->result;
    }

    function net_listening(){
        $method = "net_listening";
        $resp = $this->curl_data($method);
        return $resp->result;
    }

    function eth_protocolVersion(){
        $method = "eth_protocolVersion";
        $resp = $this->curl_data($method);
        return hexdec($resp->result);
    }

    function web3_clientVersion(){
        $method = "web3_clientVersion";
        $resp = $this->curl_data($method);
        return $resp->result;
    }

    function eth_getTransactionCount($account, $state=1){
        $method = "eth_getTransactionCount";
        $resp = $this->curl_data($method, $account, $state);
        return hexdec($resp->result);
    }

    function eth_getBlockTransactionCountByHash($block_hash){
        $method = "eth_getBlockTransactionCountByHash";
        $resp = $this->curl_data($method, $block_hash);
        return hexdec($resp->result);
    }

    function eth_getBlockTransactionCountByNumber($block_number){
        $method = "eth_getBlockTransactionCountByNumber";
        $resp = $this->curl_data($method, $block_number);
        return hexdec($resp->result);
    }

    function eth_getUncleCountByBlockHash($block_hash){
        $method = "eth_getUncleCountByBlockHash";
        $resp = $this->curl_data($method, $block_hash);
        return hexdec($resp->result);
    }

    function eth_getUncleCountByBlockNumber($block_number){
        $method = "eth_getUncleCountByBlockNumber";
        $resp = $this->curl_data($method, $block_number);
        return hexdec($resp->result);
    }

    function eth_getCode($account, $state=1){
        $method = "eth_getCode";
        $resp = $this->curl_data($method, $account, $state);
        return hexdec($resp->result);
    }

    function eth_getBlockByHash($block_hash, $detailed="true"){
        $method = "eth_getBlockByHash";
        $params = $block_hash.'", "'.$detailed;
        $resp = $this->curl_data($method, $params);
        return $resp->result;
    }

    function eth_getBlockByNumber($block_number, $detailed="true"){
        $method = "eth_getBlockByNumber";
        $params = $block_number.'", "'.$detailed;
        $resp = $this->curl_data($method, $params);
        return $resp->result;
    }

    function eth_getTransactionByHash($trx_hash){
        $method = "eth_getTransactionByHash";
        $resp = $this->curl_data($method, $trx_hash);
        return $resp->result;
    }

    function eth_getTransactionReceipt($trx_hash){
        $method = "eth_getTransactionReceipt";
        $resp = $this->curl_data($method, $trx_hash);
        return $resp->result;
    }

    function eth_getCompilers(){
        $method = "eth_getCompilers";
        $resp = $this->curl_data($method);
        return hexdec($resp->result);
    }




/*
 * for GETBLOCK
if(is_numeric($block)) {
$parameter = $block;
} else {
    $parameter = "'pending'";
}
//IN PROGRESS...

    ADMIN
        setSolc
        startRPC
        startWS
        stopRPC
        stopWS

    PERSONAL
        ecRecover
        importRawKey
        sendTransaction
        sign

    MINER
        makeDAG
        setExtra
        setGasPrice

    web3_sha3
    eth_getStorageAt
    eth_sign
    eth_sendTransaction
    eth_sendRawTransaction
    eth_call
    eth_estimateGas

    eth_compileLLL
    eth_compileSolidity
    eth_compileSerpent
    eth_newFilter
    eth_newBlockFilter
    eth_newPendingTransactionFilter
    eth_uninstallFilter
    eth_getFilterChanges
    eth_getFilterLogs
    eth_getLogs
    eth_getWork
    eth_submitWork
    eth_submitHashrate
    db_putString
    db_getString
    db_putHex
    db_getHex
    shh_post
    shh_version
    shh_newIdentity
    shh_hasIdentity
    shh_newGroup
    shh_addToGroup
    shh_newFilter
    shh_uninstallFilter
    shh_getFilterChanges
    shh_getMessages

*/


}
