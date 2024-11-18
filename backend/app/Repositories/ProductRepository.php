<?php

namespace App\Repositories;

class ProductRepository extends AbstractRepository {    

    
    public function stockQuantity() {
        $this->model = $this->model->withSum('entries as stock', 'quantity');
    }
}