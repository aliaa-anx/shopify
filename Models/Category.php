<?php
require_once 'C:\xampp\htdocs\security-project\Controllers\DBController.php';

Class Category
{
    public $id;
    public $name;

    public function addCategory(Category $cat)
    {
        require_once 'C:\xampp\htdocs\security-project\Controllers\AuthController.php';
        $auth = new AuthController();
        $name = $auth->validate($cat->name);

        if (empty($name)) {
            header("Location: add_category.php?error=Category Name is required");
            exit();
        }else{
            $db = new DBController;
            $db->openConnection();
            $query1 = "SELECT * FROM category WHERE name = '$cat->name'";
            $result = $db->proccessQuery($query1);
            if(mysqli_num_rows($result) > 0)
            {
                return "<script> alert('Category already exists') </script>";
            }else{
            $query2 = "INSERT INTO category (name) VALUES ('$cat->name')";
            $result = $db->proccessQuery($query2);
            if($result)
            {
                $db->closeConnection();
                return "<script> alert('Category has been added successfully') </script>";
            }
        }
    }
    }


    public function displayCategories()
    {
        $db = new DBController();
        $db->openConnection();
        $query = "SELECT * FROM category";
        $result = $db->proccessQuery($query);
        $categories = array();
        while($row = mysqli_fetch_assoc($result))
        {
            $categories[] = $row;
        }
        $db->closeConnection();
        return $categories;
    }

    public function deleteCategory($id)
    {
        $db = new DBController();
        $db->openConnection();
        $query = "DELETE FROM category where id = '$id'";
        $result = $db->proccessQuery($query);
        if($result)
        {
            $db->closeConnection();
            return "<script> alert('Category has been deleted successfully') </script>";
        }
    }
}
?>