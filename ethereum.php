<?php
/**
 * Created by Balazs
 * Date: 01/03/17
 * Time: 15:14
 */

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


    //Supplimental functions
    function eth_to_wei($eth){
        return $eth * 1000000000000000000;
    }

    function wei_to_eth($eth){
        return $eth / 1000000000000000000;
    }

    //ETH Functions - RPC API
    function curl_data($method, $parameters="", $state =null, $boolean=null){

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
        if(!empty($boolean)) {
            if ($boolean) {
                $insert = ",true";
            } else {
                $insert = ", false";
            }
        } else {
            $insert = "";
        }

        if(!empty($parameters) AND substr($parameters,0,1)=="{") {
            $data = '{"jsonrpc":"2.0","method":"'.$method.'","params":['.$parameters.'],"id":'.$this->id.'}';
        } else {
            $data = '{"jsonrpc":"2.0","method":"' . $method . '","params":["' . $parameters . '"' . $insert . '],"id":' . $this->id . '}';
        }
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
        $resp = $this->curl_data($method, $block_hash, null, $detailed);
        return $resp->result;
    }

    function eth_getBlockByNumber($block_number, $detailed="true"){
        $method = "eth_getBlockByNumber";
        $resp = $this->curl_data($method, $block_number, null, $detailed);
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

    function eth_submitWork($nonce, $pow_hash, $mix_dig){
        $method = "eth_submitWork";
        $param = $nonce.'", "'.$pow_hash.'", "'.$mix_dig;
        $resp = $this->curl_data($method, $param);
        return $resp->result;
    }

    function eth_submitHashrate($hash_rate, $ID_string){
        $method = "eth_submitHashrate";
        $param = $hash_rate.'", "'.$ID_string;
        $resp = $this->curl_data($method,$param);
        return $resp->result;
    }

    function db_putString($DB_name, $key_name, $data){
        $method = "db_putString";
        $param = $DB_name.'", "'.$key_name.'", "'.$data;
        $resp = $this->curl_data($method, $param);
        return $resp->result;
    }

    function db_getString($DB_name, $key_name){
        $method = "db_getString";
        $param = $DB_name.'", "'.$key_name;
        $resp = $this->curl_data($method, $param);
        return $resp->result;
    }

    function db_putHex($DB_name, $key_name, $hex){
        $method = "db_putHex";
        $param = $DB_name.'", "'.$key_name.'", "'.$hex;
        $resp = $this->curl_data($method,$param);
        return $resp->result;
    }

    function db_getHex($DB_name, $key_name){
        $method = "db_getHex";
        $param = $DB_name.'", "'.$key_name;
        $resp = $this->curl_data($method);
        return $resp->result;
    }

    function shh_version(){
        $method = "shh_version";
        $resp = $this->curl_data($method);
        return $resp->result;
    }

    function shh_newIdentity(){
        $method = "shh_newIdentity";
        $resp = $this->curl_data($method);
        return $resp->result;
    }

    function shh_hasIdentity($new_ID_address){
        $method = "shh_hasIdentity";
        $resp = $this->curl_data($method, $new_ID_address);
        return $resp->result;
    }

    function eth_sendTransaction($from, $to, $value,  $gas="", $data_hex="", $gasPrice=""){
        $method = "eth_sendTransaction";

        $params = '{"from":"'.$from.'", "to":"'.$to.'", "value":"0x'.dechex($value).'"';
        if(!empty($data_hex)) {
            $params .=', "data":"'.$data_hex.'"';
        }
        if(!empty($gas)) {
            $params .=', "gas":"0x'.dechex($gas).'"';
        }
        if(!empty($gasPrice)) {
            $params .=', "gasPrice":"'.$gasPrice.'"';
        }


        $params .= '}';
        $resp = $this->curl_data($method, $params);

        if(isset($resp->result)){
            return $resp->result;
        } else {
            return $resp->error;
        }
    }

    function eth_estimateGas($from, $to, $value,  $gas="", $data_hex="", $gasPrice=""){
        $method = "eth_estimateGas";

        $params = '{"from":"'.$from.'", "to":"'.$to.'", "value":"0x'.dechex($value).'"';
        if(!empty($data_hex)) {
            $params .=', "data":"'.$data_hex.'"';
        }
        if(!empty($gas)) {
            $params .=', "gas":"0x'.dechex($gas).'"';
        }
        if(!empty($gasPrice)) {
            $params .=', "gasPrice":"'.$gasPrice.'"';
        }


        $params .= '}';
        $resp = $this->curl_data($method, $params);

        if(isset($resp->result)){
            return hexdec($resp->result);
        } else {
            return $resp->error;
        }

    }

    function eth_getWork(){
        $method = "eth_getWork";
        $resp = $this->curl_data($method);
        return $resp->result;
    }

    function web3_sha3($data_to_SHA3){
        $method = "web3_sha3";
        $resp = $this->curl_data($method, "0x".$data_to_SHA3);
        return $resp->result;
    }

    function shh_post($topics, $payload, $ttl=null, $priority=null, $from="", $to=""){
        $method = "shh_post";
        $params = '{"topics": '.$topics.', "payload":"'.$payload.'"';

        // TODO FIX Priority and TTL!!!!
        //, "priority": 0x'.dechex($priority);//. "ttl":0x'.dechex($ttl);//.', "priority": 0x'.dechex($priority).'';

        if(!empty($from)) {
            $params .=', "from":"'.$from.'"';
        }
        if(!empty($to)) {
            $params .=', "to":"0x'.$to.'"';
        }

        $params .= '}';
        $resp = $this->curl_data($method, $params);

        if(isset($resp->result)){
            return $resp->result;
        } else {
            return $resp->error;
        }
    }

/*
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

    eth_getStorageAt
    eth_sign
    eth_sendRawTransaction
    eth_call
    eth_getTransactionByBlockHashAndIndex
    eth_getTransactionByBlockNumberAndIndex
    eth_getUncleByBlockHashAndIndex
    eth_getUncleByBlockNumberAndIndex
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
    shh_newGroup
    shh_addToGroup
    shh_newFilter
    shh_uninstallFilter
    shh_getFilterChanges
    shh_getMessages

*/


}
