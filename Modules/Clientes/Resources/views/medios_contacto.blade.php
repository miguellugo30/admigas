<input type="hidden" name="id" id="id" value="{{ \Auth::user()->Departamentos->first()->id }}">
{{ csrf_field() }}
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title"><b><i class="fas fa-headset"></i> Medios de Contacto </b></h4>
                    </div>
                </div>
                <div class="card-body" >
                    <div class="col text-center" >
                        <h4>Ponemos a tu disposición los siguientes medios de contacto</h4>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-3 m-2 p-3 border border-info rounded text-center">
                            <i class="fas fa-headset "></i>
                            Soporte a clientes
                            <br>
                            <a href="tel:5587180827">55-8718-0827</a> / <a href="tel:5587180828">55-8718-0828</a>
                        </div>
                        <div class="col-3 m-2 p-3 border border-info rounded text-center">
                            <a href="https://wa.link/jj24bi" target="_blank">
                                <i class="fab fa-whatsapp-square fa-2x"></i>
                                <br>
                                Chatea ahora
                            </a>
                        </div>
                        <div class="col-3 m-2 p-3 border border-info rounded text-center">
                            <a href="https://www.facebook.com/2G-Administradora-de-Condominios-Gas-LP-115323313659285" target="_blank">
                                <i class="fab fa-facebook-square fa-2x"></i>
                                <br>
                                Facebook
                            </a>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-4 m-2 p-3 border border-info rounded text-center">
                            <a href="https://www.linkedin.com/in/2g-administraci%C3%B3n-de-condominios-9022391a8/" target="_blank">
                                <i class="fab fa-linkedin fa-2x"></i>
                                <br>
                                Linkedln
                            </a>
                        </div>
                        <div class="col-4 m-2 p-3 border border-info rounded text-center">
                            <a href="https://www.instagram.com/2gadmindecondominios/" target="_blank">
                                <i class="fab fa-instagram-square fa-2x"></i>
                                <br>
                                Instagram
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.row -->
</div>