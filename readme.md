## Disclaimer
 As this is my first ever *actual* GitHub Repository that i've done, there might be something that could've went wrong and things i could've improve. <Br><br>
 ***Thank you*** :blush:

<br><br><br>

# Penjelasan Super Singkat :grin:

Ini merupakan tugas sekolah atau test projek singkat yang menyangkut soal API, projek ini bisa dibagi menjadi 2 bagian, Front-end dan API + Back-end.

Mari kita masuk ke penjelasan tentang projek ini.

<br>

# Cara Kerja Aplikasi  (Front-end) :thinking:

## Run App

Pertama-tama, kita buka menggunakan

    ionic start

Ataupun

    npm run dev

<br>

## Login

Jika sudah maka akan dibawa ke tampilan awal yaitu Tampilan Login, disini anda akan diminta untuk memasukan *Username* dan *Password*. <br><br>

![WhatsWrongWithMyLogin!?](Public/Login.png)

<br>

## Main Page

Jika sudah berhasil Login, maka anda akan dibawa ke Main Page dimana semua postingan akan terlihat, begitu juga Post Artikel, Edit Artikel, dan Delete artikel.

<br>

![EhhhItsMainPage.png?](Public/MainPage.png)

<br>

## Post Page

Dengan Menekan Tombol *Post Page* Di Bagian Tab bawah di layar, anda akan dibawa halaman Post Page, dimana anda mendapat membuat artikel baru tentang apa aja yang anda inginkan.

<br>

![PostPageEh?](Public/PostPage.png)

<br>

## Edit Page 

Anda bisa mengakses Edit page dengan menekan tombol Hijau yang ada pada *Main Page* yang berlabelkan *Edit*, lalu anda dapat mengubah post sesuai keinginan.

<br>

![Editing...What?](Public/EditPage.png)

<br>

## Edit Page Failure

Anda juga bisa mengakses melalui tombol dibagian Tab dibawah, namun tidak akan menampilkan apapun atau menampilkan page sebelumnya karena Edit tidak dapat mengambil ID dari Post yang digunakan untuk mengedit Post, dicontoh dibawah, page menampilkan Post Artikel (*Post Page*) karena page terakhir sebelum ke *Edit Page* adalah *Post Page*

![Boohoo. Editor Failed](Public/EditPageFail.png)

<br>

## Delete Button

Tombol Ini merupakan tombol yang akan menghapus suatu post, ketika di klik, akan menampilkan Warning yang berasal dari Localhost:8100 yang menanyakan apakah anda akan menghapus post,

 "*Are you sure you want to delete this post?*"

 <br>

![DoNotDeleteItSir](Public/Delete.png)

<br><br>

# API + Back-End

## Pertanyaan Umum seputar API dan Back-end :thinking:
1. Apa itu API? 
<br>

API atau Aplication Programming Interface bisa di umpamakan sebagai penghubung (Contoh :Jembatan, Antenna Starlink) yang menghubungkan Back-End atau Server-side (Contoh Samarinda, Satelite Starlink) dengan Front-end atau Client-side (Contoh : Samarinda Sebrang, Pengguna Layanan Starlink)

- Contoh 1 : Jika ingin pergi dari Sebrang menuju ke Samarinda, maka perlu melewati jembatan, bisa melewati Jembatan Mahakam ataupun Jembatan Mahkota

- Contoh 2 : Pengguna Starlink ingin menggunakan layanan Starlink, maka ia harus mempunyai Antenna Starlink (Dish) yang menjadi Median yang bisa memancarkan sinyal yang di hasilkan oleh Satellite untuk menyambungkan antara Satellite Starlink dengan Pengguna Starlink

<br>

2. Mungking anda akan bertanya, mengapa API dan Back-end disini menjadi satu? bukannya API itu biasanya terpisah dari Back-end?
 <br>

 Ya, memang seharusnya begitu, API yang betul yaitu tidak terhubung atau saling bersangkutan dengan Server (Back-end) atau Client (Front-end). Namun saya menggunakan API yang bersangkutan dengan Server (Back-end) karena saya terlambat mempelajari jenis-jenis API yang ada. 

<br>

3. Jadi apa yang terjadi jika API dan Back-end menjadi satu/terhubung dengan satu sama lain?
<br>

Ketika Server (Contoh : XAMPP dan Laragon) Dimatikan, maka API tidak akan bekerja karena mereka saling terikat satu sama lain, ini juga menjadi salah satu kelemahan dari API dan Back-end yang terikat satu sama lain.

