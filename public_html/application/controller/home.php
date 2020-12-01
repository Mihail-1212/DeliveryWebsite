<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Home extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/_templates/main_header.php';
        require APP . 'view/home/index.php';
        require APP . 'view/_templates/footer.php';
    }
    
    public function category($category_name, $product_id){
        $sql = "CALL GetProductCategory(0)";
        $query = $this->db->prepare($sql);
        $query->execute();
        $categories = $query->fetchAll(PDO::FETCH_ASSOC);
        $cat = array_column($categories, "link_name");

        if(in_array($category_name, $cat)){
            
            foreach($categories as $category_item){
                if($category_item['link_name'] == $category_name){
                    $category = $category_item;
                    break;
                }    
            }
            
            if(!$product_id){
                require APP . 'view/_templates/header.php';
                require APP . 'view/_templates/main_header.php';
                require APP . 'view/categories/index.php';
                require APP . 'view/_templates/footer.php';
            }
            else{
                require APP . 'view/_templates/header.php';
                require APP . 'view/_templates/main_header.php';
                require APP . 'view/categories/product_description.php';
                require APP . 'view/_templates/footer.php';
            }
        }
        else {
            header('location: ' . URL . 'problem');
        }
    }
}
