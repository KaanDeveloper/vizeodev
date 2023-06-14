<?php 
    //Veritabanı Bağlantısı
    $sunucu="localhost";
    $db="isletmelistesi";
    $kuladi="root";
    $parola="";
    
    $baglan= new PDO("mysql:host=$sunucu;dbname=$db;charset=utf8",$kuladi,$parola);
    if($baglan);
    else echo "Hata benim günah benim";
?>


<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="UTF-8">
        <title>İşletme Listesi</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <body>
        <div class="col-lg-1 mx-auto mb-2 mt-2 w-100 d-flex justify-content-center">
            <form name="isletme" actions="" method="post">
                <label for="isletmeadi" class="form-label">İşletme İsmi:</label>
                <input type="text" name="isletmeadi" class="form-control-sm" required><br>
                <label for="adres" class="form-label">İşletme Adresi:</label>
                <input type="text" name="adres" class="form-control-sm" required><br>
                <label for="telefon" class="form-label">İşletme Tel No:</label>
	            <input type="number" name="telefon" class="form-control-sm" required><br>
                <label for="eposta" class="form-label">İşletme E-Posta:</label>
	            <input type="text" name="eposta" class="form-control-sm" required><br>
                <label for="isletmeturu" class="form-label">İşletme Türü:</label>
	            <select name="isletmeturu" class="form-select-sm" required><br>
	                <option value="1">Kuaför</option>
		            <option value="2">Kafe</option>
		            <option value="3">Restoran</option>
		            <option value="4">Beyaz Eşya</option>
                    <option value="5">Elektronik</option>
	            </select><br>
	            <input type="submit" value="Kaydet" name="kaydet"> 
            </form>
        </div>
        <input type="text" class="mx-auto d-flex justify-content-center mb-5 mt-5" id="searchBox" placeholder="Sadece İşletme Adı Giriniz...">
    </body>
    <script>
        //Arama Fonsiyonelliği
        var searchBox = document.getElementById("searchBox");
        var i, j, table, row, column, text;

        searchBox.addEventListener("keyup", () => {
            text = searchBox.value.toUpperCase();
            table = document.getElementById("dataTable");
            tr = table.getElementsByTagName("tr");

            for(i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td");
                for(j = 0; j < td.length; j++) {
                    if(td[j]) {
                        if(td[j].innerHTML.toUpperCase().indexOf(text) > -1) {
                            tr[i].style.display = "";
                        }
                        else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        });

    </script>
</html>

<?php
//Formdan Gelen Bilgileri Veritabanına Kaydet
if(isset($_POST['kaydet'])){ 
	$ia=$_POST['isletmeadi']; 
    $adres=$_POST['adres'];
	$tel=$_POST['telefon']; 
	$eposta=$_POST['eposta']; 
	$it=$_POST['isletmeturu']; 
	$sorgu="INSERT INTO isletmeler(isletmeisim, isletmeadres, isletmetel, isletmeeposta, isletmeturu) 
			VALUES('$ia','$adres','$tel','$eposta','$it')"; 	
			
	$sorgucalistir=$baglan->query($sorgu); 
	if(!$sorgucalistir) echo "Eklemede sorun var";

    //Sayfa Yenilendiğinde En Son Eklenen Verinin Bir Daha Yazılmasını Önler
    header("location: isletme.php");
    exit;
}
    //Veritabanındaki Bilgileri Sitede Göster
    $sql = "SELECT * FROM isletmeler";
    $result = $baglan->query($sql);

    if ($result->rowCount() > 0) {
        echo "<div class='col-sm-6 mx-auto'>";
        echo "<table class='table table-striped table-hover' id='dataTable'>";
        echo "<tr><th>İşletme Adı</th><th>Adres</th><th>Telefon</th><th>E-Posta</th><th>İşletme Türü</th></tr>";
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $ia=$row['isletmeisim']; 
            $adres=$row['isletmeadres'];
	        $tel=$row['isletmetel']; 
	        $eposta=$row['isletmeeposta']; 
	        $it=$row['isletmeturu']; 
            switch ($it) {
                case 1 :
                    $it = "Kuaför";
                break;
                case 2 :
                    $it = "Kafe";
                break;
                case 3 :
                    $it = "Restoran";
                break;
                case 4 :
                    $it = "Beyaz Eşya";
                break;
                case 5:
                    $it = "Elektronik";
                break;
                default:
                    $it = "Diğer";
                break;
            }
            echo "<tr><td>" . $ia . "</td><td>" . $adres . "</td><td>" . $tel . "</td><td>" . $eposta . "</td><td>" . $it . "</td></tr>";
        }
        echo "</table>";
        echo "</div>";
    }   

// Veritabanı Bağlantısını Kapat
$baglan = null;

?>