<br><br>

# Penjelasan API dan Back-end bagian Code

Disini saya akan menjelaskan Sebagaian code yang ada pada folder Server-side yang mengandung API dan Function yang digunakan untuk CRUD

<br>

## API

Sebelum kita lanjut makin dalam membahas bagian Back-end lainnya, disini saya akan membahas tentang API yang ada di semua file.php yang akan dibahas selanjutnya

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

<br>

Mari kita breakdown satu per satu
   
<br>

     header("Access-Control-Allow-Origin: *");
Digunakan untuk siapapun yang memanggil file ini boleh mengakses bagian API, ini juga merupakan bagian dari CORS (Cross-Origin Resource Sharing).

<br>

    header("Content-Type: application/json; charset=UTF-8");
Merupakan standar API yang mengirim data JSON dengan encode UTF-8 <br>
Contoh Sederhana Encode UTF-8 : <br>
Halo dunia – こんにちは世界 – مرحبا بالعالم – 😀 // ....Amin.

<br> 

    header("Access-Control-Allow-Methods: POST, OPTIONS");
Ini digunakan untuk memberi tahu browser metode HTTP apa saja yang boleh digunakan, dalam contoh ini ada 2 yaitu : <br>
- POST = Digunakan untuk Memberi data
- OPTIONS = preflight atau pengecekan yang dikirim oleh browser sebelum mengirimkan request

<Br>

    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
Memberi tahu request apa saja yang boleh dilakukan ke Client-side
- Content-Type = digunakan untuk mengirim JSON
- Authorization = Digunakan untuk menghandle TOKEN JWT
- X-Requested-With = untuk request AJAX/HXR
- Access-Control-Allow-Headers : Standard Header

<br><br>

# Back-end

Back-end, dimana logika bekerja, mengambil data, mengolah data, dan mengirim data. disini back-end menggunakan PHP untuk mengirim data langsung ke database localhost. disini saya akan membahas 3 file yang sangat penting, yaitu db.php, login.php dan post.php karena mereka merupakan file utama yang penting. Sisanya merupakan CRUD yang kuranf lebih sama dengan post.php, kita mulai dari koneksi database dari db.php


## db.php

Ini adalah file.php yang digunakan untuk menyambungkan Database dengan file.php lainnya, dengan cara 

    include 'db.php';

Mengapa menggunakan cara demikian? ini adalah step paling awal dan simpel untuk mencegah bocornya nama database, user, serta password admin ke bagian Client-side

<br>

## Converter JSON > PHP

    $data = json_decode(file_get_contents("php://input"), true);

Ini digunakan untuk mengambil input dari JSON dibuat menjadi input yang sesuai dengan standar php agar bisa diolah lalu dikirim ke database. Line code ini ada di seluruh file.php

### Breakdown

    $data 
Variabel yang digunakan untuk mengolah data nantinya

<br>

    (file_get_contents("php://input")
Digunakan untuk mengambil data lalu dikonversi menjadi string

<br>

    json_decode(...), true);
- json_decode = mengubah struktur JSON string -> Struktur PHP
- true = mengubah struktur PHP yang sudah di ubah menjadi Associative array, jika tidak ingin diubah maka bisa dikosongkan saja atau diganti parameter menjadi false

<br><br>

## Login.db

Ini merupakan file yang digunakan untuk menghandle login di Client-side dan generate Token JWT untuk autentikasi login.

### Breakdown

    $username = $data['username'] ?? '';
    $password = $data['password'] ?? '';

    if (!$username || !$password) {
        echo json_encode(["success" => false, "message" => "Username and password required"]);
        exit;
    }

Code ini mengambil data yang sudah diubah oleh json decode yang diambil dari client-side lalu di simpan di variabel $data, jika field tidal di isi pada Client-side maka akan di set deault ke empty string dilambang kan oleh tanda petik ('')

Lalu memvalidasi input jika kosong maka memberitahu pengguna bahwa username dan password harus di isi terlebih dahulu

