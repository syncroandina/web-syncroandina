<?php
namespace Core;

class MailHelper {
    /**
     * Envía un correo electrónico utilizando SMTP o la función nativa mail().
     *
     * @param string $to Destinatario(s) (puede ser separado por comas)
     * @param string $subject Asunto del correo
     * @param string $htmlContent Contenido en formato HTML
     * @param string $fromName Nombre del remitente
     * @param string $fromEmail Correo del remitente
     * @return bool True si se envió correctamente, False en caso contrario.
     */
    public static function send($to, $subject, $htmlContent, $fromName = "Syncro Andina", $fromEmail = "no-reply@syncroandina.com") {
        $boundary = "----=_NextPart_" . md5(uniqid(rand(), true));
        $hasCidLogo = false;
        $mimeType = 'image/png';
        $logoFilename = '';
        $base64Data = '';

        // Intentar detectar y embeber el logotipo como un archivo adjunto CID inline (Content-ID)
        try {
            $settingModel = new \App\Models\Setting();
            $settings = $settingModel->getAll();
            $logoUrl = $settings['logo_url'] ?? '';
            
            if (empty($logoUrl)) {
                $logoUrl = '/assets/images/logo.webp';
            }
            
            // Limpiar query string (ej: ?1779038240) para obtener la ruta física real
            $logoPath = parse_url($logoUrl, PHP_URL_PATH);
            $localFilePath = $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($logoPath, '/');
            
            if (file_exists($localFilePath) && is_file($localFilePath)) {
                $hasCidLogo = true;
                $fileData = file_get_contents($localFilePath);
                $base64Data = chunk_split(base64_encode($fileData));
                $logoFilename = basename($logoPath);
                
                $ext = strtolower(pathinfo($logoPath, PATHINFO_EXTENSION));
                if ($ext === 'png') {
                    $mimeType = 'image/png';
                } elseif ($ext === 'jpg' || $ext === 'jpeg') {
                    $mimeType = 'image/jpeg';
                } elseif ($ext === 'webp') {
                    $mimeType = 'image/webp';
                }
                
                // Reemplazo ultra-robusto con Expresión Regular para cambiar cualquier src que contenga el archivo del logo por el CID
                $logoBase = preg_quote($logoFilename, '/');
                $pattern = '/src\s*=\s*[\'"][^\'"]*' . $logoBase . '[^\'"]*[\'"]/i';
                $htmlContent = preg_replace($pattern, 'src="cid:logo_cid"', $htmlContent);
            }
        } catch (\Exception $e) {
            error_log("Error parseando logo CID en MailHelper: " . $e->getMessage());
        }

        // Construir cuerpo de mensaje y cabecera de tipo de contenido
        if ($hasCidLogo) {
            $body = "--{$boundary}\r\n";
            $body .= "Content-Type: text/html; charset=UTF-8\r\n";
            $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
            $body .= $htmlContent . "\r\n\r\n";
            
            $body .= "--{$boundary}\r\n";
            $body .= "Content-Type: {$mimeType}; name=\"{$logoFilename}\"\r\n";
            $body .= "Content-Transfer-Encoding: base64\r\n";
            $body .= "Content-ID: <logo_cid>\r\n";
            $body .= "Content-Disposition: inline; filename=\"{$logoFilename}\"\r\n\r\n";
            $body .= $base64Data . "\r\n";
            $body .= "--{$boundary}--";
            
            $contentTypeHeader = "Content-Type: multipart/related; boundary=\"{$boundary}\"";
        } else {
            $body = $htmlContent;
            $contentTypeHeader = "Content-Type: text/html; charset=UTF-8";
        }

        try {
            $settingModel = new \App\Models\Setting();
            $settings = $settingModel->getAll();
            
            $useSmtp = $settings['notification_use_smtp'] ?? '0';
            if ($useSmtp === '1') {
                $config = [
                    'host' => $settings['notification_smtp_host'] ?? '',
                    'port' => $settings['notification_smtp_port'] ?? '465',
                    'encryption' => $settings['notification_smtp_encryption'] ?? 'ssl',
                    'username' => $settings['notification_smtp_user'] ?? '',
                    'password' => $settings['notification_smtp_pass'] ?? '',
                    'from_email' => $settings['notification_smtp_user'] ?? $fromEmail,
                    'from_name' => $fromName
                ];
                
                // Si el host o el usuario están vacíos, no intentar SMTP y usar mail() nativo
                if (!empty($config['host']) && !empty($config['username'])) {
                    return self::sendSmtp($to, $subject, $body, $contentTypeHeader, $config);
                }
            }
        } catch (\Exception $e) {
            // Registra el error en los logs del servidor
            error_log("Error SMTP en MailHelper: " . $e->getMessage());
        }

        // Fallback a correo nativo si falla SMTP o no está configurado
        $domain = $_SERVER['HTTP_HOST'] ?? 'syncroandina.com';
        $domainClean = preg_replace('/:[0-9]+$/', '', $domain);
        $messageId = "<" . md5(uniqid(rand(), true)) . "@" . $domainClean . ">";

        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "{$contentTypeHeader}\r\n";
        $headers .= "From: =?UTF-8?B?" . base64_encode($fromName) . "?= <{$fromEmail}>\r\n";
        $headers .= "Reply-To: {$fromEmail}\r\n";
        $headers .= "Message-ID: {$messageId}\r\n";
        $headers .= "Auto-Submitted: auto-generated\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

        return @mail($to, "=?UTF-8?B?" . base64_encode($subject) . "?=", $body, $headers);
    }

