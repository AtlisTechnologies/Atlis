<?php
$error = get_get('error', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$token = generate_csrf_token();
?>
<main class="main" id="top">
<div class="container-fluid bg-body-tertiary dark__bg-gray-1200">
  <div class="bg-holder bg-auth-card-overlay" style="background-image:url(<?php echo getURLDir(); ?>assets/img/bg/37.png);"></div>
  <div class="row flex-center position-relative min-vh-100 g-0 py-5">
    <div class="col-11 col-sm-10 col-xl-8">
      <div class="card border border-translucent auth-card">
        <div class="card-body pe-md-0">
          <div class="row align-items-center gx-0 gy-7">
            <div class="col mx-auto">
              <div class="auth-form-box">
                <div class="text-center mb-7">
                  <h3 class="text-body-highlight">Sign In</h3>
                  <p class="text-body-tertiary">Get access to your account</p>
                  <?php if ($error) { ?>
                  <div class="alert alert-danger" role="alert">Invalid email or password.</div>
                  <?php } ?>
                </div>
                <form method="post" action="<?php echo getURLDir(); ?>module/users/functions/login.php">
                  <input type="hidden" name="csrf_token" value="<?= e($token); ?>">
                  <div class="mb-3 text-start">
                    <label class="form-label" for="email">Email address</label>
                    <div class="form-icon-container">
                      <input class="form-control form-icon-input" id="email" type="email" name="email" placeholder="name@example.com" required />
                      <span class="fas fa-user text-body fs-9 form-icon"></span>
                    </div>
                  </div>
                  <div class="mb-3 text-start">
                    <label class="form-label" for="password">Password</label>
                    <div class="form-icon-container" data-password="data-password">
                      <input class="form-control form-icon-input pe-6" id="password" type="password" name="password" placeholder="Password" data-password-input="data-password-input" required />
                      <span class="fas fa-key text-body fs-9 form-icon"></span>
                      <button class="btn px-3 py-0 h-100 position-absolute top-0 end-0 fs-7 text-body-tertiary" type="button" data-password-toggle="data-password-toggle"><span class="uil uil-eye show"></span><span class="uil uil-eye-slash hide"></span></button>
                    </div>
                  </div>
                  <div class="row flex-between-center mb-7">
                    <div class="col-auto">
                      <div class="form-check mb-0">
                        <input class="form-check-input" id="basic-checkbox" type="checkbox" name="remember" />
                        <label class="form-check-label mb-0" for="basic-checkbox">Remember me</label>
                      </div>
                    </div>
                  </div>
                  <button class="btn btn-primary w-100 mb-3" type="submit">Sign In</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</main>
