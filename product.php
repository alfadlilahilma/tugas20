<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "pos_shop";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
  die("Tidak bisa terkoneksi ke database");
}
$product_name       = "";
$category_id        = "";
$product_code       = "";
$unit               = "";
$description        = "";
$price              = "";
$stock              = "";
$image              = "";


if (isset($_GET['op'])) {
  $op = $_GET['op'];
} else {
  $op = "";
}

if ($op == 'delete') {
  $product_code        = $_GET['product_code'];
  $sql1       = "delete from products where product_code = '$product_code'";
  $q1         = mysqli_query($koneksi, $sql1);
  if ($q1) {
    $sukses = "Berhasil hapus data";
  } else {
    $error  = "Gagal melakukan delete data";
  }
}

if ($op == 'edit') {
  $product_code            = $_GET['product_code'];
  $sql1          = "select * from products where product_code = '$product_code'";
  $q1            = mysqli_query($koneksi, $sql1);
  $r1            = mysqli_fetch_array($q1);
  $product_name  = $r1['product_name'];
  $category_id   = $r1['category_id'];
  $product_code  = $r1['product_code'];
  $unit          = $r1['unit'];
  $description   = $r1['description'];
  $price         = $r1['price'];
  $stock         = $r1['stock'];

  if ($product_name == '') {
    $error = "Data tidak ditemuukan";
  }
}


if (isset($_POST['simpan'])) { //untuk create
  $product_name  = $_POST['product_name'];
  $category_id   = $_POST['category_id'];
  $product_code  = $_POST['product_code'];
  $unit          = $_POST['unit'];
  $description   = $_POST['description'];
  $price         = $_POST['price'];
  $stock         = $_POST['stock'];


  $gambar_produk_paths = [];
  if (isset($_FILES['gambar']) && !empty($_FILES['gambar']['name'][0])) {
    $gambar_produk_dir = "htdocs/haloo/pos_shop/";
     foreach ($_FILES['gambar']['tmp_name'] as $key => $tmp_name) {
        $gambar_name = $_FILES['gambar']['name'][$key];
        $gambar_tmp = $_FILES['gambar']['tmp_name'][$key];
        $gambar_path = $gambar_produk_dir . $gambar_name;

        if (move_uploaded_file($gambar_tmp, $gambar_path)) {
            $gambar_produk_paths[] = $gambar_path;
        }
    }
}

// Simpan path gambar dalam bentuk JSON
$gambar_json = json_encode($gambar_produk_paths);





  if ($product_name && $category_id && $product_code && $unit && $description && $price && $stock && $image) { //untuk insert
    if ($op == 'edit') { //untuk update
      $sql1       = "update products set product_name='$product_name', category_id, ='$category_id, product_code = '$product_code', unit = '$unit', description = '$description', price = '$price', stock = '$stock' where id = '$id'";
      $q1         = mysqli_query($koneksi, $sql1);
      if ($q1) {
        $sukses = "Data berhasil diupdate";
      } else {
        $error  = "Data gagal diupdate";
      }
    } else {     //untuk insert
     $sql1 ="insert into products (product_name, category_id, product_code, unit, description, price, stock, image) values ('$product_name', '$category_id', '$product_code', '$unit', '$description', '$price', '$stock', '$gambar_json')";

      $q1     = mysqli_query($koneksi, $sql1);
      if ($q1) {
        $sukses     = "Berhasil memasukkan data baru";
      } else {
        $error      = "Gagal memasukkan data";
      }
    }
  }
}
        if (!empty($gambar_json)) {
    $gambar_produk_paths = json_decode($gambar_json);
    echo "Gambar Produk:<br>";
    foreach ($gambar_produk_paths as $gambar_produk_path) {
        echo '<img src="' . $gambar_produk_path . '" alt="Produk"><br>';

            }
        }

