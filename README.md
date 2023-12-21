# mugroup-store

服务器开启唯一ip访问
firewall-cmd --permanent --add-rich-rule="rule family="ipv4" source address="192.168.0.1" port protocol="tcp" port="9001" accept"
firewall-cmd --reload

// 易仓API接口SOAP协议对接
header("content-type:text/html;charset=utf-8");
try {
$url = "http://nt5e7hf-eb.eccang.com/default/svc-open/web-service-v2";
$soapClient = new SoapClient($url);
$params = [
'paramsJson'    =>  "{}",
'userName'      =>  "NJJ",
'userPass'      =>  "alex02081888",
'service'       =>  "getOrderList"
];
$ret = $soapClient->callService($params);
$arr = get_object_vars($ret);
dump(json_decode($arr['response'], true));
exit;

//            $url = "https://nt5e7hf.eccang.com/default/svc-open/web-service-v2";
//            $soapClient = new SoapClient($url);
//            $params = [
//                'paramsJson'    =>  "{}",
//                'userName'      =>  "NJJ",
//                'userPass'      =>  "alex02081888",
//                'service'       =>  "getOrders"
//            ];
//            $ret = $soapClient->callService($params);
//            $arr = get_object_vars($ret);
//            dump(json_decode($arr['response'], true));
//            exit;
} catch (\SoapFault $e) {
    dump('Exception:'.$e);
}