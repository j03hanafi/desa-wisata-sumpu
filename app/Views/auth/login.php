<?= $this->extend($config->viewLayout) ?>
<?= $this->extend('auth/index'); ?>

<?= $this->section('content'); ?>
    <div class="row justify-content-center align-items-center h-100" style="background-color: #2d499d">
        <div class="col-xl-4 col-lg-5 col-10">
            <div class="card">
                <div class="card-content">
                    <div id="auth-left">
                        <div class="auth-logo">
                            <a href="<?= base_url(); ?>"
                            ><img src="<?= base_url('media/icon/logo.svg'); ?>" alt="Logo"
                                /></a>
                        </div>
                        <h1 class="auth-title text-center"><?=lang('Auth.loginTitle')?></h1>
                        <p class="auth-subtitle mb-4 text-center">
                            Log in with your data that you entered during registration.
                        </p>
                        <?= view('Myth\Auth\Views\_message_block') ?>

                        <form action="<?= route_to('login') ?>" method="post">
                            <?= csrf_field() ?>
                            <?php if ($config->validFields === ['email']): ?>
                            <div class="form-group position-relative has-icon-left mb-3">
                                <input
                                        type="email"
                                        class="form-control <?php if(session('errors.login')) : ?>is-invalid<?php endif ?>"
                                        placeholder="<?=lang('Auth.email')?>"
                                        name="login"
                                        value="<?= old('login') ?>"
                                />
                                <div class="form-control-icon">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div class="invalid-feedback">
                                    <?= session('errors.login') ?>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="form-group position-relative has-icon-left mb-3">
                                <input
                                        type="text"
                                        class="form-control <?php if(session('errors.login')) : ?>is-invalid<?php endif ?>"
                                        placeholder="<?=lang('Auth.emailOrUsername')?>"
                                        name="login"
                                        value="<?= old('login') ?>"
                                />
                                <div class="form-control-icon">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div class="invalid-feedback">
                                    <?= session('errors.login') ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="form-group position-relative has-icon-left mb-3">
                                <input
                                        type="password"
                                        class="form-control <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>"
                                        placeholder="<?=lang('Auth.password')?>"
                                        name="password"
                                />
                                <div class="form-control-icon">
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                                <div class="invalid-feedback">
                                    <?= session('errors.password') ?>
                                </div>
                            </div>
                            <?php if ($config->allowRemembering): ?>
                            <div class="form-check d-flex align-items-start">
                                <input
                                        class="form-check-input me-2"
                                        type="checkbox"
                                        value=""
                                        id="flexCheckDefault"
                                        name="remember"
                                        <?php if(old('remember')) : ?> checked <?php endif ?>
                                />
                                <label
                                        class="form-check-label text-gray-600"
                                        for="flexCheckDefault"
                                >
                                    <?=lang('Auth.rememberMe')?>
                                </label>
                            </div>
                            <?php endif; ?>
                            <button class="btn btn-primary btn-block shadow mt-5" type="submit">
                                <?=lang('Auth.loginAction')?>
                            </button>
                        </form>
                        <?php if ($config->allowRegistration) : ?>
                        <div class="text-center mt-4 text-lg">
                            <p class="text-gray-600">
                                <?=lang('Auth.needAnAccount')?>
                                <a href="<?= route_to('register') ?>" class="font-bold"><?=lang('Auth.register')?></a> <br>
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
