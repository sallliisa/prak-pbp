<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Form</title>
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
 <script>
  window.addEventListener('load', () => {
   const kelas = document.getElementById('kelas')
   const ekstrakurikuler = document.getElementById('ekstrakurikuler')
   function revalidateEkstrakurikulerField() {
    if (kelas.value == 'XII') ekstrakurikuler.style.display = 'none'
    else ekstrakurikuler.style.display = 'block'
   }
   kelas.addEventListener('change', revalidateEkstrakurikulerField)
  })
 </script>
</head>

<body>
 <?php
 if (isset($_POST['submit'])) {
   //validasi nis: tidak boleh kosong, hanya dapat berisi huruf dan spasi 
   $nis = test_input($_POST['nis']);
   if (empty($nis)) {
    $error_nis = "NIS harus diisi";
   // NIS terdiri atas 10 karakter dan hanya boleh berisi angka 0..9. 
   } elseif (strlen($nis) != 10) {
    $error_nis = "NIS harus terdiri atas 10 karakter";
   }
   elseif(!preg_match("/^[0-9]*$/", $nis)){
    $error_nis = "NIS hanya dapat berisi angka 0..9";
   }
   //validasi nama: tidak boleh kosong, format harus benar
   $nama = test_input($_POST['nama']);
   if ($nama == '') {
     $error_nama = "Nama harus diisi";
   } 
   //validasi jenis kelamin: tidak boleh kosong
   if (!isset($_POST['jenis_kelamin'])) {
     $error_jenis_kelamin = "Jenis kelamin harus diisi";
   }
   //validasi kelas: tidak boleh kosong
   if (!isset($_POST['kelas'])) {
     $error_kelas = "Kota harus diisi";
   }
   //validasi ekstrakurikuler: tidak boleh kosong dan harus tidak boleh lebih dari 3
   if (isset($_POST['kelas']) && $_POST['kelas'] != 'xii'){
    if (!isset($_POST['ekstrakurikuler'])){
     $error_ekstrakurikuler = "ekstrakurikuler harus diisi";
    }
    elseif ((count($_POST['ekstrakurikuler'])<1) || (count($_POST['ekstrakurikuler'])>3)){
     $error_ekstrakurikuler = "Maksimal memilih 3 ekstrakurikuler";
    }
   }
 }

 function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
 }

 if (isset($_POST['ekstrakurikuler'])) {
  $ekstrakurikuler = $_POST['ekstrakurikuler'];
 }
 ?>
 <div class="container"><br/>
   <div class="card">
     <div class="card-header">Form Input Siswa</div>
     <div class="card-body">
       <form method="POST" autocomplete="on" action>
         <div class="form-group">
           <label for="nis">NIS:</label>
           <input type="text" class="form-control" id="nis" name="nis" maxlength="50" value="<?php if (isset($_POST['nis'])) echo $_POST['nis'] ?>">
           <div class="error text-danger"><?php if (isset($error_nis)) echo $error_nis; ?></div>
         </div>
         <div class="form-group">
           <label for="nama">Nama:</label>
           <input type="text" class="form-control" id="nama" name="nama" value="<?php if (isset($_POST['nama'])) echo $_POST['nama'] ?>">
           <div class="error text-danger"><?php if (isset($error_nama)) echo $error_nama; ?></div>
         </div>
         <label>Jenis Kelamin:</label>
         <div class="form-check">
           <label class="form-check-label">
             <input type="radio" class="form-check-input" <?php if (isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin'] == 'pria') echo 'checked' ?> name="jenis_kelamin" value="pria">Pria
           </label>
           <div class="error text-danger"><?php if (isset($error_jenis_kelamin)) echo $error_jenis_kelamin; ?></div>
         </div>
         <div class="form-check">
           <label class="form-check-label">
             <input type="radio" class="form-check-input" name="jenis_kelamin" value="wanita" <?php if (isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin'] == 'wanita') echo 'checked' ?> name="jenis_kelamin" value="pria">Wanita
           </label>
           <div class="error text-danger"><?php if (isset($error_jenis_kelamin)) echo $error_jenis_kelamin; ?></div>
         </div>
         <div class="form-group">
           <label for="kelas">Kelas: <?php echo !isset($_POST['kelas']) ?></label>
           <select id="kelas" name="kelas" class="form-control">
             <option value="X" <?php if (isset($_POST['kelas']) && $_POST['kelas'] == 'X') echo 'selected' ?>>X</option>
             <option value="XI" <?php if (isset($_POST['kelas']) && $_POST['kelas'] == 'XI') echo 'selected' ?>>XI</option>
             <option value="XII" <?php if (isset($_POST['kelas']) && $_POST['kelas'] == 'XII') echo 'selected' ?>>XII</option>
           </select>
           <div class="error text-danger"><?php if (isset($error_kelas)) echo $error_kelas; ?></div>
         </div>

         <br>

         <div id="ekstrakurikuler">
           <label>Ekstrakurikuler:</label>
           <div class="form-check">
               <label class="form-check-label">
               <input <?php if (isset($_POST['ekstrakurikuler']) && in_array('pramuka', $_POST['ekstrakurikuler'])) echo 'checked' ?> type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="pramuka">Pramuka
               </label>
           </div>
           <div class="form-check">
               <label class="form-check-label">
               <input <?php if (isset($_POST['ekstrakurikuler']) && in_array('seni_tari', $_POST['ekstrakurikuler'])) echo 'checked' ?> type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="seni_tari">Seni Tari
               </label>
           </div>
           <div class="form-check">
               <label class="form-check-label">
               <input <?php if (isset($_POST['ekstrakurikuler']) && in_array('sinematografi', $_POST['ekstrakurikuler'])) echo 'checked' ?> type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="sinematografi">Sinematografi
               </label>
           </div>
           <div class="form-check">
               <label class="form-check-label">
               <input <?php if (isset($_POST['ekstrakurikuler']) && in_array('basket', $_POST['ekstrakurikuler'])) echo 'checked' ?> type="checkbox" class="form-check-input" name="ekstrakurikuler[]" value="basket">Basket
               </label>
           </div>
           <div class="error text-danger"><?php if (isset($error_ekstrakurikuler)) echo $error_ekstrakurikuler; ?></div>
         </div>
         <br>

         <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
         <button type="reset" class="btn btn-danger">Reset</button>
       </form>
     </div>
     <?php
     if (isset($_POST["submit"]) && isset($_POST["nis"]) && isset($_POST["nama"]) && isset($_POST["jenis_kelamin"]) && isset($_POST["kelas"]) && isset($_POST["ekstrakurikuler"])) {
       echo "<h3>Your Input:</h3>";
       echo 'NIS = ' . $_POST['nis'] . '<br />';
       echo 'Nama = ' . $_POST['nama'] . '<br />';
       echo 'Kota = ' . $_POST['kelas'] . '<br />';
       echo 'Jenis Kelamin = ' . $_POST['jenis_kelamin'] . '<br />';

       $ekstrakurikuler = $_POST['ekstrakurikuler'];
       if (!empty($ekstrakurikuler)) {
         echo 'ekstrakurikuler yang dipilih: ';
         foreach ($ekstrakurikuler as $ekstrakurikuler_item) {
           echo '<br />' . $ekstrakurikuler_item;
         }
       }
     }
  ?>
</html>
