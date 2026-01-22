
<?php

class VerifyPhoneController
{
    private function requireLogin()
    {
        if (!isset($_SESSION['user']['id'])) {
            header("Location: index.php?page=connexion");
            exit;
        }
        return $_SESSION['user']['id'];
    }

    public function form()
    {
        $userId = $this->requireLogin();
        global $pdo;

        $stmt = $pdo->prepare("SELECT numero_verifie FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();

        if ($user && $user['numero_verifie']) {
            header("Location: index.php?page=profil");
            exit;
        }

        require __DIR__ . '/../views/verifnum.php';
    }

    public function send()
    {
        $userId = $this->requireLogin();

        if (empty($_POST['phone'])) {
            header("Location: index.php?page=verifnum&error=" . urlencode("Numéro manquant"));
            exit;
        }

        global $pdo;

        $raw  = $_POST['phone'];
        $clean = preg_replace('/\D/', '', $raw);

        if (strlen($clean) === 10 && $clean[0] === '0') {
            $phone = '+33' . substr($clean, 1);
        } elseif (strpos($raw, '+33') === 0) {
            $phone = $raw;
        } else {
            header("Location: index.php?page=verifnum&error=" . urlencode("Format invalide"));
            exit;
        }

        $code   = rand(100000, 999999);
        $expire = date("Y-m-d H:i:s", time() + 300);


        $apiKey    = '....';
        $apiSecret = '....';

         $params = [
            'api_key'    => $apiKey,
            'api_secret' => $apiSecret,
            'to'         => $phone,
            'from'       => "Caramba",
            'text'       => "Votre code Caramba : $code"
        ];

        $url = "https://rest.nexmo.com/sms/json?" . http_build_query($params);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if (!$response) {
            header("Location: index.php?page=verifnum&error=Erreur SMS");
            exit;
        }

        $data = json_decode($response, true);

        if ($data['messages'][0]['status'] !== '0') {
            $err = $data['messages'][0]['error-text'] ?? "Erreur inconnue";
            header("Location: index.php?page=verifnum&error=" . urlencode($err));
            exit;
        }

        $stmt = $pdo->prepare("UPDATE users SET code_tel = ?, code_expire = ? WHERE id = ?");
        $stmt->execute([$code, $expire, $userId]);

        $_SESSION['verify_phone'] = $phone;

        header("Location: index.php?page=verifnum_code");
        exit;
    }

    public function codeForm()
    {
        $userId = $this->requireLogin();
        global $pdo;

        $stmt = $pdo->prepare("SELECT numero_verifie FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();

        if ($user['numero_verifie']) {
            header("Location: index.php?page=profil");
            exit;
        }

        require __DIR__ . '/../views/verifnum_code.php';
    }

    public function check()
    {
        $userId = $this->requireLogin();
        global $pdo;

        if (empty($_POST["code"])) {
            header("Location: index.php?page=verifnum_code&error=1");
            exit;
        }

        $code = trim($_POST["code"]);

        $stmt = $pdo->prepare("SELECT code_tel, code_expire FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $u = $stmt->fetch();

        if (!$u) {
            header("Location: index.php?page=verifnum_code&error=1");
            exit;
        }

        if (strtotime($u["code_expire"]) < time()) {
            header("Location: index.php?page=verifnum_code&error=expire");
            exit;
        }

        if ($code !== $u["code_tel"]) {
            header("Location: index.php?page=verifnum_code&error=wrong");
            exit;
        }

        $upd = $pdo->prepare("UPDATE users SET numero_verifie = 1, code_tel = NULL, code_expire = NULL WHERE id = ?");
        $upd->execute([$userId]);

        header("Location: index.php?page=profil&success=phone_verified");
        exit;
    }
}