<br>

    $stmt = $conn->prepare("SELECT * FROM tb_login WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

Code ini mempersiapkan SQL lalu mencari user dari username, setelah itu code menjalankan query dan menyimpan hasil 

<br>

    if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if ($password === $user['password']) { 

fetch_assoc() memberikan data yang sesuai dengan yang kita dapatkan di $result lalu check apakah password benar atau tidak. 

<br>

    $payload = [
        "iss" => "http://localhost",
        "aud" => "http://localhost",
        "iat" => time(),
        "exp" => time() + 60,
        "data" => [
            "username" => $user['username']
        ]
    ];

Ini adalah code yang menhasilkan Token JWT
- iss / issuer = siapa yang membuat token
- aud / audience = untuk siapa tokennya
- iat / issued at = kapan dibuat
- exp / expired = kadaluarsa Token JWT
- data = menyimpan data yang ada di token jadi token ada data user 

<br>

    $secret_key = "MY_SUPER_DUPER_UBER_SECRET_KEY";
    $jwt = JWT::encode($payload, $secret_key, 'HS256');

secret_key digunakan untuk generate token yang valid, setelah itu 
diubah menjadi encode HS256 pada JWT: :encode()

<br>

            echo json_encode(["success" => true, "token" => $jwt]);
        } else {
            echo json_encode(["success" => false, "message" => "Aww? Something's Wrong~ , Boohoo."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "You don't exist."]);
    }

Code bagian ini digunakan untuk mengirim balik ke client-side bahwa login sukses dan token bisa di simpan, token juga bisa di echo/print jika ingin melihat apakah token sudah terkirim dengan benar atau belum

Dua code dibawahnya merupakan code jika login gagal. 
- Error pertama adalah jika password salah, maka akan menampilkan warning bahwa ada sesuatu yang salah.
- Error kedua adalah jika akun tidak ada, maka akan menampilkan warning bahwa akun tidak ada.

## post.php

Ini adalah file.php yang menghandle bagian memposting sebuah post, file ini menerima JSON Input lalu mengirim inputan yang diterima ke Database melalui query INSERT

<br>

### Breakdown

<br>

    if ($title === '' || $content === '') {
        http_response_code(400);
        echo json_encode([
            "message" => "Field judul, dan deskripsi wajib diisi dengan benar.",
            "success" => false
        ]);
        exit(0);
    }

Code ini akan melakukan sebuah check apakah title dan content kosong, jika kosong maka akan megirim error 400 yang berisikan message "Field Judul dan deskripsi wajib di isi dengan benar" ke bagian Client-side lalu mengakhiri dengan exit(0) agar code tidak menambahkan post kosong

<br>

    $query = "INSERT INTO tb_post (judul, deskripsi) VALUES (?, ?)";
    $stmt = $conn->prepare($query);  

    // Ikat parameter: s (title), s (content)
    $stmt->bind_param("ss", $title, $content);

Bagian code ini menuliskan code SQL yang akan menambahkan judul dan deskripsi ke dalam Database, lalu menyiapkan parameter untuk di bind, mengapa harus di bind? karena binding parameter merupakan salah satu step security pada SQL. bind bertujuan memberi tahu data bahwa ini merupakan sebuah *Values* bukan SQL Commands agar tidak terjadi SQL Injection

<br>

    if ($stmt->execute()) {
        http_response_code(201); 
        echo json_encode(array(
            "message" => "Artikel berhasil disimpan.",
            "success" => true,
            "insert_id" => $conn->insert_id 
        ));
    } else {
        http_response_code(500); 
        echo json_encode(array(
            "message" => "Error. womp womp: " . $stmt->error,
            "success" => false
        ));
    }

Code bagian ini mengeksekusi statement yang dibuat sebelumnya menggunakan if, jadi ada 2 kemungkinan

1. Code berhasil. code lalu mengirimkan pesan ke Client-side bahwa artikel sudah tersimpan, lalu kode memasukkan value dari statement ke dalam Database
2. Code gagal. code lalu mengirimkan pesan ke CLient-side bahwa ada error

<br>

    $stmt->close();
    $conn->close();

Pengujung dari code. Code ini akan menutup statement dan connection dan mengakhiri operasi jika sudah selesai dipakai.

<br><br><br>

# Finale :hourglass:

## Kesimpulan :notebook:

Seperti yang saya sudah katakan pada disclaimer di awal, readme ini tidak sempurna dan masih mempunyai banyak hal yang bisa di perbaiki kedepannya sendiri. Saya juga hanya menginclude 2 code pada bagian Back-end karena bagian Code CRUD bisa diwakili oleh kedua Code yang sudah dijelaskan

## Terimakasih :grin::+1:

Ya, terimakasih telah membaca readme ini :grin::+1:, Terimakasih kepada teman-teman saya yang sudah membantu tentunya :grin::+1:. Tidak lupa saya berterimakasih kepada guru pembimbing, Pak Rey, makasih pak rey :grin::+1:. Makasih ya semuanya:grin::+1:

