<?php

namespace App\Controllers;


use \CodeIgniter\RESTful\ResourceController; // Import REST

use \CodeIgniter\API\ResponseTrait; // Import API

use App\Models\Crudapi; // Import Model

class Items extends ResourceController
{
    use ResponseTrait;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this -> model = new Crudapi();
        $this -> request = \Config\Services::request();
    }


    /**
     * Default Method
     * 
     * Fetch all Products from Database
     * 
     * @request : GET
     */
    public function index()
    {
        $data = $this -> model -> findAll();
        return $this -> respond($data);
    }


    /**
     * Fetch only a SINGLE item
     * 
     * <id> : item's id
     * 
     * @request : GET
     */
    public function show($id = null)
    {
        $data = $this -> model -> getWhere(['id' => $id]) -> getResult();

        if($data)
        {
            return $this -> respond($data);
        }else
        {
            return ($this -> failNotFound("No data found for specified Id : {$id}"));
        }
    }


    /**
     * Insert a new item
     * 
     * @request : POST
     */
    public function create()
    {
        $data = [
            'Name' => $this -> request -> getVar('product_name'),
            'Description' => $this -> request -> getVar('product_desc'),
            'Stock' => $this -> request -> getVar('stock_count'),
            'Price' => $this -> request -> getVar('product_price')
        ];

        $this -> model -> insert($data); // insert

        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Data Saved'
            ]
        ];


        return $this -> respondCreated($response);

    }


    /**
     * Update an existing product
     */
    public function update($id = null)
    {
        $input = $this -> request -> getRawInput();

        $data = [
            'Name' => $input['product_name'],
            'Description' => $input['product_desc'],
            'Stock' => $input['stock_count'],
            'Price' => $input['product_price']
        ];

        $this -> model -> update($id, $data);

        $response = [
            'status' => 200, 
            'error' => 'null',
            'messages' => [
                'success' => 'Data Updated'
            ]
        ];

        return $this -> respond($response);
    }
    

    /**
     * Delete an item
     */
    public function delete($id = null)
    {
        $data = $this -> model -> find($id);

        if($data)
        {
            $this -> model -> delete($data);

            $response = [
                'status' => 200,
                'error' => null,
                'messages' => [
                    'success' => 'Data Deleted'
                ] 
            ];
            return $this -> respondDeleted($response);
        }else
        {
            return $this -> failNotFound("No Data found for specific id : {$id}");
        }
    }
}






?>