function previewImage(event) {
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onload = function() {
        const output = document.getElementById('nueva_imagen');
        output.src = reader.result;
        output.style.display = 'block';  // Mostrar la imagen
    };
    
    if (file) {
        reader.readAsDataURL(file);  // Leer el archivo como una URL de datos
    }

    document.querySelector('.new-image').style.display = 'block';  // Mostrar el texto
}