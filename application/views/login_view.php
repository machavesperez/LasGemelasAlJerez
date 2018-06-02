<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>  
                <?php if(!isset($mensaje)){?>
                <section id="reservation-modal" class="reservation-modal">
                    <div class="container">
                        <div class="row">
                            <div class="form-holder col-md-12 text-center">
                                <h2>Login</h2>
                                <h3>Introduce Usuario y Contraseña</h3> 
                <?php }else{?>
                <section id="reservation-modal" class="reservation-modal">
                    <div class="container">
                        <div class="row">
                            <div class="form-holder col-md-12 text-center">
                                <h2>Login</h2>
                                <h3><?php echo $mensaje ?></h3>
                
                <?php }?>               
                                <form id="booking-form-alternative" method="POST"  action="<?=base_url().'login/verify_sesion'?>">
                                    <div class="row">
                                        <div class="col-md-push-1 col-sm-10">
                                            <div class="row">
                                                <label for="cnumber" class="col-sm-6 unique">Usuario
                                                    <input name="nombre" type="text" id="cname" required>
                                                </label>
                                                <label for="cnumber" class="col-sm-6 unique">Contraseña
                                                    <input name="pass" type="password" id="cname" required>
                                                </label>
                                                <div class="col-sm-12">
                                                    <button type="submit" class="btn-unique">Login</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?= form_close();?> 
                            </div>
                        </div>
                    </div>
                </section>
                <!-- end modal booking form -->