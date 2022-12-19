<section class="py-5 bg-light">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="fw-bolder mb-4">Related foods</h2>
        <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-3 row-cols-xl-4 justify-content-center">
        <?php 
            $products = $conn->query("SELECT p.*,b.name as bname,c.category  FROM `products` p inner join brands b on p.brand_id = b.id inner join categories c on p.category_id = c.id where p.status = 1 and (p.category_id = '{$category_id}' or p.brand_id = '{$brand_id}') and p.id !='{$id}' order by rand() limit 4 ");
            while($row = $products->fetch_assoc()):
                $upload_path = base_app.'/uploads/product_'.$row['id'];
                $img = "";
                if(is_dir($upload_path)){
                    $fileO = scandir($upload_path);
                    if(isset($fileO[2]))
                        $img = "uploads/product_".$row['id']."/".$fileO[2];
                   
                }
                foreach($row as $k=> $v){
                    $row[$k] = trim(stripslashes($v));
                }
                $rinventory = $conn->query("SELECT distinct(`price`) FROM inventory where product_id = ".$row['id']." order by `price` asc");
                $rinv = array();
                while($ir = $rinventory->fetch_assoc()){
                    $rinv[] = format_num($ir['price']);
                }
                $price = '';
                if(isset($rinv[0]))
                $price .= $rinv[0];
                if(count($rinv) > 1){
                $price .= " ~ ".$rinv[count($rinv) - 1];

                }
        ?>
            <div class="col mb-5">
                <a class="card product-item text-reset text-decoration-none" href=".?p=view_product&id=<?php echo md5($row['id']) ?>">
                 
                    <div class="overflow-hidden shadow product-holder">
                        <img class="card-img-top w-100 product-cover" src="<?php echo validate_image($img) ?>" alt="..." />
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="">
                           
                            <h5 class="fw-bolder"><?php echo $row['name'] ?></h5>
                            
                            <span><b class="text-muted">Price: </b><?php echo $price ?></span>
                            <p class="m-0"><small>Food: <?php echo $row['bname'] ?></small></p>
                            <p class="m-0"><small><span class="text-muted">Category:</span> <?php echo $row['category'] ?></small></p>
                        </div>
                    </div>
                </a>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
