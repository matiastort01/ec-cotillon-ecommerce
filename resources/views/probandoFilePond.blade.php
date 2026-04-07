<!-- SIN USO -->
<!-- SIN USO -->
<!-- SIN USO -->
<!-- SIN USO -->

<!DOCTYPE html>
<html>
    <head>
        <title>FilePond from CDN</title>

        <!-- Filepond stylesheet -->
        <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
    </head>
    <body>
        <!-- We'll transform this input into a pond -->
        <input type="file" class="filepond" />

        <!-- Load FilePond library -->
        
        <!-- Turn all file input elements into ponds -->
        <script>
            FilePond.parse(document.body);
            </script>
        <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    </body>
</html>
