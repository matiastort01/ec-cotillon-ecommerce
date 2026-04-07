        <footer class="bg-light-dark text-white py-4 mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 d-flex flex-column align-items-center text-center">
                        <h5 class="font-weight-bold">Nuestra Dirección</h5>
                        <p><i class="fas fa-map-marker-alt"></i> 
                            <a id="id-direccion" href="https://www.google.com/maps?q=Brandsen 805, C1161AAQ Cdad. Autónoma de Buenos Aires" target="_blank" class="text-white">Brandsen 805, C1161AAQ, CABA </a>
                        </p>
                    </div>
                    
                    <!-- Contacto -->
                    <div class="col-md-4 d-flex flex-column align-items-center text-center">
                        <h5 class="font-weight-bold">Contacto</h5>
                        <p><i class="fas fa-phone-alt"></i> Tel: +54 9 11 1234 5678</p>
                        <p><i class="fas fa-envelope"></i> Email: ec-cotillon@gmail.com</p>
                    </div>
                    
                    <!-- Redes Sociales -->
                    <div class="col-md-4 d-flex flex-column align-items-center text-center">
                        <h5 class="font-weight-bold">Seguinos</h5>
                        <div>
                            <a href="https://facebook.com" class="text-white mx-2"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://twitter.com" class="text-white mx-2"><i class="fab fa-twitter"></i></a>
                            <a href="https://www.instagram.com" class="text-white mx-2"><i class="fab fa-instagram"></i></a>
                            <a href="https://linkedin.com" class="text-white mx-2"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>            
                </div>

                <!-- Copyright -->
                <div class="text-center mt-4">
                    <p>&copy; 2024 EC-Cotillon. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="{{ asset('js/swiper.js') }}" defer></script>
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <script src="{{ asset('js/display-new-image.js') }}" type="text/javascript"></script>
        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
        
        <!-- Ahora incluyo los 2 js del public/js -->
        <script src="{{ asset('js/datatable-cat.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/datatable-prod.js') }}" type="text/javascript"></script>

    </body>
</html>