?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    .mx-auto {
      width: 800px
      max-width: 400px;
      margin: 0 auto;
      padding: 30px;
      border: 1px solid #e1e1e1;
      border-radius: 5px;
      background-color: pink;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

    .card {
      margin-top: 10px;
      width: 800px
      max-width: 400px;
      margin: 0 auto;
      padding: 30px;
      border: 2px solid black;;
      border-radius: 5px;
      background-color: pink;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    }
  </style>
 <!-- /.card-header -->
                <div class="mx-auto">
                  <div class="card">
                    <div class="card-header">
                      Create / Edit data
                    </div>
                          <div class="card-body">
                          <form action="" method="POST">
                          <div class="mb-3 row">
                          <label for="description" class="col-sm-2 col-form-label">product_name</label>
                          <div class="col-sm-10">
                          <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $product_name ?>">
                          </div>
                          </div>
                          <div class="mb-3 row">
                          <label for="stock" class="col-sm-2 col-form-label">category_id</label>
                          <div class="col-sm-10">
                          <input type="text" class="form-control" id="category_id" name="category_id" value="<?php echo $category_id ?>">
                          </div>
                          </div>
                          <div class="mb-3 row">
                          <label for="stock" class="col-sm-2 col-form-label">product_code</label>
                          <div class="col-sm-10">
                          <input type="text" class="form-control" id="product_code" name="product_code" value="<?php echo $product_code ?>">
                          </div>
                          </div>
                          <div class="mb-3 row">
                          <label for="stock" class="col-sm-2 col-form-label">unit</label>
                          <div class="col-sm-10">
                          <input type="text" class="form-control" id="unit" name="unit" value="<?php echo $unit ?>">
                          </div>
                          </div>
                          <div class="mb-3 row">
                          <label for="stock" class="col-sm-2 col-form-label">description</label>
                          <div class="col-sm-10">
                          <input type="text" class="form-control" id="description" name="description" value="<?php echo $description ?>">
                          </div>
                          </div>
                          <div class="mb-3 row">
                          <label for="stock" class="col-sm-2 col-form-label">price</label>
                          <div class="col-sm-10">
                          <input type="text" class="form-control" id="price" name="price" value="<?php echo $price ?>">
                          </div>
                          </div>
                          <div class="mb-3 row">
                          <label for="stock" class="col-sm-2 col-form-label">stock</label>
                          <div class="col-sm-10">
                          <input type="text" class="form-control" id="stock" name="stock" value="<?php echo $stock ?>">
                          </div>
                          </div>
                          <label for="gambar">Gambar Produk:</label>
                          <input type="file" id="gambar" name="gambar[]" multiple required>
                          </div>
                          </div>
                          <div class="col-12">
                          <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                        </div>
                      </form>
                    </div>
                  </div>

                  <!-- untuk menampilkan data -->

                  <div class="card">
                    <div class="card-header text-white bg-secondary">
                      Data Product
                    </div>
                    <div class="card-body">
                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product_name</th>
                            <th scope="col">category_id</th>
                            <th scope="col">product_code</th>
                            <th scope="col">unit</th>
                            <th scope="col">description</th>
                            <th scope="col">price</th>
                            <th scope="col">stock</th>
                          </tr>
                        <tbody>
                          <?php
                          $sql2 = "select * from products order by product_code desc";
                          $q2   = mysqli_query($koneksi, $sql2);
                          $urut = 1;
                          while ($r2 = mysqli_fetch_array($q2)) {
                             $product_name  = $r2['product_name'];
                             $category_id   = $r2['category_id'];
                             $product_code  = $r2['product_code'];
                             $unit          = $r2['unit'];
                             $description   = $r2['description'];
                             $price         = $r2['price'];
                             $stock         = $r2['stock'];
                             $gambar_paths = json_decode($r2['image']);
                          ?>
                            <tr>
                              <th scope="row"><?php echo $urut++ ?></th>
                              <td scope="row"><?php echo $product_name ?></td>
                              <td scope="row"><?php echo $category_id ?></td>
                              <td scope="row"><?php echo $product_code ?></td>
                              <td scope="row"><?php echo $unit ?></td>
                              <td scope="row"><?php echo $description ?></td>
                              <td scope="row"><?php echo $product_code ?></td>
                              <td scope="row"><?php echo $price ?></td>
                              <td scope="row"><?php echo $stock ?></td>
                              <td scope="row">
                                <a href="index.php?op=edit&product_code=<?php echo $product_code ?>">
                                  <button type="button" class="btn btn-warning">Edit</button>
                                </a>
                                <a href="index.php?op=delete&product_code=<?php echo $product_code ?>" onclick="return confirm('Yakin mau delete data?')">
                                  <button type="button" class="btn btn-danger">Delete</button>
                                </a>
                              </td>
                            </tr>
                          <?php
                          }
                          ?>
                        </tbody>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->