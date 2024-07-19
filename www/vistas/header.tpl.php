<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="../assets/bootstrap.min.css" rel="stylesheet" >
    <script type="module" src="../assets/index.m.js"></script>  
    <script>
        customElements.define("crud-input-image", class extends HTMLInputElement {
            constructor() {
                super();
                this.type = "file";
                this.accept = "image/*";
            }
            connectedCallback() {
                
                const append_preview =document.createElement("img");
                append_preview.style.maxWidth = "100px";
                append_preview.style.maxHeight = "100px";
                const default_src = this.getAttribute("value")
                if( default_src!= null){
                  append_preview.src = default_src.indexOf("/") ? default_src : "./imagenes/" + default_src;
                }
                this.parentElement.appendChild(append_preview);                
                this.addEventListener("change", function() {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        // var img = document.createElement("img");
                        // let base64_data = e.target.result;
                        // img.src = e.target.result;
                        // img.style.maxWidth = "100px";
                        // img.style.maxHeight = "100px";
                        //this.parentElement.appendChild(img);
                        append_preview.src = e.target.result;
                    };
                    reader.readAsDataURL(this.files[0]);
                });
            }
        }, { extends: "input" });
    </script>
</head>
<body>
<nav class="navbar navbar-light navbar-expand-lg " style="background-color: #e3f2fd;">
  <!-- Navbar content -->
  <div class="container-fluid">
    <a class="navbar-brand" href="#">JUVENIL</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
        <!-- <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li> -->
        
        <li class="nav-item">
        <a class="nav-link"  href="categorias.php"  >categorias.php</a>
        </li>
        <li class="nav-item">
          <a class="nav-link"  href="productos.php"  >Producto.php</a>
        </li>
        <li class="nav-item">
          <a class="nav-link"  href="proveedores.php"  >Proveedor.php</a>
        </li>

        <li class="nav-item">
          <a class="nav-link"  href="proveedores_buscar.php"  >Proveedor buscar.php</a>
        </li>
      </ul>

    </div>
  </div>
</nav>
    <main>

    
