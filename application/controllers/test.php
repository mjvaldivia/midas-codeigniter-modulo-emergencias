<?php

class Test extends MY_Controller 
{
    
    public function comprimir(){
        $filter     = new Zend_Filter_Compress('Bz2');
        $compressed = $filter->filter(
                'a:2:{s:4:"type";s:15:"MultiLineString";s:11:"coordinates";a:1:{i:0;a:25:{i:0;a:2:{i:0;d:323073.5208;i:1;d:6410523.3888999997;}i:1;a:2:{i:0;d:323000.85610000044;i:1;d:6410506.2089999998;}i:2;a:2:{i:0;d:322934.71009999979;i:1;d:6410512.8235999998;}i:3;a:2:{i:0;d:322875.17879999988;i:1;d:6410559.1257999996;}i:4;a:2:{i:0;d:322795.80360000022;i:1;d:6410631.8864000002;}i:5;a:2:{i:0;d:322718.0833;i:1;d:6410696.3888999997;}i:6;a:2:{i:0;d:322689.11459999997;i:1;d:6410711.8888999997;}i:7;a:2:{i:0;d:322456.5208;i:1;d:6410836.8888999997;}i:8;a:2:{i:0;d:322402.1458;i:1;d:6410989.8888999997;}i:9;a:2:{i:0;d:322379.08399999997;i:1;d:6411041.9912999999;}i:10;a:2:{i:0;d:322332.7818;i:1;d:6411088.2934999997;}i:11;a:2:{i:0;d:322272.30209999997;i:1;d:6411109.3888999997;}i:12;a:2:{i:0;d:322220.33370000031;i:1;d:6411088.2934999997;}i:13;a:2:{i:0;d:322200.48990000039;i:1;d:6411088.2934999997;}i:14;a:2:{i:0;d:322154.18769999966;i:1;d:6411114.7518999996;}i:15;a:2:{i:0;d:322107.88559999969;i:1;d:6411154.4395000003;}i:16;a:2:{i:0;d:322054.96879999997;i:1;d:6411174.2833000002;}i:17;a:2:{i:0;d:321943.61459999997;i:1;d:6411188.8888999997;}i:18;a:2:{i:0;d:321863.14549999963;i:1;d:6411233.8146000002;}i:19;a:2:{i:0;d:321830.07249999978;i:1;d:6411286.7313999999;}i:20;a:2:{i:0;d:321783.77029999997;i:1;d:6411346.2627999997;}i:21;a:2:{i:0;d:321677.93680000026;i:1;d:6411366.1065999996;}i:22;a:2:{i:0;d:321605.17619999964;i:1;d:6411419.0232999995;}i:23;a:2:{i:0;d:321494.05209999997;i:1;d:6411447.3888999997;}i:24;a:2:{i:0;d:321387.3333;i:1;d:6411434.3888999997;}}}}');
        echo $compressed;
    }
    
    public function descomprimir(){
        
        $filter     = new Zend_Filter_Compress('Bz2');
        $compressed = $filter->filter(
                'a:2:{s:4:"type";s:15:"MultiLineString";s:11:"coordinates";a:1:{i:0;a:25:{i:0;a:2:{i:0;d:323073.5208;i:1;d:6410523.3888999997;}i:1;a:2:{i:0;d:323000.85610000044;i:1;d:6410506.2089999998;}i:2;a:2:{i:0;d:322934.71009999979;i:1;d:6410512.8235999998;}i:3;a:2:{i:0;d:322875.17879999988;i:1;d:6410559.1257999996;}i:4;a:2:{i:0;d:322795.80360000022;i:1;d:6410631.8864000002;}i:5;a:2:{i:0;d:322718.0833;i:1;d:6410696.3888999997;}i:6;a:2:{i:0;d:322689.11459999997;i:1;d:6410711.8888999997;}i:7;a:2:{i:0;d:322456.5208;i:1;d:6410836.8888999997;}i:8;a:2:{i:0;d:322402.1458;i:1;d:6410989.8888999997;}i:9;a:2:{i:0;d:322379.08399999997;i:1;d:6411041.9912999999;}i:10;a:2:{i:0;d:322332.7818;i:1;d:6411088.2934999997;}i:11;a:2:{i:0;d:322272.30209999997;i:1;d:6411109.3888999997;}i:12;a:2:{i:0;d:322220.33370000031;i:1;d:6411088.2934999997;}i:13;a:2:{i:0;d:322200.48990000039;i:1;d:6411088.2934999997;}i:14;a:2:{i:0;d:322154.18769999966;i:1;d:6411114.7518999996;}i:15;a:2:{i:0;d:322107.88559999969;i:1;d:6411154.4395000003;}i:16;a:2:{i:0;d:322054.96879999997;i:1;d:6411174.2833000002;}i:17;a:2:{i:0;d:321943.61459999997;i:1;d:6411188.8888999997;}i:18;a:2:{i:0;d:321863.14549999963;i:1;d:6411233.8146000002;}i:19;a:2:{i:0;d:321830.07249999978;i:1;d:6411286.7313999999;}i:20;a:2:{i:0;d:321783.77029999997;i:1;d:6411346.2627999997;}i:21;a:2:{i:0;d:321677.93680000026;i:1;d:6411366.1065999996;}i:22;a:2:{i:0;d:321605.17619999964;i:1;d:6411419.0232999995;}i:23;a:2:{i:0;d:321494.05209999997;i:1;d:6411447.3888999997;}i:24;a:2:{i:0;d:321387.3333;i:1;d:6411434.3888999997;}}}}');
      
        
        $filter     = new Zend_Filter_Decompress('Bz2');
        $decompressed = $filter->filter($compressed);
        
        echo $decompressed;
    }
}