    /**
     * Cliente SMTP nativo autocontenido basado en sockets.
     * Soporta cifrados SSL/TLS, EHLO, AUTH LOGIN y múltiples destinatarios.
     */
    private static function sendSmtp($to, $subject, $body, $contentTypeHeader, $config) {
        $host = $config['host'];
        $port = $config['port'];
        $username = $config['username'];
        $password = $config['password'];
        $encryption = strtolower($config['encryption'] ?? 'ssl');
        $fromEmail = $config['from_email'];
        $fromName = $config['from_name'];

        $server = $host;
        if ($encryption === 'ssl') {
            $server = 'ssl://' . $host;
        }

        // Establecer conexión por sockets
        $socket = @stream_socket_client($server . ':' . $port, $errno, $errstr, 15, STREAM_CLIENT_CONNECT);
        if (!$socket) {
            throw new \Exception("No se pudo conectar al servidor SMTP {$host}:{$port}. Error: {$errstr} ({$errno})");
        }

        self::readResponse($socket, '220');

        // EHLO de saludo inicial
        $localHost = $_SERVER['HTTP_HOST'] ?? 'localhost';
        fwrite($socket, "EHLO {$localHost}\r\n");
        self::readResponse($socket, '250');

        // Negociación TLS
        if ($encryption === 'tls') {
            fwrite($socket, "STARTTLS\r\n");
            self::readResponse($socket, '220');
            
            // Habilitar cifrado TLS en el stream activo
            if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                fclose($socket);
                throw new \Exception("Falló la negociación del protocolo TLS de red.");
            }
            
            // Re-enviar EHLO tras establecer el canal TLS cifrado
            fwrite($socket, "EHLO {$localHost}\r\n");
            self::readResponse($socket, '250');
        }

        // Autenticación SMTP
        if (!empty($username) && !empty($password)) {
            fwrite($socket, "AUTH LOGIN\r\n");
            self::readResponse($socket, '334');

            fwrite($socket, base64_encode($username) . "\r\n");
            self::readResponse($socket, '334');

            fwrite($socket, base64_encode($password) . "\r\n");
            self::readResponse($socket, '235');
        }

        // Definición de remitente de correo
        fwrite($socket, "MAIL FROM:<{$fromEmail}>\r\n");
        self::readResponse($socket, '250');

        // Definición de destinatario(s)
        $recipients = array_map('trim', explode(',', $to));
        foreach ($recipients as $recipient) {
            if (!empty($recipient)) {
                fwrite($socket, "RCPT TO:<{$recipient}>\r\n");
                self::readResponse($socket, '250');
            }
        }

        // Transmisión de cuerpo de mensaje
        fwrite($socket, "DATA\r\n");
        self::readResponse($socket, '354');

        // Construcción de cabeceras de correo estándar RFC 822/2822
        $domainClean = preg_replace('/:[0-9]+$/', '', $host);
        $messageId = "<" . md5(uniqid(rand(), true)) . "@" . $domainClean . ">";

        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "{$contentTypeHeader}\r\n";
        $headers .= "From: =?UTF-8?B?" . base64_encode($fromName) . "?= <{$fromEmail}>\r\n";
        $headers .= "To: {$to}\r\n";
        $headers .= "Subject: =?UTF-8?B?" . base64_encode($subject) . "?=\r\n";
        $headers .= "Date: " . date('r') . "\r\n";
        $headers .= "Message-ID: {$messageId}\r\n";
        $headers .= "Auto-Submitted: auto-generated\r\n";
        $headers .= "X-Mailer: PHP/SMTP-Client/" . phpversion() . "\r\n";
        $headers .= "\r\n";

        $message = $headers . $body . "\r\n.\r\n";

        fwrite($socket, $message);
        self::readResponse($socket, '250');

        // Desconexión limpia
        fwrite($socket, "QUIT\r\n");
        fclose($socket);

