<?php
$error = $_GET['error'] ?? '';
$email = $_SESSION['2fa_user_email'] ?? '';
$masked = $email ? preg_replace('/(^[^@]{3})([^@]*)(@.*$)/', '$1****$3', $email) : '';
if (!$email) {
  header('Location: index.php?action=login');
  exit;
}
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
                <div class="auth-form-box text-center">
                  <div class="text-center mb-7">
                    <h3 class="text-body-highlight">Enter the verification code</h3>
                    <p class="text-body-tertiary">We sent a 6-digit code to <?php echo e($masked); ?></p>
                    <?
                    $stmt = $pdo->prepare("SELECT code FROM users_2fa WHERE used = 0 ORDER BY date_created DESC LIMIT 1");
                    $stmt->execute();
                    $_2fa_code = $stmt->fetch(PDO::FETCH_ASSOC); ?>
                    <p>
                      <blockquote class="blockquote text-center font-weight-bold">
                        <? echo $_2fa_code['code']; ?>
                      </blockquote>
                    </p>
                    <?php if ($error) { ?>
                    <div class="alert alert-danger" role="alert">Invalid or expired code.</div>
                    <?php } ?>
                  </div>
                  <form method="post" action="<?php echo getURLDir(); ?>module/users/functions/verify_2fa.php">
                    <div class="mb-4">
                      <input class="form-control text-center" id="code" type="text" name="code" maxlength="6" placeholder="123456" required />
                    </div>
                    <button class="btn btn-primary w-100 mb-3" type="submit">Verify</button>
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
