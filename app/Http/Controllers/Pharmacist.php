<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Pharmacist extends Controller
{

    //traverse throught medicine in depot refering to its category
    public function traverse(){
        $filepath = ''; // path of pharmacy file .json
        $filecontent = file_get_contents($filepath);
        $jsoncontent = json_decode($filecontent , true);
        foreach($jsoncontent as $item){
            // sort based on category
        }
        return response()->json([
            $jsoncontent
        ]);

    }

    //order from depot
    public function order(Request $request){
        $pharmacist = request();
        $sc_name[] = $request->input();
        $qty[] = $request->input();

// Medicine in depot path
        $Medicinepath = "C:\xampp\htdocs\programming\Medicines.json";
        $Medicinecontent = file_get_contents($Medicinepath);
        $jsonMedicine = json_decode($Medicinecontent , true);

// orders path
        $orderpath = 'C:\xampp\htdocs\programming\orders.json' ;
        $ordercontent = file_get_contents($orderpath);
        $jsonorder = json_decode($ordercontent , true);
// adding order

        $exist = false ;
        if(!$sc_name || !$qty){
            return response()->json([
                'message' => 'All fields are required'
            ]);
        }
        else{
            for($i = 0 ;$i < count($sc_name) ; $i++){
                foreach($jsonMedicine as $item){
                    if($item['sc_name'] == $sc_name[$i]){
                        $exist = true ;
                        if($item['qty'] < $qty[$i]){
                            return response()->json([
                                'message' => 'Quantity you are asking for is more than existed'
                            ]);
                        }
                    }

                    else{
                        return response()->json([
                            'message' => sprintf('%s This medicine is not existed' , $sc_name[$i])
                        ]);
                    }
                }
            }
            $total_price = 0 ;
            for($i = 0 ;$i < count($sc_name) ; $i++){
                foreach($jsonMedicine as $item){
                    if($item['sc_name'] == $sc_name[$i]){
                        $total_price += ($item['price'] * $qty[$i]);
                    }
                }
            }
            $info = [
                'pharmacist' => $pharmacist ,
                'statue' => 'bending',
                'paid' => false ,
                'med' => [
                    'name' => $sc_name ,
                    'qty' => $qty
                ],
                'total_price' => $total_price,
            ];

            if(!$ordercontent || !is_array($ordercontent)){
                $content = [ $info ];
                file_put_contents($orderpath , json_encode($content));
                return response()->json([
                    'message' => 'order added successfully'
                ]);
            }
            else{
                $ordercontent[] = $info ;
                file_put_contents($orderpath , json_encode($ordercontent));
                return response()->json([
                    'message' => 'order added successfully'
                ]);
            }

        }
    }

    //show orders for pharmacist
    public function show_orders(){
        $pharmacist = request();
    // orders path
        $orderpath = 'C:\xampp\htdocs\programming\orders.json' ;
        $ordercontent = file_get_contents($orderpath);
        $jsonorder = json_decode($ordercontent , true);
    // orders show
        $exist = false ;
        if(!$jsonorder || !is_array($jsonorder)){
            return response()->json([
                'message' => 'No orders found'
            ]);
        }
        foreach($jsonorder as $item)
            if($item['pharmacist' ] == $pharmacist){
                $exist = true ;
                return response()->json([ $item ]);
        }
        if($exist == false)
            return response()->json([
                'message' => 'No orders found'
            ]);

    }
    // Medicine details
    public function details(){
        $name = request();

        $filepath = 'C:\xampp\htdocs\programming\Medicines.json';
        $filecontent = file_get_contents($filepath);
        $jsoncontent = json_decode($filecontent , true);
        $exist = false ;

            foreach($jsoncontent as $item){
                if($item['sc_name'] == $name){
                    $exist = true ;
                    return response()->json([
                        'message' => 'Medicine is existed',
                        'Medicine' => $item
                    ]);
                }
            }
            if($exist == false){
                return response([
                    'message' => 'Medicine is not existed'
                ]);
            }
    }

    //search function(by name and by category)
    public function search(){
        $name = request();
        $category = request();

        $filepath = 'C:\xampp\htdocs\programming\Medicines.json';
        $filecontent = file_get_contents($filepath);
        $jsoncontent = json_decode($filecontent , true);
        $exist = false ;
        if($name && ($category == null)){
            foreach($jsoncontent as $item){
                if($item['sc_name'] == $name){
                    $exist = true ;
                    return response()->json([
                        'message' => 'Medicine is existed',
                        'Medicine' => $item
                    ]);
                }
            }
            if($exist == false){
                return response([
                    'message' => 'Medicine is not existed'
                ]);
            }
        }
        else if($category){
            foreach($jsoncontent as $item){
                if($item['category'] == $category){
                    $exist = true ;
                    return response()->json([
                        'message' => 'Medicine is existed',
                        'Medicine' => $item
                    ]);
                }
            }
            if($exist == false){
                return response([
                    'message' => 'Medicine is not existed'
                ]);
            }
        }
        else{
            return response()->json([
                'message' => 'Bad request'
            ] , 400);
        }
    }


}
