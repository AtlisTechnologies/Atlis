<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_WARNING);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../logs/php-error.log');
ob_start();
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
date_default_timezone_set('America/Denver');

// connect to Database
require __DIR__ . '/config.php';
require_once __DIR__ . '/lookup_helpers.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/contractor_helpers.php';

// Composer autoload (for third-party libraries)
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
  require_once __DIR__ . '/../vendor/autoload.php';
}

// OAuth configuration (Google, Microsoft, etc.)
$oauthConfig = [];
$oauthConfigPath = __DIR__ . '/config.oauth.php';
if (file_exists($oauthConfigPath)) {
  $oauthConfig = require $oauthConfigPath;
}

$today = date('Y-m-d H:i:s');
$today_date = date('Y-m-d');
$date_today = date("l, F j, Y");
$tomorrow = date('l, F j, Y',strtotime("$today +1 days"));

$is_logged_in = isset($_SESSION['user_logged_in']) ? $_SESSION['user_logged_in'] : false;
$is_admin = $is_logged_in && (($_SESSION['type'] ?? '') === 'ADMIN');

if (!$is_logged_in) {
  $requestUri = $_SERVER['REQUEST_URI'] ?? '';
  if (strpos($requestUri, '/module/') !== false && strpos($requestUri, '/module/users/') === false) {
    header('Location: ' . getURLDir() . 'module/users/index.php?action=login');
    exit;
  }
}

if ($is_logged_in) {

  // STRINGS AREN'T FUN IN MySQL QUERIES
  $email = $_SESSION['this_user_email'];

  $sql = "SELECT u.*, upp.file_path, p.first_name, p.last_name, p.gender_id, lli.code AS gender_code
          FROM users u
          LEFT JOIN users_profile_pics upp ON u.current_profile_pic_id = upp.id
          LEFT JOIN person p ON u.id = p.user_id
          LEFT JOIN lookup_list_items lli ON p.gender_id = lli.id
          WHERE u.email = :email";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':email', $email, PDO::PARAM_STR);
  $stmt->execute();
  if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $this_user_id = $row['id']; // primary key ID
    $this_user_email = $row['email']; // email user signed up with
    $this_user_email_verified = $row['email_verified']; // 1 or 0
    $this_user_profile_pic = $row['file_path'];
    $this_user_type = $row['type']; // either 'admin' or 'user'
    $this_user_status = $row['status']; // 1 or 0
    $this_user_date_created = $row['date_created'];
    $this_user_last_login = $row['last_login'];
    $this_user_first_name = $row['first_name'];
    $this_user_last_name = $row['last_name'];
    $this_user_gender_id = $row['gender_id'];
    $this_user_gender_code = $row['gender_code'];

    $this_user_name = $this_user_first_name . " " . $this_user_last_name;
  } // END THIS_USER
}

$useragent = $_SERVER['HTTP_USER_AGENT'];
if ( preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
  $this_user_mobile = 1;
}else{
  $this_user_mobile = 0;
}

$curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

$user_currentUrl = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

?>
