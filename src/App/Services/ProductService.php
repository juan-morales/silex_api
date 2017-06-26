<?php

namespace App\Services;

class ProductService extends BaseService
{

    //select by id or select all
    public function index($product_id)
    {
        if (!is_null($product_id ))
        {
            $stmt = $this->db->prepare("SELECT * FROM product WHERE id = :value ");
            $stmt->bindValue("value",$product_id);
        } else {
            $stmt = $this->db->prepare("SELECT * FROM product");
        }

        $stmt->execute();
        $results = $stmt->fetchAll();

        if($results) return $results ;
        else return false ;
    }
    
    //select a product by Name
    public function selectbyName($product_name)
    {
        if (is_null($product_name))
        {
            return false;    
        } 
        
        $stmt = $this->db->prepare("SELECT * FROM product WHERE name = :value ");
        $stmt->bindValue("value",$product_name);
        $stmt->execute();
        $results = $stmt->fetchAll();

        if($results) return $results ;
        else return false ;
    }

	//create
	public function create($record)
    {
        $this->db->insert("product", $record);
        return $this->db->lastInsertId();
    }  
	
	//update
	function update($product_id, $record)
    {
        return $this->db->update('product', $record, ['id' => $product_id]);
    }
	
	//delete
    function delete($product_id)
    {
        return $this->db->delete('product', array('id' => $product_id));
    }
		
}
