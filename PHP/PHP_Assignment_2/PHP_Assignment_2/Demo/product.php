<html>

<head>
	<title>Product</title>
</head>

<body>
    <div style="text-align:end;">
        <a href="login.php">Logout</a>
    </div>
    
    <a href="category.php">Category</a>
    <?php 
        include_once("../../connection.php");

        if(isset($_POST["product"]) && isset($_POST['cid']))
        {
            
                $pname = $_POST["product"];
                $cid = $_POST['cid'];
                $image = basename($_FILES["image"]["name"]);
                $data=$cn->query("insert into product_tbl(Pname,Cid,Image) values('$pname','$cid','$image')");
            
        }
        if(isset($_GET['id']))
        {
            
                $id = $_GET['id'];
                $data=$cn->query("delete from Product_tbl where Pid='$id' ");
            
        }
    
    ?>
	<center>
		<form method="post" enctype="multipart/form-data" action="product.php">
			<table>
				<tr>
					<td>Enter Product-Name:</td>
					<td><input type="text" name="product"></td>
				</tr>

                <tr>
					<td>Select Product-Category:</td>
					<td>
                        <select name="cid">
                            <option value="-1">Select Category</option>
                            <?php 
                                $data = $cn->query("select * from Category_tbl");
                                if($data->num_rows>0)  
                                    while ($d=$data->fetch_assoc()) {
                                        ?><option value="<?= $d['Cid'] ?>"><?= $d['Cname'] ?></option><?php
                                    }
                            ?>
                        </select>
                    </td>
				</tr>

                <tr>
                    <td>Image:</td>
                    <td><input type="file" name="image"></td>   
                </tr>
				
				<tr>
					<td></td>
					<td><input type="submit" value="Add"></td>
				</tr>
            </table>
            <table border=1 style="height:100%;width:100%">
                <tr>
                    <th>Product Id</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                <tr>
                    <?php 
                        $data = $cn->query("select * from Product_tbl");
                        if($data->num_rows>0)  
                            while ($d=$data->fetch_assoc()) {
                                ?><tr>
                                    <td><?= $d['Pid']?></td>
                                    <td><?= $d['Pname']?></td>
                                    <td>
                                        <?php 
                                        
                                            $cat = $cn->query("select * from Category_tbl");
                                            if($cat->num_rows>0)  
                                                while ($d1=$cat->fetch_assoc()) {
                                                    if($d1['Cid']==$d['Cid'])
                                                    {
                                                        ?>
                                                        <?= $d1['Cname'] ?></td>
                                                        <?php
                                                    }
                                                }

                                        ?>
                                    <td><img src="../../Image/<?= $d['Image']?>" alt="<?= $d['Image']?>" width="200" height="200"></td>
                                    <td><a href="updateProduct.php?id=<?=$d['Pid']?>">Edit</a></td>
                                    <td><a href="product.php?id=<?= $d['Pid'] ?>">Delete</a></td>
                                </tr><?php
                            }
                    ?>
                </tr>
            </table>
			<?php
			$data = (int)$_GET['data'];
			if($data)
				echo "Invalid username or password";
		?>
        </form>
	</center>
</body>

</html>