        return true;
    }

    /**
     * Lee y valida la respuesta del servidor de sockets SMTP.
     */
    private static function readResponse($socket, $expectedCode) {
        $response = '';
        while ($line = fgets($socket, 515)) {
            $response .= $line;
            if (substr($line, 3, 1) == ' ') {
                break;
            }
        }
        $code = substr($response, 0, 3);
        if ($code !== $expectedCode) {
            throw new \Exception("Servidor SMTP respondió: " . trim($response) . " (Esperado: {$expectedCode})");
        }
    }

    /**
     * Genera la plantilla HTML premium para los correos.
     *
     * @param string $title Título del correo
     * @param string $contentHtml Contenido en formato HTML
     * @param string $logoUrl URL del logo corporativo
     * @param string $accentColor Color de acento
     * @return string Plantilla HTML completa
     */
    public static function getTemplate($title, $contentHtml, $logoUrl = '/assets/images/logo.webp', $accentColor = '#3b82f6') {
        $logoSrc = !empty($logoUrl) ? $logoUrl : '/assets/images/logo.webp';
        
        // Si la ruta del logo es relativa, concatenarle el protocolo y host para que sea absoluta
        if (strpos($logoSrc, 'http') !== 0) {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
            $host = $_SERVER['HTTP_HOST'] ?? 'localhost:8000';
            $logoSrc = $protocol . $host . '/' . ltrim($logoSrc, '/');
        }

        return "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>{$title}</title>
            <style>
                body {
                    margin: 0;
                    padding: 0;
                    background-color: #f8fafc;
                    font-family: 'Segoe UI', Helvetica, Arial, sans-serif;
                    color: #334155;
                    -webkit-font-smoothing: antialiased;
                }
                .wrapper {
                    width: 100%;
                    table-layout: fixed;
                    background-color: #f8fafc;
                    padding: 40px 0;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: #ffffff;
                    border-radius: 20px;
                    overflow: hidden;
                    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.05);
                    border: 1px solid #f1f5f9;
                }
                .header {
                    background-color: #f1f5f9;
                    padding: 15px 20px;
                    text-align: center;
                    border-bottom: 4px solid {$accentColor};
                }
                .logo {
                    max-height: 140px;
                    width: auto;
                    display: inline-block;
                }
                .body {
                    padding: 40px;
                }
                .title {
                    font-size: 22px;
                    font-weight: 800;
                    color: #0f172a;
                    margin-top: 0;
                    margin-bottom: 20px;
                    letter-spacing: -0.5px;
                }
                .content {
                    font-size: 15px;
                    line-height: 1.6;
                    color: #475569;
                }
                .card {
                    background-color: #f8fafc;
                    border: 1px solid #e2e8f0;
                    border-radius: 16px;
                    padding: 24px;
                    margin: 25px 0;
                }
                .card-title {
                    font-size: 14px;
                    font-weight: 800;
                    color: #0f172a;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                    margin-top: 0;
                    margin-bottom: 15px;
                }
                .field-row {
                    margin-bottom: 12px;
                    font-size: 14px;
                    line-height: 1.5;
                }
                .field-row:last-child {
                    margin-bottom: 0;
                }
                .field-label {
                    font-weight: 700;
                    color: #475569;
                    display: inline-block;
                    width: 120px;
                }
                .field-value {
                    color: #0f172a;
                }
                .btn-container {
                    text-align: center;
                    margin-top: 25px;
                }
                .btn {
                    display: inline-block;
                    background-color: {$accentColor};
                    color: #ffffff !important;
                    text-decoration: none;
                    font-weight: 700;
                    font-size: 14px;
                    padding: 12px 28px;
                    border-radius: 12px;
                    text-align: center;
                }
                .footer {
                    background-color: #f8fafc;
                    padding: 30px 40px;
                    text-align: center;
                    border-top: 1px solid #e2e8f0;
                }
                .footer-text {
                    font-size: 12px;
                    color: #94a3b8;
                    line-height: 1.5;
                    margin: 0;
                }
                .footer-text a {
                    color: {$accentColor};
                    text-decoration: none;
                    font-weight: 600;
                }
            </style>
        </head>
        <body>
            <div class='wrapper'>
                <div class='container'>
                    <div class='header'>
                        <img src='{$logoSrc}' alt='Syncro Andina Logo' class='logo'>
                    </div>
                    <div class='body'>
                        <h2 class='title'>{$title}</h2>
                        <div class='content'>
                            {$contentHtml}
                        </div>
                    </div>
                    <div class='footer'>
                        <p class='footer-text'>
                            &copy; " . date('Y') . " <strong>Syncro Andina</strong> - Soluciones Industriales.<br>
                            Este es un correo automático generado por el sistema. Por favor, no respondas a esta dirección.
                        </p>
                    </div>
                </div>
            </div>
        </body>
        </html>
        ";
    }
}
