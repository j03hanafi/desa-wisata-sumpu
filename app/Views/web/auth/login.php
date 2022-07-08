<?= $this->extend('web/auth/index'); ?>

<?= $this->section('content'); ?>
    <div class="row justify-content-center align-items-center h-100" style="background-color: #2d499d">
        <div class="col-xl-4 col-lg-5 col-10">
            <div class="card">
                <div class="card-content">
                    <div id="auth-left">
                        <div class="auth-logo">
                            <a href="<?= base_url(); ?>"
                            ><img src="<?= base_url('assets/images/logo/logo.svg'); ?>" alt="Logo"
                                /></a>
                        </div>
                        <h1 class="auth-title text-center">Log in</h1>
                        <p class="auth-subtitle mb-4 text-center">
                            Log in with your data that you entered during registration.
                        </p>

                        <form action="">
                            <div class="form-group position-relative has-icon-left mb-3">
                                <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Username"
                                />
                                <div class="form-control-icon">
                                    <i class="bi bi-person"></i>
                                </div>
                            </div>
                            <div class="form-group position-relative has-icon-left mb-3">
                                <input
                                        type="password"
                                        class="form-control"
                                        placeholder="Password"
                                />
                                <div class="form-control-icon">
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                            </div>
                            <div class="form-check d-flex align-items-start">
                                <input
                                        class="form-check-input me-2"
                                        type="checkbox"
                                        value=""
                                        id="flexCheckDefault"
                                />
                                <label
                                        class="form-check-label text-gray-600"
                                        for="flexCheckDefault"
                                >
                                    Keep me logged in
                                </label>
                            </div>
                            <button class="btn btn-primary btn-block shadow mt-5">
                                Log in
                            </button>
                        </form>
                        <div class="text-center mt-4 text-lg">
                            <p class="text-gray-600">
                                Don't have an account?
                                <a href="<?= base_url('register'); ?>" class="font-bold">Sign up</a> <br>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
